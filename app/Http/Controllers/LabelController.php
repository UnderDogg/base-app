<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabelRequest;
use App\Processors\LabelProcessor;

class LabelController extends Controller
{
    /**
     * @var LabelProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param LabelProcessor $processor
     */
    public function __construct(LabelProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays all labels.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return $this->processor->index();
    }

    /**
     * Displays the form for creating a new label.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return $this->processor->create();
    }

    /**
     * Creates a new label.
     *
     * @param LabelRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LabelRequest $request)
    {
        if ($this->processor->store($request)) {
            flash()->success('Success!', 'Successfully created label.');

            return redirect()->route('labels.index');
        } else {
            flash()->error('Error!', 'There was a problem creating a label. Please try again.');

            return redirect()->route('labels.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
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
