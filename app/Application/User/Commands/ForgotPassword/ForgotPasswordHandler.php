<?php

namespace App\Application\User\Commands\ForgotPassword;

use App\Infrastructure\Persistence\Eloquent\UserModel;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class ForgotPasswordHandler
{
    public function handle(ForgotPasswordCommand $command): bool
    {
        $user = UserModel::where('email', $command->email)->first();

        // ユーザーが存在しない場合でもセキュリティ上 true を返す
        if (!$user) {
            return true;
        }

        $token = Password::broker()->createToken($user);
        $frontendUrl = config('app.frontend_url', env('FRONTEND_URL', 'http://localhost:3000'));
        $resetUrl = $frontendUrl . '/password-reset/confirm?token=' . $token . '&email=' . urlencode($user->email);

        Mail::to($user->email)->send(new PasswordResetMail($resetUrl));

        return true;
    }
}
