<?php

namespace App\Listeners\Issue;

use App\Events\Issue\Created;
use Illuminate\Mail\Mailer;

class EmailAdministratorsAboutNewTicket
{
    /**
     * @var Mailer
     */
    protected $mailer;

    /**
     * Constructor.
     *
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param Created $event
     *
     * @return void
     */
    public function handle(Created $event)
    {
        $this->mailer->send('emails.issues.new', compact('event'), function ($m) {
            $m->to(env('MAIL_USERNAME'));

            $m->subject('Testing');
        });
    }
}
