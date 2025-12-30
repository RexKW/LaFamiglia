<x-template>
    <div class="w-full flex flex-col items-center justify-center h-[calc(100vh-100px)]">
        <div class="bg-[#3B5155] p-8 rounded-xl shadow-2xl border-2 border-[#2A3B3E] flex flex-col items-center w-80 relative">

            <!-- Avatar Circle -->
            <div class="w-40 h-40 bg-gray-200 rounded-full overflow-hidden border-4 border-white mb-4 flex items-center justify-center">
                 <img src="https://api.dicebear.com/9.x/pixel-art/svg?seed={{ auth()->user()->username }}" alt="avatar" class="w-full h-full object-cover">
            </div>

            <!-- Username -->
            <h1 class="text-4xl font-bold text-white font-mono mb-1 tracking-wide">{{ auth()->user()->username }}</h1>

            <!-- Email -->
            <p class="text-zinc-400 font-mono mb-8 text-lg">{{ auth()->user()->email }}</p>

            <!-- Logout Button -->
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full py-3 bg-[#FE4C40] text-white font-bold rounded-lg border-b-4 border-[#CC3D33] active:border-b-0 active:translate-y-1 transition-all font-mono text-2xl shadow-lg">
                    Logout
                </button>
            </form>
        </div>
    </div>
</x-template>
