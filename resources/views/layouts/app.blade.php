<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-zinc-950">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SolveSphere Dashboard')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- ApexCharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #09090b;
        }
        ::-webkit-scrollbar-thumb {
            background: #27272a;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #3f3f46;
        }
    </style>
</head>
<body class="h-full bg-zinc-950 text-gray-100 flex flex-col md:flex-row overflow-hidden">

    <!-- Mobile Header -->
    <header class="md:hidden flex items-center justify-between px-6 py-4 bg-zinc-900 border-b border-zinc-800 shrink-0">
        <a href="{{ route('home') }}" class="flex items-center gap-2 group">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-violet-600 to-indigo-500 flex items-center justify-center shadow-lg shadow-indigo-500/20">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                </svg>
            </div>
            <span class="font-bold tracking-tight text-white">SolveSphere</span>
        </a>
        <button id="mobile-sidebar-toggle" class="p-1.5 text-zinc-400 hover:text-white rounded-lg hover:bg-zinc-800">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </header>

    <!-- Sidebar Navigation -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 md:relative md:translate-x-0 -translate-x-full transition-transform duration-300 ease-in-out flex flex-col bg-zinc-900 border-r border-zinc-800 shrink-0">
        
        <!-- Logo Header -->
        <div class="h-16 flex items-center justify-between px-6 border-b border-zinc-800 shrink-0">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-violet-600 to-indigo-500 flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:scale-105 transition-transform duration-200">
                    <svg class="w-5.5 h-5.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                    </svg>
                </div>
                <span class="text-xl font-bold tracking-tight text-white">SolveSphere</span>
            </a>
            <button id="mobile-sidebar-close" class="md:hidden p-1.5 text-zinc-400 hover:text-white rounded-lg hover:bg-zinc-800">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Sidebar Content -->
        <div class="flex-1 overflow-y-auto px-4 py-6 space-y-7">
            <!-- User Info Summary / Guest Options -->
            @auth
            <div class="flex items-center gap-3 px-2">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-zinc-700 to-zinc-800 flex items-center justify-center border border-zinc-700 font-bold text-zinc-200 shadow-inner">
                    {{ substr(Auth::user()->name ?? 'U', 0, 2) }}
                </div>
                <div class="overflow-hidden">
                    <h4 class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</h4>
                    <span class="inline-flex items-center px-2 py-0.5 mt-0.5 rounded-full text-3xs font-medium {{ Auth::user()->isAdmin() ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' : 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' }}">
                        {{ Auth::user()->role === 'admin' ? 'Administrator' : 'Developer' }}
                    </span>
                </div>
            </div>
            @endauth
            @guest
            <div class="px-3 py-4 bg-zinc-950/40 border border-zinc-800/50 rounded-2xl text-center space-y-3">
                <p class="text-2xs text-zinc-400">Join SolveSphere to ask questions and post solutions!</p>
                <div class="flex gap-2">
                    <a href="{{ route('login') }}" class="flex-1 text-center py-2 px-2 bg-zinc-800 hover:bg-zinc-750 text-white rounded-xl text-xs font-semibold border border-zinc-700/50 transition-colors">Sign In</a>
                    <a href="{{ route('register') }}" class="flex-1 text-center py-2 px-2 bg-gradient-to-r from-violet-600 to-indigo-500 hover:from-violet-500 hover:to-indigo-400 text-white rounded-xl text-xs font-semibold shadow-md transition-colors">Sign Up</a>
                </div>
            </div>
            @endguest

            <!-- Main Menu -->
            <div>
                <span class="px-3 text-3xs font-semibold tracking-wider text-zinc-500 uppercase block mb-3">Platform</span>
                <nav class="space-y-1">
                    @auth
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('dashboard') ? 'bg-zinc-800 text-white shadow-sm border border-zinc-700/50' : 'text-zinc-400 hover:text-zinc-200 hover:bg-zinc-800/40 border border-transparent' }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                        </svg>
                        Dashboard
                    </a>
                    @endauth
                    <a href="{{ route('problems.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('problems.index') || request()->routeIs('problems.show') ? 'bg-zinc-800 text-white shadow-sm border border-zinc-700/50' : 'text-zinc-400 hover:text-zinc-200 hover:bg-zinc-800/40 border border-transparent' }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Explore Problems
                    </a>
                    <a href="{{ route('problems.create') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('problems.create') ? 'bg-zinc-800 text-white shadow-sm border border-zinc-700/50' : 'text-zinc-400 hover:text-zinc-200 hover:bg-zinc-800/40 border border-transparent' }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Ask a Question
                    </a>
                    @auth
                    <a href="{{ route('profile.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('profile.index') ? 'bg-zinc-800 text-white shadow-sm border border-zinc-700/50' : 'text-zinc-400 hover:text-zinc-200 hover:bg-zinc-800/40 border border-transparent' }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profile Settings
                    </a>
                    @endauth
                </nav>
            </div>

            <!-- Admin Menu -->
            @if(Auth::check() && Auth::user()->isAdmin())
            <div>
                <span class="px-3 text-3xs font-semibold tracking-wider text-indigo-400 uppercase block mb-3">Admin Console</span>
                <nav class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-650 text-white shadow-sm border border-indigo-650' : 'text-zinc-450 hover:text-zinc-200 hover:bg-zinc-800/40 border border-transparent' }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z" />
                        </svg>
                        Overview Analytics
                    </a>
                    <a href="{{ route('admin.categories') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.categories') ? 'bg-indigo-650 text-white shadow-sm border border-indigo-650' : 'text-zinc-450 hover:text-zinc-200 hover:bg-zinc-800/40 border border-transparent' }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Manage Categories
                    </a>
                    <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.users') ? 'bg-indigo-650 text-white shadow-sm border border-indigo-650' : 'text-zinc-450 hover:text-zinc-200 hover:bg-zinc-800/40 border border-transparent' }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Manage Users
                    </a>
                    <a href="{{ route('admin.content') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.content') ? 'bg-indigo-650 text-white shadow-sm border border-indigo-650' : 'text-zinc-450 hover:text-zinc-200 hover:bg-zinc-800/40 border border-transparent' }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Content Moderation
                    </a>
                </nav>
            </div>
            @endif
        </div>

        @auth
        <!-- Logout Section -->
        <div class="p-4 border-t border-zinc-800 shrink-0">
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="flex items-center justify-center gap-2.5 w-full px-4 py-2.5 rounded-xl text-sm font-medium text-rose-400 hover:text-white bg-rose-500/10 hover:bg-rose-500 border border-rose-500/20 hover:border-rose-500 transition-all cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout Session
                </button>
            </form>
        </div>
        @endauth
    </aside>

    <!-- Overlay backdrops for mobile sidebar -->
    <div id="sidebar-overlay" class="fixed inset-0 z-30 bg-black/60 hidden transition-opacity duration-300 ease-in-out md:hidden"></div>

    <!-- Main Container -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto relative">
        
        <!-- Top bar -->
        <header class="h-16 border-b border-zinc-800 bg-zinc-900/60 backdrop-blur-md px-8 flex items-center justify-between shrink-0 sticky top-0 z-20">
            <div class="flex items-center gap-4">
                <h1 class="text-lg font-bold text-white tracking-tight">@yield('page_title', 'Overview')</h1>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('problems.index') }}" class="hidden sm:inline-flex items-center px-4.5 py-2 text-sm font-medium text-white bg-zinc-800 hover:bg-zinc-700 border border-zinc-700/50 rounded-xl transition-all">
                    Search Discussions
                </a>
                <a href="{{ route('problems.create') }}" class="inline-flex items-center px-4.5 py-2 text-sm font-medium text-white bg-gradient-to-r from-violet-600 to-indigo-500 hover:from-violet-500 hover:to-indigo-400 rounded-xl shadow-lg shadow-indigo-500/10 hover:shadow-indigo-500/20 transition-all">
                    Ask Question
                </a>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-8">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="py-6 border-t border-zinc-800 bg-zinc-950 text-center shrink-0">
            <p class="text-xs text-zinc-500">© {{ date('Y') }} SolveSphere Platform. Crafted with modern Laravel & Tailwind CSS.</p>
        </footer>
    </div>

    <!-- Toast Notifications -->
    <x-toast />

    <!-- Script for mobile menu -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('mobile-sidebar-toggle');
            const closeBtn = document.getElementById('mobile-sidebar-close');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            function toggleSidebar() {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
                document.body.classList.toggle('overflow-hidden');
            }

            if (toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
            if (closeBtn) closeBtn.addEventListener('click', toggleSidebar);
            if (overlay) overlay.addEventListener('click', toggleSidebar);
        });
    </script>
</body>
</html>
