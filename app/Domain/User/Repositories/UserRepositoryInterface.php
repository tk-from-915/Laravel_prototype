<?php

namespace App\Domain\User\Repositories;

use App\Domain\User\Entities\User;
use App\Domain\User\ValueObjects\Email;
use App\Domain\User\ValueObjects\UserId;
use App\Domain\User\ValueObjects\UserName;
use App\Domain\User\ValueObjects\UserRole;

interface UserRepositoryInterface
{
    public function findById(UserId $id): ?User;

    public function findByEmail(Email $email): ?User;

    /**
     * メールアドレスとパスワードを検証し、一致すればエンティティを返す。
     * 認証失敗時は null を返す。
     */
    public function verifyCredentials(Email $email, string $plainPassword): ?User;

    /**
     * 新規ユーザーを DB に挿入し、ID が付与されたエンティティを返す。
     */
    public function create(
        UserName $name,
        Email $email,
        string $plainPassword,
        UserRole $role,
    ): User;

    /** 既存ユーザーの変更を DB に反映する */
    public function update(User $user): void;

    public function delete(UserId $id): void;

    /** @return User[] */
    public function findAll(int $page, int $perPage): array;

    public function countAll(): int;
}
