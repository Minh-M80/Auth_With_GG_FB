
# Họ tên: Nguyễn Đức Minh
# Mã sinh viên: 23810310259
# Lớp: D18CNPM4


# Auth With Google & Facebook

Ứng dụng Laravel tích hợp đăng nhập OAuth 2.0 bằng Google và Facebook với `Laravel Socialite`.

## Chức năng đã có

- Đăng nhập bằng Google
- Đăng nhập bằng Facebook
- Nếu tài khoản đã tồn tại theo email thì đăng nhập luôn
- Nếu chưa tồn tại thì tự tạo mới tài khoản và đăng nhập
- Lưu thông tin cơ bản vào database: `name`, `email`, `avatar`, `google_id`, `facebook_id`, `student_id`
- Hiển thị thông tin người dùng sau đăng nhập
- Hiển thị thông tin cá nhân sinh viên trên giao diện
- Đăng xuất
- Xử lý lỗi khi người dùng từ chối quyền hoặc cấu hình OAuth chưa đúng

## Công nghệ sử dụng

- Laravel 12
- Laravel Socialite
- MySQL
- Blade Template

## Cấu hình môi trường

File `.env` đã được tạo sẵn và `.gitignore` đã chặn không cho đẩy file này lên Git.

Thông số MySQL hiện tại:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3309
DB_DATABASE=auth_with_gg_fb
DB_USERNAME=root
DB_PASSWORD=
```

Bạn cần điền thêm các khóa OAuth:

```env
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"

FACEBOOK_CLIENT_ID=
FACEBOOK_CLIENT_SECRET=
FACEBOOK_REDIRECT_URI="${APP_URL}/auth/facebook/callback"
```

## Cách cài đặt và chạy dự án

1. Tạo database MySQL tên `auth_with_gg_fb`
2. Mở terminal tại thư mục project:

```bash
cd C:\xampp\htdocs\Auth_With_GG_FB
```

3. Cài package nếu cần:

```bash
composer install
```

4. Tạo khóa ứng dụng:

```bash
php artisan key:generate
```

5. Chạy migration:

```bash
php artisan migrate
```

6. Khởi động server:

```bash
php artisan serve
```

7. Mở trình duyệt:

```text
http://127.0.0.1:8000
```

## Cấu hình Google OAuth

1. Truy cập Google Cloud Console
2. Tạo project mới hoặc chọn project sẵn có
3. Bật Google Identity hoặc OAuth consent screen
4. Tạo `OAuth Client ID`
5. Chọn loại ứng dụng `Web application`
6. Thêm callback URL:

```text
http://127.0.0.1:8000/auth/google/callback
```

7. Copy `Client ID` và `Client Secret` vào file `.env`

## Cấu hình Facebook OAuth

1. Truy cập Meta for Developers
2. Tạo app mới
3. Thêm sản phẩm `Facebook Login`
4. Chọn nền tảng `Web`
5. Cấu hình callback URL:

```text
http://127.0.0.1:8000/auth/facebook/callback
```

6. Copy `App ID` và `App Secret` vào file `.env`

## Trường hợp Facebook cần HTTPS hoặc domain public

Trong nhiều trường hợp Facebook không chấp nhận callback local `http://127.0.0.1:8000`, khi đó bạn dùng `ngrok`.

### Cài và chạy ngrok

1. Tải và cài `ngrok`
2. Chạy Laravel:

```bash
php artisan serve
```

3. Mở terminal khác và chạy:

```bash
ngrok http 8000
```

4. Ngrok sẽ cung cấp URL dạng:

```text
https://abc123.ngrok-free.app
```

5. Cập nhật trong `.env`:

```env
APP_URL=https://abc123.ngrok-free.app
FACEBOOK_REDIRECT_URI="${APP_URL}/auth/facebook/callback"
GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"
```

6. Cập nhật lại callback URL trong Google Console và Facebook Developer:

```text
https://abc123.ngrok-free.app/auth/google/callback
https://abc123.ngrok-free.app/auth/facebook/callback
```

7. Sau khi sửa `.env`, chạy:

```bash
php artisan config:clear
```

## Cấu trúc chính

- `app/Http/Controllers/Auth/SocialAuthController.php`: điều hướng và callback OAuth
- `app/Services/SocialAuthService.php`: xử lý tạo mới hoặc đăng nhập user
- `app/Http/Controllers/DashboardController.php`: hiển thị thông tin sau đăng nhập
- `config/services.php`: cấu hình Google/Facebook OAuth
- `config/student.php`: thông tin cá nhân sinh viên
- `resources/views/welcome.blade.php`: giao diện đăng nhập
- `resources/views/dashboard.blade.php`: giao diện sau đăng nhập


