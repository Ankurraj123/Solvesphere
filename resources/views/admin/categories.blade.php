@extends('layouts.app')

@section('title', 'Manage Categories – SolveSphere')
@section('page_title', 'Category Console')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Left: List of Categories -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 shadow-lg">
            <div class="border-b border-zinc-800/80 pb-4 mb-6">
                <h3 class="text-base font-bold text-white">Existing Categories</h3>
                <p class="text-xs text-zinc-400 mt-0.5">Manage topic categorization rules and descriptions for problem filtering.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-zinc-800/80 text-3xs font-semibold text-zinc-500 uppercase tracking-widest">
                            <th class="pb-3">Name</th>
                            <th class="pb-3">Description</th>
                            <th class="pb-3 text-center">Problems</th>
                            <th class="pb-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800/40 text-sm text-zinc-300">
                        @foreach($categories as $cat)
                            <!-- Normal Row -->
                            <tr id="cat-row-{{ $cat->id }}">
                                <td class="py-4 font-bold text-white">{{ $cat->name }}</td>
                                <td class="py-4 text-zinc-400 max-w-xs truncate" title="{{ $cat->description }}">{{ $cat->description ?: 'No description' }}</td>
                                <td class="py-4 text-center font-semibold text-zinc-400">{{ $cat->problems_count }}</td>
                                <td class="py-4 text-right space-x-1.5 whitespace-nowrap">
                                    <button type="button" onclick="toggleEditCategory({{ $cat->id }})" class="inline-flex items-center justify-center p-1.5 bg-zinc-850 hover:bg-zinc-800 border border-zinc-750 text-zinc-300 hover:text-white rounded-lg transition-colors cursor-pointer" title="Edit inline">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </button>
                                    
                                    <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="inline-block m-0" onsubmit="return confirm('Deleting category will cascade and remove all associated questions. Proceed?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center p-1.5 bg-rose-500/10 hover:bg-rose-500 border border-rose-500/20 text-rose-400 hover:text-white rounded-lg transition-colors cursor-pointer" title="Delete Category">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Edit Row (Hidden by default) -->
                            <tr id="cat-edit-row-{{ $cat->id }}" class="hidden bg-zinc-950/40">
                                <td colspan="4" class="p-4">
                                    <form action="{{ route('admin.categories.update', $cat->id) }}" method="POST" class="space-y-4 m-0">
                                        @csrf
                                        @method('PUT')
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div class="md:col-span-1">
                                                <label class="block text-4xs font-bold text-zinc-550 uppercase tracking-widest mb-1.5">Category Name</label>
                                                <input type="text" name="name" required value="{{ $cat->name }}"
                                                       class="w-full px-3 py-2 rounded-lg bg-zinc-950 border border-zinc-800 text-white text-xs focus:outline-none focus:border-violet-500">
                                            </div>
                                            <div class="md:col-span-2">
                                                <label class="block text-4xs font-bold text-zinc-550 uppercase tracking-widest mb-1.5">Description</label>
                                                <input type="text" name="description" value="{{ $cat->description }}"
                                                       class="w-full px-3 py-2 rounded-lg bg-zinc-950 border border-zinc-800 text-white text-xs focus:outline-none focus:border-violet-500">
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2.5 justify-end">
                                            <button type="submit" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold text-white bg-violet-650 hover:bg-violet-600 transition-colors cursor-pointer">Save Changes</button>
                                            <button type="button" onclick="toggleEditCategory({{ $cat->id }})" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold text-zinc-400 hover:text-white transition-colors">Cancel</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right: Create Category Form -->
    <div class="space-y-6">
        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 shadow-lg">
            <div class="border-b border-zinc-800/80 pb-4 mb-6">
                <h3 class="text-base font-bold text-white">Create Category</h3>
                <p class="text-xs text-zinc-400 mt-0.5">Register a new CS or programming classification.</p>
            </div>

            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="new_name" class="block text-xs font-semibold text-zinc-300 uppercase tracking-wider mb-2">Category Name</label>
                    <input id="new_name" name="name" type="text" required value="{{ old('name') }}"
                           class="w-full px-4 py-3 rounded-xl bg-zinc-950 border border-zinc-800 text-white placeholder-zinc-500 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 transition-all text-sm"
                           placeholder="e.g. System Design">
                </div>

                <div>
                    <label for="new_description" class="block text-xs font-semibold text-zinc-300 uppercase tracking-wider mb-2">Description</label>
                    <textarea id="new_description" name="description" rows="4"
                              class="w-full px-4 py-3 rounded-xl bg-zinc-950 border border-zinc-800 text-white placeholder-zinc-500 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 transition-all text-sm"
                              placeholder="Describe which topics fit under this categorization..."></textarea>
                </div>

                <div>
                    <button type="submit" class="w-full py-3 px-4 text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-violet-600 to-indigo-500 hover:from-violet-500 hover:to-indigo-400 shadow-lg shadow-indigo-500/10 hover:shadow-indigo-500/20 transition-all cursor-pointer">
                        Add Category
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<!-- Inline Editor toggle script -->
<script>
    function toggleEditCategory(id) {
        const row = document.getElementById('cat-row-' + id);
        const editRow = document.getElementById('cat-edit-row-' + id);
        if (row && editRow) {
            row.classList.toggle('hidden');
            editRow.classList.toggle('hidden');
        }
    }
</script>
@endsection
