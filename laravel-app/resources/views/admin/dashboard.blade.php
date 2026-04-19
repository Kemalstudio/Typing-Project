<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - TypeSpeed</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.45.0/dist/apexcharts.min.js"></script>
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

        .stats-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.7) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .nav-bar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .tab-active {
            color: #667eea;
            border-bottom: 3px solid #667eea;
        }

        .tab-inactive {
            color: #999;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .tab-inactive:hover {
            color: #667eea;
        }

        table tbody tr:hover {
            background: rgba(102, 126, 234, 0.05);
        }

        .difficulty-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
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
                    <p class="text-xs text-gray-500">Dashboard</p>
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
        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 animate-fade-in">
            <div class="stats-card p-8 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-600 text-sm font-medium mb-2"><i class="fas fa-users mr-2"></i>Total Users</h3>
                        <p class="text-4xl font-bold text-blue-600">{{ $stats['total_users'] }}</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-blue-50 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-users text-2xl text-blue-600"></i>
                    </div>
                </div>
            </div>
            <div class="stats-card p-8 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-600 text-sm font-medium mb-2"><i class="fas fa-list mr-2"></i>Total Tests</h3>
                        <p class="text-4xl font-bold text-green-600">{{ $stats['total_tests'] }}</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-green-50 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-list text-2xl text-green-600"></i>
                    </div>
                </div>
            </div>
            <div class="stats-card p-8 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-600 text-sm font-medium mb-2"><i class="fas fa-tachometer-alt mr-2"></i>Avg WPM</h3>
                        <p class="text-4xl font-bold text-purple-600">{{ $stats['avg_wpm'] }}</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-purple-50 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-tachometer-alt text-2xl text-purple-600"></i>
                    </div>
                </div>
            </div>
            <div class="stats-card p-8 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-600 text-sm font-medium mb-2"><i class="fas fa-bullseye mr-2"></i>Avg Accuracy</h3>
                        <p class="text-4xl font-bold text-orange-600">{{ $stats['avg_accuracy'] }}%</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-100 to-orange-50 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-bullseye text-2xl text-orange-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="glass-effect rounded-2xl shadow-xl overflow-hidden animate-fade-in">
            <div class="flex border-b border-gray-200">
                <a href="{{ route('admin.dashboard') }}" class="px-6 py-4 tab-active font-semibold flex items-center gap-2">
                    <i class="fas fa-chart-line"></i>Dashboard
                </a>
                <a href="{{ route('admin.users') }}" class="px-6 py-4 tab-inactive font-semibold flex items-center gap-2 hover:text-purple-600 transition">
                    <i class="fas fa-users"></i>Users
                </a>
                <a href="{{ route('admin.results') }}" class="px-6 py-4 tab-inactive font-semibold flex items-center gap-2 hover:text-purple-600 transition">
                    <i class="fas fa-keyboard"></i>All Results
                </a>
            </div>

            <!-- Recent Results -->
            <div class="p-8">
                <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
                    <i class="fas fa-history text-purple-600"></i>Recent Test Results
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <th class="px-6 py-4 text-left font-semibold text-gray-700"><i class="fas fa-user mr-2"></i>User</th>
                                <th class="px-6 py-4 text-left font-semibold text-gray-700"><i class="fas fa-tachometer-alt mr-2"></i>WPM</th>
                                <th class="px-6 py-4 text-left font-semibold text-gray-700"><i class="fas fa-bullseye mr-2"></i>Accuracy</th>
                                <th class="px-6 py-4 text-left font-semibold text-gray-700"><i class="fas fa-hourglass-half mr-2"></i>Duration</th>
                                <th class="px-6 py-4 text-left font-semibold text-gray-700"><i class="fas fa-fire mr-2"></i>Difficulty</th>
                                <th class="px-6 py-4 text-left font-semibold text-gray-700"><i class="fas fa-calendar mr-2"></i>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recent_results as $result)
                                <tr class="border-b border-gray-200 transition">
                                    <td class="px-6 py-4 font-semibold text-gray-800">
                                        <div class="flex items-center gap-2">
                                            <img src="https://ui-avatars.com/api/?name={{ $result->user->name ?? 'Unknown' }}&background=667eea&color=fff" 
                                                 alt="Avatar" class="w-8 h-8 rounded-full">
                                            {{ $result->user->name ?? 'Unknown' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-blue-600">{{ $result->wpm }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center">
                                            <i class="fas fa-check text-green-600 mr-2"></i>{{ $result->accuracy }}%
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">{{ $result->duration }}s</td>
                                    <td class="px-6 py-4">
                                        <span class="difficulty-badge px-4 py-2 rounded-full text-sm font-bold inline-flex
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
            </div>
        </div>
    </div>
</body>
</html>
