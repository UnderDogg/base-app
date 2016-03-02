<?php

namespace App\Jobs\Mail;

use App\Jobs\Job;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Mail\Mailer;

class Notification extends Job
{
    /**
     * @var User
     */
    protected $user;

    /**
     * The view to use for the mail message.
     *
     * @var string
     */
    protected $view;

    /**
     * The mail data array.
     *
     * @var array
     */
    protected $data;

    /**
     * The mail message closure.
     *
     * @var Closure
     */
    protected $message;

    /**
     * Constructor.
     *
     * @param User    $user
     * @param string  $view
     * @param array   $data
     * @param Closure $message
     */
    public function __construct(User $user, $view, $data, Closure $message)
    {
        $this->user = $user;
        $this->view = $view;
        $this->data = $data;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @param Mailer $mailer
     *
     * @return bool
     */
    public function handle(Mailer $mailer)
    {
        $this->data['user'] = $this->user;

        try {
            $mailer->send($this->view, $this->data, $this->message);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
