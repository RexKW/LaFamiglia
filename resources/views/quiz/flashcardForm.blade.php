<x-template>
    <div class="w-full max-w-3xl">
        <!-- Header Section -->
        <div class="text-center mb-8">
            {{-- <div
                class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
            </div> --}}
        </div>

        <!-- Main Card -->
        <div class="bg-zinc-800/50 backdrop-blur-sm rounded-3xl shadow-2xl border border-zinc-700/50 p-8">
             <h1 class="text-4xl text-center font-bold text-white mb-2">Flashcard Generator</h1>
            <form action="{{ route('generate.flashcards') }}" enctype="multipart/form-data"  method="POST" class="space-y-6">
                @csrf
                <!-- Textarea Section -->
                <div>
                    <label for="content" class="block text-sm text-center font-medium text-zinc-300 mb-3">
                        Enter Your Study Material
                    </label>

                    <div class="relative">

                        <!-- Textarea -->
                        <textarea id="content" name="content" rows="12"
                            placeholder="Paste your notes, textbook excerpts, or any study material here..."
                            class="w-full bg-zinc-900/50 border border-zinc-700 rounded-2xl p-4 pr-16 text-white placeholder-zinc-500
            focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent resize-none transition-all duration-200"></textarea>

                        <!-- Character Count -->
                        <div class="absolute bottom-4 right-4 text-xs text-zinc-500">
                            <span id="charCount">0</span> characters
                        </div>

                        <!-- Attachment Button -->
                        <label for="pdfUpload"
                            class="absolute top-4 right-4 cursor-pointer bg-zinc-800/80 hover:bg-zinc-700 text-white p-2 rounded-xl transition">
                            <!-- Paperclip Icon -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12.79V7a4 4 0 00-8 0v9a2 2 0 104 0V7"></path>
                            </svg>
                        </label>

                        <!-- Hidden File Input -->
                        <input id="pdfUpload" name="pdf" type="file" accept="application/pdf" class="hidden">
                    </div>

                    <!-- Attachment Preview -->
                    <div id="pdfPreview"
                        class="hidden mt-3 flex items-center space-x-3 bg-zinc-800/40 p-3 rounded-xl border border-zinc-700">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7V3a1 1 0 011-1h4m4 4v14a2 2 0 01-2 2H7a2 2 0 01-2-2V7m10 0h-3m-4 0H5"></path>
                        </svg>

                        <span id="pdfFileName" class="text-zinc-300 text-sm"></span>

                        <button type="button" id="removePdf"
                            class="text-zinc-400 hover:text-red-400 transition text-sm">
                            Remove
                        </button>
                    </div>
                </div>
                @if ($errors->any())
                    <div class="mb-4 bg-red-500/20 border border-red-500/30 text-red-300 p-4 rounded-xl">
                        <strong>Error:</strong>
                        <ul class="mt-2 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

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


    </div>

    <script>
        const textarea = document.getElementById('content');
        const charCount = document.getElementById('charCount');
        const pdfUpload = document.getElementById('pdfUpload');
        const pdfPreview = document.getElementById('pdfPreview');
        const pdfFileName = document.getElementById('pdfFileName');
        const removePdf = document.getElementById('removePdf');

        textarea.addEventListener('input', function () {
            charCount.textContent = this.value.length;
        });

        pdfUpload.addEventListener('change', function () {
            if (this.files.length > 0) {
                pdfFileName.textContent = this.files[0].name;
                pdfPreview.classList.remove('hidden');
            }
        });

        removePdf.addEventListener('click', function () {
            pdfUpload.value = '';
            pdfPreview.classList.add('hidden');
        });
    </script>
</x-template>