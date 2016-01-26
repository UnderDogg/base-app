<?php

namespace App\Http\Controllers\Inquiry;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inquiry\InquiryRequest;
use App\Processors\Inquiry\InquiryProcessor;

class InquiryController extends Controller
{
    /**
     * @var InquiryProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param InquiryProcessor $processor
     */
    public function __construct(InquiryProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays all of the users open inquiries.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return $this->processor->index();
    }

    /**
     * Displays all of the users closed inquiries.
     *
     * @return \Illuminate\View\View
     */
    public function closed()
    {
        return $this->processor->closed();
    }

    /**
     * Displays the form for creating an inquiry.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return $this->processor->create();
    }

    /**
     * Creates a new inquiry.
     *
     * @param InquiryRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(InquiryRequest $request)
    {
        if ($this->processor->store($request)) {
            flash()->success('Success!', 'Successfully created request.');

            return redirect()->route('inquiries.index');
        } else {
            flash()->error('Error!', 'There was an issue creating a request. Please try again.');

            return redirect()->route('inquiries.create');
        }
    }

    /**
     * Displays the specified inquiry.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        return $this->processor->show($id);
    }

    /**
     * Displays the form for editing the specified inquiry.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        return $this->processor->edit($id);
    }

    /**
     * Updates the specified inquiry.
     *
     * @param InquiryRequest $request
     * @param int|string     $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(InquiryRequest $request, $id)
    {
        if ($this->processor->update($request, $id)) {
            flash()->success('Success!', 'Successfully updated request.');

            return redirect()->route('inquiries.show', [$id]);
        } else {
            flash()->error('Error!', 'There was an issue updating this request. Please try again.');

            return redirect()->route('inquiries.edit', [$id]);
        }
    }

    /**
     * Delete's the specified inquiry.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if ($this->processor->destroy($id)) {
            flash()->success('Success!', 'Successfully deleted request.');

            return redirect()->route('inquiries.index');
        } else {
            flash()->error('Error!', 'There was an issue deleting this request. Please try again.');

            return redirect()->route('inquiries.show', [$id]);
        }
    }
}