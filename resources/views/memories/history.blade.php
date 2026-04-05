<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.my_memories') }} - {{ __('messages.app_name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border: none;
        }
        .history-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
        }
        .badge-created { background: #28a745; color: white; }
        .badge-updated { background: #ffc107; color: black; }
        .badge-deleted { background: #dc3545; color: white; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-brain"></i> {{ __('messages.app_name') }}
            </a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h4><i class="fas fa-history"></i> تاريخ التعديلات: {{ $memory->title }}</h4>
                    </div>
                    <div class="card-body">
                        @forelse($histories as $history)
                            <div class="mb-3 p-3 border rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        @if($history->action == 'created')
                                            <span class="history-badge badge-created">تم الإنشاء</span>
                                        @elseif($history->action == 'updated')
                                            <span class="history-badge badge-updated">تم التعديل</span>
                                        @else
                                            <span class="history-badge badge-deleted">تم الحذف</span>
                                        @endif
                                        <span class="ms-2 text-muted">
                                            <i class="far fa-clock"></i> 
                                            {{ \Carbon\Carbon::parse($history->created_at)->format('Y-m-d H:i:s') }}
                                        </span>
                                    </div>
                                </div>
                                @if($history->action == 'updated' && $history->old_data && $history->new_data)
                                    <hr>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <strong>البيانات القديمة:</strong>
                                            <pre class="bg-light p-2 rounded">{{ json_encode(json_decode($history->old_data), JSON_PRETTY_PRINT) }}</pre>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>البيانات الجديدة:</strong>
                                            <pre class="bg-light p-2 rounded">{{ json_encode(json_decode($history->new_data), JSON_PRETTY_PRINT) }}</pre>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center text-muted">
                                <i class="fas fa-info-circle"></i> لا يوجد تاريخ تعديلات لهذه الذكرى
                            </div>
                        @endforelse
                        <div class="mt-3">
                            <a href="{{ route('memories.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-right"></i> رجوع للذكريات
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>