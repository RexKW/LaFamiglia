<x-template>
    <div class="w-full">
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
        </div>

        <!-- Quizzes List -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            @foreach ($quizzes as $quiz)
                <div
                    class="bg-zinc-800/50 justify-center items-center flex flex-col w-full backdrop-blur-sm rounded-2xl border border-zinc-700/50 p-6 hover:border-zinc-600/50 transition-all duration-200">
                    <div class="flex flex-col items-center w-full justify-between space-y-4">
                        <div>
                            <h3 class="text-xl text-center font-semibold text-white mb-2">{{ $quiz->name }}</h3>
                            <p class="text-zinc-400 text-center">{{ $quiz->flashcards->count() }} questions</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('quiz.start', $quiz->id) }}"
                                class="text-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-200">
                                Start Quiz
                            </a>
                            <a href="{{ route('quiz.review', $quiz->id) }}"
                                class="text-center px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-white font-semibold rounded-lg transition-all duration-200">
                                Review Questions
                            </a>
                            <form action="{{ route('quiz.destroy', $quiz->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this quiz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-all duration-200">
                                    Delete
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
</x-template>