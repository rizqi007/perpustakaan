<div x-data="{
    toasts: [],
    addToast(type, message, duration = 4000) {
        const id = Date.now();
        this.toasts.push({ id, type, message, show: false });
        this.$nextTick(() => {
            const t = this.toasts.find(t => t.id === id);
            if (t) t.show = true;
        });
        setTimeout(() => this.removeToast(id), duration);
    },
    removeToast(id) {
        const t = this.toasts.find(t => t.id === id);
        if (t) t.show = false;
        setTimeout(() => { this.toasts = this.toasts.filter(t => t.id !== id); }, 300);
    },
    icon(type) {
        if (type === 'success') return `<svg class='w-5 h-5' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 13l4 4L19 7'/></svg>`;
        if (type === 'error') return `<svg class='w-5 h-5' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 18L18 6M6 6l12 12'/></svg>`;
        return `<svg class='w-5 h-5' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'/></svg>`;
    }
}"
@toast.window="addToast($event.detail.type || 'success', $event.detail.message, $event.detail.duration || 4000)"
class="fixed top-6 right-6 z-[9999] flex flex-col gap-3 pointer-events-none" style="max-width: 400px;">

    @if(session('success'))
        <div x-init="addToast('success', '{{ session('success') }}')"></div>
    @endif
    @if(session('message'))
        <div x-init="addToast('success', '{{ session('message') }}')"></div>
    @endif
    @if(session('error'))
        <div x-init="addToast('error', '{{ session('error') }}')"></div>
    @endif

    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="toast.show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-8"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 translate-x-8"
             class="pointer-events-auto flex items-start gap-3 px-5 py-4 rounded-2xl shadow-2xl backdrop-blur-sm border"
             :class="{
                'bg-emerald-50/95 border-emerald-200 text-emerald-800': toast.type === 'success',
                'bg-red-50/95 border-red-200 text-red-800': toast.type === 'error',
                'bg-blue-50/95 border-blue-200 text-blue-800': toast.type === 'info'
             }">
            
            {{-- Icon --}}
            <div class="flex-shrink-0 mt-0.5 rounded-full p-1"
                 :class="{
                    'bg-emerald-100 text-emerald-600': toast.type === 'success',
                    'bg-red-100 text-red-600': toast.type === 'error',
                    'bg-blue-100 text-blue-600': toast.type === 'info'
                 }"
                 x-html="icon(toast.type)">
            </div>

            {{-- Message --}}
            <p class="text-sm font-medium flex-1" x-text="toast.message"></p>

            {{-- Close --}}
            <button @click="removeToast(toast.id)" 
                    class="flex-shrink-0 opacity-50 hover:opacity-100 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </template>
</div>
