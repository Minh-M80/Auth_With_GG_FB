<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\SocialAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SocialAuthController extends Controller
{
    public function __construct(private readonly SocialAuthService $socialAuthService)
    {
    }

    public function redirect(string $provider): RedirectResponse
    {
        $this->abortIfProviderInvalid($provider);

        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function callback(Request $request, string $provider): RedirectResponse
    {
        $this->abortIfProviderInvalid($provider);

        if ($request->filled('error')) {
            return redirect()
                ->route('login')
                ->with('error', 'Đăng nhập ' . ucfirst($provider) . ' đã bị hủy hoặc bị từ chối quyền truy cập.');
        }

        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();
            $user = $this->socialAuthService->loginOrCreateUser($provider, $socialUser);

            return redirect()
                ->route('dashboard')
                ->with('success', 'Đăng nhập bằng ' . ucfirst($provider) . ' thành công. Xin chào ' . $user->name . '!');
        } catch (\Throwable $exception) {
            report($exception);

            return redirect()
                ->route('login')
                ->with('error', 'Không thể đăng nhập bằng ' . ucfirst($provider) . '. Vui lòng kiểm tra lại cấu hình OAuth hoặc thử lại.');
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Bạn đã đăng xuất thành công.');
    }

    private function abortIfProviderInvalid(string $provider): void
    {
        if (! $this->socialAuthService->isSupportedProvider($provider)) {
            throw new NotFoundHttpException();
        }
    }
}
