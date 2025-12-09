<x-template>
    <div class="flex flex-col w-full  items-center justify-center items-center">
        <div class="bg-zinc-800/50 backdrop-blur-sm w-1/4 rounded-3xl shadow-2xl border border-zinc-700/50 p-8">
            @if (session('error'))
                    <div class="mb-4 bg-red-500/20 border border-red-500/30 text-red-300 p-4 rounded-xl">
                        <strong>Error:</strong> {{ session('error') }}
                    </div>
                @endif
            {{ $slot }}
        </div>
    </div>
</x-template>