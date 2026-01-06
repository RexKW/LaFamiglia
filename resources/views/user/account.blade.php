<x-template>
    <div class="w-full flex flex-col items-center justify-center h-[calc(100vh-100px)] relative">
        
        <div class="p-4 bg-[#3B5155] absolute top-5 left-5 border-[#A3ACB9] border-2 rounded-2xl shadow-lg z-10">
            <a href="/home" class="block hover:opacity-80 transition-opacity">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 64 64" fill="none">
                    <path d="M2.66675 34.6667V29.3333H5.33341V26.6667H8.00008V24H10.6667V21.3333H13.3334V18.6667H16.0001V16H18.6667V13.3333H21.3334V10.6667H24.0001V8H26.6667V5.33333H29.3334V2.66667H32.0001V5.33333H34.6667V8H37.3334V10.6667H34.6667V13.3333H32.0001V16H29.3334V18.6667H26.6667V21.3333H24.0001V24H21.3334V26.6667H61.3334V37.3333H21.3334V40H24.0001V42.6667H26.6667V45.3333H29.3334V48H32.0001V50.6667H34.6667V53.3333H37.3334V56H34.6667V58.6667H32.0001V61.3333H29.3334V58.6667H26.6667V56H24.0001V53.3333H21.3334V50.6667H18.6667V48H16.0001V45.3333H13.3334V42.6667H10.6667V40H8.00008V37.3333H5.33341V34.6667H2.66675Z" fill="#1C2C30"/>
                </svg>
            </a>
        </div>

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
