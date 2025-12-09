<x-template>
    <div class="w-full max-w-3xl mt-20">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">Flashcard Generator</h1>
            <p class="text-zinc-400 text-lg">Transform your study material into interactive flashcards</p>
        </div>

        <!-- Main Card -->
        <div class="bg-zinc-800/50 backdrop-blur-sm rounded-3xl shadow-2xl border border-zinc-700/50 p-8">
            <form action="{{ route('generate.flashcards') }}" method="POST" class="space-y-6">
                @csrf
                <!-- Textarea Section -->
                <div>
                    <label for="content" class="block text-sm font-medium text-zinc-300 mb-3">
                        Enter Your Study Material
                    </label>
                    <div class="relative">
                        <textarea id="content" name="content" rows="12"
                            placeholder="Paste your notes, textbook excerpts, or any study material here. I'll help you create flashcards from it..."
                            class="w-full bg-zinc-900/50 border border-zinc-700 rounded-2xl p-4 text-white placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent resize-none transition-all duration-200"></textarea>
                        <div class="absolute bottom-4 right-4 text-xs text-zinc-500">
                            <span id="charCount">0</span> characters
                        </div>
                    </div>
                </div>
                @if (session('error'))
                    <div class="mb-4 bg-red-500/20 border border-red-500/30 text-red-300 p-4 rounded-xl">
                        <strong>Error:</strong> {{ session('error') }}
                    </div>
                @endif

                <!-- Info Section -->
                <div class="bg-blue-500/10 border border-blue-500/20 rounded-xl p-4">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm text-zinc-300">
                            <p class="font-medium text-blue-400 mb-1">Tips for best results:</p>
                            <ul class="space-y-1 text-zinc-400">
                                <li>• Include key concepts, definitions, and important facts</li>
                                <li>• The more detailed your input, the better the flashcards</li>
                                <li>• Break down complex topics into smaller sections</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-4 rounded-2xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span>Generate Flashcards</span>
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 text-zinc-500 text-sm">
            Powered by AI • Study smarter, not harder
        </div>
    </div>

    <script>
        const textarea = document.getElementById('content');
        const charCount = document.getElementById('charCount');

        textarea.addEventListener('input', function () {
            charCount.textContent = this.value.length;
        });
    </script>
</x-template>