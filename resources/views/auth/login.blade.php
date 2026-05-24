@extends('layouts.auth')

@section('title', 'Sign In – SolveSphere')

@section('content')
<div class="bg-zinc-900/80 border border-zinc-800 rounded-2xl shadow-2xl backdrop-blur-md p-8">
    <div class="mb-6">
        <h2 class="text-xl font-bold text-white tracking-tight">Welcome back</h2>
        <p class="text-sm text-zinc-400 mt-1">Please enter your details to access your account.</p>
    </div>

    <form action="{{ route('login') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-xs font-semibold text-zinc-300 uppercase tracking-wider mb-2">Email Address</label>
            <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                   class="w-full px-4 py-3 rounded-xl bg-zinc-950 border border-zinc-800 text-white placeholder-zinc-500 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 transition-all text-sm @error('email') border-rose-500/50 @enderror"
                   placeholder="you@domain.com">
            @error('email')
                <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-xs font-semibold text-zinc-300 uppercase tracking-wider mb-2">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required
                   class="w-full px-4 py-3 rounded-xl bg-zinc-950 border border-zinc-800 text-white placeholder-zinc-500 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 transition-all text-sm"
                   placeholder="••••••••">
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox"
                       class="h-4.5 w-4.5 rounded-lg bg-zinc-950 border-zinc-800 text-violet-600 focus:ring-violet-500/20 focus:ring-offset-0">
                <label for="remember" class="ml-2 block text-sm text-zinc-400">Remember me</label>
            </div>
        </div>

        <div>
            <button type="submit"
                    class="w-full py-3 px-4 text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-violet-600 to-indigo-500 hover:from-violet-500 hover:to-indigo-400 shadow-lg shadow-indigo-500/10 hover:shadow-indigo-500/25 transform hover:-translate-y-0.5 transition-all duration-200 cursor-pointer">
                Sign In
            </button>
        </div>
    </form>

    <div class="mt-6 pt-6 border-t border-zinc-800/80 text-center">
        <p class="text-sm text-zinc-400">
            Don't have an account?
            <a href="{{ route('register') }}" class="font-medium text-violet-400 hover:text-violet-300 transition-colors">Create one now</a>
        </p>
    </div>
</div>
@endsection
