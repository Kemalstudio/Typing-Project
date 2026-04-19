<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users - Admin Panel</title>
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

        .action-btn {
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .action-btn-primary {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        .action-btn-primary:hover {
            background: #667eea;
            color: white;
        }

        .action-btn-danger {
            background: rgba(255, 0, 0, 0.1);
            color: #dc2626;
        }

        .action-btn-danger:hover {
            background: #dc2626;
            color: white;
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
                    <p class="text-xs text-gray-500">User Management</p>
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
        <div class="glass-effect rounded-2xl shadow-xl overflow-hidden animate-fade-in">
            <!-- Tabs -->
            <div class="flex border-b border-gray-200">
                <a href="{{ route('admin.dashboard') }}" class="px-6 py-4 tab-inactive font-semibold flex items-center gap-2 hover:text-purple-600 transition">
                    <i class="fas fa-chart-line"></i>Dashboard
                </a>
                <a href="{{ route('admin.users') }}" class="px-6 py-4 tab-active font-semibold flex items-center gap-2">
                    <i class="fas fa-users"></i>Users
                </a>
                <a href="{{ route('admin.results') }}" class="px-6 py-4 tab-inactive font-semibold flex items-center gap-2 hover:text-purple-600 transition">
                    <i class="fas fa-keyboard"></i>All Results
                </a>
            </div>

            <!-- Users Table -->
            <div class="p-8">
                <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
                    <i class="fas fa-users text-purple-600"></i>Registered Users
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <th class="px-6 py-4 text-left font-semibold text-gray-700"><i class="fas fa-user mr-2"></i>Name</th>
                                <th class="px-6 py-4 text-left font-semibold text-gray-700"><i class="fas fa-envelope mr-2"></i>Email</th>
                                <th class="px-6 py-4 text-left font-semibold text-gray-700"><i class="fas fa-list mr-2"></i>Tests Completed</th>
                                <th class="px-6 py-4 text-left font-semibold text-gray-700"><i class="fas fa-calendar mr-2"></i>Joined</th>
                                <th class="px-6 py-4 text-left font-semibold text-gray-700"><i class="fas fa-cogs mr-2"></i>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="border-b border-gray-200 transition">
                                    <td class="px-6 py-4 font-semibold text-gray-800">
                                        <div class="flex items-center gap-2">
                                            <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=667eea&color=fff" 
                                                 alt="Avatar" class="w-8 h-8 rounded-full">
                                            {{ $user->name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">{{ $user->email }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1 bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-bold">
                                            <i class="fas fa-keyboard"></i>{{ $user->typing_results_count }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">{{ $user->created_at->format('Y-m-d') }}</td>
                                    <td class="px-6 py-4 flex gap-2">
                                        <a href="{{ route('admin.user.results', $user->id) }}" class="action-btn action-btn-primary">
                                            <i class="fas fa-eye"></i>View Results
                                        </a>
                                        <form method="POST" action="{{ route('admin.delete.user', $user->id) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn action-btn-danger">
                                                <i class="fas fa-trash"></i>Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6 flex justify-center">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
