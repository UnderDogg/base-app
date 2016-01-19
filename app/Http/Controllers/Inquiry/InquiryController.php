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

    public function index()
    {
        return $this->processor->index();
    }

    public function closed()
    {
        return $this->processor->closed();
    }

    public function create()
    {
        return $this->processor->create();
    }

    public function store(InquiryRequest $request)
    {
        if ($this->processor->store($request)) {
        } else {
        }
    }

    public function show($id)
    {
        return $this->processor->show($id);
    }

    public function edit($id)
    {
        return $this->processor->edit($id);
    }

    public function update($id)
    {
        if ($this->processor->update($id)) {
        } else {
        }
    }

    public function destroy($id)
    {
        if ($this->processor->destroy($id)) {
        } else {
        }
    }
}
