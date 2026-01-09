<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaFamiglia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animate-float { animation: float 3s ease-in-out infinite; }
        .gradient-animate {
            background-size: 200% 200%;
            animation: gradient 8s ease infinite;
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-8px);
        }
    </style>
</head>
<body class="bg-slate-950 text-white">
    <!-- Navigation -->
    <x-navBar/>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <div class="absolute inset-0 bg-linear-to-br from-purple-900/20 via-slate-950 to-pink-900/20"></div>
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-5xl md:text-7xl mb-6 bg-linear-to-r from-purple-400 via-pink-400 to-purple-400 gradient-animate bg-clip-text text-transparent">
                    Learn Smarter with AI-Generated Flashcards
                </h1>
                <p class="text-xl text-slate-300 mb-8 max-w-2xl mx-auto">
                    Transform any content into personalized flashcards instantly. Our AI understands your material and creates the perfect study cards tailored to your learning style.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/login" class="px-8 py-4 bg-linear-to-r from-purple-500 to-pink-500 rounded-xl text-lg font-semibold hover:shadow-2xl hover:shadow-purple-500/50 transition transform hover:scale-105">
                        Start Learning Free
                    </a>

                </div>
                
                <!-- Animated Flashcard Demo -->
                <div class="mt-16 relative">
                    <div class="animate-float inline-block">
                        <div class="bg-linear-to-br from-purple-500/10 to-pink-500/10 backdrop-blur-xl rounded-2xl border border-purple-500/20 p-8 shadow-2xl shadow-purple-500/20 max-w-md">
                            <div class="text-sm text-purple-300 mb-2">AI Generated</div>
                            <h3 class="text-2xl font-bold mb-4">What is Photosynthesis?</h3>
                            <p class="text-slate-300">The process by which plants convert light energy into chemical energy...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 px-4 sm:px-6 lg:px-8 bg-slate-900/50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">Powerful Features</h2>
                <p class="text-xl text-slate-400">Everything you need to master your subjects</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="card-hover bg-linear-to-br from-purple-500/10 to-slate-800 p-8 rounded-2xl border border-purple-500/20">
                    <div class="w-12 h-12 bg-linear-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center text-2xl mb-4">🤖</div>
                    <h3 class="text-2xl font-bold mb-3">AI Generation</h3>
                    <p class="text-slate-300">Upload notes, PDFs, or paste text. Our AI instantly creates comprehensive flashcards from any content.</p>
                </div>
                
                <div class="card-hover bg-linear-to-br from-pink-500/10 to-slate-800 p-8 rounded-2xl border border-pink-500/20">
                    <div class="w-12 h-12 bg-linear-to-br from-pink-500 to-purple-500 rounded-xl flex items-center justify-center text-2xl mb-4">🎯</div>
                    <h3 class="text-2xl font-bold mb-3">Smart Spaced Repetition</h3>
                    <p class="text-slate-300">Adaptive learning algorithm that shows you cards exactly when you need to review them for optimal retention.</p>
                </div>
                
                <div class="card-hover bg-linear-to-br from-blue-500/10 to-slate-800 p-8 rounded-2xl border border-blue-500/20">
                    <div class="w-12 h-12 bg-linear-to-br from-blue-500 to-purple-500 rounded-xl flex items-center justify-center text-2xl mb-4">📊</div>
                    <h3 class="text-2xl font-bold mb-3">Progress Analytics</h3>
                    <p class="text-slate-300">Track your learning journey with detailed statistics, streaks, and insights into your study patterns.</p>
                </div>
                
                <div class="card-hover bg-linear-to-br from-green-500/10 to-slate-800 p-8 rounded-2xl border border-green-500/20">
                    <div class="w-12 h-12 bg-linear-to-br from-green-500 to-blue-500 rounded-xl flex items-center justify-center text-2xl mb-4">🌐</div>
                    <h3 class="text-2xl font-bold mb-3">Multi-Language Support</h3>
                    <p class="text-slate-300">Create and study flashcards in over 50 languages. Perfect for language learners and international students.</p>
                </div>
                
                <div class="card-hover bg-linear-to-br from-yellow-500/10 to-slate-800 p-8 rounded-2xl border border-yellow-500/20">
                    <div class="w-12 h-12 bg-linear-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center text-2xl mb-4">👥</div>
                    <h3 class="text-2xl font-bold mb-3">Collaborative Decks</h3>
                    <p class="text-slate-300">Share flashcard decks with classmates, study groups, or make them public for the community.</p>
                </div>
                
                <div class="card-hover bg-linear-to-br from-orange-500/10 to-slate-800 p-8 rounded-2xl border border-orange-500/20">
                    <div class="w-12 h-12 bg-linear-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center text-2xl mb-4">📱</div>
                    <h3 class="text-2xl font-bold mb-3">Cross-Platform Sync</h3>
                    <p class="text-slate-300">Study anywhere with seamless sync across web, mobile, and tablet. Your progress goes with you.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">How It Works</h2>
                <p class="text-xl text-slate-400">Get started in three simple steps</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-12">
                <div class="text-center">
                    <div class="w-20 h-20 bg-linear-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-6">1</div>
                    <h3 class="text-2xl font-bold mb-3">Upload Content</h3>
                    <p class="text-slate-300">Paste text, upload PDFs, images, or even record voice notes. We support all formats.</p>
                </div>
                
                <div class="text-center">
                    <div class="w-20 h-20 bg-linear-to-br from-pink-500 to-purple-500 rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-6">2</div>
                    <h3 class="text-2xl font-bold mb-3">AI Creates Cards</h3>
                    <p class="text-slate-300">Our AI analyzes your content and generates perfectly structured flashcards in seconds.</p>
                </div>
                
                <div class="text-center">
                    <div class="w-20 h-20 bg-linear-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-6">3</div>
                    <h3 class="text-2xl font-bold mb-3">Start Learning</h3>
                    <p class="text-slate-300">Study with spaced repetition, track progress, and ace your exams with confidence.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">Ready to Transform Your Learning?</h2>
            <p class="text-xl text-slate-300 mb-8">Join thousands of students who are learning smarter with FlashAI</p>
            <button class="px-10 py-4 bg-linear-to-r from-purple-500 to-pink-500 rounded-xl text-lg font-semibold hover:shadow-2xl hover:shadow-purple-500/50 transition transform hover:scale-105">
                Get Started for Free
            </button>
        </div>
    </section>

</body>
</html>