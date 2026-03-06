<?php

namespace App\Application\User\Commands\ResetPassword;

use Illuminate\Support\Facades\Password;

class ResetPasswordHandler
{
    public function handle(ResetPasswordCommand $command): bool
    {
        $status = Password::broker()->reset(
            [
                'email'    => $command->email,
                'token'    => $command->token,
                'password' => $command->password,
            ],
            function ($user, string $password) {
                $user->password = $password;
                $user->save();
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw new \DomainException(__($status));
        }

        return true;
    }
}
