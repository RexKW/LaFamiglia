<x-loginRegisterTemplate>
    <form action="{{ route('loginUser') }}" method="POST" class="w-full">
        @csrf
        <div class="flex flex-col gap-4">
            <h2 class="text-3xl font-bold text-white text-center font-mono mb-4 tracking-wide">Welcome to LaFamiglia</h2>

            <!-- Username Field -->
            <div>
                <label for="username" class="block text-white font-mono mb-2 text-sm">Username</label>
                <input type="text" name="username" id="username" required placeholder="Insert Username"
                    class="w-full bg-[#2A3B3E] text-zinc-400 px-4 py-3 rounded-lg border-2 border-[#5A6B6F] focus:outline-none focus:border-white font-mono placeholder-zinc-500">
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-white font-mono mb-2 text-sm">Password</label>
                <input type="password" name="password" id="password" required placeholder="Insert Password"
                    class="w-full bg-[#2A3B3E] text-zinc-400 px-4 py-3 rounded-lg border-2 border-[#5A6B6F] focus:outline-none focus:border-white font-mono placeholder-zinc-500">
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center mt-6">
                <button type="submit"
                    class="px-12 py-3 bg-[#0093FE] text-white rounded-lg border-b-4 border-[#0073C7] active:border-b-0 active:translate-y-1 transition-all font-mono text-xl shadow-lg">
                    Login
                </button>
            </div>
            <p class="w-full text-center mt-4 text-zinc-400 font-mono">Don't have an account? <a href="/register" class="text-[#0093FE] hover:text-[#0073C7] hover:underline">Register here</a>.</p>
        </div>
    </form>
</x-loginRegisterTemplate>
