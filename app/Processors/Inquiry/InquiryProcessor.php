<?php

namespace App\Processors\Inquiry;

use App\Http\Presenters\Inquiry\InquiryPresenter;
use App\Http\Requests\Inquiry\InquiryRequest;
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

    public function store(InquiryRequest $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update($id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
