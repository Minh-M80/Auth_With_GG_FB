<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin người dùng</title>
    <style>
        :root {
            --bg: #f8fafc;
            --panel: #ffffff;
            --primary: #0f766e;
            --text: #0f172a;
            --muted: #64748b;
            --border: #dbe4ea;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background:
                linear-gradient(180deg, rgba(20, 184, 166, 0.10), rgba(248, 250, 252, 0)),
                var(--bg);
            color: var(--text);
            padding: 24px;
        }

        .wrapper { max-width: 1100px; margin: 0 auto; }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .brand h1 { margin: 0 0 8px; font-size: clamp(28px, 4vw, 42px); }
        .brand p { margin: 0; color: var(--muted); }
        .logout-btn {
            border: 0;
            border-radius: 14px;
            padding: 13px 20px;
            background: #111827;
            color: #fff;
            font-weight: 700;
            cursor: pointer;
        }

        .grid {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 24px;
        }

        .panel {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 16px 50px rgba(15, 23, 42, 0.08);
        }

        .profile {
            display: flex;
            gap: 18px;
            align-items: center;
            margin-bottom: 22px;
        }

        .avatar {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            object-fit: cover;
            background: #e2e8f0;
            border: 4px solid #ccfbf1;
        }

        .meta-list {
            display: grid;
            gap: 14px;
            margin-top: 14px;
        }

        .meta-item {
            padding: 16px;
            border-radius: 18px;
            background: #f8fafc;
            border: 1px solid var(--border);
        }

        .label {
            display: block;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--muted);
            margin-bottom: 6px;
        }

        .value { font-size: 18px; font-weight: 700; word-break: break-word; }
        .success {
            margin-bottom: 18px;
            padding: 14px 16px;
            border-radius: 14px;
            background: #dcfce7;
            color: #166534;
        }

        @media (max-width: 860px) {
            .grid { grid-template-columns: 1fr; }
            .profile { align-items: flex-start; flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="topbar">
            <div class="brand">
                <h1>Thông tin sau đăng nhập</h1>
                <p>Phiên đăng nhập đã được tạo thành công bằng Google hoặc Facebook.</p>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Đăng xuất</button>
            </form>
        </div>

        @if (session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <div class="grid">
            <section class="panel">
                <div class="profile">
                    <img
                        class="avatar"
                        src="{{ auth()->user()->avatar ?: 'data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"88\" height=\"88\" viewBox=\"0 0 88 88\"><rect width=\"88\" height=\"88\" rx=\"44\" fill=\"%230f766e\"/><text x=\"50%25\" y=\"52%25\" font-size=\"32\" text-anchor=\"middle\" fill=\"white\" font-family=\"Arial\" dy=\".3em\">' . strtoupper(substr(auth()->user()->name, 0, 1)) . '</text></svg>' }}"
                        alt="Avatar người dùng"
                    >

                    <div>
                        <span class="label">Người dùng đã đăng nhập</span>
                        <div class="value" style="font-size: 28px;">{{ auth()->user()->name }}</div>
                        <div style="color: var(--muted); margin-top: 6px;">{{ auth()->user()->email ?: 'Nhà cung cấp không trả về email' }}</div>
                    </div>
                </div>

                <div class="meta-list">
                    <div class="meta-item">
                        <span class="label">Email</span>
                        <div class="value">{{ auth()->user()->email ?: 'Không có email' }}</div>
                    </div>
                    <div class="meta-item">
                        <span class="label">Mã sinh viên lưu trong database</span>
                        <div class="value">{{ auth()->user()->student_id ?: 'Chưa có' }}</div>
                    </div>
                    <div class="meta-item">
                        <span class="label">Google ID</span>
                        <div class="value">{{ auth()->user()->google_id ?: 'Chưa liên kết' }}</div>
                    </div>
                    <div class="meta-item">
                        <span class="label">Facebook ID</span>
                        <div class="value">{{ auth()->user()->facebook_id ?: 'Chưa liên kết' }}</div>
                    </div>
                </div>
            </section>

            <aside class="panel">
                <div class="meta-list" style="margin-top: 0;">
                    <div class="meta-item">
                        <span class="label">Họ tên sinh viên</span>
                        <div class="value">{{ config('student.name') }}</div>
                    </div>
                    <div class="meta-item">
                        <span class="label">Mã sinh viên</span>
                        <div class="value">{{ config('student.id') }}</div>
                    </div>
                    <div class="meta-item">
                        <span class="label">Lớp</span>
                        <div class="value">{{ config('student.class') }}</div>
                    </div>
                    <div class="meta-item">
                        <span class="label">Avatar</span>
                        <div class="value">{{ auth()->user()->avatar ?: 'Không có avatar từ nhà cung cấp' }}</div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</body>
</html>
