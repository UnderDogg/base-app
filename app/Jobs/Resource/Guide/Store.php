<?php

namespace App\Jobs\Resource\Guide;

use App\Http\Requests\Resource\GuideRequest;
use App\Jobs\Job;
use App\Models\Guide;
use Illuminate\Support\Str;

class Store extends Job
{
    /**
     * @var GuideRequest
     */
    protected $request;

    /**
     * @var Guide
     */
    protected $guide;

    /**
     * Constructor.
     *
     * @param GuideRequest $request
     * @param Guide        $guide
     */
    public function __construct(GuideRequest $request, Guide $guide)
    {
        $this->request = $request;
        $this->guide = $guide;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        $this->guide->slug = Str::slug($this->request->input('title'));
        $this->guide->title = $this->request->input('title');
        $this->guide->description = $this->request->input('description');

        $published = $this->request->has('publish');

        if ($published) {
            $this->guide->published = true;
            $this->guide->published_on = $this->guide->freshTimestampString();
        }

        return $this->guide->save();
    }
}
