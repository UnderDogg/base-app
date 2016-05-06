<?php

namespace App\Http\Controllers\Inquiry;

use App\Exceptions\Inquiry\AlreadyApprovedException;
use App\Http\Controllers\Controller;
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

class InquiryController extends Controller
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
     * Displays all of the users open inquiries.
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
     * Displays all of the users closed inquiries.
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
     * Displays all of the users approved inquiries.
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
     * Displays category selection for a new request.
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
     * Displays the form for creating an inquiry.
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

     * @param int|string     $categoryId
     * @param InquiryRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($categoryId, InquiryRequest $request)
    {
        $category = $this->category
            ->whereBelongsTo($this->inquiry->getTable())
            ->findOrFail($categoryId);

        $inquiry = $this->inquiry->newInstance();

        if ($this->dispatch(new Store($request, $inquiry, $category))) {
            flash()->success('Success!', 'Successfully created request.');

            return redirect()->route('inquiries.index');
        }

        flash()->error('Error!', 'There was an issue creating a request. Please try again.');

        return redirect()->route('inquiries.create');
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
        $inquiry = $this->inquiry->with(['category'])->findOrFail($id);

        $this->authorize('inquiries.show', [$inquiry]);

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

        $this->authorize('inquiries.edit', [$inquiry]);

        $form = $this->presenter->form($inquiry, $inquiry->category);

        return view('pages.inquiries.edit', compact('form'));
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
        $inquiry = $this->inquiry->findOrFail($id);

        $this->authorize('inquiries.edit', [$inquiry]);

        if ($this->dispatch(new Update($request, $inquiry))) {
            flash()->success('Success!', 'Successfully updated request.');

            return redirect()->route('inquiries.show', [$id]);
        }

        flash()->error('Error!', 'There was an issue updating this request. Please try again.');

        return redirect()->route('inquiries.edit', [$id]);
    }

    /**
     * Closes the specified inquiry.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function close($id)
    {
        $inquiry = $this->inquiry->findOrFail($id);

        $this->authorize('inquiries.close', [$inquiry]);

        if ($this->dispatch(new Close($inquiry))) {
            flash()->success('Success!', 'Successfully closed request.');

            return redirect()->route('inquiries.show', [$id]);
        }

        flash()->error('Error!', 'There was an issue closing this request. Please try again.');

        return redirect()->route('inquiries.show', [$id]);
    }

    /**
     * Opens the specified inquiry.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function open($id)
    {
        $inquiry = $this->inquiry->findOrFail($id);

        $this->authorize('inquiries.open', [$inquiry]);

        if ($this->dispatch(new Open($inquiry))) {
            flash()->success('Success!', 'Successfully re-opened request.');

            return redirect()->route('inquiries.show', [$id]);
        }

        flash()->success('Success!', 'There was an issue re-opening this request. Please try again.');

        return redirect()->route('inquiries.show', [$id]);
    }

    /**
     * Approves the specified inquiry.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve($id)
    {
        $inquiry = $this->inquiry->findOrFail($id);

        $this->authorize('inquiries.approve', [$inquiry]);

        try {
            if ($this->dispatch(new Approve($inquiry))) {
                flash()->success('Success!', 'Successfully approved request.');

                return redirect()->route('inquiries.show', [$id]);
            }

            flash()->success('Success!', 'There was an issue approving this request. Please try again.');

            return redirect()->route('inquiries.show', [$id]);
        } catch (AlreadyApprovedException $e) {
            flash()->error('Error!', $e->getMessage());

            return redirect()->route('inquiries.show', [$id]);
        }
    }

    /**
     * Approves the specified inquiry via UUID.
     *
     * @param string $uuid
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approveUuid($uuid)
    {
        $inquiry = $this->inquiry->whereUuid($uuid)->firstOrFail();

        try {
            if ($this->dispatch(new Approve($inquiry))) {
                flash()->success('Success!', 'Successfully approved users request.');

                return redirect()->route('inquiries.index');
            }

            flash()->error('Error!', 'There was an issue approving this users request. Please try again.');

            return redirect()->route('inquiries.index');
        } catch (AlreadyApprovedException $e) {
            flash()->setTimer(null)->error('Error!', $e->getMessage());

            return redirect()->route('inquiries.index');
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
        $inquiry = $this->inquiry->findOrFail($id);

        $this->authorize('inquiries.destroy', [$inquiry]);
        
        if ($inquiry->delete()) {
            flash()->success('Success!', 'Successfully deleted request.');

            return redirect()->route('inquiries.index');
        }

        flash()->error('Error!', 'There was an issue deleting this request. Please try again.');

        return redirect()->route('inquiries.show', [$id]);
    }
}
