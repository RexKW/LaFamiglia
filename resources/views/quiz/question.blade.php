<x-template>
    <div class="w-full max-w-3xl">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">Quiz Time</h1>
            <p class="text-zinc-400 text-lg">{{ $quiz->name }}</p>
        </div>

        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-medium text-zinc-300">Progress</span>
                <span class="text-sm font-medium text-zinc-400" id="progressText">1 / {{ $questions->count() }}</span>
            </div>
            <div class="w-full bg-zinc-700 rounded-full h-2">
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-2 rounded-full transition-all duration-300" id="progressBar" style="width: 0%"></div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="bg-zinc-800/50 backdrop-blur-sm rounded-3xl shadow-2xl border border-zinc-700/50 p-8">
            <div id="quizContainer">
                <!-- Question will be rendered here -->
            </div>
        </div>

        <!-- Results Modal -->
        <div id="resultModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50">
            <div class="bg-zinc-800 rounded-3xl p-8 max-w-2xl mx-4 border border-zinc-700">
                <h2 class="text-2xl font-bold text-white mb-4" id="resultTitle"></h2>
                <p class="text-zinc-300 mb-6" id="resultMessage"></p>
                <div class="flex gap-4">
                    <a href="/" class="flex-1 px-4 py-3 bg-zinc-700 hover:bg-zinc-600 text-white font-semibold rounded-lg transition-all duration-200 text-center">
                        Back to Home
                    </a>
                    <button onclick="nextQuestion()" class="flex-1 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-200">
                        Next Question
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const questions = @json($questions);
        const quizId = {{ $quiz->id }};
        let currentIndex = 0;
        let answered = false;
        let score = 0;

        function renderQuestion() {
            const question = questions[currentIndex];
            const answers = [
                question.correct_answer,
                question.wrong_answer_1,
                question.wrong_answer_2,
                question.wrong_answer_3,
            ].sort(() => Math.random() - 0.5);

            const html = `
                <div class="mb-8">
                    <p class="text-sm text-zinc-400 mb-2">Question ${currentIndex + 1} of ${questions.length}</p>
                    <h2 class="text-2xl font-bold text-white">${question.question}</h2>
                </div>

                <div class="space-y-3">
                    ${answers.map((answer, idx) => `
                        <button 
                            onclick="checkAnswer('${answer}', '${question.correct_answer}')"
                            class="w-full text-left p-4 bg-zinc-900/50 border-2 border-zinc-700 rounded-lg hover:border-blue-500 hover:bg-zinc-900 transition-all duration-200 text-white font-medium answer-btn"
                            data-answer="${answer}"
                            ${answered ? 'disabled' : ''}
                        >
                            ${answer}
                        </button>
                    `).join('')}
                </div>
            `;

            document.getElementById('quizContainer').innerHTML = html;
            updateProgress();
        }

        function updateProgress() {
            const progress = ((currentIndex + 1) / questions.length) * 100;
            document.getElementById('progressBar').style.width = progress + '%';
            document.getElementById('progressText').textContent = `${currentIndex + 1} / ${questions.length}`;
        }

        function checkAnswer(selectedAnswer, correctAnswer) {
            if (answered) return;
            answered = true;

            const answerBtns = document.querySelectorAll('.answer-btn');
            answerBtns.forEach(btn => {
                const answer = btn.getAttribute('data-answer');
                if (answer === correctAnswer) {
                    btn.classList.add('border-green-500', 'border-2', 'bg-green-500/10');
                } else if (answer === selectedAnswer && selectedAnswer !== correctAnswer) {
                    btn.classList.add('border-red-500', 'border-2', 'bg-red-500/10');
                }
                btn.disabled = true;
            });

            const isCorrect = selectedAnswer === correctAnswer;
            if (isCorrect) {
                score++;
            }

            showResult(isCorrect, correctAnswer);
        }

        function showResult(isCorrect, correctAnswer) {
            const modal = document.getElementById('resultModal');
            const title = document.getElementById('resultTitle');
            const message = document.getElementById('resultMessage');

            if (isCorrect) {
                title.textContent = '✓ Correct!';
                title.classList.add('text-green-400');
                title.classList.remove('text-red-400');
                message.textContent = 'Well done! You selected the correct answer.';
            } else {
                title.textContent = '✗ Incorrect';
                title.classList.add('text-red-400');
                title.classList.remove('text-green-400');
                message.textContent = `The correct answer is: ${correctAnswer}`;
            }

            modal.classList.remove('hidden');
        }

        function nextQuestion() {
            const modal = document.getElementById('resultModal');
            modal.classList.add('hidden');

            currentIndex++;
            answered = false;

            if (currentIndex < questions.length) {
                renderQuestion();
            } else {
                showFinalResults();
            }
        }

        function showFinalResults() {
            const percentage = Math.round((score / questions.length) * 100);
            const html = `
                <div class="text-center">
                    <div class="mb-6">
                        <div class="text-6xl font-bold text-white mb-2">${percentage}%</div>
                        <div class="text-2xl font-semibold text-zinc-300">You scored ${score} out of ${questions.length}</div>
                    </div>
                    <div class="mb-8">
                        ${percentage >= 80 ? '<p class="text-lg text-green-400">Excellent work! 🎉</p>' : 
                          percentage >= 60 ? '<p class="text-lg text-blue-400">Good effort! Keep practicing.</p>' :
                          '<p class="text-lg text-yellow-400">Keep studying! You\'ll do better next time.</p>'}
                    </div>
                    <div class="flex gap-4">
                        <a href="/" class="flex-1 px-4 py-3 bg-zinc-700 hover:bg-zinc-600 text-white font-semibold rounded-lg transition-all duration-200">
                            Back to Home
                        </a>
                        <a href="/" class="flex-1 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-200">
                            Try Another Quiz
                        </a>
                    </div>
                </div>
            `;

            document.getElementById('quizContainer').innerHTML = html;
        }

        // Initialize
        renderQuestion();
    </script>
</x-template>
