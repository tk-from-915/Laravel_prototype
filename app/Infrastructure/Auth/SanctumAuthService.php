<?php

namespace App\Infrastructure\Auth;

use App\Application\Shared\Auth\AuthServiceInterface;
use App\Domain\User\ValueObjects\UserId;
use App\Infrastructure\Persistence\Eloquent\UserModel;

class SanctumAuthService implements AuthServiceInterface
{
    public function createToken(UserId $userId, string $name = 'auth_token'): string
    {
        $model = UserModel::findOrFail($userId->value());

        return $model->createToken($name)->plainTextToken;
    }

    public function revokeCurrentToken(): void
    {
        auth()->user()->currentAccessToken()->delete();
    }
}
