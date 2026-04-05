<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الإحصائيات - Memory Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            min-height: 100vh;
        }
        .navbar {
            background: #2e7d32 !important;
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #2e7d32;
        }
        .stat-label {
            color: #666;
            font-size: 1rem;
        }
        .chart-container {
            background: white;
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .btn-primary {
            background: #2e7d32;
            border: none;
        }
        .dark-mode {
            background: #1a1a2e;
            color: white;
        }
        .dark-mode .stat-card {
            background: #16213e;
            color: white;
        }
        .dark-mode .chart-container {
            background: #16213e;
            color: white;
        }
        .dark-mode .stat-label {
            color: #ccc;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-brain"></i> Memory Digital
            </a>
            <div class="ms-auto">
                <button class="btn btn-light me-2" onclick="toggleDarkMode()">
                    <i class="fas fa-moon"></i>
                </button>
                <div class="dropdown d-inline">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-language"></i> اللغة
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('lang.switch', 'ar') }}">العربية</a></li>
                        <li><a class="dropdown-item" href="{{ route('lang.switch', 'fr') }}">Français</a></li>
                        <li><a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">English</a></li>
                    </ul>
                </div>
                <a href="{{ route('memories.index') }}" class="btn btn-success me-2">
                    <i class="fas fa-book"></i> ذكرياتي
                </a>
                <a href="{{ route('logout') }}" class="btn btn-danger"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> خروج
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="mb-4"><i class="fas fa-chart-line"></i> إحصائيات ذكرياتي</h2>
        
        <!-- بطاقات الإحصائيات -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <i class="fas fa-book fa-2x" style="color: #2e7d32;"></i>
                    <div class="stat-number">{{ $totalMemories }}</div>
                    <div class="stat-label">إجمالي الذكريات</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <i class="fas fa-image fa-2x" style="color: #2196f3;"></i>
                    <div class="stat-number">{{ $totalImages }}</div>
                    <div class="stat-label">الصور</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <i class="fas fa-video fa-2x" style="color: #ff9800;"></i>
                    <div class="stat-number">{{ $totalVideos }}</div>
                    <div class="stat-label">الفيديوهات</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <i class="fas fa-music fa-2x" style="color: #9c27b0;"></i>
                    <div class="stat-number">{{ $totalAudios }}</div>
                    <div class="stat-label">الأغاني والتسجيلات</div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- رسم بياني للحالة النفسية -->
            <div class="col-md-6">
                <div class="chart-container">
                    <h5><i class="fas fa-smile"></i> توزيع الحالة النفسية</h5>
                    <canvas id="emotionsChart"></canvas>
                </div>
            </div>
            
            <!-- رسم بياني للذكريات حسب الشهر -->
            <div class="col-md-6">
                <div class="chart-container">
                    <h5><i class="fas fa-calendar-alt"></i> الذكريات حسب الشهر</h5>
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>

        <!-- آخر الذكريات المضافة -->
        <div class="chart-container">
            <h5><i class="fas fa-clock"></i> آخر الذكريات المضافة</h5>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>العنوان</th>
                            <th>الحالة النفسية</th>
                            <th>التاريخ</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentMemories as $memory)
                            <tr>
                                <td>{{ $memory->title }}</td>
                                <td>
                                    @switch($memory->emotion)
                                        @case('happy') 😊 @break
                                        @case('sad') 😢 @break
                                        @case('excited') 🤩 @break
                                        @case('nostalgic') 📜 @break
                                        @case('angry') 😠 @break
                                        @case('calm') 😌 @break
                                        @case('loved') ❤️ @break
                                    @endswitch
                                </td>
                                <td>{{ \Carbon\Carbon::parse($memory->created_at)->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ route('memories.edit', $memory->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // رسم بياني للحالة النفسية
        const emotionsCtx = document.getElementById('emotionsChart').getContext('2d');
        new Chart(emotionsCtx, {
            type: 'doughnut',
            data: {
                labels: ['سعيد 😊', 'حزين 😢', 'متحمس 🤩', 'حنين 📜', 'غاضب 😠', 'هادئ 😌', 'محبوب ❤️'],
                datasets: [{
                    data: [
                        {{ $emotionsStats['happy'] }},
                        {{ $emotionsStats['sad'] }},
                        {{ $emotionsStats['excited'] }},
                        {{ $emotionsStats['nostalgic'] }},
                        {{ $emotionsStats['angry'] }},
                        {{ $emotionsStats['calm'] }},
                        {{ $emotionsStats['loved'] }}
                    ],
                    backgroundColor: ['#4caf50', '#f44336', '#ff9800', '#9c27b0', '#795548', '#2196f3', '#e91e63']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });

        // رسم بياني للذكريات حسب الشهر
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        const monthlyData = @json($memoriesByMonth);
        const months = ['يناير', 'فبراير', 'مارس', 'أبريل', 'ماي', 'يونيو', 'يوليو', 'غشت', 'سبتمبر', 'أكتوبر', 'نونبر', 'دجنبر'];
        const dataCounts = Array(12).fill(0);
        
        monthlyData.forEach(item => {
            dataCounts[item.month - 1] = item.count;
        });

        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'عدد الذكريات',
                    data: dataCounts,
                    backgroundColor: '#2e7d32',
                    borderRadius: 10
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true, stepSize: 1 }
                }
            }
        });

        // الوضع الليلي
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
    </script>
</body>
</html>