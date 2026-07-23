<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Shivalay Travels</title>
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
            color: #666;
            margin-bottom: 24px;
        }

        .demo-creds {
            background: rgba(255,255,255,0.02);
            border: 1px dashed rgba(255,255,255,0.08);
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 28px;
        }

        .demo-creds-label {
            font-size: 11px;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
            margin-bottom: 10px;
        }

        .demo-creds-btns {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .demo-role-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 5px 10px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 20px;
            color: #aaa;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .demo-role-btn:hover {
            color: #fff;
            background: rgba(255,255,255,0.06);
            border-color: #ff0000;
        }

        .demo-role-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
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

        .login-input:focus {
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

        <h1 class="login-heading">Welcome back</h1>
        <p class="login-sub">Sign in to access the dashboard</p>

        <!-- Demo credentials -->
        <div class="demo-creds">
            <span class="demo-creds-label">Quick Demo Login:</span>
            <div class="demo-creds-btns">
                <button type="button" class="demo-role-btn" onclick="fillDemo('admin@shivalay.in', 'admin123')">
                    <span class="demo-role-dot" style="background: #ff0000;"></span> Super Admin
                </button>
                <button type="button" class="demo-role-btn" onclick="fillDemo('manager@shivalay.in', 'manager123')">
                    <span class="demo-role-dot" style="background: #f59e0b;"></span> Manager
                </button>
                <button type="button" class="demo-role-btn" onclick="fillDemo('agent@shivalay.in', 'agent123')">
                    <span class="demo-role-dot" style="background: #3b82f6;"></span> Agent
                </button>
            </div>
        </div>

        <form method="POST" action="/admin/login" class="login-form">
            @csrf
            @if ($errors->any())
                <div class="login-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="login-field">
                <label class="login-label">Email Address</label>
                <input id="email-field" type="email" name="email" class="login-input" placeholder="admin@shivalay.in" required>
            </div>

            <div class="login-field">
                <label class="login-label">Password</label>
                <input id="password-field" type="password" name="password" class="login-input" placeholder="••••••••" required>
            </div>

            <button type="submit" class="login-submit">Sign In</button>
        </form>

        <a href="/" class="login-back-link">← Back to website</a>
    </div>

    <script>
        function fillDemo(email, pass) {
            document.getElementById('email-field').value = email;
            document.getElementById('password-field').value = pass;
        }
    </script>
</body>
</html>
