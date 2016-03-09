<?php

namespace App\Processors\Device\Computer;

use App\Models\ComputerType;
use App\Processors\Processor;

class ComputerTypeProcessor extends Processor
{
    public function __construct(ComputerType $type)
    {
        $this->type = $type;
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store()
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
