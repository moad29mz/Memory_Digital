<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Digital - ذكرياتي</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            min-height: 100vh;
            font-family: 'Tajawal', sans-serif;
        }
        .navbar {
            background: #2e7d32 !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .navbar-brand, .nav-link {
            color: white !important;
            font-weight: bold;
        }
        .btn-primary {
            background: #2e7d32;
            border: none;
        }
        .btn-primary:hover {
            background: #1b5e20;
        }
        .btn-danger {
            background: #d32f2f;
            border: none;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .emotion-badge {
            font-size: 1.2rem;
            padding: 5px 10px;
            border-radius: 20px;
            background: #f5f5f5;
        }
        .search-bar {
            background: white;
            border-radius: 50px;
            padding: 5px 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .dark-mode {
            background: #1a1a2e;
            color: white;
        }
        .dark-mode .card {
            background: #16213e;
            color: white;
        }
        .dark-mode .search-bar {
            background: #0f3460;
            color: white;
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
                        <i class="fas fa-language"></i> {{ __('lang') }}
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/lang/ar">العربية</a></li>
                        <li><a class="dropdown-item" href="/lang/fr">Français</a></li>
                        <li><a class="dropdown-item" href="/lang/en">English</a></li>
                    </ul>
                </div>
                <a href="{{ route('logout') }}" class="btn btn-danger ms-2"
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
        <div class="row mb-4">
            <div class="col-md-8">
                <h2><i class="fas fa-bookmark"></i> ذكرياتي</h2>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('memories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> إضافة ذكرى جديدة
                </a>
            </div>
        </div>

        <!-- Search Form -->
        <div class="search-bar mb-4 p-3">
            <form action="{{ route('memories.search') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-5">
                        <input type="text" name="search" class="form-control" placeholder="بحث بالعنوان...">
                    </div>
                    <div class="col-md-5">
                        <input type="date" name="date" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">بحث</button>
                    </div>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            @forelse($memories as $memory)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="emotion-badge mb-2">
                                @switch($memory->emotion)
                                    @case('happy') 😊 @break
                                    @case('sad') 😢 @break
                                    @case('excited') 🤩 @break
                                    @case('nostalgic') 📜 @break
                                    @case('angry') 😠 @break
                                    @case('calm') 😌 @break
                                    @case('loved') ❤️ @break
                                    @default 📝
                                @endswitch
                                {{ ucfirst($memory->emotion) }}
                            </div>
                            <h5 class="card-title">{{ $memory->title }}</h5>
                            <p class="card-text">{{ Str::limit($memory->description, 100) }}</p>
                            <small class="text-muted">
                                <i class="far fa-calendar-alt"></i> 
                                {{ \Carbon\Carbon::parse($memory->created_at)->format('Y-m-d H:i') }}
                            </small>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('memories.edit', $memory->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> تعديل
                            </a>
                            <form action="{{ route('memories.destroy', $memory->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد؟')">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> لا توجد ذكريات بعد. أضف أول ذكرى لك!
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
    </script>
</body>
</html>