<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Problem;
use App\Models\Answer;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users_count' => User::count(),
            'problems_count' => Problem::count(),
            'answers_count' => Answer::count(),
            'categories_count' => Category::count(),
        ];

        // ApexCharts data: Users distribution by Role
        $roleCounts = [
            'admin' => User::where('role', 'admin')->count(),
            'user' => User::where('role', 'user')->orWhereNull('role')->orWhere('role', '')->count(),
        ];
        $chartRoles = array_keys($roleCounts);
        $chartRoleData = array_values($roleCounts);

        // ApexCharts data: Problems per category
        $categoryData = Category::all()->map(function ($category) {
            $category->problems_count = Problem::where('category_id', $category->id)->count();
            return $category;
        });
        $chartCategories = $categoryData->pluck('name')->toArray();
        $chartCategoryProblems = $categoryData->pluck('problems_count')->toArray();

        // ApexCharts data: Solved vs Unsolved
        $solvedCount = Problem::where('status', 'solved')->count();
        $unsolvedCount = Problem::where('status', 'unsolved')->count();

        // Recent users
        $recentUsers = User::latest()->limit(5)->get();

        return view('admin.index', compact(
            'stats',
            'chartRoles',
            'chartRoleData',
            'chartCategories',
            'chartCategoryProblems',
            'solvedCount',
            'unsolvedCount',
            'recentUsers'
        ));
    }

    public function categories()
    {
        $categories = Category::all()->map(function ($category) {
            $category->problems_count = Problem::where('category_id', $category->id)->count();
            return $category;
        });
        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories')->with('success', 'Category created successfully.');
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories')->with('success', 'Category updated successfully.');
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully.');
    }

    public function users()
    {
        $users = User::all()->map(function ($user) {
            $user->problems_count = Problem::where('user_id', (string) $user->id)->count();
            $user->answers_count = Answer::where('user_id', (string) $user->id)->count();
            return $user;
        });
        return view('admin.users', compact('users'));
    }

    public function toggleUserRole($id)
    {
        $user = User::findOrFail($id);

        // Prevent self-demotion
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'You cannot change your own administrator role.');
        }

        $newRole = $user->role === 'admin' ? 'user' : 'admin';
        $user->update(['role' => $newRole]);

        return redirect()->back()->with('success', "Role for {$user->name} updated to {$newRole}.");
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        // Prevent self-deletion
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'You cannot delete your own administrator account.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User account deleted successfully.');
    }

    public function content()
    {
        $problems = Problem::with(['user', 'category'])->latest()->paginate(15);
        return view('admin.content', compact('problems'));
    }
}
