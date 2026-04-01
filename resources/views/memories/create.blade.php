<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة ذكرى جديدة</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            min-height: 100vh;
        }
        .card {
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: none;
        }
        .btn-primary {
            background: #2e7d32;
            border: none;
            padding: 10px 30px;
        }
        .btn-primary:hover {
            background: #1b5e20;
        }
        .emotion-btn {
            margin: 5px;
            padding: 10px 20px;
            border-radius: 30px;
            background: #f5f5f5;
            cursor: pointer;
            transition: all 0.2s;
        }
        .emotion-btn.selected {
            background: #2e7d32;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-success text-white text-center py-3">
                        <h3><i class="fas fa-plus-circle"></i> إضافة ذكرى جديدة</h3>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('memories.store') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">عنوان الذكرى</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">وصف الذكرى</label>
                                <textarea name="description" class="form-control" rows="5"></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">حالتك النفسية</label>
                                <div class="row">
                                    @php
                                        $emotions = [
                                            'happy' => '😊 سعيد',
                                            'sad' => '😢 حزين',
                                            'excited' => '🤩 متحمس',
                                            'nostalgic' => '📜 حنين',
                                            'angry' => '😠 غاضب',
                                            'calm' => '😌 هادئ',
                                            'loved' => '❤️ محبوب'
                                        ];
                                    @endphp
                                    @foreach($emotions as $key => $value)
                                        <div class="col-md-3 col-6">
                                            <div class="emotion-btn text-center" data-emotion="{{ $key }}">
                                                {{ $value }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <input type="hidden" name="emotion" id="emotion" required>
                            </div>
                            
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save"></i> حفظ الذكرى
                                </button>
                                <a href="{{ route('memories.index') }}" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-arrow-right"></i> رجوع
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.querySelectorAll('.emotion-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.emotion-btn').forEach(b => b.classList.remove('selected'));
                this.classList.add('selected');
                document.getElementById('emotion').value = this.dataset.emotion;
            });
        });
    </script>
</body>
</html>