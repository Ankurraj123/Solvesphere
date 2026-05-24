<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Problem;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch contribution stats
        $problemsCount = Problem::where('user_id', $user->id)->count();
        $answersCount = Answer::where('user_id', $user->id)->count();
        
        $solvedCount = Problem::where('user_id', $user->id)
            ->where('status', 'solved')
            ->count();

        // Recent activity feed: user's own problems
        $recentProblems = Problem::with('category')
            ->where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        return view('profile.index', compact('user', 'problemsCount', 'answersCount', 'solvedCount', 'recentProblems'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:8',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }
}
