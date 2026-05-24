@if (session('success') || session('error') || $errors->any())
<div id="toast-container" class="fixed top-6 right-6 z-50 flex flex-col gap-3 max-w-md w-full pointer-events-none">
    
    @if (session('success'))
    <div class="toast-item flex items-center p-4 text-gray-100 bg-zinc-900 border border-emerald-500/30 rounded-xl shadow-xl backdrop-blur-md pointer-events-auto transform transition-all duration-300 translate-x-12 opacity-0" role="alert">
        <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-emerald-400 bg-emerald-500/10 rounded-lg">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <div class="ms-3 text-sm font-medium pr-8">{{ session('success') }}</div>
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-transparent text-gray-400 hover:text-white rounded-lg p-1.5 inline-flex items-center justify-center h-8 w-8 focus:outline-none" onclick="this.parentElement.remove()" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>
    @endif

    @if (session('error'))
    <div class="toast-item flex items-center p-4 text-gray-100 bg-zinc-900 border border-rose-500/30 rounded-xl shadow-xl backdrop-blur-md pointer-events-auto transform transition-all duration-300 translate-x-12 opacity-0" role="alert">
        <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-rose-400 bg-rose-500/10 rounded-lg">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <div class="ms-3 text-sm font-medium pr-8">{{ session('error') }}</div>
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-transparent text-gray-400 hover:text-white rounded-lg p-1.5 inline-flex items-center justify-center h-8 w-8 focus:outline-none" onclick="this.parentElement.remove()" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>
    @endif

    @if ($errors->any())
    <div class="toast-item flex items-start p-4 text-gray-100 bg-zinc-900 border border-amber-500/30 rounded-xl shadow-xl backdrop-blur-md pointer-events-auto transform transition-all duration-300 translate-x-12 opacity-0" role="alert">
        <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-amber-400 bg-amber-500/10 rounded-lg mt-0.5">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <div class="ms-3 text-sm font-medium pr-8">
            <p class="font-semibold text-amber-400 mb-1">Please fix the following errors:</p>
            <ul class="list-disc pl-4 text-xs text-gray-300 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-transparent text-gray-400 hover:text-white rounded-lg p-1.5 inline-flex items-center justify-center h-8 w-8 focus:outline-none" onclick="this.parentElement.remove()" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const items = document.querySelectorAll('.toast-item');
        items.forEach((item, index) => {
            // Delay entrance animation
            setTimeout(() => {
                item.classList.remove('translate-x-12', 'opacity-0');
                item.classList.add('translate-x-0', 'opacity-100');
            }, index * 150 + 100);

            // Auto dismiss after 5 seconds
            setTimeout(() => {
                item.classList.remove('translate-x-0', 'opacity-100');
                item.classList.add('translate-x-12', 'opacity-0');
                setTimeout(() => item.remove(), 300);
            }, 6000);
        });
    });
</script>
@endif
