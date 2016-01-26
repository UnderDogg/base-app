<?php

namespace App\Http\Controllers\Inquiry;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryMoveRequest;
use App\Http\Requests\Category\CategoryRequest;
use App\Processors\Inquiry\InquiryCategoryProcessor;
use Baum\MoveNotPossibleException;

class InquiryCategoryController extends Controller
{
    /**
     * @var InquiryCategoryProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param InquiryCategoryProcessor $processor
     */
    public function __construct(InquiryCategoryProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays all inquiry categories.
     *
     * @param int|string|null $id
     *
     * @return \Illuminate\View\View
     */
    public function index($id = null)
    {
        return $this->processor->index($id);
    }

    /**
     * Displays the form for creating a category.
     *
     * @param int|string|null $id
     *
     * @return \Illuminate\View\View
     */
    public function create($id = null)
    {
        return $this->processor->create($id);
    }

    /**
     * Creates a new inquiry category.
     *
     * @param CategoryRequest $request
     * @param int|string|null $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request, $id = null)
    {
        if ($this->processor->store($request, $id)) {
            flash()->success('Success!', 'Successfully created category.');

            return redirect()->route('inquiries.categories.index');
        } else {
            flash()->error('Error!', 'There was an issue creating a category. Please try again.');

            return redirect()->route('inquiries.categories.index');
        }
    }

    public function edit($id)
    {
        return $this->processor->edit($id);
    }

    public function update(CategoryRequest $request, $id)
    {
        if ($this->processor->update($request, $id)) {
            flash()->success('Success!', 'Successfully updated category.');

            return redirect()->route('inquiries.categories.index', [$id]);
        } else {
            flash()->error('Error!', 'There was an issue updating this category. Please try again.');

            return redirect()->route('inquiries.categories.edit', [$id]);
        }
    }

    public function move(CategoryMoveRequest $request, $id)
    {
        try {
            $this->processor->move($request, $id);

            $moved = true;
        } catch (MoveNotPossibleException $e) {
            flash()->error('Error!', 'There was an issue moving this category. Please try again.');

            $moved = false;
        }

        return compact('moved');
    }

    /**
     * Deletes the specified category.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if ($this->processor->destroy($id)) {
            flash()->success('Success!', 'Successfully deleted category.');

            return redirect()->route('inquiries.categories.index');
        } else {
            flash()->error('Error!', 'There was an issue deleting this category. Please try again.');

            return redirect()->route('inquiries.categories.index');
        }
    }
}
