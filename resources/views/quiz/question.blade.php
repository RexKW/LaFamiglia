<x-template>
    <div class="w-full h-full min-h-screen flex flex-col items-center justify-center relative py-12">

        <div class="p-4 bg-[#3B5155] fixed top-5 left-5 border border-[#A3ACB9] border-2 rounded-2xl shadow-lg z-10">
            <a href="/home" class="block hover:opacity-80 transition-opacity">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 64 64" fill="none">
                    <path d="M2.66675 34.6667V29.3333H5.33341V26.6667H8.00008V24H10.6667V21.3333H13.3334V18.6667H16.0001V16H18.6667V13.3333H21.3334V10.6667H24.0001V8H26.6667V5.33333H29.3334V2.66667H32.0001V5.33333H34.6667V8H37.3334V10.6667H34.6667V13.3333H32.0001V16H29.3334V18.6667H26.6667V21.3333H24.0001V24H21.3334V26.6667H61.3334V37.3333H21.3334V40H24.0001V42.6667H26.6667V45.3333H29.3334V48H32.0001V50.6667H34.6667V53.3333H37.3334V56H34.6667V58.6667H32.0001V61.3333H29.3334V58.6667H26.6667V56H24.0001V53.3333H21.3334V50.6667H18.6667V48H16.0001V45.3333H13.3334V42.6667H10.6667V40H8.00008V37.3333H5.33341V34.6667H2.66675Z" fill="#1C2C30"/>
                </svg>
            </a>
        </div>

        <div class="w-full max-w-4xl">
            
            <div class="mb-4 px-2" id="progressContainer">
                <div class="flex justify-between items-center mb-2 font-mono">
                    <span class="text-sm text-[#A3ACB9]">PROGRESS</span>
                    <span class="text-sm text-white" id="progressText">1 / {{ $questions->count() }}</span>
                </div>
                <div class="w-full bg-[#1C2C30] rounded-full h-4 border-2 border-[#A3ACB9]">
                    <div class="bg-[#0093FE] h-full rounded-full transition-all duration-300 border-r-2 border-[#A3ACB9]" id="progressBar" style="width: 0%"></div>
                </div>
            </div>

            <div class="bg-[#3B5155] border-2 border-[#A3ACB9] rounded-xl p-8 shadow-2xl min-h-[500px] flex flex-col justify-center">
                <div id="quizContainer" class="w-full">
                    </div>
            </div>
        </div>
    </div>

    <script>
        // Define all variables at the top to prevent errors
        const questions = @json($questions);
        const quizName = "{{ $quiz->name }}"; // Crucial for the results page
        const quizId = {{ $quiz->id }};
        const isPublicQuiz = {{ $quiz->share_token ? 'true' : 'false' }};
        const publicStartUrl = "{{ $quiz->share_token ? route('quiz.public.start', $quiz->share_token) : '' }}";
        const publicReviewUrl = "{{ $quiz->share_token ? route('quiz.public.review', $quiz->share_token) : '' }}";
        const internalStartUrl = "{{ route('quiz.start', $quiz->id) }}";
        const internalReviewUrl = "{{ route('quiz.review', $quiz->id) }}";
        
        let currentIndex = 0;
        let answered = false;
        let score = 0;
        let wrongAnswers = [];

        function renderQuestion() {
            const question = questions[currentIndex];
            const answers = [
                question.correct_answer,
                question.wrong_answer_1,
                question.wrong_answer_2,
                question.wrong_answer_3,
            ].sort(() => Math.random() - 0.5);

            // Question Layout (No Bold)
            const html = `
                <div class="flex flex-col w-full">
                    <div class="text-center mb-6">
                        <div class="text-6xl font-mono text-white tracking-tight">Question ${currentIndex + 1}</div>
                    </div>

                    <div class="w-full text-left mb-2 px-1">
                        <h2 class="text-2xl text-white font-mono leading-tight">${question.question}</h2>
                    </div>

                    <div class="w-full bg-[#A3ACB9] p-4 rounded-xl border-2 border-[#A3ACB9]">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            ${answers.map((answer, idx) => `
                                <button 
                                    onclick="handleAnswerClick(this)"
                                    class="w-full h-40 flex items-center justify-center p-6 
                                           bg-[#1C2C30] border-4 border-[#1C2C30] rounded-lg
                                           hover:bg-[#0093FE] hover:border-[#0073C7] hover:translate-y-[-2px]
                                           transition-all duration-150 ease-out
                                           text-white text-xl font-mono text-center leading-snug shadow-sm
                                           answer-btn active:scale-95"
                                    data-answer="${answer.replace(/"/g, '&quot;')}"
                                    ${answered ? 'disabled' : ''}
                                >
                                    ${answer}
                                </button>
                            `).join('')}
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('quizContainer').innerHTML = html;
            updateProgress();
        }

        function handleAnswerClick(btn) {
            if (answered) return;
            
            const selectedAnswer = btn.getAttribute('data-answer');
            const correctAnswer = questions[currentIndex].correct_answer;
            
            checkAnswer(selectedAnswer, correctAnswer);
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
                
                // Remove hover
                btn.classList.remove('hover:bg-[#0093FE]', 'hover:border-[#0073C7]', 'hover:translate-y-[-2px]');
                
                if (answer === correctAnswer) {
                    // Green
                    btn.classList.remove('bg-[#1C2C30]', 'border-[#1C2C30]');
                    btn.classList.add('bg-[#51F1A9]', 'border-[#3DBD85]', 'text-[#1C2C30]'); 
                } else if (answer === selectedAnswer && selectedAnswer !== correctAnswer) {
                    // Red
                    btn.classList.remove('bg-[#1C2C30]', 'border-[#1C2C30]');
                    btn.classList.add('bg-[#FE4C40]', 'border-[#CC3D33]', 'text-white');
                } else {
                    btn.classList.add('opacity-50');
                }
                btn.disabled = true;
            });

            const isCorrect = selectedAnswer === correctAnswer;
            if (isCorrect) {
                score++;
            } else {
                const question = questions[currentIndex];
                wrongAnswers.push({
                    question: question.question,
                    selected: selectedAnswer,
                    correct: correctAnswer,
                    options: [
                        question.correct_answer,
                        question.wrong_answer_1,
                        question.wrong_answer_2,
                        question.wrong_answer_3
                    ].sort(() => Math.random() - 0.5)
                });
            }
            
            setTimeout(() => {
                nextQuestion();
            }, 1500);
        }

        function nextQuestion() {
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
            
            // Generate Date: YYYY-MM-DD HH:MM
            const now = new Date();
            const dateString = now.getFullYear() + '-' + 
                String(now.getMonth() + 1).padStart(2, '0') + '-' + 
                String(now.getDate()).padStart(2, '0') + ' ' + 
                String(now.getHours()).padStart(2, '0') + ':' + 
                String(now.getMinutes()).padStart(2, '0');

            let wrongAnswersHtml = '';
            if (wrongAnswers.length > 0) {
                wrongAnswersHtml = `
                    <div class="w-full text-left mb-8">
                        <h2 class="text-3xl text-white font-mono mb-4 text-center">Incorrect Answers</h2>
                        <div class="flex-1 overflow-y-auto custom-scrollbar bg-[#2A3B3E] border-2 border-[#A3ACB9] rounded-xl space-y-4 mb-6 shadow-inner max-h-[500px]">
                            <div class="p-4 space-y-4">
                                ${wrongAnswers.map((item, index) => `
                                    <div class="bg-[#3B5155] rounded-xl border-2 border-[#1C2C30] p-6 shadow-md">
                                        <div class="flex flex-col mb-4">
                                            <div class="text-sm font-mono text-zinc-400 mb-2">QUESTION</div>
                                            <h3 class="text-xl text-white font-mono">${item.question}</h3>
                                        </div>

                                        <div class="space-y-2 font-mono">
                                            ${item.options.map(opt => {
                                                if (opt === item.correct) {
                                                    return `
                                                    <div class="flex items-center p-3 bg-[#51F1A9]/10 border-2 border-[#51F1A9] rounded-lg">
                                                        <svg class="w-5 h-5 text-[#51F1A9] mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                        </svg>
                                                        <span class="text-[#51F1A9]">${opt.replace(/"/g, '&quot;')}</span>
                                                    </div>`;
                                                } else if (opt === item.selected) {
                                                    return `
                                                    <div class="flex items-center p-3 bg-[#FE4C40]/10 border-2 border-[#FE4C40] rounded-lg">
                                                        <svg class="w-5 h-5 text-[#FE4C40] mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                        <span class="text-[#FE4C40]">${opt.replace(/"/g, '&quot;')}</span>
                                                    </div>`;
                                                } else {
                                                    return `
                                                    <div class="flex items-center p-3 bg-[#2A3B3E] border-2 border-[#1C2C30] rounded-lg opacity-60">
                                                        <span class="text-zinc-400">${opt.replace(/"/g, '&quot;')}</span>
                                                    </div>`;
                                                }
                                            }).join('')}
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    </div>
                `;
            }

            // Result HTML (No Bold)
            const html = `
                <div class="text-center py-4">
                    
                    <div class="mb-2">
                        <h1 class="text-5xl md:text-6xl text-white font-mono tracking-tight">Quiz Results</h1>
                    </div>

                    <div class="mb-10">
                        <p class="text-4xl text-white font-mono mb-2">${quizName}</p>
                        <p class="text-xl text-zinc-400 font-mono">Date Done: ${dateString}</p>
                    </div>
                    
                    <div class="mb-4">
                        <div class="text-8xl text-white font-mono tracking-tighter">${percentage}%</div>
                    </div>

                    <div class="mb-12">
                        <p class="text-4xl text-white font-mono">You got ${score} out of ${questions.length} questions right</p>
                    </div>

                    ${wrongAnswersHtml}

                    <div class="flex flex-col md:flex-row gap-6 justify-center w-full max-w-2xl mx-auto px-4">
                        ${isPublicQuiz ? `
                            <a href="${publicStartUrl}" class="flex-1 px-8 py-4 bg-[#A3ACB9] hover:bg-[#929bab] text-white text-xl font-mono rounded-xl border-b-8 border-[#7A8C99] active:border-b-0 active:translate-y-2 transition-all text-center shadow-lg">
                                Retry Quiz
                            </a>
                            <a href="${publicReviewUrl}" class="flex-1 px-8 py-4 bg-[#0093FE] hover:bg-[#0073C7] text-white text-xl font-mono rounded-xl border-b-8 border-[#0073C7] active:border-b-0 active:translate-y-2 transition-all shadow-lg text-center">
                                Review Questions
                            </a>
                        ` : `
                            <a href="${internalStartUrl}" class="flex-1 px-8 py-4 bg-[#A3ACB9] hover:bg-[#929bab] text-white text-xl font-mono rounded-xl border-b-8 border-[#7A8C99] active:border-b-0 active:translate-y-2 transition-all text-center shadow-lg">
                                Retry Quiz
                            </a>
                            <a href="${internalReviewUrl}" class="flex-1 px-8 py-4 bg-[#0093FE] hover:bg-[#0073C7] text-white text-xl font-mono rounded-xl border-b-8 border-[#0073C7] active:border-b-0 active:translate-y-2 transition-all shadow-lg text-center">
                                Review Questions
                            </a>
                        `}
                    </div>
                </div>
            `;

            document.getElementById('quizContainer').innerHTML = html;
            
            // Hide the progress bar container when results are shown
            const progressContainer = document.getElementById('progressContainer');
            if(progressContainer) progressContainer.style.display = 'none';
        }

        // Initialize the quiz
        renderQuestion();

    </script>
</x-template>