<?php

namespace App\Application\Contact\Commands\ReplyContact;

use App\Domain\Contact\Repositories\ContactRepositoryInterface;
use App\Domain\Contact\ValueObjects\ContactId;
use App\Mail\ContactReplyMail;
use Illuminate\Support\Facades\Mail;

class ReplyContactHandler
{
    public function __construct(
        private readonly ContactRepositoryInterface $contacts,
    ) {}

    public function handle(ReplyContactCommand $command): bool
    {
        $contact = $this->contacts->findById(new ContactId($command->id));

        if (!$contact) {
            throw new \DomainException('お問い合わせが見つかりません。');
        }

        Mail::to($contact->email())->send(
            new ContactReplyMail(
                mailSubject:     $command->subject,
                replyMessage:    $command->message,
                contactorName:   $contact->name(),
                originalMessage: $contact->message(),
            )
        );

        $contact->markAsReplied();
        $this->contacts->update($contact);

        return true;
    }
}
