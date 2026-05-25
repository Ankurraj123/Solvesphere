@extends('layouts.app')

@section('title', $problem->title . ' – SolveSphere')
@section('page_title', 'Discussion Thread')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    
    <!-- Navigation Back Link -->
    <div class="flex items-center justify-between shrink-0">
        <a href="{{ route('problems.index') }}" class="inline-flex items-center text-xs font-semibold text-zinc-550 hover:text-zinc-300 gap-1.5 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Back to Explore
        </a>
    </div>

    <!-- Main Problem Question Post -->
    <article class="bg-zinc-900 border border-zinc-800 rounded-2xl shadow-xl p-8 relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_right_top,rgba(99,102,241,0.06),transparent_35%)] pointer-events-none"></div>

        <div class="relative z-10 space-y-6">
            <!-- Header Metadata -->
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-zinc-800 border border-zinc-700/80 flex items-center justify-center font-bold text-zinc-200 text-sm shadow-inner">
                        {{ substr($problem->user->name ?? 'U', 0, 2) }}
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-white leading-tight">{{ $problem->user->name }}</h4>
                        <span class="text-3xs text-zinc-500 mt-0.5 block">Asked {{ $problem->created_at->diffForHumans() }} in <span class="text-violet-400 font-medium">{{ $problem->category->name }}</span></span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 rounded-full text-2xs font-bold border uppercase tracking-wider {{ $problem->isSolved() ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-amber-500/10 text-amber-400 border-amber-500/20' }}">
                        {{ $problem->status }}
                    </span>

                    <!-- Mark as Solved (Owner only) -->
                    @if(Auth::check() && (string) Auth::id() === (string) $problem->user_id)
                        <form action="{{ route('problems.solved', $problem->id) }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="px-3.5 py-1.5 rounded-xl text-2xs font-semibold border cursor-pointer transition-all {{ $problem->isSolved() ? 'bg-zinc-800 hover:bg-zinc-750 text-zinc-400 border-zinc-700 hover:text-white' : 'bg-emerald-500/10 hover:bg-emerald-500 text-emerald-400 hover:text-white border-emerald-500/20 hover:border-emerald-500 shadow-md shadow-emerald-500/5' }}">
                                {{ $problem->isSolved() ? 'Reopen Issue' : 'Mark as Solved' }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Title -->
            <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight leading-snug">
                {{ $problem->title }}
            </h2>

            <!-- Description Body -->
            <div class="text-sm text-zinc-300 leading-relaxed whitespace-pre-wrap break-words">
                {{ $problem->description }}
            </div>

            <!-- Attached Image if present -->
            @if($problem->image)
                <div class="bg-zinc-950 p-4 border border-zinc-800 rounded-xl overflow-hidden shadow-inner max-w-2xl">
                    <p class="text-3xs text-zinc-500 uppercase font-semibold mb-3">Attached Screenshot:</p>
                    <a href="{{ str_starts_with($problem->image, 'data:') ? $problem->image : asset($problem->image) }}" target="_blank">
                        <img src="{{ str_starts_with($problem->image, 'data:') ? $problem->image : asset($problem->image) }}" class="rounded-lg max-h-96 w-auto object-contain hover:opacity-90 transition-opacity" alt="Problem Screenshot">
                    </a>
                </div>
            @endif

            <!-- Moderation / Editing Tools -->
            @if(Auth::check() && ((string) Auth::id() === (string) $problem->user_id || Auth::user()->isAdmin()))
                <div class="flex items-center gap-3 pt-6 border-t border-zinc-800/80">
                    @if((string) Auth::id() === (string) $problem->user_id || Auth::user()->isAdmin())
                        <a href="{{ route('problems.edit', $problem->id) }}" class="inline-flex items-center gap-1.5 px-4.5 py-2 rounded-xl text-xs font-semibold text-zinc-300 bg-zinc-800 hover:bg-zinc-750 border border-zinc-750 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            Edit
                        </a>
                        <form action="{{ route('problems.destroy', $problem->id) }}" method="POST" class="m-0" onsubmit="return confirm('Are you sure you want to permanently delete this discussion thread?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-1.5 px-4.5 py-2 rounded-xl text-xs font-semibold text-rose-400 bg-rose-500/10 hover:bg-rose-500 hover:text-white border border-rose-500/20 hover:border-rose-500 transition-colors cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Delete
                            </button>
                        </form>
                    @endif
                </div>
            @endif
        </div>
    </article>

    <!-- Solutions / Answers Section -->
    <div class="space-y-6">
        <h3 class="text-base font-bold text-white border-b border-zinc-800/80 pb-3">
            {{ $problem->answers->count() }} Solutions / Answers
        </h3>

        @if($problem->answers->isEmpty())
            <x-empty-state title="No answers posted yet" description="Do you know the solution? Be the first to contribute by posting an answer below." />
        @else
            <div class="space-y-6">
                @foreach($problem->answers as $ans)
                    <div class="p-6 bg-zinc-900/50 border border-zinc-850 rounded-2xl shadow-lg relative flex flex-col justify-between">
                        <div class="space-y-4">
                            <!-- Answerer Meta -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-zinc-800 border border-zinc-700/60 flex items-center justify-center font-bold text-zinc-300 text-xs shadow-inner">
                                        {{ substr($ans->user->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-semibold text-white leading-tight">
                                            {{ $ans->user->name }}
                                            @if((string) $ans->user_id === (string) $problem->user_id)
                                                <span class="ml-1 text-4xs bg-violet-500/10 text-violet-400 px-1.5 py-0.5 rounded font-bold uppercase tracking-wider border border-violet-500/15">Owner</span>
                                            @endif
                                        </h4>
                                        <span class="text-4xs text-zinc-500 block mt-0.5">Answered {{ $ans->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>

                                <!-- Modify Buttons for Answer Owner or Admin -->
                                @if(Auth::check() && ((string) Auth::id() === (string) $ans->user_id || Auth::user()->isAdmin()))
                                    <div class="flex items-center gap-2">
                                        @if((string) Auth::id() === (string) $ans->user_id)
                                            <button type="button" onclick="toggleEditAnswer({{ $ans->id }})" class="p-1.5 text-zinc-550 hover:text-white rounded-lg hover:bg-zinc-800 transition-colors" title="Edit answer">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                            </button>
                                        @endif
                                        <form action="{{ route('answers.destroy', $ans->id) }}" method="POST" class="m-0" onsubmit="return confirm('Are you sure you want to delete this answer?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-rose-455/80 hover:text-rose-400 rounded-lg hover:bg-zinc-800 transition-colors cursor-pointer" title="Delete answer">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>

                            <!-- Answer Body Text -->
                            <div id="answer-text-{{ $ans->id }}" class="text-sm text-zinc-300 leading-relaxed whitespace-pre-wrap break-words">
                                {{ $ans->answer }}
                            </div>

                            <!-- Inline Edit Form (Hidden by default) -->
                            @if(Auth::check() && (string) Auth::id() === (string) $ans->user_id)
                                <form id="answer-edit-form-{{ $ans->id }}" action="{{ route('answers.update', $ans->id) }}" method="POST" class="hidden space-y-3 mt-4 pt-4 border-t border-zinc-800/40">
                                    @csrf
                                    @method('PUT')
                                    <textarea name="answer" rows="5" required
                                              class="w-full px-4 py-3 rounded-xl bg-zinc-950 border border-zinc-800 text-white placeholder-zinc-500 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 transition-all text-sm">{{ $ans->answer }}</textarea>
                                    <div class="flex items-center gap-2">
                                        <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-violet-650 rounded-xl hover:bg-violet-600 transition-colors cursor-pointer">Save Changes</button>
                                        <button type="button" onclick="toggleEditAnswer({{ $ans->id }})" class="px-4 py-2 text-xs font-semibold text-zinc-400 rounded-xl hover:text-white transition-colors">Cancel</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Post Answer Form -->
    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl shadow-xl p-8">
        <div class="border-b border-zinc-800/80 pb-4 mb-6">
            <h3 class="text-base font-bold text-white">Your Solution</h3>
            <p class="text-xs text-zinc-400 mt-0.5">Contribute code, explanation steps, and debug resolutions to help standard coding bugs.</p>
        </div>

        @auth
            <form action="{{ route('answers.store', $problem->id) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <textarea name="answer" rows="6" required
                              class="w-full px-4 py-3 rounded-xl bg-zinc-950 border border-zinc-800 text-white placeholder-zinc-500 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 transition-all text-sm"
                              placeholder="Write your explanation or paste your code snippet here..."></textarea>
                </div>
                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-violet-600 to-indigo-500 hover:from-violet-500 hover:to-indigo-400 shadow-lg shadow-indigo-500/10 hover:shadow-indigo-500/20 transition-all cursor-pointer">
                        Post Solution
                    </button>
                </div>
            </form>
        @else
            <div class="text-center p-6 bg-zinc-950/40 border border-zinc-850 rounded-xl">
                <p class="text-sm text-zinc-400">
                    You must be signed in to post a solution.
                    <a href="{{ route('login') }}" class="font-semibold text-violet-400 hover:text-violet-300 transition-colors ml-1">Sign In now</a>
                </p>
            </div>
        @endauth
    </div>

</div>

<script>
    function toggleEditAnswer(id) {
        const textDiv = document.getElementById('answer-text-' + id);
        const editForm = document.getElementById('answer-edit-form-' + id);
        if(textDiv && editForm) {
            textDiv.classList.toggle('hidden');
            editForm.classList.toggle('hidden');
        }
    }
</script>
@endsection
