@extends('layouts.app')

@section('title', 'Developer Dashboard – SolveSphere')
@section('page_title', 'Overview')

@section('content')
<div class="space-y-8">
    <!-- Welcome Header Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-zinc-900 border border-zinc-800 p-8 flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl shadow-zinc-950/20">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_-20%,rgba(99,102,241,0.12),transparent_40%)] pointer-events-none"></div>
        <div class="space-y-1.5 z-10">
            <h2 class="text-2xl font-bold text-white">Hello, {{ Auth::user()->name }}!</h2>
            <p class="text-sm text-zinc-400">Keep track of your programming problems, view stats, and browse community discussions.</p>
        </div>
        <a href="{{ route('problems.create') }}" class="z-10 inline-flex items-center justify-center px-5 py-3 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-violet-600 to-indigo-500 hover:from-violet-500 hover:to-indigo-400 shadow-lg shadow-indigo-500/10 hover:shadow-indigo-500/20 transition-all cursor-pointer">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 4v16m8-8H4"/></svg>
            Ask a Question
        </a>
    </div>

    <!-- Analytics Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1: Questions Posted -->
        <div class="p-6 bg-zinc-900 border border-zinc-800 rounded-2xl flex items-center justify-between shadow-lg">
            <div class="space-y-1.5">
                <span class="text-xs font-semibold text-zinc-500 uppercase tracking-wider block">Your Questions</span>
                <h3 class="text-3xl font-bold text-white">{{ $totalQuestions }}</h3>
                <span class="text-2xs text-zinc-400">Questions created by you</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-violet-500/10 border border-violet-500/20 text-violet-400 flex items-center justify-center shadow-inner">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Card 2: Answers Given -->
        <div class="p-6 bg-zinc-900 border border-zinc-800 rounded-2xl flex items-center justify-between shadow-lg">
            <div class="space-y-1.5">
                <span class="text-xs font-semibold text-zinc-500 uppercase tracking-wider block">Answers Contributed</span>
                <h3 class="text-3xl font-bold text-white">{{ $totalAnswers }}</h3>
                <span class="text-2xs text-zinc-400">Solutions you have shared</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center shadow-inner">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Card 3: Solved Problems Rate -->
        <div class="p-6 bg-zinc-900 border border-zinc-800 rounded-2xl flex items-center justify-between shadow-lg">
            <div class="space-y-1.5">
                <span class="text-xs font-semibold text-zinc-500 uppercase tracking-wider block">Solved Rate</span>
                <h3 class="text-3xl font-bold text-white">{{ $solvedRate }}%</h3>
                <span class="text-2xs text-zinc-400">{{ $solvedQuestions }} solved questions</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center shadow-inner">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Main Grid Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Recent Activity Feed -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 shadow-lg">
                <div class="flex items-center justify-between border-b border-zinc-800/80 pb-4 mb-6">
                    <h3 class="text-base font-bold text-white">Recent Community Questions</h3>
                    <a href="{{ route('problems.index') }}" class="text-xs font-semibold text-violet-400 hover:text-violet-300">View All</a>
                </div>

                @if($recentProblems->isEmpty())
                    <x-empty-state title="No discussions yet" description="Be the first to post a problem to start the community discussion!" />
                @else
                    <div class="divide-y divide-zinc-800/60">
                        @foreach($recentProblems as $prob)
                            <div class="py-4.5 first:pt-0 last:pb-0 flex items-start justify-between gap-4 group">
                                <div class="space-y-1.5 min-w-0">
                                    <a href="{{ route('problems.show', $prob->id) }}" class="text-sm font-bold text-zinc-100 hover:text-violet-400 transition-colors line-clamp-1">
                                        {{ $prob->title }}
                                    </a>
                                    <div class="flex flex-wrap items-center gap-2.5 text-2xs text-zinc-500">
                                        <span class="font-medium text-zinc-400">{{ $prob->user->name }}</span>
                                        <span>•</span>
                                        <span>{{ $prob->created_at->diffForHumans() }}</span>
                                        <span>•</span>
                                        <span class="px-2 py-0.5 rounded bg-zinc-800 border border-zinc-700/80 text-zinc-400 text-3xs font-medium">{{ $prob->category->name }}</span>
                                    </div>
                                </div>
                                <span class="px-2 py-1 rounded-full text-3xs font-semibold border shrink-0 uppercase tracking-wider {{ $prob->isSolved() ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-amber-500/10 text-amber-400 border-amber-500/20' }}">
                                    {{ $prob->status }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Right: Category breakdown & Trending Categories -->
        <div class="space-y-6">
            <!-- ApexCharts: Category Distribution -->
            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 shadow-lg">
                <div class="border-b border-zinc-800/80 pb-4 mb-4">
                    <h3 class="text-base font-bold text-white">Category Distribution</h3>
                </div>
                <div id="category-chart" class="min-h-[220px]"></div>
            </div>

            <!-- Trending Categories List -->
            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 shadow-lg">
                <div class="border-b border-zinc-800/80 pb-4 mb-4">
                    <h3 class="text-base font-bold text-white">Active Categories</h3>
                </div>
                <div class="space-y-3">
                    @foreach($trendingCategories as $cat)
                        <div class="flex items-center justify-between p-3 bg-zinc-950/55 border border-zinc-850 rounded-xl hover:border-zinc-800 hover:bg-zinc-850/20 transition-all duration-200">
                            <span class="text-xs font-semibold text-zinc-300">{{ $cat->name }}</span>
                            <span class="px-2 py-0.5 rounded-full bg-violet-500/10 text-violet-400 border border-violet-500/20 text-3xs font-semibold">
                                {{ $cat->problems_count }} problems
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const categories = @json($chartCategories);
        const data = @json($chartData);

        const options = {
            chart: {
                type: 'bar',
                height: 220,
                toolbar: { show: false },
                background: 'transparent'
            },
            theme: {
                mode: 'dark'
            },
            series: [{
                name: 'Problems',
                data: data
            }],
            xaxis: {
                categories: categories,
                labels: {
                    style: { colors: '#71717a', fontSize: '10px', fontFamily: 'Plus Jakarta Sans' }
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    style: { colors: '#71717a', fontSize: '10px', fontFamily: 'Plus Jakarta Sans' }
                }
            },
            grid: {
                borderColor: '#27272a',
                strokeDashArray: 4,
                padding: { left: 0, right: 0, top: 0, bottom: 0 }
            },
            colors: ['#8b5cf6'],
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '50%',
                    distributed: false,
                    dataLabels: { position: 'top' }
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                show: false
            },
            tooltip: {
                theme: 'dark',
                y: {
                    formatter: function(val) {
                        return val + " discussions";
                    }
                }
            }
        };

        const chart = new ApexCharts(document.querySelector("#category-chart"), options);
        chart.render();
    });
</script>
@endsection
