@props([
    'title' => 'No items found',
    'description' => 'Try creating a new item or adjusting your filters.',
    'actionUrl' => null,
    'actionText' => null
])

<div class="flex flex-col items-center justify-center p-10 text-center bg-zinc-950/40 border border-zinc-800/60 rounded-2xl backdrop-blur-sm">
    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-zinc-900/80 border border-zinc-800 mb-5 text-zinc-400">
        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
        </svg>
    </div>
    <h3 class="text-lg font-semibold text-white mb-2">{{ $title }}</h3>
    <p class="text-sm text-zinc-400 max-w-sm mb-6 leading-relaxed">{{ $description }}</p>
    @if ($actionUrl && $actionText)
        <a href="{{ $actionUrl }}" class="inline-flex items-center justify-center px-4.5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-500 hover:to-indigo-500 rounded-xl shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/30 transform hover:-translate-y-0.5 transition-all duration-200">
            {{ $actionText }}
        </a>
    @endif
</div>
