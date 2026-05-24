@extends('layouts.app')

@section('title', 'Admin Overview – SolveSphere')
@section('page_title', 'Admin Dashboard')

@section('content')
<div class="space-y-8">
    
    <!-- Admin Warning Alert banner -->
    <div class="relative overflow-hidden rounded-2xl bg-zinc-900 border border-indigo-900/40 p-8 shadow-xl">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_right_top,rgba(99,102,241,0.08),transparent_40%)] pointer-events-none"></div>
        <h2 class="text-xl font-bold text-white tracking-tight">System Administration Panel</h2>
        <p class="text-sm text-zinc-400 mt-1">Monitor user registrations, oversee active categories, and perform moderation operations across discussions.</p>
    </div>

    <!-- Administrative Statistics Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="p-6 bg-zinc-900 border border-zinc-800 rounded-2xl shadow-lg">
            <span class="text-3xs font-bold text-zinc-550 uppercase tracking-widest block">Total Users</span>
            <h3 class="text-2xl font-extrabold text-white mt-1.5">{{ $stats['users_count'] }}</h3>
        </div>
        <div class="p-6 bg-zinc-900 border border-zinc-800 rounded-2xl shadow-lg">
            <span class="text-3xs font-bold text-zinc-550 uppercase tracking-widest block">Total Posts</span>
            <h3 class="text-2xl font-extrabold text-white mt-1.5">{{ $stats['problems_count'] }}</h3>
        </div>
        <div class="p-6 bg-zinc-900 border border-zinc-800 rounded-2xl shadow-lg">
            <span class="text-3xs font-bold text-zinc-550 uppercase tracking-widest block">Solutions Shared</span>
            <h3 class="text-2xl font-extrabold text-white mt-1.5">{{ $stats['answers_count'] }}</h3>
        </div>
        <div class="p-6 bg-zinc-900 border border-zinc-800 rounded-2xl shadow-lg">
            <span class="text-3xs font-bold text-zinc-550 uppercase tracking-widest block">Categories</span>
            <h3 class="text-2xl font-extrabold text-white mt-1.5">{{ $stats['categories_count'] }}</h3>
        </div>
    </div>

    <!-- Charts Section Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Problems per category bar chart -->
        <div class="lg:col-span-2 p-6 bg-zinc-900 border border-zinc-800 rounded-2xl shadow-lg">
            <h4 class="text-sm font-bold text-white mb-4">Questions per Category</h4>
            <div id="admin-category-chart" class="min-h-[260px]"></div>
        </div>

        <!-- Solved vs Unsolved Pie Chart -->
        <div class="p-6 bg-zinc-900 border border-zinc-800 rounded-2xl shadow-lg flex flex-col justify-between">
            <h4 class="text-sm font-bold text-white mb-4">Solved vs Unsolved Ratio</h4>
            <div id="admin-status-chart" class="min-h-[220px] flex items-center justify-center"></div>
            <div class="pt-4 border-t border-zinc-800/60 flex items-center justify-around text-center text-xs mt-4">
                <div>
                    <span class="text-emerald-400 font-bold block">{{ $solvedCount }}</span>
                    <span class="text-3xs text-zinc-500 font-semibold uppercase">Solved</span>
                </div>
                <div>
                    <span class="text-amber-400 font-bold block">{{ $unsolvedCount }}</span>
                    <span class="text-3xs text-zinc-500 font-semibold uppercase">Unsolved</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Section: Recent users -->
    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 shadow-lg">
        <div class="flex items-center justify-between border-b border-zinc-800/80 pb-4 mb-6">
            <h3 class="text-base font-bold text-white">Recently Joined Users</h3>
            <a href="{{ route('admin.users') }}" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300">Manage Users</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-zinc-800/80 text-3xs font-semibold text-zinc-500 uppercase tracking-widest">
                        <th class="pb-3">Name</th>
                        <th class="pb-3">Email</th>
                        <th class="pb-3">Access Role</th>
                        <th class="pb-3">Registration Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800/40 text-sm text-zinc-300">
                    @foreach($recentUsers as $ru)
                        <tr>
                            <td class="py-3.5 font-semibold text-white">{{ $ru->name }}</td>
                            <td class="py-3.5 text-zinc-400">{{ $ru->email }}</td>
                            <td class="py-3.5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-4xs font-bold uppercase tracking-wider {{ $ru->isAdmin() ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/15' : 'bg-zinc-800 text-zinc-400 border border-zinc-700/80' }}">
                                    {{ $ru->role }}
                                </span>
                            </td>
                            <td class="py-3.5 text-zinc-500 text-xs">{{ $ru->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Render Charts -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // 1. Category Chart
        const categories = @json($chartCategories);
        const categoryData = @json($chartCategoryProblems);
        
        const catOptions = {
            chart: {
                type: 'bar',
                height: 260,
                toolbar: { show: false },
                background: 'transparent'
            },
            theme: { mode: 'dark' },
            series: [{
                name: 'Questions',
                data: categoryData
            }],
            xaxis: {
                categories: categories,
                labels: { style: { colors: '#71717a', fontSize: '10px', fontFamily: 'Plus Jakarta Sans' } },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: { style: { colors: '#71717a', fontSize: '10px', fontFamily: 'Plus Jakarta Sans' } }
            },
            grid: {
                borderColor: '#27272a',
                strokeDashArray: 4,
            },
            colors: ['#6366f1'],
            plotOptions: {
                bar: { borderRadius: 6, columnWidth: '40%' }
            },
            dataLabels: { enabled: false }
        };
        const catChart = new ApexCharts(document.querySelector("#admin-category-chart"), catOptions);
        catChart.render();

        // 2. Status Chart (Donut)
        const solved = {{ $solvedCount }};
        const unsolved = {{ $unsolvedCount }};
        
        const statusOptions = {
            chart: {
                type: 'donut',
                height: 220,
                background: 'transparent'
            },
            theme: { mode: 'dark' },
            series: [solved, unsolved],
            labels: ['Solved', 'Unsolved'],
            colors: ['#10b981', '#f59e0b'],
            stroke: { show: false },
            dataLabels: { enabled: false },
            legend: {
                position: 'bottom',
                fontFamily: 'Plus Jakarta Sans',
                fontSize: '11px',
                labels: { colors: '#a1a1aa' }
            },
            tooltip: {
                theme: 'dark'
            }
        };
        const statusChart = new ApexCharts(document.querySelector("#admin-status-chart"), statusOptions);
        statusChart.render();
    });
</script>
@endsection
