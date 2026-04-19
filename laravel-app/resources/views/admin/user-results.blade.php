<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name }} Results - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Sora', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .nav-bar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        table tbody tr:hover {
            background: rgba(102, 126, 234, 0.05);
        }

        .user-card {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border: 1px solid rgba(102, 126, 234, 0.3);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="nav-bar sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg">
                    <i class="fas fa-keyboard text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">TypeSpeed Admin</h1>
                    <p class="text-xs text-gray-500">User Results</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="px-4 py-2 text-gray-600 hover:text-purple-600 font-semibold transition">
                    <i class="fas fa-arrow-left mr-2"></i>Back to App
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg hover:shadow-lg transition">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 py-8">
        <!-- Back Link -->
        <div class="mb-6">
            <a href="{{ route('admin.users') }}" class="inline-flex items-center gap-2 text-white hover:text-gray-200 font-semibold transition">
                <i class="fas fa-arrow-left"></i>Back to Users
            </a>
        </div>

        <!-- User Card -->
        <div class="glass-effect rounded-2xl shadow-xl p-8 mb-8 user-card animate-fade-in">
            <div class="flex items-center gap-6">
                <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=667eea&color=fff&size=120" 
                     alt="Avatar" class="w-32 h-32 rounded-2xl border-4 border-purple-400 shadow-lg">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ $user->name }}</h1>
                    <p class="text-gray-600 flex items-center gap-2 mb-2">
                        <i class="fas fa-envelope"></i>{{ $user->email }}
                    </p>
                    <p class="text-gray-600 flex items-center gap-2">
                        <i class="fas fa-calendar"></i>Joined {{ $user->created_at->format('F d, Y') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Results Table -->
        <div class="glass-effect rounded-2xl shadow-xl overflow-hidden animate-fade-in">
            <div class="p-8">
                <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
                    <i class="fas fa-keyboard text-purple-600"></i>Test Results
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <th class="px-6 py-4 text-left font-semibold text-gray-700"><i class="fas fa-tachometer-alt mr-2"></i>WPM</th>
                                <th class="px-6 py-4 text-left font-semibold text-gray-700"><i class="fas fa-bullseye mr-2"></i>Accuracy</th>
                                <th class="px-6 py-4 text-left font-semibold text-gray-700"><i class="fas fa-hourglass-half mr-2"></i>Duration</th>
                                <th class="px-6 py-4 text-left font-semibold text-gray-700"><i class="fas fa-fire mr-2"></i>Difficulty</th>
                                <th class="px-6 py-4 text-left font-semibold text-gray-700"><i class="fas fa-calendar mr-2"></i>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $result)
                                <tr class="border-b border-gray-200 transition">
                                    <td class="px-6 py-4 font-bold text-blue-600 text-lg">{{ $result->wpm }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1 bg-green-100 text-green-800 px-3 py-1 rounded-full font-bold">
                                            <i class="fas fa-check"></i>{{ $result->accuracy }}%
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">{{ $result->duration }}s</td>
                                    <td class="px-6 py-4">
                                        <span class="px-4 py-2 rounded-full text-sm font-bold inline-flex items-center gap-1
                                            {{ $result->difficulty == 'easy' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $result->difficulty == 'medium' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $result->difficulty == 'hard' ? 'bg-red-100 text-red-800' : '' }}
                                        ">
                                            @if($result->difficulty == 'easy')
                                                <i class="fas fa-leaf"></i>
                                            @elseif($result->difficulty == 'medium')
                                                <i class="fas fa-fire"></i>
                                            @else
                                                <i class="fas fa-skull"></i>
                                            @endif
                                            {{ ucfirst($result->difficulty) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">{{ $result->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6 flex justify-center">
                    {{ $results->links() }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
