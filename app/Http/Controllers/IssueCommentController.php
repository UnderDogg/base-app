<?php

namespace App\Http\Controllers;

use App\Processors\IssueCommentProcessor;
use App\Http\Requests\IssueCommentRequest;

class IssueCommentController extends Controller
{
    /**
     * @var IssueCommentProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param IssueCommentProcessor $processor
     */
    public function __construct(IssueCommentProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Creates a comment and attaches it to the specified issue.
     *
     * @param IssueCommentRequest $request
     * @param int|string          $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(IssueCommentRequest $request, $id)
    {
        if($this->processor->store($request, $id)) {
            flash()->success('Success!', 'Successfully added comment.');

            return redirect()->back();
        } else {
            flash()->error('Error!', 'There was a problem adding a comment. Please try again.');

            return redirect()->back();
        }
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
}
