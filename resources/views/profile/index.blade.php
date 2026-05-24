@extends('layouts.app')

@section('title', 'Profile Settings – SolveSphere')
@section('page_title', 'Profile Settings')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Profile Update Form -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl shadow-xl p-8">
                <div class="border-b border-zinc-800/80 pb-4 mb-6">
                    <h3 class="text-base font-bold text-white">Account Details</h3>
                    <p class="text-xs text-zinc-400 mt-0.5">Update your registration details, username, email, and access passwords.</p>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-xs font-semibold text-zinc-300 uppercase tracking-wider mb-2">Display Name</label>
                        <input id="name" name="name" type="text" required value="{{ old('name', $user->name) }}"
                               class="w-full px-4 py-3 rounded-xl bg-zinc-950 border border-zinc-800 text-white placeholder-zinc-500 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 transition-all text-sm @error('name') border-rose-500/50 @enderror">
                        @error('name')
                            <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-zinc-300 uppercase tracking-wider mb-2">Email Address</label>
                        <input id="email" name="email" type="email" required value="{{ old('email', $user->email) }}"
                               class="w-full px-4 py-3 rounded-xl bg-zinc-950 border border-zinc-800 text-white placeholder-zinc-500 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 transition-all text-sm @error('email') border-rose-500/50 @enderror">
                        @error('email')
                            <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password divider -->
                    <div class="pt-4 border-t border-zinc-800/60 mt-6">
                        <h4 class="text-xs font-semibold text-zinc-300 uppercase tracking-wider mb-1">Change Password</h4>
                        <p class="text-3xs text-zinc-500 mb-4">Leave empty if you do not wish to update your password.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-xs font-semibold text-zinc-300 uppercase tracking-wider mb-2">New Password</label>
                            <input id="password" name="password" type="password"
                                   class="w-full px-4 py-3 rounded-xl bg-zinc-950 border border-zinc-800 text-white placeholder-zinc-500 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 transition-all text-sm @error('password') border-rose-500/50 @enderror"
                                   placeholder="••••••••">
                            @error('password')
                                <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-xs font-semibold text-zinc-300 uppercase tracking-wider mb-2">Confirm New Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password"
                                   class="w-full px-4 py-3 rounded-xl bg-zinc-950 border border-zinc-800 text-white placeholder-zinc-500 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 transition-all text-sm"
                                   placeholder="••••••••">
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="flex justify-end pt-4 border-t border-zinc-800/80">
                        <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-violet-600 to-indigo-500 hover:from-violet-500 hover:to-indigo-400 shadow-lg shadow-indigo-500/10 hover:shadow-indigo-500/20 transition-all cursor-pointer">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Column: Contribution Statistics & Activity -->
        <div class="space-y-6">
            <!-- Stats overview -->
            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 shadow-xl space-y-4">
                <div class="border-b border-zinc-800/80 pb-3">
                    <h3 class="text-sm font-bold text-white">Contribution Metrics</h3>
                </div>
                
                <div class="grid grid-cols-3 gap-3">
                    <div class="p-3.5 bg-zinc-950/60 border border-zinc-850 rounded-xl text-center">
                        <span class="text-lg font-bold text-white block">{{ $problemsCount }}</span>
                        <span class="text-4xs text-zinc-550 font-bold uppercase tracking-wider">Posts</span>
                    </div>
                    <div class="p-3.5 bg-zinc-950/60 border border-zinc-850 rounded-xl text-center">
                        <span class="text-lg font-bold text-white block">{{ $answersCount }}</span>
                        <span class="text-4xs text-zinc-550 font-bold uppercase tracking-wider">Answers</span>
                    </div>
                    <div class="p-3.5 bg-zinc-950/60 border border-zinc-850 rounded-xl text-center">
                        <span class="text-lg font-bold text-white block">{{ $solvedCount }}</span>
                        <span class="text-4xs text-zinc-550 font-bold uppercase tracking-wider">Solved</span>
                    </div>
                </div>
            </div>

            <!-- Recent posts activity -->
            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 shadow-xl">
                <div class="border-b border-zinc-800/80 pb-3 mb-4">
                    <h3 class="text-sm font-bold text-white">Your Recent Posts</h3>
                </div>

                @if($recentProblems->isEmpty())
                    <div class="text-center py-6">
                        <p class="text-xs text-zinc-500">You haven't posted any questions yet.</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($recentProblems as $prob)
                            <div class="p-3 bg-zinc-950/45 border border-zinc-850 hover:border-zinc-800 rounded-xl transition-all duration-200">
                                <a href="{{ route('problems.show', $prob->id) }}" class="text-xs font-bold text-zinc-200 hover:text-violet-400 block truncate">
                                    {{ $prob->title }}
                                </a>
                                <div class="flex items-center justify-between mt-2 text-4xs text-zinc-500">
                                    <span>{{ $prob->created_at->format('M d, Y') }}</span>
                                    <span class="uppercase font-semibold {{ $prob->isSolved() ? 'text-emerald-450' : 'text-amber-450' }}">{{ $prob->status }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
