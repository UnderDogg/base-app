<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Presenters\Service\ServicePresenter;
use App\Http\Requests\Service\ServiceRequest;
use App\Jobs\Service\Store;
use App\Jobs\Service\Update;
use App\Models\Service;
use App\Models\ServiceRecord;

class ServiceController extends Controller
{
    /**
     * @var Service
     */
    protected $service;

    /**
     * @var ServicePresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Service          $service
     * @param ServicePresenter $presenter
     */
    public function __construct(Service $service, ServicePresenter $presenter)
    {
        $this->service = $service;
        $this->presenter = $presenter;
    }

    /**
     * Displays all services.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize($this->service);

        $services = $this->presenter->table($this->service);

        $navbar = $this->presenter->navbar();

        return view('pages.services.index', compact('services', 'navbar'));
    }

    /**
     * Displays the form for creating a service.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize($this->service);

        $form = $this->presenter->form($this->service);

        return view('pages.services.create', compact('form'));
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
        $this->authorize($this->service);

        if ($this->dispatch(new Store($request, $this->service))) {
            flash()->success('Success!', 'Successfully created service.');

            return redirect()->route('services.index');
        }

        flash()->error('Error!', 'There was an issue creating a service. Please try again.');

        return redirect()->route('services.create');
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
        $service = $this->service->findOrFail($id);

        $this->authorize($service);

        return view('pages.services.show', compact('service'));
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
        $service = $this->service->with('records')->findOrFail($id);

        $current = $service->last_record;

        if ($current instanceof ServiceRecord) {
            // Remove the last record out of the records collection.
            $service->records->shift();
        }

        return view('pages.services.status', compact('service', 'current'));
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
        $service = $this->service->findOrFail($id);

        $this->authorize($service);

        $form = $this->presenter->form($service);

        return view('pages.services.edit', compact('form'));
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
        $service = $this->service->findOrFail($id);

        $this->authorize($service);

        if ($this->dispatch(new Update($request, $service))) {
            flash()->success('Success!', 'Successfully updated service.');

            return redirect()->route('services.show', [$id]);
        }

        flash()->error('Error!', 'There was an issue updating this service. Please try again.');

        return redirect()->route('services.edit', [$id]);
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
        $service = $this->service->findOrFail($id);

        $this->authorize($service);

        if ($service->delete()) {
            flash()->success('Success!', 'Successfully deleted service.');

            return redirect()->route('services.index');
        }

        flash()->error('Error!', 'There was an issue deleting this service. Please try again.');

        return redirect()->route('services.show', [$id]);
    }
}
