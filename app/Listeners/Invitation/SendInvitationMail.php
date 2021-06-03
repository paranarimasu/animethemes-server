<?php

declare(strict_types=1);

namespace App\Listeners\Invitation;

use App\Events\Invitation\InvitationCreated;
use App\Mail\InvitationEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

/**
 * Class SendInvitationMail.
 */
class SendInvitationMail implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param InvitationCreated $event
     * @return void
     */
    public function handle(InvitationCreated $event)
    {
        $invitation = $event->getInvitation();

        Mail::to($invitation->email)->queue(new InvitationEmail($invitation));
    }
}
