<x-loginRegisterTemplate>
    <form action="{{ route('registerUser') }}" method="POST" class="w-full">
        @csrf
        <div class="flex flex-col gap-4">
            <h2 class="text-3xl font-bold text-white text-center font-mono mb-4 tracking-wide">Welcome to LaFamiglia</h2>

            <!-- Username & Email Row -->
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Username Field -->
                <div class="flex-1">
                    <label for="username" class="block text-white font-mono mb-2 text-sm">Username</label>
                    <input type="text" name="username" id="username" required placeholder="Insert Username"
                        class="w-full bg-[#2A3B3E] text-zinc-400 px-4 py-3 rounded-lg border-2 border-[#5A6B6F] focus:outline-none focus:border-white font-mono placeholder-zinc-500">
                </div>

                <!-- Email Field -->
                <div class="flex-1">
                    <label for="email" class="block text-white font-mono mb-2 text-sm">Email</label>
                    <input type="email" name="email" id="email" required placeholder="Insert Email"
                        class="w-full bg-[#2A3B3E] text-zinc-400 px-4 py-3 rounded-lg border-2 border-[#5A6B6F] focus:outline-none focus:border-white font-mono placeholder-zinc-500">
                </div>
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-white font-mono mb-2 text-sm">Password</label>
                <input type="password" name="password" id="password" required placeholder="Insert Password"
                    class="w-full bg-[#2A3B3E] text-zinc-400 px-4 py-3 rounded-lg border-2 border-[#5A6B6F] focus:outline-none focus:border-white font-mono placeholder-zinc-500">
            </div>

            <!-- Confirm Password Field -->
            <div>
                <label for="confirm_password" class="block text-white font-mono mb-2 text-sm">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required placeholder="insert Confirm Password"
                    class="w-full bg-[#2A3B3E] text-zinc-400 px-4 py-3 rounded-lg border-2 border-[#5A6B6F] focus:outline-none focus:border-white font-mono placeholder-zinc-500">
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center mt-6">
                <button type="submit"
                    class="px-12 py-3 bg-[#0093FE] text-white rounded-lg border-b-4 border-[#0073C7] active:border-b-0 active:translate-y-1 transition-all font-mono text-xl shadow-lg">
                    Register
                </button>
            </div>
            <p class="w-full text-center mt-4 text-zinc-400 font-mono">Already have an account? <a href="/login" class="text-[#0093FE] hover:text-[#0073C7] hover:underline">Login here</a>.</p>
        </div>
    </form>
</x-loginRegisterTemplate>
