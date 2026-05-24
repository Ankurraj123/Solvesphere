<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth bg-zinc-950">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SolveSphere – Collaborative Problem Solving Platform</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-zinc-950 text-gray-100 selection:bg-violet-500/30 selection:text-white overflow-x-hidden relative">

    <!-- Background Gradients -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[600px] bg-[radial-gradient(circle_at_top,rgba(124,58,237,0.15),transparent_50%)] pointer-events-none z-0"></div>
    <div class="absolute top-[800px] right-0 w-[400px] h-[400px] bg-[radial-gradient(circle_at_center,rgba(79,70,229,0.08),transparent_50%)] pointer-events-none z-0"></div>

    <!-- Navigation Header -->
    <nav class="border-b border-zinc-800/80 bg-zinc-950/60 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-18 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-violet-600 to-indigo-500 flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:scale-105 transition-transform duration-200">
                    <svg class="w-5.5 h-5.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                    </svg>
                </div>
                <span class="text-xl font-bold tracking-tight text-white">SolveSphere</span>
            </a>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-4.5 py-2.5 rounded-xl text-sm font-semibold text-white bg-zinc-900 border border-zinc-800 hover:border-zinc-700/80 hover:bg-zinc-800/80 transition-all">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-zinc-400 hover:text-white transition-colors">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4.5 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-violet-600 to-indigo-500 hover:from-violet-500 hover:to-indigo-400 shadow-lg shadow-indigo-500/15 hover:shadow-indigo-500/25 transition-all">
                        Get Started
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- 1. Hero Section -->
    <section class="max-w-7xl mx-auto px-6 pt-20 pb-16 text-center relative z-10">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-violet-500/10 text-violet-400 border border-violet-500/20 mb-6">
            <span class="w-1.5 h-1.5 rounded-full bg-violet-400 animate-pulse"></span>
            Version 2.0 now live
        </span>
        
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight text-white max-w-4xl mx-auto leading-[1.15]">
            Knowledge Sharing Platform for <span class="bg-gradient-to-r from-violet-400 via-fuchsia-400 to-indigo-400 bg-clip-text text-transparent">Problem Solving</span>
        </h1>
        
        <p class="text-lg md:text-xl text-zinc-400 max-w-2xl mx-auto mt-6 leading-relaxed">
            Collaborate, solve coding bugs, discuss computer science foundations, and grow together in a community built for software engineers and students.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mt-10">
            <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-7 py-3.5 rounded-xl text-base font-semibold text-white bg-gradient-to-r from-violet-600 to-indigo-500 hover:from-violet-500 hover:to-indigo-400 shadow-xl shadow-indigo-500/20 hover:shadow-indigo-500/30 transform hover:-translate-y-0.5 transition-all duration-200">
                Join Community
            </a>
            <a href="{{ route('problems.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-7 py-3.5 rounded-xl text-base font-semibold text-zinc-300 bg-zinc-900 border border-zinc-800 hover:border-zinc-700 hover:bg-zinc-800/80 transition-all">
                Explore Problems
            </a>
        </div>

        <!-- Dashboard Mockup Preview -->
        <div class="mt-20 relative rounded-2xl border border-zinc-800/80 bg-zinc-900/40 p-4 shadow-2xl shadow-indigo-500/5 backdrop-blur-sm max-w-5xl mx-auto">
            <div class="flex items-center gap-2 mb-4 border-b border-zinc-800/60 pb-3">
                <span class="w-3 h-3 rounded-full bg-rose-500/70 inline-block"></span>
                <span class="w-3 h-3 rounded-full bg-amber-500/70 inline-block"></span>
                <span class="w-3 h-3 rounded-full bg-emerald-500/70 inline-block"></span>
                <span class="text-xs text-zinc-500 ml-2">solvesphere.com/dashboard</span>
            </div>
            
            <!-- Nested grid to represent SaaS dashboard -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-left">
                <!-- Mock Sidebar -->
                <div class="hidden md:flex flex-col gap-3 border-r border-zinc-800/50 pr-4">
                    <div class="h-8 bg-zinc-850 rounded-lg w-3/4"></div>
                    <div class="h-8 bg-zinc-800/40 rounded-lg"></div>
                    <div class="h-8 bg-zinc-800/40 rounded-lg"></div>
                    <div class="h-8 bg-zinc-800/40 rounded-lg"></div>
                </div>
                <!-- Mock content area -->
                <div class="md:col-span-3 space-y-4">
                    <!-- Cards -->
                    <div class="grid grid-cols-3 gap-3">
                        <div class="p-3 bg-zinc-800/30 rounded-xl border border-zinc-800/80">
                            <span class="text-3xs font-semibold text-zinc-500 uppercase">Solved</span>
                            <h4 class="text-lg font-bold text-white mt-1">2.5k+</h4>
                        </div>
                        <div class="p-3 bg-zinc-800/30 rounded-xl border border-zinc-800/80">
                            <span class="text-3xs font-semibold text-zinc-500 uppercase">Members</span>
                            <h4 class="text-lg font-bold text-white mt-1">8.1k+</h4>
                        </div>
                        <div class="p-3 bg-zinc-800/30 rounded-xl border border-zinc-800/80">
                            <span class="text-3xs font-semibold text-zinc-500 uppercase">Discussions</span>
                            <h4 class="text-lg font-bold text-white mt-1">128+</h4>
                        </div>
                    </div>
                    <!-- Question table -->
                    <div class="p-4 bg-zinc-800/30 rounded-xl border border-zinc-800/80 space-y-3">
                        <div class="flex items-center justify-between border-b border-zinc-800/50 pb-2">
                            <span class="text-xs font-semibold text-zinc-400">Recent Community Questions</span>
                            <span class="w-16 h-4 bg-zinc-800 rounded"></span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                            <div class="flex-1 space-y-1">
                                <div class="h-4 bg-zinc-800 rounded w-5/6"></div>
                                <div class="h-3 bg-zinc-850 rounded w-1/3"></div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-2.5 h-2.5 rounded-full bg-amber-500"></div>
                            <div class="flex-1 space-y-1">
                                <div class="h-4 bg-zinc-800 rounded w-3/4"></div>
                                <div class="h-3 bg-zinc-850 rounded w-1/4"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. Stats Section -->
    <section class="max-w-7xl mx-auto px-6 py-16 relative z-10 border-t border-zinc-900">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
            <div class="p-6">
                <h3 class="text-4xl md:text-5xl font-black text-transparent bg-gradient-to-r from-violet-400 to-indigo-400 bg-clip-text">{{ $stats['problems_solved'] }}+</h3>
                <p class="text-sm font-medium text-zinc-400 uppercase tracking-widest mt-2.5">Problems Solved</p>
            </div>
            <div class="p-6">
                <h3 class="text-4xl md:text-5xl font-black text-transparent bg-gradient-to-r from-fuchsia-400 to-pink-400 bg-clip-text">{{ $stats['members'] }}+</h3>
                <p class="text-sm font-medium text-zinc-400 uppercase tracking-widest mt-2.5">Community Members</p>
            </div>
            <div class="p-6">
                <h3 class="text-4xl md:text-5xl font-black text-transparent bg-gradient-to-r from-cyan-400 to-indigo-400 bg-clip-text">{{ $stats['discussions'] }}+</h3>
                <p class="text-sm font-medium text-zinc-400 uppercase tracking-widest mt-2.5">Active Discussions</p>
            </div>
        </div>
    </section>

    <!-- 3. Categories Section -->
    <section class="max-w-7xl mx-auto px-6 py-20 relative z-10 border-t border-zinc-900">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-3xl font-extrabold text-white tracking-tight">Structured by Categories</h2>
            <p class="text-sm md:text-base text-zinc-400 mt-3">Find exact solutions and browse catalogued threads curated by active engineering peers.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
            @foreach($categories as $category)
                <div class="p-6 bg-zinc-900/40 border border-zinc-800 rounded-2xl backdrop-blur-sm hover:border-zinc-700 hover:bg-zinc-800/40 transition-all duration-300 group flex flex-col justify-between">
                    <div>
                        <!-- Icon representation -->
                        <div class="w-10 h-10 rounded-xl bg-violet-600/10 border border-violet-500/20 text-violet-400 flex items-center justify-center mb-5 group-hover:scale-105 transition-transform">
                            @if($category->name === 'DSA')
                                <svg class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h7"/></svg>
                            @elseif($category->name === 'Operating Systems')
                                <svg class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                            @elseif($category->name === 'DBMS')
                                <svg class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 7v10c0 2.21 3.58 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.58 4 8 4s8-1.79 8-4M4 7c0-2.21 3.58-4 8-4s8 1.79 8 4m0 5c0 2.21-3.58 4-8 4s-8-1.79-8-4"/></svg>
                            @elseif($category->name === 'Web Development')
                                <svg class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                            @else
                                <svg class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            @endif
                        </div>
                        <h3 class="text-base font-bold text-white">{{ $category->name }}</h3>
                        <p class="text-xs text-zinc-400 mt-2 line-clamp-3 leading-relaxed">{{ $category->description }}</p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-zinc-800/40">
                        <a href="{{ route('problems.index') }}?category={{ $category->id }}" class="text-xs font-semibold text-violet-400 hover:text-violet-300 inline-flex items-center gap-1">
                            Browse threads
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- 4. Features Section -->
    <section class="max-w-7xl mx-auto px-6 py-20 relative z-10 border-t border-zinc-900">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-3xl font-extrabold text-white tracking-tight">Everything you need to <span class="bg-gradient-to-r from-indigo-400 to-violet-400 bg-clip-text text-transparent">solve faster</span></h2>
            <p class="text-sm md:text-base text-zinc-400 mt-3">Avoid getting stuck for hours. Tap into the developer collective knowledge.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="p-8 bg-zinc-900/30 border border-zinc-800 rounded-2xl flex gap-6">
                <div class="w-12 h-12 rounded-xl bg-violet-500/10 border border-violet-500/20 text-violet-400 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Ask Questions</h3>
                    <p class="text-sm text-zinc-400 mt-2 leading-relaxed">Post detailed problems, assign categories, and upload screenshots of stack traces or code layout blocks for clean, readable debugging.</p>
                </div>
            </div>

            <div class="p-8 bg-zinc-900/30 border border-zinc-800 rounded-2xl flex gap-6">
                <div class="w-12 h-12 rounded-xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Share Solutions</h3>
                    <p class="text-sm text-zinc-400 mt-2 leading-relaxed">Provide markdown-formatted answers with syntax-highlighted code blocks, write explanations, and help others debug their software problems.</p>
                </div>
            </div>

            <div class="p-8 bg-zinc-900/30 border border-zinc-800 rounded-2xl flex gap-6">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Community Discussions</h3>
                    <p class="text-sm text-zinc-400 mt-2 leading-relaxed">Engage in collaborative discussions. Upvote correct explanations, comment on answers, and refine steps to build a repository of verified solutions.</p>
                </div>
            </div>

            <div class="p-8 bg-zinc-900/30 border border-zinc-800 rounded-2xl flex gap-6">
                <div class="w-12 h-12 rounded-xl bg-pink-500/10 border border-pink-500/20 text-pink-400 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Organized Learning</h3>
                    <p class="text-sm text-zinc-400 mt-2 leading-relaxed">Browse solved questions by specific tags or academic disciplines. Build a clear, structured understanding of core concepts with real examples.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Testimonials Section -->
    <section class="max-w-7xl mx-auto px-6 py-20 relative z-10 border-t border-zinc-900">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-3xl font-extrabold text-white tracking-tight">Loved by Developer Community</h2>
            <p class="text-sm md:text-base text-zinc-400 mt-3">See how developers and students use SolveSphere to accelerate their problem solving.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-6 bg-zinc-900/30 border border-zinc-800 rounded-2xl flex flex-col justify-between">
                <p class="text-sm text-zinc-300 leading-relaxed italic">
                    "SolveSphere has completely replaced standard debugging search queries for me. Whenever I hit an esoteric error in Laravel or React, there is already a detailed discussion thread with step-by-step instructions."
                </p>
                <div class="flex items-center gap-3 mt-6 border-t border-zinc-800/40 pt-4">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-violet-600 to-indigo-500 flex items-center justify-center font-bold text-white text-xs">
                        MH
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-white">Michael H.</h4>
                        <span class="text-xs text-zinc-500">Full Stack Engineer</span>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-zinc-900/30 border border-zinc-800 rounded-2xl flex flex-col justify-between">
                <p class="text-sm text-zinc-300 leading-relaxed italic">
                    "As a computer science student, I struggle with complex operating system scheduling and DBMS normalization questions. The categorized approach here makes it easy to research core topics and view clean explanations."
                </p>
                <div class="flex items-center gap-3 mt-6 border-t border-zinc-800/40 pt-4">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-fuchsia-600 to-pink-500 flex items-center justify-center font-bold text-white text-xs">
                        AL
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-white">Alice L.</h4>
                        <span class="text-xs text-zinc-500">CS Student at MIT</span>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-zinc-900/30 border border-zinc-800 rounded-2xl flex flex-col justify-between">
                <p class="text-sm text-zinc-300 leading-relaxed italic">
                    "I love contributing answers on SolveSphere. The editor handles code styling cleanly, and marking answers as 'solved' gives a real sense of accomplishment while building a portfolio of my problem-solving skills."
                </p>
                <div class="flex items-center gap-3 mt-6 border-t border-zinc-800/40 pt-4">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-cyan-600 to-teal-500 flex items-center justify-center font-bold text-white text-xs">
                        SK
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-white">Siddharth K.</h4>
                        <span class="text-xs text-zinc-500">Systems Developer</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. Modern Footer -->
    <footer class="border-t border-zinc-900 bg-zinc-950 text-zinc-500 text-sm">
        <div class="max-w-7xl mx-auto px-6 py-12 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-violet-600 to-indigo-500 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                    </svg>
                </div>
                <span class="font-bold text-white">SolveSphere</span>
            </div>

            <p class="text-xs text-zinc-650">© {{ date('Y') }} SolveSphere – Knowledge Sharing Platform. All rights reserved.</p>

            <div class="flex items-center gap-6 text-zinc-400">
                <a href="{{ route('problems.index') }}" class="hover:text-white transition-colors">Explore</a>
                <a href="{{ route('login') }}" class="hover:text-white transition-colors">Login</a>
                <a href="{{ route('register') }}" class="hover:text-white transition-colors">Register</a>
            </div>
        </div>
    </footer>

    <!-- Toast Notifications -->
    <x-toast />
</body>
</html>
