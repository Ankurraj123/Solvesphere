@extends('layouts.app')

@section('title', 'Content Moderation – SolveSphere')
@section('page_title', 'Content Moderation')

@section('content')
<div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 shadow-lg">
    <div class="border-b border-zinc-800/80 pb-4 mb-6">
        <h3 class="text-base font-bold text-white">Platform Content Moderation</h3>
        <p class="text-xs text-zinc-400 mt-0.5">Moderate questions and discussions. Delete inappropriate, duplicate, or abusive threads.</p>
    </div>

    @if($problems->isEmpty())
        <x-empty-state title="No content found" description="There are currently no discussions posted on the platform." />
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-zinc-800/80 text-3xs font-semibold text-zinc-500 uppercase tracking-widest">
                        <th class="pb-3">Title</th>
                        <th class="pb-3">Author</th>
                        <th class="pb-3">Category</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3">Created</th>
                        <th class="pb-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800/40 text-sm text-zinc-300">
                    @foreach($problems as $prob)
                        <tr>
                            <td class="py-4 font-bold text-white max-w-sm truncate">
                                <a href="{{ route('problems.show', $prob->id) }}" class="hover:text-violet-400 transition-colors">
                                    {{ $prob->title }}
                                </a>
                            </td>
                            <td class="py-4 text-zinc-400">{{ $prob->user->name }}</td>
                            <td class="py-4">
                                <span class="px-2 py-0.5 rounded bg-zinc-800 border border-zinc-700/80 text-zinc-450 text-3xs font-semibold">
                                    {{ $prob->category->name }}
                                </span>
                            </td>
                            <td class="py-4">
                                <span class="px-2 py-0.5 rounded-full text-4xs font-bold border uppercase tracking-wider {{ $prob->isSolved() ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/15' : 'bg-amber-500/10 text-amber-400 border-amber-500/15' }}">
                                    {{ $prob->status }}
                                </span>
                            </td>
                            <td class="py-4 text-zinc-500 text-xs">{{ $prob->created_at->format('M d, Y') }}</td>
                            <td class="py-4 text-right">
                                <form action="{{ route('problems.destroy', $prob->id) }}" method="POST" class="inline-block m-0" onsubmit="return confirm('Are you sure you want to delete this post?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-2xs font-semibold text-rose-400 bg-rose-500/10 hover:bg-rose-500 hover:text-white border border-rose-500/20 hover:border-rose-500 transition-colors cursor-pointer">
                                        Delete Post
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pt-6">
            {{ $problems->links() }}
        </div>
    @endif
</div>
@endsection
