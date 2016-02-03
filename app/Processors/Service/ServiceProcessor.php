<?php

namespace App\Processors\Service;

use App\Http\Presenters\Service\ServicePresenter;
use App\Http\Requests\Service\ServiceRequest;
use App\Jobs\Service\Store;
use App\Jobs\Service\Update;
use App\Models\Service;
use App\Processors\Processor;

class ServiceProcessor extends Processor
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
     * Displays the form for creating a new service.
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
     * Creates a new service.
     *
     * @param ServiceRequest $request
     *
     * @return bool
     */
    public function store(ServiceRequest $request)
    {
        $this->authorize($this->service);

        return $this->dispatch(new Store($request, $this->service));
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
     * @return bool
     */
    public function update(ServiceRequest $request, $id)
    {
        $service = $this->service->findOrFail($id);

        $this->authorize($service);

        return $this->dispatch(new Update($request, $service));
    }

    /**
     * Deletes the specified service.
     *
     * @param int|string $id
     *
     * @return bool
     */
    public function destroy($id)
    {
        $service = $this->service->findOrFail($id);

        return $service->delete();
    }
}
