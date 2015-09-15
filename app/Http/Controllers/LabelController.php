<?php

namespace App\Http\Controllers;

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
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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
