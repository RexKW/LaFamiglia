<x-template>
    <div class="w-full max-w-4xl">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">Review Your Questions</h1>
            <p class="text-zinc-400 text-lg">{{ $quiz->flashcards->count() }} questions generated</p>
        </div>

        @if ($message = Session::get('success'))
            <div class="bg-green-500/20 border border-green-500/30 rounded-xl p-4 mb-6">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-green-300">{{ $message }}</span>
                </div>
            </div>
        @endif

        <!-- Questions List -->
        <div class="space-y-4 mb-8">
            @foreach ($quiz->flashcards as $index => $flashcard)
                <div class="bg-zinc-800/50 backdrop-blur-sm rounded-2xl border border-zinc-700/50 p-6 hover:border-zinc-600/50 transition-all duration-200">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="text-sm font-medium text-zinc-400 mb-2">Question {{ $index + 1 }}</div>
                            <h3 class="text-lg font-semibold text-white mb-4">{{ $flashcard->question }}</h3>
                            
                            <!-- Answer Options -->
                            <div class="space-y-2">
                                @php
                                    $answers = [
                                        $flashcard->correct_answer,
                                        $flashcard->wrong_answer_1,
                                        $flashcard->wrong_answer_2,
                                        $flashcard->wrong_answer_3,
                                    ];
                                    shuffle($answers);
                                @endphp
                                
                                @foreach ($answers as $answer)
                                    @if ($answer === $flashcard->correct_answer)
                                        <div class="flex items-center p-3 bg-green-500/10 border border-green-500/30 rounded-lg">
                                            <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-green-300 font-medium">{{ $answer }}</span>
                                        </div>
                                    @else
                                        <div class="flex items-center p-3 bg-zinc-900/50 border border-zinc-700 rounded-lg">
                                            <span class="text-zinc-400">{{ $answer }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4 justify-center">
            <a href="/" class="px-8 py-3 bg-zinc-700 hover:bg-zinc-600 text-white font-semibold rounded-lg transition-all duration-200">
                Create New Quiz
            </a>
            <a href="{{ route('quiz.start', $quiz->id) }}" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl">
                Start Quiz
            </a>
        </div>
    </div>
</x-template>
