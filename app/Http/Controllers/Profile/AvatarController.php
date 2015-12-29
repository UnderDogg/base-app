<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\AvatarRequest;
use App\Processors\Profile\AvatarProcessor;

class AvatarController extends Controller
{
    /**
     * @var AvatarProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param AvatarProcessor $processor
     */
    public function __construct(AvatarProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Processes changing.
     *
     * @return \Illuminate\View\View
     */
    public function change()
    {
        return $this->processor->change();
    }

    /**
     * Processes updating the current users avatar.
     *
     * @param AvatarRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AvatarRequest $request)
    {
        if ($this->processor->update($request)) {
            flash()->success('Success!', 'Successfully updated avatar!');

            return redirect()->route('profile.avatar');
        } else {
            flash()->error('Error!', 'There was an issue updating your avatar. Please try again.');

            return redirect()->route('profile.avatar');
        }
    }

    /**
     * Returns a download response of the current users avatar.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download()
    {
        return $this->processor->download();
    }
}
