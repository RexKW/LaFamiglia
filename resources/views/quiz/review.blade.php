<x-template>
    <div class="w-full h-full mt-32">
        @if($quiz->user_id == auth()->id() && !request()->route('token'))
            <div class="p-5 bg-[#3B5155] absolute top-5 left-5 border border-[#A3ACB9] border-2 rounded-2xl">


                <a href="/home">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64" fill="none">
                        <path
                            d="M2.66675 34.6667V29.3333H5.33341V26.6667H8.00008V24H10.6667V21.3333H13.3334V18.6667H16.0001V16H18.6667V13.3333H21.3334V10.6667H24.0001V8H26.6667V5.33333H29.3334V2.66667H32.0001V5.33333H34.6667V8H37.3334V10.6667H34.6667V13.3333H32.0001V16H29.3334V18.6667H26.6667V21.3333H24.0001V24H21.3334V26.6667H61.3334V37.3333H21.3334V40H24.0001V42.6667H26.6667V45.3333H29.3334V48H32.0001V50.6667H34.6667V53.3333H37.3334V56H34.6667V58.6667H32.0001V61.3333H29.3334V58.6667H26.6667V56H24.0001V53.3333H21.3334V50.6667H18.6667V48H16.0001V45.3333H13.3334V42.6667H10.6667V40H8.00008V37.3333H5.33341V34.6667H2.66675Z"
                            fill="#1C2C30" />
                    </svg>
                </a>
            </div>
        @endif

        <!-- Header Section -->
        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                    </path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">Questions</h1>
            <p class="text-zinc-400 text-lg">{{ $quiz->flashcards->count() }} questions generated</p>
            @if($quiz->user_id == auth()->id() && !request()->route('token'))
                <form action="{{ route('quiz.share', $quiz->id) }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl">
                        Share Quiz
                    </button>
                </form>
            @endif
        </div>

        @if ($message = Session::get('success'))
            <div class="bg-green-500/20 border border-green-500/30 rounded-xl p-4 mb-6">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="text-green-300">{{ $message }}</span>
                </div>
            </div>
        @endif

        <!-- Questions List -->
        <div class="space-y-4 mb-8">
            @foreach ($quiz->flashcards as $index => $flashcard)
                <div
                    class="bg-zinc-800/50 backdrop-blur-sm rounded-2xl border border-zinc-700/50 p-6 hover:border-zinc-600/50 transition-all duration-200">
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
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
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
            @if(!$quiz->share_token)
                <a href="/home"
                    class="px-8 py-3 bg-zinc-700 hover:bg-zinc-600 text-white font-semibold rounded-lg transition-all duration-200">
                    Create New Quiz
                </a>
            @endif
            <a href="{{ route('quiz.start', $quiz->id) }}"
                class="px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl">
                Start Quiz
            </a>
        </div>
    </div>
</x-template>