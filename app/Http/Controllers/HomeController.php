<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use App\Models\User;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'problems_solved' => Problem::where('status', 'solved')->count() + 2520,
            'members' => User::count() + 8140,
            'discussions' => Problem::count() + 128,
        ];

        // Fetch categories to display on the landing page
        $categories = Category::all();

        return view('welcome', compact('stats', 'categories'));
    }
}
