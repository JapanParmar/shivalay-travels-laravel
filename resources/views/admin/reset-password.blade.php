<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — Shivalay Travels</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: #050505;
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding: 24px;
        }

        .admin-login-bg {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .bg-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
        }

        .bg-orb-1 {
            width: 500px; height: 500px;
            background: rgba(255,0,0,0.05);
            top: -100px; left: -100px;
            animation: orbFloat 12s ease-in-out infinite;
        }

        .bg-orb-2 {
            width: 400px; height: 400px;
            background: rgba(255,0,0,0.03);
            bottom: -80px; right: -80px;
            animation: orbFloat 16s ease-in-out infinite reverse;
        }

        @keyframes orbFloat {
            0%,100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-30px) scale(1.05); }
        }

        .admin-grid-overlay {
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(255,255,255,0.01) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.01) 1px, transparent 1px);
            background-size: 50px 50px;
        }

        .admin-login-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            background: rgba(12,12,12,0.95);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 24px;
            padding: 40px;
            backdrop-filter: blur(20px);
            box-shadow: 0 40px 80px -20px rgba(0,0,0,0.8);
        }

        .login-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 32px;
        }

        .login-logo-icon {
            width: 40px; height: 40px;
            background: #ff0000;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            box-shadow: 0 0 20px rgba(255,0,0,0.4);
            font-weight: bold;
            font-size: 18px;
        }

        .login-brand {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 1px;
        }

        .login-panel-label {
            display: block;
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .login-heading {
            font-size: 26px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 6px;
        }

        .login-sub {
            font-size: 14px;
            color: #888;
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .login-field {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .login-label {
            font-size: 12px;
            font-weight: 600;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .login-input {
            width: 100%;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 14px;
            color: #fff;
            outline: none;
            transition: all 0.2s ease;
        }

        .login-input-otp {
            width: 100%;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 6px;
            text-align: center;
            color: #fff;
            outline: none;
            transition: all 0.2s ease;
        }

        .login-input:focus, .login-input-otp:focus {
            border-color: #ff0000;
            background: rgba(255,0,0,0.02);
        }

        .login-error {
            background: rgba(255,0,0,0.07);
            border: 1px solid rgba(255,0,0,0.2);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            color: #ff6060;
        }

        .login-submit {
            background: #ff0000;
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            border: none;
            border-radius: 10px;
            padding: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 6px;
            box-shadow: 0 4px 20px rgba(255,0,0,0.3);
        }

        .login-submit:hover {
            background: #cc0000;
        }

        .login-back-link {
            display: block;
            text-align: center;
            margin-top: 24px;
            font-size: 13px;
            color: #555;
            text-decoration: none;
            transition: color 0.2s;
        }

        .login-back-link:hover { color: #fff; }
    </style>
</head>
<body>

    <div class="admin-login-bg">
        <div class="bg-orb bg-orb-1"></div>
        <div class="bg-orb bg-orb-2"></div>
        <div class="admin-grid-overlay"></div>
    </div>

    <div class="admin-login-card">
        <div class="login-logo">
            <div class="login-logo-icon">S</div>
            <div>
                <span class="login-brand">SHIVALAY TRAVELS</span>
                <span class="login-panel-label">Admin Panel</span>
            </div>
        </div>

        <h1 class="login-heading">Reset Password</h1>
        <p class="login-sub">Enter the OTP sent to <strong>{{ session('otp_reset_email') }}</strong> along with your new password.</p>

        <form method="POST" action="/admin/reset-password" class="login-form">
            @csrf
            @if ($errors->any())
                <div class="login-error">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('success'))
                <div style="background: rgba(34,197,94,0.08); border: 1px solid rgba(34,197,94,0.2); border-radius: 8px; padding: 10px 14px; font-size: 13px; color: #4ade80;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="login-field">
                <label class="login-label">Enter 6-Digit OTP</label>
                <input type="text" name="otp" class="login-input-otp" placeholder="000000" maxlength="6" required autocomplete="off">
            </div>

            <div class="login-field">
                <label class="login-label">New Password</label>
                <input type="password" name="password" class="login-input" placeholder="••••••••" required>
            </div>

            <div class="login-field">
                <label class="login-label">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="login-input" placeholder="••••••••" required>
            </div>

            <button type="submit" class="login-submit">Reset Password</button>
        </form>

        <a href="/admin/forgot-password" class="login-back-link">← Request Another OTP</a>
    </div>

</body>
</html>
