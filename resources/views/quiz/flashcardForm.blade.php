<x-template>
    <div class="w-full h-full min-h-screen flex flex-col items-center justify-center relative py-12">

        <div class="p-4 bg-[#3B5155] fixed top-5 left-5 border border-[#A3ACB9] border-2 rounded-2xl shadow-lg z-10">
            <a href="/home" class="block hover:opacity-80 transition-opacity">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 64 64" fill="none">
                    <path d="M2.66675 34.6667V29.3333H5.33341V26.6667H8.00008V24H10.6667V21.3333H13.3334V18.6667H16.0001V16H18.6667V13.3333H21.3334V10.6667H24.0001V8H26.6667V5.33333H29.3334V2.66667H32.0001V5.33333H34.6667V8H37.3334V10.6667H34.6667V13.3333H32.0001V16H29.3334V18.6667H26.6667V21.3333H24.0001V24H21.3334V26.6667H61.3334V37.3333H21.3334V40H24.0001V42.6667H26.6667V45.3333H29.3334V48H32.0001V50.6667H34.6667V53.3333H37.3334V56H34.6667V58.6667H32.0001V61.3333H29.3334V58.6667H26.6667V56H24.0001V53.3333H21.3334V50.6667H18.6667V48H16.0001V45.3333H13.3334V42.6667H10.6667V40H8.00008V37.3333H5.33341V34.6667H2.66675Z" fill="#1C2C30"/>
                </svg>
            </a>
        </div>

        <div class="w-full max-w-3xl bg-[#3B5155] rounded-xl p-8 shadow-2xl border-2 border-[#A3ACB9] relative mt-16 md:mt-0">
            
            <h1 class="text-5xl md:text-6xl text-center text-white mb-8 font-mono tracking-tight">
                Generate Your Quiz
            </h1>

            <form id="generateForm" action="{{ route('generate.flashcards') }}" enctype="multipart/form-data" method="POST" class="space-y-6">
                @csrf
                
                <div class="relative">
                    <textarea id="content" name="content" rows="12"
                        placeholder="Paste your notes, textbook excerpts, or any study material here..."
                        class="w-full bg-[#223033] border-2 border-[#A3ACB9] rounded-xl p-6 pr-20 text-white font-mono placeholder-zinc-500 focus:outline-none focus:border-white resize-none transition-all duration-200 custom-scrollbar shadow-inner"></textarea>

                    <div class="absolute bottom-4 right-4 text-xs text-zinc-500 font-mono">
                        <span id="charCount">0</span> chars
                    </div>

                    <label for="pdfUpload" class="absolute top-4 right-4 cursor-pointer w-14 h-14 bg-[#FF9800] border-b-4 border-[#CC7A00] active:border-b-0 active:translate-y-1 rounded-lg flex items-center justify-center transition-all hover:bg-[#ffac33] shadow-lg group">
                        <svg class="w-8 h-8 group-hover:scale-110 transition-transform" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g opacity="0.6">
                                <path d="M56.0002 10.6667V24H53.3335V26.6667H50.6668V29.3333H48.0002V32H45.3335V34.6667H42.6668V37.3333H40.0002V40H37.3335V42.6667H34.6668V45.3333H32.0002V48H29.3335V50.6667H21.3335V48H18.6668V45.3333H16.0002V37.3333H18.6668V34.6667H21.3335V32H24.0002V29.3333H26.6668V26.6667H29.3335V24H32.0002V21.3333H34.6668V18.6667H37.3335V16H40.0002V13.3333H42.6668V16H45.3335V21.3333H42.6668V24H40.0002V26.6667H37.3335V29.3333H34.6668V32H32.0002V34.6667H29.3335V37.3333H26.6668V40H24.0002V42.6667H29.3335V40H32.0002V37.3333H34.6668V34.6667H37.3335V32H40.0002V29.3333H42.6668V26.6667H45.3335V24H48.0002V13.3333H45.3335V10.6667H37.3335V13.3333H34.6668V16H32.0002V18.6667H29.3335V21.3333H26.6668V24H24.0002V26.6667H21.3335V29.3333H18.6668V32H16.0002V34.6667H13.3335V48H16.0002V50.6667H18.6668V53.3333H32.0002V50.6667H34.6668V48H37.3335V45.3333H40.0002V42.6667H42.6668V40H45.3335V37.3333H48.0002V34.6667H50.6668V32H53.3335V34.6667H56.0002V40H53.3335V42.6667H50.6668V45.3333H48.0002V48H45.3335V50.6667H42.6668V53.3333H40.0002V56H37.3335V58.6667H34.6668V61.3333H18.6668V58.6667H13.3335V56H10.6668V53.3333H8.00016V48H5.3335V32H8.00016V29.3333H10.6668V26.6667H13.3335V24H16.0002V21.3333H18.6668V18.6667H21.3335V16H24.0002V13.3333H26.6668V10.6667H29.3335V8.00001H32.0002V5.33334H37.3335V2.66667H48.0002V5.33334H50.6668V8.00001H53.3335V10.6667H56.0002Z" fill="#1C2C30"/>
                            </g>
                        </svg>
                    </label>

                    <input id="pdfUpload" name="pdf" type="file" accept="application/pdf" class="hidden">
                </div>

                <div id="pdfPreview" class="hidden mt-3 flex items-center justify-between bg-[#2A3B3E] p-3 rounded-xl border border-[#5A6B6F]">
                    <div class="flex items-center gap-3">
                         <svg class="w-6 h-6 text-[#FF9800]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0111.414 2.586L15 6.172V14a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                        </svg>
                        <span id="pdfFileName" class="text-zinc-200 text-sm font-mono truncate max-w-[200px]"></span>
                    </div>
                    <button type="button" id="removePdf" class="text-[#FE4C40] hover:text-red-400 font-bold text-sm font-mono">REMOVE</button>
                </div>

                <div class="text-center space-y-1">
                    <p class="font-bold text-[#51F1A9] text-base font-mono tracking-wide">Tips for best results:</p>
                    <ul class="text-white text-sm font-mono leading-tight">
                        <li>• Include key concepts, definitions, and important facts</li>
                        <li>• The more detailed your input, the better the flashcards</li>
                        <li>• Break down complex topics into smaller sections</li>
                    </ul>
                </div>

                <div class="flex justify-center w-full">
                    <button type="submit"
                        class="w-auto px-24 py-4 bg-[#0093FE] hover:bg-[#0073C7] text-white text-4xl md:text-5xl font-mono rounded-xl border-b-8 border-[#0073C7] active:border-b-0 active:translate-y-2 transition-all shadow-lg">
                        Generate
                    </button>
                </div>

                <div id="loadingMessage" class="hidden mt-4 text-center">
                    <p class="text-[#51F1A9] text-xl font-mono animate-pulse">Generating Flashcards...</p>
                </div>

            </form>

            @if ($errors->any())
                <div class="mt-6 bg-[#FE4C40]/20 border-2 border-[#FE4C40] text-[#FE4C40] p-4 rounded-xl font-mono text-sm">
                    <strong>Error:</strong>
                    <ul class="mt-1 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="mt-6 bg-[#FE4C40]/20 border-2 border-[#FE4C40] text-[#FE4C40] p-4 rounded-xl font-mono text-sm">
                    <strong>Error:</strong> {{ session('error') }}
                </div>
            @endif
        </div>
    </div>

    <script>
        const textarea = document.getElementById('content');
        const charCount = document.getElementById('charCount');
        const pdfUpload = document.getElementById('pdfUpload');
        const pdfPreview = document.getElementById('pdfPreview');
        const pdfFileName = document.getElementById('pdfFileName');
        const removePdf = document.getElementById('removePdf');
        const form = document.getElementById('generateForm');
        const loadingMessage = document.getElementById('loadingMessage');
        const submitButton = form.querySelector('button[type="submit"]');

        form.addEventListener('submit', function() {
            loadingMessage.classList.remove('hidden');
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            submitButton.innerHTML = 'Generating...';
        });

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