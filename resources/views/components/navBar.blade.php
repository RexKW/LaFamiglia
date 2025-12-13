
<nav class="fixed w-full top-0 z-50 bg-slate-950/80 backdrop-blur-lg border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="/" class="text-white text-xl font-semibold hover:text-zinc-300 transition-colors">
                LaFamiglia
            </a>

            <!-- Auth Section -->
            <div class="flex items-center gap-6">
                @auth
                    <a href="/home" class="px-4 py-2 text-sm hover:text-purple-400 transition">Quizzes</a>
                    <span class="text-zinc-400 text-sm">{{ Auth::user()->username }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2  bg-gradient-to-r from-purple-500 to-pink-500 text-white text-sm rounded-lg transition-colors">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="/login" class="px-4 py-2 text-sm hover:text-purple-400 transition">
                        Login
                    </a>
                    <a href="/register" class="px-6 py-2 bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg text-sm font-semibold hover:shadow-lg hover:shadow-purple-500/50 transition">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>