<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProblemController extends Controller
{
    public function index(Request $request)
    {
        $query = Problem::with(['user', 'category', 'answers']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        // Status filter
        if ($request->filled('status')) {
            $status = $request->input('status');
            if (in_array($status, ['solved', 'unsolved'])) {
                $query->where('status', $status);
            }
        }

        $problems = $query->latest()->paginate(9)->withQueryString();
        $categories = Category::orderBy('name', 'asc')->get();
        $other = $categories->firstWhere('name', 'Other');
        if ($other) {
            $categories = $categories->reject(fn($c) => $c->name === 'Other')->push($other);
        }

        return view('problems.index', compact('problems', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $other = $categories->firstWhere('name', 'Other');
        if ($other) {
            $categories = $categories->reject(fn($c) => $c->name === 'Other')->push($other);
        }
        return view('problems.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Ensure directory exists
            $destinationPath = public_path('uploads/problems');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }
            
            $image->move($destinationPath, $filename);
            $imagePath = 'uploads/problems/' . $filename;
        }

        Problem::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'status' => 'unsolved',
        ]);

        return redirect()->route('problems.index')->with('success', 'Your problem has been posted successfully!');
    }

    public function show($id)
    {
        $problem = Problem::with(['user', 'category', 'answers.user'])->findOrFail($id);
        return view('problems.show', compact('problem'));
    }

    public function edit($id)
    {
        $problem = Problem::findOrFail($id);

        // Authorize: check if owner or admin
        if (Auth::id() !== $problem->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::orderBy('name', 'asc')->get();
        $other = $categories->firstWhere('name', 'Other');
        if ($other) {
            $categories = $categories->reject(fn($c) => $c->name === 'Other')->push($other);
        }
        return view('problems.edit', compact('problem', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $problem = Problem::findOrFail($id);

        // Authorize: check if owner or admin
        if (Auth::id() !== $problem->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $problem->image;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($problem->image && File::exists(public_path($problem->image))) {
                File::delete(public_path($problem->image));
            }

            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            $destinationPath = public_path('uploads/problems');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            $image->move($destinationPath, $filename);
            $imagePath = 'uploads/problems/' . $filename;
        }

        $problem->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'image' => $imagePath,
        ]);

        return redirect()->route('problems.show', $problem->id)->with('success', 'Problem updated successfully!');
    }

    public function destroy($id)
    {
        $problem = Problem::findOrFail($id);

        // Authorize: check if owner or admin
        if (Auth::id() !== $problem->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete associated image
        if ($problem->image && File::exists(public_path($problem->image))) {
            File::delete(public_path($problem->image));
        }

        $problem->delete();

        return redirect()->route('problems.index')->with('success', 'Problem deleted successfully.');
    }

    public function toggleSolved($id)
    {
        $problem = Problem::findOrFail($id);

        // Authorize: only owner can mark as solved
        if (Auth::id() !== $problem->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $newStatus = $problem->status === 'solved' ? 'unsolved' : 'solved';
        $problem->update(['status' => $newStatus]);

        $message = $newStatus === 'solved' ? 'Problem marked as solved!' : 'Problem reopened.';

        return redirect()->back()->with('success', $message);
    }
}
