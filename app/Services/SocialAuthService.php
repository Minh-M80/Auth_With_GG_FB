<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as SocialUser;

class SocialAuthService
{
    public function loginOrCreateUser(string $provider, SocialUser $socialUser): User
    {
        $providerColumn = $this->providerColumn($provider);
        $email = $socialUser->getEmail();

        $user = User::query()
            ->when($email, fn ($query) => $query->orWhere('email', $email))
            ->orWhere($providerColumn, $socialUser->getId())
            ->first();

        $payload = [
            'name' => $socialUser->getName() ?: $socialUser->getNickname() ?: 'OAuth User',
            'avatar' => $socialUser->getAvatar(),
            $providerColumn => $socialUser->getId(),
        ];

        if ($email) {
            $payload['email'] = $email;
            $payload['email_verified_at'] = now();
        }

        if (! $user) {
            $payload['student_id'] = config('student.id');
            $payload['password'] = Str::password(32);

            $user = User::create($payload);
        } else {
            $safePayload = Arr::where($payload, fn ($value) => filled($value));
            $user->fill($safePayload);

            if (blank($user->student_id)) {
                $user->student_id = config('student.id');
            }

            $user->save();
        }

        Auth::login($user, true);

        return $user;
    }

    public function isSupportedProvider(string $provider): bool
    {
        return in_array($provider, ['google', 'facebook'], true);
    }

    private function providerColumn(string $provider): string
    {
        return match ($provider) {
            'google' => 'google_id',
            'facebook' => 'facebook_id',
            default => throw new \InvalidArgumentException('Unsupported provider.'),
        };
    }
}
