<?php

namespace App\Processors\Service;

use App\Http\Presenters\Service\ServicePresenter;
use App\Http\Requests\Service\ServiceRequest;
use App\Jobs\Service\Store;
use App\Jobs\Service\Update;
use App\Models\Service;
use App\Models\ServiceRecord;
use App\Policies\ServicePolicy;
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
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (ServicePolicy::index(auth()->user())) {
            $services = $this->presenter->table($this->service);

            $navbar = $this->presenter->navbar();

            return view('pages.services.index', compact('services', 'navbar'));
        }

        $this->unauthorized();
    }

    /**
     * Displays the form for creating a new service.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if (ServicePolicy::create(auth()->user())) {
            $form = $this->presenter->form($this->service);

            return view('pages.services.create', compact('form'));
        }

        $this->unauthorized();
    }

    /**
     * Creates a new service.
     *
     * @param ServiceRequest $request
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return bool
     */
    public function store(ServiceRequest $request)
    {
        if (ServicePolicy::create(auth()->user())) {
            return $this->dispatch(new Store($request, $this->service));
        }

        $this->unauthorized();
    }

    /**
     * Displays the specified service.
     *
     * @param int|string $id
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        if (ServicePolicy::show(auth()->user())) {
            $service = $this->service->findOrFail($id);

            return view('pages.services.show', compact('service'));
        }

        $this->unauthorized();
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
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        if (ServicePolicy::edit(auth()->user())) {
            $service = $this->service->findOrFail($id);

            $form = $this->presenter->form($service);

            return view('pages.services.edit', compact('form'));
        }

        $this->unauthorized();
    }

    /**
     * Updates the specified service.
     *
     * @param ServiceRequest $request
     * @param int|string     $id
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return bool
     */
    public function update(ServiceRequest $request, $id)
    {
        if (ServicePolicy::edit(auth()->user())) {
            $service = $this->service->findOrFail($id);

            return $this->dispatch(new Update($request, $service));
        }

        $this->unauthorized();
    }

    /**
     * Deletes the specified service.
     *
     * @param int|string $id
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return bool
     */
    public function destroy($id)
    {
        if (ServicePolicy::destroy(auth()->user())) {
            $service = $this->service->findOrFail($id);

            return $service->delete();
        }

        $this->unauthorized();
    }
}
