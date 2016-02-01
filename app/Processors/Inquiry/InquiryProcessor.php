<?php

namespace App\Processors\Inquiry;

use App\Http\Presenters\Inquiry\InquiryPresenter;
use App\Http\Requests\Inquiry\InquiryRequest;
use App\Jobs\Inquiry\Approve;
use App\Jobs\Inquiry\Close;
use App\Jobs\Inquiry\Open;
use App\Jobs\Inquiry\Store;
use App\Jobs\Inquiry\Update;
use App\Models\Inquiry;
use App\Processors\Processor;

class InquiryProcessor extends Processor
{
    /**
     * @var Inquiry
     */
    protected $inquiry;

    /**
     * @var InquiryPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Inquiry          $inquiry
     * @param InquiryPresenter $presenter
     */
    public function __construct(Inquiry $inquiry, InquiryPresenter $presenter)
    {
        $this->inquiry = $inquiry;
        $this->presenter = $presenter;
    }

    /**
     * Displays the users open inquiries.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $inquiries = $this->presenter->tableOpen($this->inquiry);

        $navbar = $this->presenter->navbar();

        return view('pages.inquiries.index', compact('inquiries', 'navbar'));
    }

    /**
     * Displays the users closed requests.
     *
     * @return \Illuminate\View\View
     */
    public function closed()
    {
        $inquiries = $this->presenter->tableClosed($this->inquiry);

        $navbar = $this->presenter->navbar();

        return view('pages.inquiries.index', compact('inquiries', 'navbar'));
    }

    /**
     * Displays the form for creating a new request.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $form = $this->presenter->form($this->inquiry);

        return view('pages.inquiries.create', compact('form'));
    }

    /**
     * Creates a new inquiry.
     *
     * @param InquiryRequest $request
     *
     * @return bool
     */
    public function store(InquiryRequest $request)
    {
        $inquiry = $this->inquiry->newInstance();

        return $this->dispatch(new Store($request, $inquiry));
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
        $inquiry = $this->inquiry->findOrFail($id);
        
        $formComment = $this->presenter->formComment($inquiry);

        return view('pages.inquiries.show', compact('inquiry', 'formComment'));
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
        $inquiry = $this->inquiry->findOrFail($id);

        $form = $this->presenter->form($inquiry);

        return view('pages.inquiries.edit', compact('form'));
    }

    /**
     * Updates the specified inquiry.
     *
     * @param InquiryRequest $request
     * @param int|string     $id
     *
     * @return bool
     */
    public function update(InquiryRequest $request, $id)
    {
        $inquiry = $this->inquiry->findOrFail($id);

        return $this->dispatch(new Update($request, $inquiry));
    }

    /**
     * Deletes the specified inquiry.
     *
     * @param int|string $id
     *
     * @return bool
     */
    public function destroy($id)
    {
        $inquiry = $this->inquiry->findOrFail($id);

        return $inquiry->delete();
    }

    /**
     * Closes the current inquiry.
     *
     * @param int|string $id
     *
     * @return bool
     */
    public function close($id)
    {
        $inquiry = $this->inquiry->findOrFail($id);

        $this->authorize($inquiry);

        return $this->dispatch(new Close($inquiry));
    }

    /**
     * Opens the specified inquiry.
     *
     * @param int|string $id
     *
     * @return bool
     */
    public function open($id)
    {
        $inquiry = $this->inquiry->findOrFail($id);

        $this->authorize($inquiry);

        return $this->dispatch(new Open($inquiry));
    }

    /**
     * Approves the specified inquiry.
     *
     * @param int|string $id
     *
     * @return bool
     */
    public function approve($id)
    {
        $inquiry = $this->inquiry->findOrFail($id);

        $this->authorize($inquiry);

        return $this->dispatch(new Approve($inquiry));
    }
}
