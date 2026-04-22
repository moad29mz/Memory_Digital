<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Digital - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f5f7fa;
            min-height: 100vh;
        }

        /* App Container */
        .app-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: white;
            border-right: 1px solid #e8edf2;
            padding: 30px 20px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 40px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 15px;
        }

        .logo i {
            color: #2e7d32;
            font-size: 28px;
        }

        .logo span {
            background: linear-gradient(135deg, #2e7d32, #4caf50);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Sidebar Menu */
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin-bottom: 30px;
        }

        .sidebar-menu li {
            margin-bottom: 8px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            border-radius: 12px;
            color: #5a6a7a;
            text-decoration: none;
            transition: all 0.2s;
            font-weight: 500;
        }

        .sidebar-menu a:hover {
            background: #f0f2f5;
            color: #2e7d32;
        }

        .sidebar-menu .active a {
            background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
            color: #2e7d32;
            font-weight: 600;
        }

        .sidebar-menu i {
            width: 22px;
            font-size: 18px;
        }

        /* Sidebar Bottom */
        .sidebar-bottom {
            position: absolute;
            bottom: 30px;
            left: 20px;
            right: 20px;
            border-top: 1px solid #e8edf2;
            padding-top: 20px;
        }

        .sidebar-bottom a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            border-radius: 12px;
            color: #5a6a7a;
            text-decoration: none;
            transition: all 0.2s;
            font-weight: 500;
        }

        .sidebar-bottom a:hover {
            background: #f0f2f5;
            color: #2e7d32;
        }

        .sidebar-bottom .logout-btn {
            color: #f44336;
        }

        .sidebar-bottom .logout-btn:hover {
            background: #ffebee;
            color: #f44336;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 30px 40px;
        }

        /* Header */
        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 5px;
        }

        .page-title p {
            color: #666;
            font-size: 14px;
        }

        /* Stats Cards */
        .stats-section {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 24px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            transition: all 0.3s;
            cursor: pointer;
            text-decoration: none;
            display: block;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 42px;
            font-weight: 700;
            color: #2e7d32;
        }

        .stat-label {
            color: #6c757d;
            font-size: 14px;
            margin-top: 8px;
        }

        /* Recent Memories */
        .recent-section {
            background: white;
            border-radius: 24px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        .recent-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .recent-header h3 {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a2e;
            margin: 0;
        }

        .recent-header a {
            color: #2e7d32;
            text-decoration: none;
            font-size: 14px;
        }

        .recent-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .recent-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            border-radius: 16px;
            background: #f8f9fa;
            transition: all 0.2s;
        }

        .recent-item:hover {
            background: #e8f5e9;
        }

        .recent-title {
            font-weight: 500;
            color: #1a1a2e;
        }

        .recent-date {
            font-size: 12px;
            color: #8e9aaf;
        }

        .recent-item a {
            color: #2e7d32;
            text-decoration: none;
        }

        /* Dark Mode */
        .dark-mode body {
            background: #1a1a2e;
        }

        .dark-mode .sidebar {
            background: #16213e;
            border-right-color: #2e7d32;
        }

        .dark-mode .sidebar-menu a {
            color: #aaa;
        }

        .dark-mode .sidebar-menu a:hover {
            background: #1f2a4a;
            color: #4caf50;
        }

        .dark-mode .sidebar-menu .active a {
            background: linear-gradient(135deg, #1b5e20, #2e7d32);
            color: white;
        }

        .dark-mode .sidebar-bottom {
            border-top-color: #2e7d32;
        }

        .dark-mode .sidebar-bottom a {
            color: #aaa;
        }

        .dark-mode .sidebar-bottom a:hover {
            background: #1f2a4a;
            color: #4caf50;
        }

        .dark-mode .main-content {
            background: #1a1a2e;
        }

        .dark-mode .page-title h1 {
            color: white;
        }

        .dark-mode .stat-card {
            background: #16213e;
        }

        .dark-mode .stat-label {
            color: #aaa;
        }

        .dark-mode .recent-section {
            background: #16213e;
        }

        .dark-mode .recent-header h3 {
            color: white;
        }

        .dark-mode .recent-item {
            background: #1f2a4a;
        }

        .dark-mode .recent-title {
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
                z-index: 1000;
            }
            
            .sidebar.open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
            
            .stats-section {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="logo">
                <i class="fas fa-brain"></i>
                <span>Memory Digital</span>
            </div>

            <ul class="sidebar-menu">
                <li class="active">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('memories.index') }}">
                        <i class="fas fa-book"></i> ذكرياتي
                    </a>
                </li>
            </ul>

            <div class="sidebar-bottom">
                <!-- Language Switcher -->
                <a href="#" onclick="event.preventDefault(); document.getElementById('lang-ar').submit();">
                    <i class="fas fa-language"></i> اللغة - العربية
                </a>
                <form id="lang-ar" action="{{ route('lang.switch', 'ar') }}" method="GET" class="d-none"></form>
                
                <a href="#" onclick="event.preventDefault(); document.getElementById('lang-fr').submit();">
                    <i class="fas fa-language"></i> Langue - Français
                </a>
                <form id="lang-fr" action="{{ route('lang.switch', 'fr') }}" method="GET" class="d-none"></form>
                
                <a href="#" onclick="event.preventDefault(); document.getElementById('lang-en').submit();">
                    <i class="fas fa-language"></i> Language - English
                </a>
                <form id="lang-en" action="{{ route('lang.switch', 'en') }}" method="GET" class="d-none"></form>

                <!-- Dark Mode Toggle -->
                <a href="#" onclick="toggleDarkMode()">
                    <i class="fas fa-moon"></i> الوضع الليلي
                </a>

                <!-- Logout -->
                <a href="#" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="main-header">
                <div class="page-title">
                    <h1>Dashboard</h1>
                    <p>Welcome back, @auth {{ Auth::user()->name }} @endauth 👋</p>
                </div>
                <div class="header-actions">
                    <button class="calendar-toggle" onclick="toggleSidebar()" style="background: none; border: none; font-size: 24px; display: none;">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="stats-section">
                <a href="{{ route('memories.index') }}" class="stat-card">
                    <div class="stat-number">
                        @auth {{ \App\Models\Memory::where('user_id', auth()->id())->count() }} @else 0 @endauth
                    </div>
                    <div class="stat-label">Total Memories</div>
                </a>
                <a href="{{ route('memories.create') }}" class="stat-card">
                    <div class="stat-number">
                        <i class="fas fa-plus" style="font-size: 36px;"></i>
                    </div>
                    <div class="stat-label">Add New Memory</div>
                </a>
                <div class="stat-card">
                    <div class="stat-number">
                        @auth {{ \App\Models\Memory::where('user_id', auth()->id())->where('emotion', 'happy')->count() }} @else 0 @endauth
                    </div>
                    <div class="stat-label">Happy Moments</div>
                </div>
            </div>

            <!-- Recent Memories -->
            <div class="recent-section">
                <div class="recent-header">
                    <h3><i class="fas fa-clock"></i> Recent Memories</h3>
                    <a href="{{ route('memories.index') }}">View all →</a>
                </div>
                <div class="recent-list">
                    @auth
                        @php
                            $recentMemories = \App\Models\Memory::where('user_id', auth()->id())
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();
                        @endphp
                        @forelse($recentMemories as $memory)
                            <div class="recent-item">
                                <div>
                                    <div class="recent-title">{{ $memory->title }}</div>
                                    <div class="recent-date">{{ $memory->created_at->diffForHumans() }}</div>
                                </div>
                                <a href="{{ route('memories.edit', $memory->id) }}">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">
                                No memories yet. Click "Add New Memory" to create one!
                            </div>
                        @endforelse
                    @else
                        <div class="text-center py-4">
                            <a href="{{ route('login') }}" style="color: #2e7d32;">Login</a> to see your memories
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            if (document.body.classList.contains('dark-mode')) {
                localStorage.setItem('darkMode', 'enabled');
            } else {
                localStorage.setItem('darkMode', 'disabled');
            }
        }
        
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.body.classList.add('dark-mode');
        }
        
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
        }
        
        // Show mobile menu button on small screens
        if (window.innerWidth <= 768) {
            document.querySelector('.calendar-toggle').style.display = 'block';
        }
    </script>
</body>
</html>