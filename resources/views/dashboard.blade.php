<!DOCTYPE html>
<html lang="en">
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
            font-size: 22px;
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

        .sidebar-bottom {
            margin-top: 50px;
            border-top: 1px solid #e8edf2;
            padding-top: 20px;
        }

        .sidebar-bottom .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            border-radius: 12px;
            color: #5a6a7a;
            text-decoration: none;
            transition: all 0.2s;
            font-weight: 500;
            cursor: pointer;
            width: 100%;
            background: none;
            border: none;
            text-align: left;
        }

        .sidebar-bottom .menu-item:hover {
            background: #f0f2f5;
            color: #2e7d32;
        }

        .language-dropdown {
            margin-left: 30px;
            margin-top: 5px;
            margin-bottom: 10px;
            display: none;
        }

        .language-dropdown.show {
            display: block;
        }

        .language-dropdown a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 18px;
            border-radius: 10px;
            color: #5a6a7a;
            text-decoration: none;
            transition: all 0.2s;
            font-size: 14px;
        }

        .language-dropdown a:hover {
            background: #f0f2f5;
            color: #2e7d32;
        }

        .sidebar-bottom .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            border-radius: 12px;
            color: #f44336;
            text-decoration: none;
            transition: all 0.2s;
            font-weight: 500;
            margin-top: 10px;
            cursor: pointer;
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

        /* Welcome Section - Centered Large Text */
        .welcome-section {
            text-align: center;
            margin-bottom: 50px;
            margin-top: 20px;
        }

        .welcome-section h1 {
            font-size: 48px;
            font-weight: 700;
            background: linear-gradient(135deg, #2e7d32, #4caf50);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
        }

        .welcome-section p {
            color: #8e9aaf;
            font-size: 18px;
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

        .dark-mode .sidebar-bottom .menu-item {
            color: #aaa;
        }

        .dark-mode .sidebar-bottom .menu-item:hover {
            background: #1f2a4a;
            color: #4caf50;
        }

        .dark-mode .language-dropdown a {
            color: #aaa;
        }

        .dark-mode .language-dropdown a:hover {
            background: #1f2a4a;
            color: #4caf50;
        }

        .dark-mode .main-content {
            background: #1a1a2e;
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
            
            .welcome-section h1 {
                font-size: 32px;
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
                <li>
                    <a href="{{ route('memories.index') }}">
                        <i class="fas fa-book"></i> My Memories
                    </a>
                </li>
                <li>
                    <a href="{{ route('statistics') }}">
                        <i class="fas fa-chart-line"></i> Statistics
                    </a>
                </li>
            </ul>

            <div class="sidebar-bottom">
                <!-- Language Button with Dropdown -->
                <button class="menu-item" onclick="toggleLanguageDropdown()">
                    <i class="fas fa-globe"></i> Language
                </button>
                <div class="language-dropdown" id="languageDropdown">
                    <a href="#" onclick="changeLanguage('en'); return false;">
                        <i class="fas fa-flag-usa"></i> English
                    </a>
                    <a href="#" onclick="changeLanguage('ar'); return false;">
                        <i class="fas fa-flag"></i> العربية
                    </a>
                    <a href="#" onclick="changeLanguage('fr'); return false;">
                        <i class="fas fa-flag"></i> Français
                    </a>
                </div>

                <!-- Dark Mode Toggle -->
                <button class="menu-item" onclick="toggleDarkMode()">
                    <i class="fas fa-moon"></i> Dark Mode
                </button>

                <!-- Logout -->
                <a href="#" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Welcome Section - Centered Large Text -->
            <div class="welcome-section">
                <h1>Welcome @auth {{ Auth::user()->name }} @endauth</h1>
                
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
        
        function toggleLanguageDropdown() {
            const dropdown = document.getElementById('languageDropdown');
            dropdown.classList.toggle('show');
        }
        
        function changeLanguage(locale) {
            fetch(`/lang/${locale}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => {
                window.location.reload();
            });
        }
        
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
        }
        
        // Check saved dark mode
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.body.classList.add('dark-mode');
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('languageDropdown');
            const btn = document.querySelector('.menu-item');
            if (btn && !btn.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });
    </script>
</body>
</html>