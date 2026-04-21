<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Google và Facebook</title>
    <style>
        :root {
            color-scheme: light;
            --bg: #f4efe6;
            --panel: #fffdf9;
            --primary: #0f766e;
            --primary-dark: #115e59;
            --facebook: #1877f2;
            --google: #ea4335;
            --text: #1f2937;
            --muted: #6b7280;
            --border: #e5ded3;
            --success: #166534;
            --error: #b91c1c;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, #fde68a 0, transparent 28%),
                radial-gradient(circle at bottom right, #bfdbfe 0, transparent 30%),
                var(--bg);
            display: grid;
            place-items: center;
            padding: 24px;
        }

        .card {
            width: min(100%, 980px);
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 20px 80px rgba(15, 23, 42, 0.12);
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
        }

        .hero, .content { padding: 40px; }
        .hero {
            background: linear-gradient(135deg, #134e4a, #0f766e 55%, #14b8a6);
            color: #f8fafc;
        }

        .badge {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.16);
            font-size: 14px;
            margin-bottom: 16px;
        }

        h1 { font-size: clamp(30px, 4vw, 48px); line-height: 1.1; margin: 0 0 14px; }
        p { margin: 0 0 16px; line-height: 1.7; }
        .meta {
            margin-top: 28px;
            padding: 18px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.12);
        }

        .content { display: flex; flex-direction: column; justify-content: center; }
        .title { font-size: 30px; margin-bottom: 12px; }
        .subtitle { color: var(--muted); margin-bottom: 26px; }
        .alert {
            padding: 14px 16px;
            border-radius: 14px;
            margin-bottom: 18px;
            font-size: 15px;
        }
        .alert-success { background: #dcfce7; color: var(--success); }
        .alert-error { background: #fee2e2; color: var(--error); }
        .auth-buttons { display: grid; gap: 14px; }
        .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 15px 20px;
            border-radius: 16px;
            text-decoration: none;
            color: #fff;
            font-weight: 700;
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 16px 35px rgba(15, 23, 42, 0.12); }
        .btn-google { background: linear-gradient(135deg, #ea4335, #f97316); }
        .btn-facebook { background: linear-gradient(135deg, #1877f2, #2563eb); }
        .hint {
            margin-top: 20px;
            padding: 16px;
            background: #f8fafc;
            border: 1px dashed var(--border);
            border-radius: 16px;
            color: var(--muted);
        }

        @media (max-width: 860px) {
            .card { grid-template-columns: 1fr; }
            .hero, .content { padding: 28px; }
        }
    </style>
</head>
<body>
    <main class="card">
        <section class="hero">
            <span class="badge">Laravel Socialite OAuth 2.0</span>
            <h1>Đăng nhập nhanh bằng Google và Facebook</h1>
            <p>Ứng dụng cho phép người dùng đăng nhập bằng tài khoản bên thứ ba, tự động lưu thông tin cơ bản vào cơ sở dữ liệu và quản lý phiên đăng nhập.</p>

            <div class="meta">
                <p><strong>Họ tên sinh viên:</strong> {{ config('student.name') }}</p>
                <p><strong>Mã sinh viên:</strong> {{ config('student.id') }}</p>
                <p><strong>Lớp:</strong> {{ config('student.class') }}</p>
            </div>
        </section>

        <section class="content">
            <div class="title">Bắt đầu đăng nhập</div>
            <p class="subtitle">Chọn nhà cung cấp phù hợp để chuyển tới màn hình xác thực OAuth.</p>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            <div class="auth-buttons">
                <a class="btn btn-google" href="{{ route('social.redirect', 'google') }}">Đăng nhập với Google</a>
                <a class="btn btn-facebook" href="{{ route('social.redirect', 'facebook') }}">Đăng nhập với Facebook</a>
            </div>

        </section>
    </main>
</body>
</html>
