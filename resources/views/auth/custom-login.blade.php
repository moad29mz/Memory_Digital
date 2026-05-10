<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Memory Digital</title>
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
            background: #0f0f1a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Container */
        .login-container {
            display: flex;
            max-width: 1000px;
            width: 100%;
            margin: 20px;
            background: #1a1a2e;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
            border: 1px solid rgba(255,255,255,0.1);
        }

        /* Left Side - Logo & Brand */
        .brand-side {
            flex: 1;
            background: linear-gradient(135deg, #0f0f1a, #1a1a2e);
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            border-right: 1px solid rgba(255,255,255,0.1);
        }

        .logo-circle {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #f44336, #d32f2f);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            box-shadow: 0 8px 20px rgba(244,67,54,0.3);
        }

        .logo-circle i {
            font-size: 50px;
            color: white;
        }

        .brand-side h1 {
            font-size: 32px;
            font-weight: 700;
            color: white;
            margin-bottom: 15px;
        }

        .brand-side p {
            color: #8e9aaf;
            font-size: 14px;
            line-height: 1.6;
        }

        .laravel-badge {
            margin-top: 30px;
            display: inline-block;
            background: rgba(244,67,54,0.2);
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 12px;
            color: #f44336;
            border: 1px solid rgba(244,67,54,0.3);
        }

        /* Right Side - Form */
        .form-side {
            flex: 1;
            padding: 60px 50px;
            background: #1a1a2e;
        }

        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .form-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: white;
            margin-bottom: 10px;
        }

        .form-header p {
            color: #8e9aaf;
            font-size: 14px;
        }

        .form-header a {
            color: #f44336;
            text-decoration: none;
            font-weight: 600;
        }

        .form-header a:hover {
            text-decoration: underline;
        }

        /* Form Group */
        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: white;
            font-size: 14px;
        }

        .input-group {
            position: relative;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #8e9aaf;
        }

        .form-control {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s;
            background: #0f0f1a;
            color: white;
        }

        .form-control:focus {
            outline: none;
            border-color: #f44336;
            box-shadow: 0 0 0 3px rgba(244,67,54,0.2);
        }

        .form-control::placeholder {
            color: #5a6a7a;
        }

        /* Button */
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #f44336, #d32f2f);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(244,67,54,0.4);
        }

        /* Divider */
        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: rgba(255,255,255,0.1);
        }

        .divider span {
            background: #1a1a2e;
            padding: 0 15px;
            position: relative;
            color: #8e9aaf;
            font-size: 13px;
        }

        /* Social Buttons */
        .social-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .social-btn {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.1);
            background: #0f0f1a;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            cursor: pointer;
        }

        .social-btn:hover {
            transform: scale(1.05);
            border-color: #f44336;
        }

        .social-btn i {
            font-size: 18px;
        }

        /* Error Messages */
        .error-message {
            color: #f44336;
            font-size: 12px;
            margin-top: 5px;
        }

        .alert-danger {
            background: rgba(244,67,54,0.1);
            border: 1px solid rgba(244,67,54,0.3);
            border-radius: 12px;
            color: #f44336;
            padding: 12px;
            margin-bottom: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                margin: 10px;
                border-radius: 20px;
            }
            
            .brand-side {
                padding: 40px 30px;
                border-right: none;
                border-bottom: 1px solid rgba(255,255,255,0.1);
            }
            
            .form-side {
                padding: 40px 30px;
            }
            
            .logo-circle {
                width: 80px;
                height: 80px;
            }
            
            .logo-circle i {
                font-size: 40px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">

        <!-- Right Side - Form -->
        <div class="form-side">
            <div class="form-header">
                <h2>Welcome </h2>
                <p>Don't have an account? <a href="{{ route('register') }}">Sign Up</a></p>
            </div>

            @if($errors->any())
                <div class="alert-danger">
                    @foreach($errors->all() as $error)
                        <p class="error-message">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('custom.login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Email Address</label>
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" class="form-control" placeholder="Enter your email" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>
            </form>

            
        </div>
    </div>
</body>
</html>
