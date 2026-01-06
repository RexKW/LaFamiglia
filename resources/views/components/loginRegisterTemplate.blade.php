<x-template>
    <div class="flex flex-col w-full justify-center items-center">
        <div class="bg-[#3B5155] w-full max-w-lg rounded-3xl shadow-2xl border-[#A3ACB9] border-2 p-8">
            @if (session('error'))
                    <div class="mb-4 bg-red-500/20 border border-red-500/30 text-red-300 p-4 rounded-xl">
                        <strong>Error:</strong> {{ session('error') }}
                    </div>
                @endif
            {{ $slot }}
        </div>
    </div>
</x-template>