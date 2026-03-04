<?php

namespace App\Application\Shared\Auth;

use App\Domain\User\ValueObjects\UserId;

interface AuthServiceInterface
{
    /** 指定ユーザーのトークンを発行し、プレーンテキストのトークン文字列を返す */
    public function createToken(UserId $userId, string $name = 'auth_token'): string;

    /** 現在認証中のトークンを無効化する */
    public function revokeCurrentToken(): void;
}
