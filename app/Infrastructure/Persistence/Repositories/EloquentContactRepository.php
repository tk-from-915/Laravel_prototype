<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Contact\Entities\Contact;
use App\Domain\Contact\Repositories\ContactRepositoryInterface;
use App\Domain\Contact\ValueObjects\ContactId;
use App\Infrastructure\Persistence\Eloquent\ContactModel;

class EloquentContactRepository implements ContactRepositoryInterface
{
    public function findById(ContactId $id): ?Contact
    {
        $model = ContactModel::find($id->value());
        return $model ? $this->toEntity($model) : null;
    }

    public function create(
        string  $name,
        ?string $tel,
        string  $email,
        string  $type,
        string  $message,
    ): Contact {
        $model = ContactModel::create([
            'name'    => $name,
            'tel'     => $tel,
            'email'   => $email,
            'type'    => $type,
            'message' => $message,
            'status'  => 'unread',
        ]);

        return $this->toEntity($model);
    }

    public function update(Contact $contact): Contact
    {
        $model = ContactModel::findOrFail($contact->id()->value());

        $model->update(['status' => $contact->status()->value]);

        return $this->toEntity($model->fresh());
    }

    public function delete(ContactId $id): void
    {
        ContactModel::findOrFail($id->value())->delete();
    }

    public function findAll(int $page, int $perPage, ?string $status = null): array
    {
        $query = ContactModel::orderByDesc('created_at');

        if ($status !== null) { $query->where('status', $status); }

        return $query->forPage($page, $perPage)->get()
            ->map(fn ($m) => $this->toEntity($m))
            ->all();
    }

    public function countAll(?string $status = null): int
    {
        $query = ContactModel::query();

        if ($status !== null) { $query->where('status', $status); }

        return $query->count();
    }

    private function toEntity(ContactModel $model): Contact
    {
        return Contact::reconstitute(
            id:        $model->id,
            name:      $model->name,
            tel:       $model->tel,
            email:     $model->email,
            type:      $model->type,
            message:   $model->message,
            status:    $model->status->value,
            createdAt: $model->created_at->toDateTimeString(),
            updatedAt: $model->updated_at->toDateTimeString(),
        );
    }
}
