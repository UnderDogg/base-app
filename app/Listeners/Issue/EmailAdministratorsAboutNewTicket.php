<?php

namespace App\Listeners\Issue;

use App\Events\Issue\Created;
use App\Models\Role;
use App\Models\User;
use Illuminate\Mail\Mailer;

class EmailAdministratorsAboutNewTicket
{
    /**
     * @var Mailer
     */
    protected $mailer;

    /**
     * @var User
     */
    protected $user;

    /**
     * Constructor.
     *
     * @param Mailer $mailer
     * @param User   $user
     */
    public function __construct(Mailer $mailer, User $user)
    {
        $this->mailer = $mailer;
        $this->user = $user;
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
        $users = $this->user->whereHas('roles', function ($query) {
             $query->where(['name' => Role::getAdministratorName()]);
        })->get();

        foreach ($users as $user) {
            $this->mailer->send('emails.issues.new', compact('event'), function ($m) use ($event, $user) {
                $m->to($user->email);

                $m->subject("New Ticket: {$event->issue->title}");
            });
        }
    }
}
