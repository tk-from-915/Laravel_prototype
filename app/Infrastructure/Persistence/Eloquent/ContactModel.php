<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Contact\ValueObjects\ContactStatus;
use Illuminate\Database\Eloquent\Model;

class ContactModel extends Model
{
    protected $table    = 'contacts';
    protected $fillable = ['name', 'tel', 'email', 'type', 'message', 'status'];

    protected $casts = [
        'status' => ContactStatus::class,
    ];
}
