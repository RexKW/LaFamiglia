<x-loginRegisterTemplate>
    <form action="{{ route('registerUser') }}" method="POST">
        @csrf
        <div>
            <h2 class="text-2xl font-semibold text-white mb-6 text-center">Register a new Account</h2>

            <!-- Username Field -->
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-zinc-300 mb-2">Username</label>
                <input type="text" name="username" id="username" required
                    class="w-full bg-zinc-900/50 border border-zinc-700 rounded-2xl p-3 text-white placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent transition-all duration-200">
            </div>

            <!-- Email Field -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-zinc-300 mb-2">Email</label>
                <input type="email" name="email" id="email" required
                    class="w-full bg-zinc-900/50 border border-zinc-700 rounded-2xl p-3 text-white placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent transition-all duration-200">
            </div>

            <!-- Password Field -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-zinc-300 mb-2">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full bg-zinc-900/50 border border-zinc-700 rounded-2xl p-3 text-white placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent transition-all duration-200">
            </div>

            <!-- Confirm Password Field -->
            <div class="mb-6">
                <label for="confirm_password" class="block text-sm font-medium text-zinc-300 mb-2">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required
                    class="w-full bg-zinc-900/50 border border-zinc-700 rounded-2xl p-3 text-white placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent transition-all duration-200">
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-3 rounded-2xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02] active:scale-[0.98]">
                Register
            </button>

            <p class="w-full text-center mt-2">Already have an account? <a href="/" class="text-blue-500 hover:underline">Login here</a>.</p>
        </div>
    </form>
</x-loginRegisterTemplate>