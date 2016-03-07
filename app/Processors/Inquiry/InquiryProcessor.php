<?php

namespace App\Processors\Inquiry;

use App\Http\Presenters\Inquiry\InquiryPresenter;
use App\Http\Requests\Inquiry\InquiryRequest;
use App\Jobs\Inquiry\Approve;
use App\Jobs\Inquiry\Close;
use App\Jobs\Inquiry\Open;
use App\Jobs\Inquiry\Store;
use App\Jobs\Inquiry\Update;
use App\Models\Category;
use App\Models\Inquiry;
use App\Policies\InquiryPolicy;
use App\Processors\Processor;

class InquiryProcessor extends Processor
{
    /**
     * @var Inquiry
     */
    protected $inquiry;

    /**
     * @var Category
     */
    protected $category;

    /**
     * @var InquiryPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Inquiry          $inquiry
     * @param Category         $category
     * @param InquiryPresenter $presenter
     */
    public function __construct(Inquiry $inquiry, Category $category, InquiryPresenter $presenter)
    {
        $this->inquiry = $inquiry;
        $this->category = $category;
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
     * Displays the users approved requests.
     *
     * @return \Illuminate\View\View
     */
    public function approved()
    {
        $inquiries = $this->presenter->tableApproved($this->inquiry);

        $navbar = $this->presenter->navbar();

        return view('pages.inquiries.index', compact('inquiries', 'navbar'));
    }

    /**
     * Displays the inquiry category selection table.
     *
     * @param null|int|string $categoryId
     *
     * @return \Illuminate\View\View
     */
    public function start($categoryId = null)
    {
        if (is_null($categoryId)) {
            $category = $this->category;
        } else {
            $category = $this->category->findOrFail($categoryId);
        }

        $categories = $this->presenter->tableCategories($this->inquiry, $category);

        return view('pages.inquiries.start', compact('categories'));
    }

    /**
     * Displays the form for creating a new request.
     *
     * @param int|string $categoryId
     *
     * @return \Illuminate\View\View
     */
    public function create($categoryId)
    {
        $category = $this->category
            ->whereBelongsTo($this->inquiry->getTable())
            ->findOrFail($categoryId);

        $form = $this->presenter->form($this->inquiry, $category);

        return view('pages.inquiries.create', compact('form', 'category'));
    }

    /**
     * Creates a new inquiry.
     *
     * @param int|string     $categoryId
     * @param InquiryRequest $request
     *
     * @return bool
     */
    public function store($categoryId, InquiryRequest $request)
    {
        $category = $this->category
            ->whereBelongsTo($this->inquiry->getTable())
            ->findOrFail($categoryId);

        $inquiry = $this->inquiry->newInstance();

        return $this->dispatch(new Store($request, $inquiry, $category));
    }

    /**
     * Displays the specified inquiry.
     *
     * @param int|string $id
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $inquiry = $this->inquiry->with(['category'])->findOrFail($id);

        if (InquiryPolicy::show(auth()->user(), $inquiry)) {
            $formComment = $this->presenter->formComment($inquiry);

            return view('pages.inquiries.show', compact('inquiry', 'formComment'));
        }

        $this->unauthorized();
    }

    /**
     * Displays the form for editing the specified inquiry.
     *
     * @param int|string $id
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $inquiry = $this->inquiry->findOrFail($id);

        if (InquiryPolicy::edit(auth()->user(), $inquiry)) {
            $form = $this->presenter->form($inquiry, $inquiry->category);

            return view('pages.inquiries.edit', compact('form'));
        }

        $this->unauthorized();
    }

    /**
     * Updates the specified inquiry.
     *
     * @param InquiryRequest $request
     * @param int|string     $id
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return bool
     */
    public function update(InquiryRequest $request, $id)
    {
        $inquiry = $this->inquiry->findOrFail($id);

        if (InquiryPolicy::edit(auth()->user(), $inquiry)) {
            return $this->dispatch(new Update($request, $inquiry));
        }

        $this->unauthorized();
    }

    /**
     * Deletes the specified inquiry.
     *
     * @param int|string $id
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return bool
     */
    public function destroy($id)
    {
        $inquiry = $this->inquiry->findOrFail($id);

        if (InquiryPolicy::destroy(auth()->user(), $inquiry)) {
            return $inquiry->delete();
        }

        $this->unauthorized();
    }

    /**
     * Closes the current inquiry.
     *
     * @param int|string $id
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return bool
     */
    public function close($id)
    {
        $inquiry = $this->inquiry->findOrFail($id);

        if (InquiryPolicy::close(auth()->user(), $inquiry)) {
            return $this->dispatch(new Close($inquiry));
        }

        $this->unauthorized();
    }

    /**
     * Opens the specified inquiry.
     *
     * @param int|string $id
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return bool
     */
    public function open($id)
    {
        $inquiry = $this->inquiry->findOrFail($id);

        if (InquiryPolicy::open(auth()->user())) {
            return $this->dispatch(new Open($inquiry));
        }

        $this->unauthorized();
    }

    /**
     * Approves the specified inquiry.
     *
     * @param int|string $id
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return bool
     */
    public function approve($id)
    {
        $inquiry = $this->inquiry->findOrFail($id);

        if (InquiryPolicy::approve(auth()->user())) {
            return $this->dispatch(new Approve($inquiry));
        }

        $this->unauthorized();
    }

    /**
     * Approves the inquiry by it's UUID.
     *
     * @param string $uuid
     *
     * @return bool
     */
    public function approveUuid($uuid)
    {
        $inquiry = $this->inquiry->whereUuid($uuid)->firstOrFail();

        return $this->dispatch(new Approve($inquiry));
    }
}
