<x-template>
    <div class="w-full flex flex-col items-center justify-center py-12 space-y-8">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">All Quizzes</h1>
            <p class="text-zinc-400 text-lg">Browse your generated quizzes</p>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-zinc-400 hover:text-white transition-colors duration-200">Logout</button>
            </form>
        </div>

        <!-- Quizzes List -->
        <div class="p-5 md:w-3/4  bg-[#3B5155] border border-[#A3ACB9] border-2 rounded-2xl">
            <div class="bg-[#A3ACB9]  h-full w-full rounded-2xl p-5">
                <div class="grid grid-cols-1 gap-6 rounded-2xl mb-8">
                    @foreach ($quizzes as $quiz)
                        <div
                            class="bg-[#3B5155] border border-[#A3ACB9] border-2  justify-center items-center flex flex-col w-full rounded-2xl p-4 transition-all duration-200">
                            <div class="flex flex-col md:flex-row items-center w-full justify-between space-y-4">
                                <div class="flex flex-col md:flex-row justify-center items-center gap-5">
                                    <h3 class="text-xl font-semibold text-white">{{ $quiz->name }}</h3>
                                    <p class="text-zinc-400 h-full flex">{{ $quiz->flashcards->count() }} questions</p>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <a href="{{ route('quiz.start', $quiz->id) }}"
                                        class="text-center px-4 py-2 bg-[#51F1A9] hover:bg-[#51F1A9] text-white font-semibold rounded-lg transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 opacity-[40%]" width="40" height="44" viewBox="0 0 40 44"
                                            fill="none">
                                            <path
                                                d="M40 20V24H38V26H36V28H32V30H28V32H26V34H22V36H18V38H16V40H12V42H8V44H2V42H0V2H2V0H8V2H12V4H16V6H18V8H22V10H26V12H28V14H32V16H36V18H38V20H40Z"
                                                fill="#1C2C30" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('quiz.review', $quiz->id) }}"
                                        class="text-center px-4 py-2 bg-[#FF9800] hover:bg-[#FF9800] text-white font-semibold rounded-lg transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" width="48" height="48" viewBox="0 0 48 48"
                                            fill="none">
                                            <g opacity="0.4">
                                                <path
                                                    d="M42 34V32H44V4H42V2H8V4H6V6H4V42H6V44H8V46H42V44H44V42H42V40H40V34H42ZM36 42H12V40H10V36H12V34H36V42ZM36 18H34V20H32V22H30V24H28V26H26V28H24V26H22V24H20V22H18V20H16V18H14V12H16V10H22V12H24V14H26V12H28V10H34V12H36V18Z"
                                                    fill="#1C2C30" />
                                            </g>
                                        </svg>
                                    </a>
                                    <form action="{{ route('quiz.destroy', $quiz->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this quiz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-2 bg-[#FE4C40] hover:bg-[#FE4C40] text-white font-semibold rounded-lg transition-all duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="40" class="w-5 h-5" height="40"
                                                viewBox="0 0 40 40" fill="none">
                                                <g opacity="0.4">
                                                    <path
                                                        d="M36.6666 5.00002V8.33335H3.33325V5.00002H13.3333V3.33335H14.9999V1.66669H24.9999V3.33335H26.6666V5.00002H36.6666ZM6.66659 11.6667V36.6667H8.33325V38.3334H31.6666V35H33.3333V11.6667H6.66659ZM26.6666 31.6667H23.3333V15H26.6666V31.6667ZM16.6666 31.6667H13.3333V15H16.6666V31.6667Z"
                                                        fill="#1C2C30" />
                                                </g>
                                            </svg>
                                        </button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div
                        class="bg-zinc-800/50 justify-center items-center flex flex-col  backdrop-blur-sm rounded-2xl border border-zinc-700/50 p-6 hover:border-zinc-600/50 transition-all duration-200">
                        <div class="flex flex-col items-center justify-between space-y-4">
                            <div>
                                <h3 class="text-xl text-center font-semibold text-white mb-2">Add Quiz</h3>
                            </div>
                            <div class="flex items-center space-x-4">
                                <a href="/generate-flashcards"
                                    class="text-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-200">
                                    Add quiz
                                </a>
                            </div>
                        </div>
                    </div>

                    @if ($quizzes->isEmpty())
                        <div class="text-center text-zinc-400">
                            No quizzes found. Generate some flashcards to create quizzes!
                            <a href="/generate-flashcards" class="text-purple-500 underline">Generate Flashcards</a>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>
</x-template>