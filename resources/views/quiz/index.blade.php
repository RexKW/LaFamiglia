<x-template>
    <div class="w-full flex flex-col items-center justify-center py-12">
        <!-- Main Card -->
        <div class="w-full max-w-5xl bg-[#3B5155] rounded-xl p-6 shadow-2xl border-2 border-[#2A3B3E]">

            <!-- Header Row -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-4xl font-bold text-white font-mono tracking-wider">Your Quizzes</h1>
                <div class="flex items-center gap-3">
                    <a href="{{ route('account') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                        <span class="text-white text-xl font-bold font-mono">{{ auth()->user()->username ?? 'Username' }}</span>
                        <div class="w-12 h-12 bg-gray-300 rounded-full overflow-hidden border-2 border-white">
                             <img src="https://api.dicebear.com/9.x/pixel-art/svg?seed={{ auth()->user()->username ?? 'User' }}" alt="avatar" class="w-full h-full object-cover">
                        </div>
                    </a>
                </div>
            </div>

            <!-- Controls Row -->
            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <!-- Search -->
                <div class="flex-1 relative">
                    <input type="text" placeholder="Search" class="w-full bg-[#2A3B3E] text-zinc-400 px-4 py-3 rounded-lg border-2 border-[#5A6B6F] focus:outline-none focus:border-white font-mono placeholder-zinc-500">
                    <svg class="w-6 h-6 absolute right-3 top-3 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                <!-- Sort By -->
                <div class="relative">
                    <button onclick="toggleSortMenu()" class="px-6 py-3 bg-[#A3ACB9] text-white font-bold rounded-lg border-b-4 border-[#7A8C99] active:border-b-0 active:translate-y-1 transition-all font-mono whitespace-nowrap flex items-center gap-2">
                        Sort By
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div id="sort-menu" class="hidden absolute top-full left-0 mt-2 w-48 bg-[#3B5155] border-2 border-[#A3ACB9] rounded-lg shadow-xl z-20 overflow-hidden">
                        <a href="{{ route('home', ['sort' => 'created_at', 'direction' => 'desc']) }}" class="block px-4 py-3 text-white hover:bg-[#2A3B3E] font-mono border-b border-[#2A3B3E]">Date (Newest)</a>
                        <a href="{{ route('home', ['sort' => 'created_at', 'direction' => 'asc']) }}" class="block px-4 py-3 text-white hover:bg-[#2A3B3E] font-mono border-b border-[#2A3B3E]">Date (Oldest)</a>
                        <a href="{{ route('home', ['sort' => 'name', 'direction' => 'asc']) }}" class="block px-4 py-3 text-white hover:bg-[#2A3B3E] font-mono border-b border-[#2A3B3E]">Name (A-Z)</a>
                        <a href="{{ route('home', ['sort' => 'name', 'direction' => 'desc']) }}" class="block px-4 py-3 text-white hover:bg-[#2A3B3E] font-mono">Name (Z-A)</a>
                    </div>
                </div>

                <!-- New Quiz -->
                <a href="/generate-flashcards" class="px-6 py-3 bg-[#0093FE] text-white font-bold rounded-lg border-b-4 border-[#0073C7] active:border-b-0 active:translate-y-1 transition-all font-mono whitespace-nowrap flex items-center justify-center">
                    New Quiz
                </a>
            </div>

            <!-- List Container -->
            <div class="bg-[#A3ACB9] rounded-xl p-4 h-[600px] overflow-y-auto custom-scrollbar">
                <div class="flex flex-col gap-3">
                    @foreach ($quizzes as $quiz)
                        <div class="bg-[#3B5155] p-3 rounded-lg flex flex-col md:flex-row items-center justify-between border-2 border-[#2A3B3E] shadow-md gap-4">
                            <!-- Left: Name -->
                            <div class="pl-2 w-full md:w-auto text-center md:text-left flex items-center gap-2">
                                <div id="name-display-{{ $quiz->id }}" class="flex items-center gap-2">
                                    <h3 class="text-white text-xl font-bold font-mono">{{ $quiz->name }}</h3>
                                    <button onclick="toggleRename({{ $quiz->id }})" class="text-zinc-400 hover:text-white transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                </div>
                                <form id="name-form-{{ $quiz->id }}" action="{{ route('quiz.update', $quiz->id) }}" method="POST" class="hidden flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="text" name="name" value="{{ $quiz->name }}" class="bg-[#2A3B3E] text-white px-2 py-1 rounded border border-[#5A6B6F] focus:outline-none font-mono w-96">
                                    <button type="submit" class="text-[#51F1A9] hover:text-[#65ffb9]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>
                                    <button type="button" onclick="toggleRename({{ $quiz->id }})" class="text-[#FE4C40] hover:text-[#ff6b61]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </form>
                            </div>

                            <!-- Right: Info & Actions -->
                            <div class="flex items-center gap-4 w-full md:w-auto justify-center md:justify-end">
                                <span class="text-white font-bold font-mono mr-2">{{ $quiz->flashcards->count() }} Questions</span>

                                <!-- Play -->
                                <a href="{{ route('quiz.start', $quiz->id) }}" class="w-12 h-10 bg-[#51F1A9] rounded flex items-center justify-center border-b-4 border-[#3DBD85] active:border-b-0 active:translate-y-1 transition-all hover:bg-[#65ffb9]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 40 44" fill="none">
                                        <path d="M40 20V24H38V26H36V28H32V30H28V32H26V34H22V36H18V38H16V40H12V42H8V44H2V42H0V2H2V0H8V2H12V4H16V6H18V8H22V10H26V12H28V14H32V16H36V18H38V20H40Z" fill="#1C2C30" />
                                    </svg>
                                </a>

                                <!-- Review -->
                                <a href="{{ route('quiz.review', $quiz->id) }}" class="w-12 h-10 bg-[#FF9800] rounded flex items-center justify-center border-b-4 border-[#CC7A00] active:border-b-0 active:translate-y-1 transition-all hover:bg-[#ffac33]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 48 48" fill="none">
                                        <path d="M42 34V32H44V4H42V2H8V4H6V6H4V42H6V44H8V46H42V44H44V42H42V40H40V34H42ZM36 42H12V40H10V36H12V34H36V42ZM36 18H34V20H32V22H30V24H28V26H26V28H24V26H22V24H20V22H18V20H16V18H14V12H16V10H22V12H24V14H26V12H28V10H34V12H36V18Z" fill="#1C2C30" />
                                    </svg>
                                </a>

                                <!-- Delete -->
                                <form action="{{ route('quiz.destroy', $quiz->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this quiz?');" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-12 h-10 bg-[#FE4C40] rounded flex items-center justify-center border-b-4 border-[#CC3D33] active:border-b-0 active:translate-y-1 transition-all hover:bg-[#ff6b61]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 40 40" fill="none">
                                            <path d="M36.6666 5.00002V8.33335H3.33325V5.00002H13.3333V3.33335H14.9999V1.66669H24.9999V3.33335H26.6666V5.00002H36.6666ZM6.66659 11.6667V36.6667H8.33325V38.3334H31.6666V35H33.3333V11.6667H6.66659ZM26.6666 31.6667H23.3333V15H26.6666V31.6667ZM16.6666 31.6667H13.3333V15H16.6666V31.6667Z" fill="#1C2C30" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach

                    @if ($quizzes->isEmpty())
                        <div class="text-center text-zinc-600 py-10 font-mono">
                            <p class="text-xl mb-4">No quizzes found.</p>
                            <a href="/generate-flashcards" class="text-blue-600 underline hover:text-blue-800">Generate your first quiz!</a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <script>
        function toggleSortMenu() {
            const menu = document.getElementById('sort-menu');
            menu.classList.toggle('hidden');
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('sort-menu');
            const button = event.target.closest('button');
            
            if (!menu.classList.contains('hidden') && !button && !menu.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });

        function toggleRename(id) {
            const display = document.getElementById(`name-display-${id}`);
            const form = document.getElementById(`name-form-${id}`);
            
            if (display.classList.contains('hidden')) {
                display.classList.remove('hidden');
                form.classList.add('hidden');
            } else {
                display.classList.add('hidden');
                form.classList.remove('hidden');
                // Focus input
                form.querySelector('input').focus();
            }
        }
    </script>
</x-template>
