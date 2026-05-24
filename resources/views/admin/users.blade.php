@extends('layouts.app')

@section('title', 'Manage Users – SolveSphere')
@section('page_title', 'User Accounts')

@section('content')
<div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 shadow-lg">
    <div class="border-b border-zinc-800/80 pb-4 mb-6">
        <h3 class="text-base font-bold text-white">Registered Users</h3>
        <p class="text-xs text-zinc-400 mt-0.5">Toggle administrative privileges or remove inappropriate member profiles.</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-zinc-800/80 text-3xs font-semibold text-zinc-500 uppercase tracking-widest">
                    <th class="pb-3">Name</th>
                    <th class="pb-3">Email Address</th>
                    <th class="pb-3">Access Role</th>
                    <th class="pb-3 text-center">Questions</th>
                    <th class="pb-3 text-center">Solutions</th>
                    <th class="pb-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800/40 text-sm text-zinc-300">
                @foreach($users as $u)
                    <tr>
                        <td class="py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-zinc-800 border border-zinc-750 flex items-center justify-center font-bold text-zinc-350 text-xs">
                                    {{ substr($u->name ?? 'U', 0, 1) }}
                                </div>
                                <span class="font-bold text-white">{{ $u->name }}</span>
                                @if(auth()->id() === $u->id)
                                    <span class="px-1.5 py-0.5 rounded text-4xs bg-zinc-800 border border-zinc-750 text-zinc-450 uppercase font-bold tracking-wider">You</span>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 text-zinc-405">{{ $u->email }}</td>
                        <td class="py-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-3xs font-bold border uppercase tracking-wider {{ $u->isAdmin() ? 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20' : 'bg-zinc-800 text-zinc-450 border border-zinc-700/80' }}">
                                {{ $u->role }}
                            </span>
                        </td>
                        <td class="py-4 text-center font-semibold text-zinc-400">{{ $u->problems_count }}</td>
                        <td class="py-4 text-center font-semibold text-zinc-400">{{ $u->answers_count }}</td>
                        <td class="py-4 text-right whitespace-nowrap">
                            @if(auth()->id() !== $u->id)
                                <!-- Toggle Role Button -->
                                <form action="{{ route('admin.users.role', $u->id) }}" method="POST" class="inline-block m-0">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 rounded-lg text-2xs font-semibold border cursor-pointer transition-colors bg-zinc-850 hover:bg-zinc-800 text-zinc-300 hover:text-white border-zinc-750 hover:border-zinc-700">
                                        {{ $u->isAdmin() ? 'Demote' : 'Make Admin' }}
                                    </button>
                                </form>

                                <!-- Delete User Button -->
                                <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="inline-block m-0" onsubmit="return confirm('Deleting this user will cascade and wipe all their questions and solutions. Proceed?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 bg-rose-500/10 hover:bg-rose-500 border border-rose-500/20 text-rose-455 hover:text-white rounded-lg transition-colors cursor-pointer ml-1.5" title="Delete User">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            @else
                                <span class="text-3xs text-zinc-550 italic font-medium pr-3.5">Self protection active</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
