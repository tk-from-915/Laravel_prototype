<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\User\ValueObjects\Email;
use App\Domain\User\ValueObjects\UserId;
use App\Domain\User\ValueObjects\UserName;
use App\Domain\User\ValueObjects\UserRole;
use App\Infrastructure\Persistence\Eloquent\UserModel;
use Illuminate\Support\Facades\Hash;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function findById(UserId $id): ?User
    {
        $model = UserModel::find($id->value());

        return $model ? $this->toEntity($model) : null;
    }

    public function findByEmail(Email $email): ?User
    {
        $model = UserModel::where('email', $email->value())->first();

        return $model ? $this->toEntity($model) : null;
    }

    public function verifyCredentials(Email $email, string $plainPassword): ?User
    {
        $model = UserModel::where('email', $email->value())->first();

        if (!$model || !Hash::check($plainPassword, $model->password)) {
            return null;
        }

        return $this->toEntity($model);
    }

    public function create(
        UserName $name,
        Email $email,
        string $plainPassword,
        UserRole $role,
    ): User {
        $model = UserModel::create([
            'name'     => $name->value(),
            'email'    => $email->value(),
            'password' => $plainPassword,   // 'hashed' cast が自動でハッシュ化
            'role'     => $role->value,
        ]);

        return $this->toEntity($model);
    }

    public function update(User $user): void
    {
        UserModel::where('id', $user->id()->value())->update([
            'name'  => $user->name()->value(),
            'email' => $user->email()->value(),
            'role'  => $user->role()->value,
        ]);
    }

    public function delete(UserId $id): void
    {
        UserModel::destroy($id->value());
    }

    public function findAll(int $page, int $perPage): array
    {
        return UserModel::paginate($perPage, page: $page)
            ->map(fn ($model) => $this->toEntity($model))
            ->all();
    }

    public function countAll(): int
    {
        return UserModel::count();
    }

    private function toEntity(UserModel $model): User
    {
        return User::reconstitute(
            id: new UserId($model->id),
            name: new UserName($model->name),
            email: new Email($model->email),
            role: $model->role instanceof UserRole ? $model->role : UserRole::from($model->role),
            createdAt: new \DateTimeImmutable($model->created_at->toDateTimeString()),
            updatedAt: $model->updated_at
                ? new \DateTimeImmutable($model->updated_at->toDateTimeString())
                : null,
        );
    }
}
