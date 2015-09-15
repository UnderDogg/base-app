<?php

namespace App\Http\Controllers;

use App\Http\Requests\IssueRequest;
use App\Processors\IssueProcessor;

class IssueController extends Controller
{
    /**
     * @var IssueProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param IssueProcessor $processor
     */
    public function __construct(IssueProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays all issues.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return $this->processor->index();
    }

    /**
     * Displays all closed issues.
     *
     * @return \Illuminate\View\View
     */
    public function closed()
    {
        return $this->processor->closed();
    }

    /**
     * Displays the form for creating an issue.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return $this->processor->create();
    }

    /**
     * Processes creating an issue.
     *
     * @param IssueRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(IssueRequest $request)
    {
        if($this->processor->store($request)) {
            flash()->success('Success!', 'Successfully created issue.');

            return redirect()->route('issues.index');
        } else {
            flash()->error('Error!', 'There was a problem creating an issue. Please try again.');

            return redirect()->route('issues.create');
        }
    }

    /**
     * Displays the issue.
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Closes an issue.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function close($id)
    {
        if($this->processor->close($id)) {
            flash()->success('Success!', 'Successfully closed issue.');

            return redirect()->back();
        } else {
            flash()->error('Error!', 'There was a problem closing this issue. Please try again.');

            return redirect()->back();
        }
    }

    /**
     * Re-Opens an issue.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function open($id)
    {
        if($this->processor->open($id)) {
            flash()->success('Success!', 'Successfully re-opened issue.');

            return redirect()->back();
        } else {
            flash()->error('Error!', 'There was a problem re-opening this issue. Please try again.');

            return redirect()->back();
        }
    }
}
