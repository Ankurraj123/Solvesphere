<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use App\Models\Answer;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // User stats
        $totalQuestions = Problem::where('user_id', (string) $user->id)->count();
        $totalAnswers = Answer::where('user_id', (string) $user->id)->count();
        $solvedQuestions = Problem::where('user_id', (string) $user->id)->where('status', 'solved')->count();
        $solvedRate = $totalQuestions > 0 ? round(($solvedQuestions / $totalQuestions) * 100) : 0;

        // Recent activity feed: latest problems in the community
        $recentProblems = Problem::with(['user', 'category'])
            ->latest()
            ->limit(5)
            ->get();

        // Data for Categories and their counts
        $categoriesData = Category::with('problems')->get()->map(function ($category) {
            $category->problems_count = $category->problems->count();
            return $category;
        });

        // Trending categories
        $trendingCategories = $categoriesData
            ->sortByDesc('problems_count')
            ->take(4);

        // Data for ApexCharts (Problems per Category distribution)
        $chartCategories = $categoriesData->pluck('name')->toArray();
        $chartData = $categoriesData->pluck('problems_count')->toArray();

        return view('dashboard.index', compact(
            'totalQuestions',
            'totalAnswers',
            'solvedQuestions',
            'solvedRate',
            'recentProblems',
            'trendingCategories',
            'chartCategories',
            'chartData'
        ));
    }
}
