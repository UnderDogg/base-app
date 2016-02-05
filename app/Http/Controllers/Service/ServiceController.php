<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\ServiceRequest;
use App\Processors\Service\ServiceProcessor;

class ServiceController extends Controller
{
    /**
     * @var ServiceProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param ServiceProcessor $processor
     */
    public function __construct(ServiceProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays all services.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return $this->processor->index();
    }

    /**
     * Displays the form for creating a service.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return $this->processor->create();
    }

    /**
     * Creates a service.
     *
     * @param ServiceRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ServiceRequest $request)
    {
        if ($this->processor->store($request)) {
            flash()->success('Success!', 'Successfully created service.');

            return redirect()->route('services.index');
        } else {
            flash()->error('Error!', 'There was an issue creating a service. Please try again.');

            return redirect()->route('services.create');
        }
    }

    /**
     * Displays the specified service.
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
     * Displays the specified service status.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function status($id)
    {
        return $this->processor->status($id);
    }

    /**
     * Displays the form for editing the specified service.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        return $this->processor->edit($id);
    }

    /**
     * Updates the specified service.
     *
     * @param ServiceRequest $request
     * @param int|string     $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ServiceRequest $request, $id)
    {
        if ($this->processor->update($request, $id)) {
            flash()->success('Success!', 'Successfully updated service.');

            return redirect()->route('services.show', [$id]);
        } else {
            flash()->error('Error!', 'There was an issue updating this service. Please try again.');

            return redirect()->route('services.edit', [$id]);
        }
    }

    /**
     * Deletes the specified service.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if ($this->processor->destroy($id)) {
            flash()->success('Success!', 'Successfully deleted service.');

            return redirect()->route('services.index');
        } else {
            flash()->error('Error!', 'There was an issue deleting this service. Please try again.');

            return redirect()->route('services.show', [$id]);
        }
    }
}
