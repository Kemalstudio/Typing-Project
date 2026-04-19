<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Typing Test - Practice Your Typing Speed</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.45.0/apexcharts.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            font-family: 'Sora', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .text-container {
            line-height: 2;
            letter-spacing: 0.5px;
            font-size: 1.1rem;
        }
        
        .char-correct {
            color: #10b981;
            font-weight: 600;
        }
        
        .char-incorrect {
            color: #ef4444;
            background-color: #fee2e2;
            border-radius: 2px;
        }
        
        .char-current {
            background-color: #3b82f6;
            color: white;
            animation: blink 1s infinite;
            border-radius: 2px;
        }
        
        .char-untyped {
            color: #d1d5db;
        }
        
        @keyframes blink {
            0%, 49%, 100% { opacity: 1; }
            50%, 99% { opacity: 0.3; }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .animate-slide-up {
            animation: slideUp 0.5s ease-out;
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }
        
        .stats-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        
        .stats-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .difficulty-btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
        }

        .difficulty-btn.active {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .btn-start {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }

        .btn-start:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        }

        .nav-bar {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .result-card {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .success-card {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-600 via-purple-500 to-indigo-600">
    <!-- Navigation -->
    <nav class="nav-bar sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg">
                    <i class="fas fa-keyboard text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">TypeSpeed</h1>
                    <p class="text-xs text-gray-500">Master Your Typing</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                @auth
                    <div class="flex items-center gap-3 px-4 py-2 bg-gray-100 rounded-full">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=667eea&color=fff" 
                             alt="Avatar" class="w-8 h-8 rounded-full border-2 border-purple-400">
                        <span class="text-gray-700 font-semibold">{{ Auth::user()->name }}</span>
                    </div>
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:shadow-lg transition transform hover:scale-105">
                            <i class="fas fa-shield-alt mr-2"></i>Admin
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-gray-600 hover:text-purple-600 font-semibold transition">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="px-4 py-2 text-gray-600 hover:text-purple-600 font-semibold transition">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:shadow-lg transition transform hover:scale-105">
                        <i class="fas fa-user-plus mr-2"></i>Sign Up
                    </a>
                @endguest
            </div>
        </div>
    </nav>

    <div class="min-h-screen py-12 px-6">
        <div class="max-w-6xl mx-auto">
            <!-- Main Container -->
            <div class="glass-effect rounded-3xl shadow-2xl p-10 animate-slide-up">
                <!-- Header -->
                <div class="text-center mb-12">
                    <h2 class="text-5xl font-bold text-gray-800 mb-3">
                        <i class="fas fa-keyboard text-purple-600 mr-3"></i>Typing Speed Test
                    </h2>
                    <p class="text-gray-600 text-lg">Test your typing speed, accuracy, and improve your skills</p>
                </div>

                <!-- Difficulty Selection -->
                <div class="mb-12 flex justify-center gap-6" id="difficultySection">
                    <button class="difficulty-btn px-8 py-4 bg-gradient-to-br from-green-100 to-green-50 text-green-800 rounded-xl font-bold hover:shadow-lg transition border-2 border-green-300" data-difficulty="easy">
                        <i class="fas fa-leaf mr-2"></i>Easy
                    </button>
                    <button class="difficulty-btn px-8 py-4 bg-gradient-to-br from-yellow-100 to-yellow-50 text-yellow-800 rounded-xl font-bold hover:shadow-lg transition border-2 border-yellow-300 active" data-difficulty="medium">
                        <i class="fas fa-fire mr-2"></i>Medium
                    </button>
                    <button class="difficulty-btn px-8 py-4 bg-gradient-to-br from-red-100 to-red-50 text-red-800 rounded-xl font-bold hover:shadow-lg transition border-2 border-red-300" data-difficulty="hard">
                        <i class="fas fa-skull mr-2"></i>Hard
                    </button>
                </div>

                <!-- Stats Bar -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8" id="statsBar" style="display:none;">
                    <div class="stats-card p-6 rounded-xl text-center">
                        <div class="text-4xl font-bold text-purple-600 mb-2" id="wpmDisplay">0</div>
                        <div class="text-gray-600 font-semibold"><i class="fas fa-tachometer-alt mr-2"></i>WPM</div>
                    </div>
                    <div class="stats-card p-6 rounded-xl text-center">
                        <div class="text-4xl font-bold text-green-600 mb-2" id="accuracyDisplay">100%</div>
                        <div class="text-gray-600 font-semibold"><i class="fas fa-bullseye mr-2"></i>Accuracy</div>
                    </div>
                    <div class="stats-card p-6 rounded-xl text-center">
                        <div class="text-4xl font-bold text-blue-600 mb-2" id="timeDisplay">0:00</div>
                        <div class="text-gray-600 font-semibold"><i class="fas fa-hourglass-half mr-2"></i>Time</div>
                    </div>
                    <div class="stats-card p-6 rounded-xl text-center">
                        <div class="text-4xl font-bold text-orange-600 mb-2" id="charDisplay">0/0</div>
                        <div class="text-gray-600 font-semibold"><i class="fas fa-keyboard mr-2"></i>Chars</div>
                    </div>
                </div>

                <!-- Text Display -->
                <div id="testContainer">
                    <div class="bg-white p-8 rounded-2xl mb-6 min-h-48 text-center shadow-inner text-container" id="textDisplay" style="border: 2px solid #e5e7eb;">
                        <!-- Text will be populated here -->
                    </div>

                    <!-- Input Area -->
                    <div class="mb-8">
                        <input 
                            type="text" 
                            id="userInput" 
                            class="w-full px-6 py-4 border-2 border-purple-300 rounded-xl focus:outline-none focus:border-purple-600 focus:ring-4 focus:ring-purple-200 text-lg"
                            placeholder="🎯 Click here and start typing..."
                            autocomplete="off"
                        >
                    </div>

                    <!-- Result Display -->
                    <div id="resultContainer" style="display:none;" class="success-card p-10 rounded-2xl mb-8 text-white animate-fade-in">
                        <div class="text-center mb-8">
                            <h3 class="text-4xl font-bold mb-2"><i class="fas fa-star mr-3"></i>Test Complete!</h3>
                            <p class="text-lg opacity-90">Great job! Here are your results.</p>
                        </div>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                            <div class="bg-white bg-opacity-20 p-6 rounded-xl text-center backdrop-blur">
                                <div class="text-3xl font-bold" id="finalWpm">0</div>
                                <div class="text-sm">WPM</div>
                            </div>
                            <div class="bg-white bg-opacity-20 p-6 rounded-xl text-center backdrop-blur">
                                <div class="text-3xl font-bold" id="finalAccuracy">100%</div>
                                <div class="text-sm">Accuracy</div>
                            </div>
                            <div class="bg-white bg-opacity-20 p-6 rounded-xl text-center backdrop-blur">
                                <div class="text-3xl font-bold" id="finalTime">0:00</div>
                                <div class="text-sm">Time</div>
                            </div>
                            <div class="bg-white bg-opacity-20 p-6 rounded-xl text-center backdrop-blur">
                                <div class="text-3xl font-bold" id="finalChars">0</div>
                                <div class="text-sm">Correct</div>
                            </div>
                        </div>

                        <!-- Details -->
                        <div class="bg-white bg-opacity-20 p-6 rounded-xl backdrop-blur mb-6">
                            <p class="mb-2"><strong><i class="fas fa-keyboard mr-2"></i>Total Typed:</strong> <span id="totalChars">0</span></p>
                            <p class="mb-2"><strong><i class="fas fa-exclamation-circle mr-2"></i>Errors:</strong> <span id="errors">0</span></p>
                            <p><strong><i class="fas fa-layer-group mr-2"></i>Difficulty:</strong> <span id="diffDisplay" class="font-bold">Medium</span></p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 justify-center flex-wrap" id="actionButtons">
                        <button id="startBtn" class="btn-start px-8 py-3 text-white rounded-lg font-bold hover:shadow-xl transition transform hover:scale-105">
                            <i class="fas fa-play mr-2"></i>Start Test
                        </button>
                        <button id="resetBtn" style="display:none;" class="px-8 py-3 bg-gray-600 text-white rounded-lg font-bold hover:bg-gray-700 transition">
                            <i class="fas fa-redo mr-2"></i>New Test
                        </button>
                        <button id="saveBtn" style="display:none;" class="px-8 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg font-bold hover:shadow-lg transition">
                            <i class="fas fa-save mr-2"></i>Save Result
                        </button>
                    </div>
                </div>

                <!-- User Stats Section -->
                @auth
                <div id="userStatsSection" class="mt-12 pt-12 border-t-2 border-gray-200">
                    <h3 class="text-3xl font-bold text-gray-800 mb-8 flex items-center">
                        <i class="fas fa-chart-line text-purple-600 mr-3"></i>Your Statistics
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8" id="userStats">
                        <div class="stats-card p-6 rounded-xl text-center">
                            <div class="text-3xl font-bold text-purple-600 mb-2">-</div>
                            <div class="text-gray-600 font-semibold"><i class="fas fa-list mr-2"></i>Total Tests</div>
                        </div>
                        <div class="stats-card p-6 rounded-xl text-center">
                            <div class="text-3xl font-bold text-green-600 mb-2">-</div>
                            <div class="text-gray-600 font-semibold"><i class="fas fa-tachometer-alt mr-2"></i>Avg WPM</div>
                        </div>
                        <div class="stats-card p-6 rounded-xl text-center">
                            <div class="text-3xl font-bold text-blue-600 mb-2">-</div>
                            <div class="text-gray-600 font-semibold"><i class="fas fa-bullseye mr-2"></i>Avg Accuracy</div>
                        </div>
                        <div class="stats-card p-6 rounded-xl text-center">
                            <div class="text-3xl font-bold text-orange-600 mb-2">-</div>
                            <div class="text-gray-600 font-semibold"><i class="fas fa-crown mr-2"></i>Best WPM</div>
                        </div>
                    </div>
                    <div id="chartContainer" class="bg-white p-6 rounded-xl shadow-lg"></div>
                </div>
                @endauth
            </div>
        </div>
    </div>

    <script>
        const app = {
            currentDifficulty: 'medium',
            testActive: false,
            startTime: null,
            currentText: '',
            typedText: '',
            texts: {
                easy: [
                    "The quick brown fox jumps over the lazy dog.",
                    "Practice makes perfect in typing tests.",
                    "Typing speed improves with regular practice.",
                    "Technology helps us learn faster.",
                    "Consistency is the key to success."
                ],
                medium: [
                    "The paradigm of typing proficiency has evolved significantly with technological advancement.",
                    "Mastering typing speed requires dedication and systematic practice over time.",
                    "Digital literacy encompasses various competencies including typing proficiency.",
                    "Ergonomics play a crucial role in preventing repetitive strain injuries.",
                    "Keyboard accuracy directly impacts overall productivity and efficiency."
                ],
                hard: [
                    "Psychological resilience and cognitive flexibility are essential attributes for contemporary problem-solving endeavors.",
                    "Etymological investigations into linguistic patterns reveal fascinating correlations with historical communication evolution.",
                    "Philosophical contemplation regarding existential phenomenology necessitates epistemological recalibration.",
                    "Synthesizing multidisciplinary perspectives facilitates sophisticated analysis of complex socioeconomic paradigms.",
                    "Hermeneutical frameworks provide invaluable methodological approaches to textual interpretation."
                ]
            },

            init() {
                this.setupEventListeners();
                this.displayText();
                this.loadUserStats();
            },

            setupEventListeners() {
                document.querySelectorAll('.difficulty-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        document.querySelectorAll('.difficulty-btn').forEach(b => b.classList.remove('active', 'ring-2'));
                        e.target.classList.add('active', 'ring-2');
                        this.selectDifficulty(e.target.dataset.difficulty);
                    });
                });

                document.getElementById('startBtn').addEventListener('click', () => this.startTest());
                document.getElementById('resetBtn').addEventListener('click', () => this.reset());
                document.getElementById('saveBtn').addEventListener('click', () => this.saveResult());
                document.getElementById('userInput').addEventListener('input', (e) => this.handleInput(e));
            },

            selectDifficulty(difficulty) {
                this.currentDifficulty = difficulty;
                this.displayText();
            },

            displayText() {
                const texts = this.texts[this.currentDifficulty];
                this.currentText = texts[Math.floor(Math.random() * texts.length)];
                const display = document.getElementById('textDisplay');
                display.innerHTML = this.currentText.split('').map((char, i) => {
                    return `<span class="char-untyped" data-index="${i}">${char}</span>`;
                }).join('');
            },

            startTest() {
                this.testActive = true;
                this.startTime = Date.now();
                this.typedText = '';
                document.getElementById('difficultySection').style.display = 'none';
                document.getElementById('statsBar').style.display = 'grid';
                document.getElementById('resultContainer').style.display = 'none';
                document.getElementById('startBtn').style.display = 'none';
                document.getElementById('resetBtn').style.display = 'inline-block';
                document.getElementById('saveBtn').style.display = 'none';
                document.getElementById('userInput').focus();
                this.displayText();
                this.updateStatsLoop();
            },

            handleInput(e) {
                if (!this.testActive) return;

                this.typedText = e.target.value;
                this.updateDisplay();

                if (this.typedText.length === this.currentText.length) {
                    this.endTest();
                }
            },

            updateDisplay() {
                const display = document.getElementById('textDisplay');
                display.innerHTML = this.currentText.split('').map((char, i) => {
                    if (i < this.typedText.length) {
                        return `<span class="${this.typedText[i] === char ? 'char-correct' : 'char-incorrect'}">${char}</span>`;
                    } else if (i === this.typedText.length) {
                        return `<span class="char-current">${char}</span>`;
                    } else {
                        return `<span class="char-untyped">${char}</span>`;
                    }
                }).join('');
            },

            updateStatsLoop() {
                if (!this.testActive) return;

                const elapsed = (Date.now() - this.startTime) / 1000;
                const minutes = elapsed / 60;
                const wpm = Math.round((this.typedText.length / 5) / minutes) || 0;
                const correctChars = [...this.typedText].filter((char, i) => char === this.currentText[i]).length;
                const accuracy = this.typedText.length > 0 ? Math.round((correctChars / this.typedText.length) * 100) : 100;

                document.getElementById('wpmDisplay').textContent = wpm;
                document.getElementById('accuracyDisplay').textContent = accuracy + '%';
                document.getElementById('timeDisplay').textContent = this.formatTime(Math.floor(elapsed));
                document.getElementById('charDisplay').textContent = correctChars + '/' + this.typedText.length;

                requestAnimationFrame(() => this.updateStatsLoop());
            },

            endTest() {
                this.testActive = false;
                const elapsed = Math.max(1, (Date.now() - this.startTime) / 1000);
                const minutes = elapsed / 60;
                const wpm = Math.round((this.typedText.length / 5) / minutes);
                const correctChars = [...this.typedText].filter((char, i) => char === this.currentText[i]).length;
                const accuracy = Math.round((correctChars / this.typedText.length) * 100);

                document.getElementById('statsBar').style.display = 'none';
                document.getElementById('resultContainer').style.display = 'block';
                document.getElementById('startBtn').style.display = 'none';
                document.getElementById('resetBtn').style.display = 'inline-block';
                document.getElementById('saveBtn').style.display = 'inline-block';
                document.getElementById('userInput').disabled = true;

                document.getElementById('finalWpm').textContent = wpm;
                document.getElementById('finalAccuracy').textContent = accuracy + '%';
                document.getElementById('finalTime').textContent = this.formatTime(Math.floor(elapsed));
                document.getElementById('finalChars').textContent = correctChars;
                document.getElementById('totalChars').textContent = this.typedText.length;
                document.getElementById('errors').textContent = this.typedText.length - correctChars;
                document.getElementById('diffDisplay').textContent = this.currentDifficulty.charAt(0).toUpperCase() + this.currentDifficulty.slice(1);

                this.currentResult = {
                    wpm,
                    accuracy,
                    duration: Math.floor(elapsed),
                    correct_chars: correctChars,
                    total_chars: this.typedText.length,
                    difficulty: this.currentDifficulty
                };
            },

            saveResult() {
                if (!this.currentResult) return;

                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

                fetch('{{ route("typing.results") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify(this.currentResult)
                }).then(res => res.json()).then(data => {
                    if (data.success) {
                        alert('Result saved successfully!');
                        this.loadUserStats();
                    } else if (data.error) {
                        window.location.href = '{{ route("login") }}';
                    }
                }).catch(err => console.error('Error:', err));
            },

            reset() {
                this.testActive = false;
                this.typedText = '';
                document.getElementById('userInput').value = '';
                document.getElementById('userInput').disabled = false;
                document.getElementById('difficultySection').style.display = 'flex';
                document.getElementById('statsBar').style.display = 'none';
                document.getElementById('resultContainer').style.display = 'none';
                document.getElementById('startBtn').style.display = 'inline-block';
                document.getElementById('resetBtn').style.display = 'none';
                document.getElementById('saveBtn').style.display = 'none';
                this.displayText();
            },

            formatTime(seconds) {
                const mins = Math.floor(seconds / 60);
                const secs = seconds % 60;
                return `${mins}:${secs.toString().padStart(2, '0')}`;
            },

            loadUserStats() {
                fetch('{{ route("stats") }}')
                    .then(res => res.json())
                    .then(data => {
                        const stats = document.getElementById('userStats');
                        if (stats) {
                            stats.innerHTML = `
                                <div class="stats-card p-6 rounded-xl text-center">
                                    <div class="text-3xl font-bold text-purple-600 mb-2">${data.total_tests}</div>
                                    <div class="text-gray-600 font-semibold"><i class="fas fa-list mr-2"></i>Total Tests</div>
                                </div>
                                <div class="stats-card p-6 rounded-xl text-center">
                                    <div class="text-3xl font-bold text-green-600 mb-2">${data.avg_wpm}</div>
                                    <div class="text-gray-600 font-semibold"><i class="fas fa-tachometer-alt mr-2"></i>Avg WPM</div>
                                </div>
                                <div class="stats-card p-6 rounded-xl text-center">
                                    <div class="text-3xl font-bold text-blue-600 mb-2">${data.avg_accuracy}%</div>
                                    <div class="text-gray-600 font-semibold"><i class="fas fa-bullseye mr-2"></i>Avg Accuracy</div>
                                </div>
                                <div class="stats-card p-6 rounded-xl text-center">
                                    <div class="text-3xl font-bold text-orange-600 mb-2">${data.best_wpm || 0}</div>
                                    <div class="text-gray-600 font-semibold"><i class="fas fa-crown mr-2"></i>Best WPM</div>
                                </div>
                            `;
                        }

                        // Create chart
                        const chartContainer = document.getElementById('chartContainer');
                        if (chartContainer && data.total_tests > 0) {
                            const options = {
                                chart: {
                                    type: 'area',
                                    sparkline: { enabled: false },
                                    background: 'transparent'
                                },
                                series: [{
                                    name: 'Performance Over Time',
                                    data: [data.avg_wpm, data.best_wpm, data.avg_accuracy, data.total_tests]
                                }],
                                categories: ['Avg WPM', 'Best WPM', 'Avg Accuracy', 'Total Tests'],
                                colors: ['#667eea'],
                                fill: {
                                    type: 'gradient',
                                    gradient: {
                                        shadeIntensity: 1,
                                        opacityFrom: 0.6,
                                        opacityTo: 0.1
                                    }
                                },
                                stroke: {
                                    curve: 'smooth',
                                    width: 3
                                },
                                xaxis: {
                                    labels: {
                                        style: { colors: '#666' }
                                    }
                                },
                                yaxis: {
                                    labels: {
                                        style: { colors: '#666' }
                                    }
                                }
                            };
                            
                            const chart = new ApexCharts(chartContainer, options);
                            chart.render();
                        }
                    }).catch(err => console.error('Error loading stats:', err));
            }
        };

        document.addEventListener('DOMContentLoaded', () => app.init());
    </script>
</body>
</html>
