@extends('layouts.app')

@section('title', 'Explore Problems – SolveSphere')
@section('page_title', 'Explore Discussions')

@section('content')
<div class="space-y-6">

    <!-- Search & Filter Controls Panel -->
    <div class="p-5 bg-zinc-900 border border-zinc-800 rounded-2xl shadow-lg">
        <form action="{{ route('problems.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 m-0">
            <!-- Search field -->
            <div class="md:col-span-2 relative">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="w-full pl-10 pr-4 py-2.5 bg-zinc-950 border border-zinc-800 rounded-xl text-sm text-white placeholder-zinc-500 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 transition-all"
                       placeholder="Search by keywords, title, error traces...">
                <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-zinc-500">
                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>

            <!-- Category Filter -->
            <div>
                <select name="category" onchange="this.form.submit()"
                        class="w-full px-4 py-2.5 bg-zinc-950 border border-zinc-800 rounded-xl text-sm text-zinc-300 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 transition-all cursor-pointer">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div class="flex gap-2">
                <select name="status" onchange="this.form.submit()"
                        class="flex-1 px-4 py-2.5 bg-zinc-950 border border-zinc-800 rounded-xl text-sm text-zinc-300 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 transition-all cursor-pointer">
                    <option value="">All Statuses</option>
                    <option value="unsolved" {{ request('status') === 'unsolved' ? 'selected' : '' }}>Unsolved</option>
                    <option value="solved" {{ request('status') === 'solved' ? 'selected' : '' }}>Solved</option>
                </select>
                
                @if(request()->anyFilled(['search', 'category', 'status']))
                    <a href="{{ route('problems.index') }}" class="p-2.5 bg-zinc-850 hover:bg-zinc-800 border border-zinc-750 hover:border-zinc-700 text-zinc-400 hover:text-white rounded-xl transition-all inline-flex items-center justify-center shadow" title="Reset Filters">
                        <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Problems Grid -->
    @if($problems->isEmpty())
        <x-empty-state title="No discussions match your filter" description="Try adjusting your keywords, categories, or select state to explore other discussions." actionUrl="{{ route('problems.create') }}" actionText="Ask a Question" />
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($problems as $prob)
                <div class="p-6 bg-zinc-900 border border-zinc-800/80 hover:border-zinc-700/80 rounded-2xl hover:bg-zinc-850/10 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex flex-col justify-between group">
                    <div class="space-y-4">
                        <!-- Header Badges -->
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-0.5 rounded-lg bg-zinc-800/80 border border-zinc-700/80 text-zinc-400 text-3xs font-semibold uppercase tracking-wider">
                                {{ $prob->category->name }}
                            </span>
                            <span class="px-2 py-0.5 rounded-full text-3xs font-bold border uppercase tracking-wider {{ $prob->isSolved() ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-amber-500/10 text-amber-400 border-amber-500/20' }}">
                                {{ $prob->status }}
                            </span>
                        </div>

                        <!-- Title and Snippet -->
                        <div class="space-y-2">
                            <a href="{{ route('problems.show', $prob->id) }}" class="block text-base font-bold text-white group-hover:text-violet-400 transition-colors line-clamp-2">
                                {{ $prob->title }}
                            </a>
                            <p class="text-xs text-zinc-450 line-clamp-3 leading-relaxed">
                                {{ strip_tags($prob->description) }}
                            </p>
                        </div>
                    </div>

                    <!-- Footer Area -->
                    <div class="mt-6 pt-4 border-t border-zinc-800/80 flex items-center justify-between">
                        <!-- Author Details -->
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-zinc-800 border border-zinc-750 flex items-center justify-center font-bold text-zinc-300 text-3xs">
                                {{ substr($prob->user->name ?? 'U', 0, 1) }}
                            </div>
                            <div class="text-3xs">
                                <p class="font-semibold text-zinc-300 leading-none truncate max-w-[80px]">{{ $prob->user->name }}</p>
                                <span class="text-zinc-500 block mt-0.5">{{ $prob->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <!-- Answers Count Badge -->
                        <div class="flex items-center gap-1.5 text-zinc-500">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <span class="text-xs font-semibold">{{ $prob->answers->count() }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination Links -->
        <div class="pt-6">
            {{ $problems->links() }}
        </div>
    @endif

</div>
@endsection
