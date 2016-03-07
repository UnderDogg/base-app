<?php

namespace App\Jobs\Inquiry;

use App\Http\Requests\Inquiry\InquiryRequest;
use App\Jobs\Job;
use App\Jobs\Mail\Notification;
use App\Models\Category;
use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Mail\Message;

class Store extends Job
{
    /**
     * @var InquiryRequest
     */
    protected $request;

    /**
     * @var Inquiry
     */
    protected $inquiry;

    /**
     * @var Category
     */
    protected $category;

    /**
     * Constructor.
     *
     * @param InquiryRequest $request
     * @param Inquiry        $inquiry
     * @param Category       $category
     */
    public function __construct(InquiryRequest $request, Inquiry $inquiry, Category $category)
    {
        $this->request = $request;
        $this->inquiry = $inquiry;
        $this->category = $category;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        // Set the inquiry model data.
        $this->inquiry->user_id = auth()->id();
        $this->inquiry->uuid = uuid();
        $this->inquiry->category_id = $this->category->getKey();
        $this->inquiry->title = $this->request->input('title');
        $this->inquiry->description = $this->request->input('description');

        if ($this->category->manager === true) {
            // If the category requires manager approval, we'll retrieve the manager record.
            $manager = User::whereHas('roles', function (Builder $query) {
                $query->whereName('managers');
            })->findOrFail($this->request->input('manager'));

            $this->inquiry->manager_id = $manager->getKey();

            // We'll send the manager a notification.
            $notification = new Notification(
                $manager,
                'emails.inquiries.created',
                ['inquiry' => $this->inquiry],
                function (Message $message) use ($manager) {
                    $message->subject('A New Request Requires Your Approval');

                    $message->to($manager->email);
                }
            );
        }

        if ($this->inquiry->save()) {
            if (isset($notification)) {
                $this->dispatch($notification);
            }

            return true;
        }

        return false;
    }
}
