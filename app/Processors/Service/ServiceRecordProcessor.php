<?php

namespace App\Processors\Service;

use App\Http\Presenters\Service\ServiceRecordPresenter;
use App\Http\Requests\Service\ServiceRecordRequest;
use App\Jobs\Service\Record\Store;
use App\Jobs\Service\Record\Update;
use App\Models\Service;
use App\Policies\ServiceRecordPolicy;
use App\Processors\Processor;

class ServiceRecordProcessor extends Processor
{
    /**
     * @var Service
     */
    protected $service;

    /**
     * @var ServiceRecordPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Service                $service
     * @param ServiceRecordPresenter $presenter
     */
    public function __construct(Service $service, ServiceRecordPresenter $presenter)
    {
        $this->service = $service;
        $this->presenter = $presenter;
    }

    /**
     * Displays the specified services records.
     *
     * @param int|string $serviceId
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return \Illuminate\View\View
     */
    public function index($serviceId)
    {
        if (ServiceRecordPolicy::index(auth()->user())) {
            $service = $this->service->findOrFail($serviceId);

            $records = $this->presenter->table($service->records());

            $navbar = $this->presenter->navbar($service);

            return view('pages.services.records.index', compact('records', 'navbar', 'service'));
        }

        $this->unauthorized();
    }

    /**
     * Displays the form for creating a new service record.
     *
     * @param int|string $serviceId
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return \Illuminate\View\View
     */
    public function create($serviceId)
    {
        if (ServiceRecordPolicy::create(auth()->user())) {
            $service = $this->service->findOrFail($serviceId);

            $record = $service->records()->getRelated();

            $form = $this->presenter->form($service, $record);

            return view('pages.services.records.create', compact('form', 'service'));
        }

        $this->unauthorized();
    }

    /**
     * Creates a record for the specified service.
     *
     * @param ServiceRecordRequest $request
     * @param int|string           $serviceId
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return bool
     */
    public function store(ServiceRecordRequest $request, $serviceId)
    {
        if (ServiceRecordPolicy::create(auth()->user())) {
            $service = $this->service->findOrFail($serviceId);

            return $this->dispatch(new Store($request, $service));
        }

        $this->unauthorized();
    }

    /**
     * Displays the specified service record.
     *
     * @param int|string $serviceId
     * @param int|string $recordId
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return \Illuminate\View\View
     */
    public function show($serviceId, $recordId)
    {
        if (ServiceRecordPolicy::show(auth()->user())) {
            $service = $this->service->findOrFail($serviceId);

            $record = $service->records()->findOrFail($recordId);

            return view('pages.services.records.show', compact('service', 'record'));
        }

        $this->unauthorized();
    }

    /**
     * Displays the form for editing the specified service record.
     *
     * @param int|string $serviceId
     * @param int|string $recordId
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return \Illuminate\View\View
     */
    public function edit($serviceId, $recordId)
    {
        if (ServiceRecordPolicy::edit(auth()->user())) {
            $service = $this->service->findOrFail($serviceId);

            $record = $service->records()->findOrFail($recordId);

            $form = $this->presenter->form($service, $record);

            return view('pages.servicess.records.edit', compact('form', 'service', 'record'));
        }

        $this->unauthorized();
    }

    /**
     * Updates the specified service record.
     *
     * @param ServiceRecordRequest $request
     * @param int|string           $serviceId
     * @param int|string           $recordId
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return bool
     */
    public function update(ServiceRecordRequest $request, $serviceId, $recordId)
    {
        if (ServiceRecordPolicy::edit(auth()->user())) {
            $service = $this->service->findOrFail($serviceId);

            $record = $service->records()->findOrFail($recordId);

            return $this->dispatch(new Update($request, $record));
        }

        $this->unauthorized();
    }

    /**
     * Deletes the specified service record.
     *
     * @param int|string $serviceId
     * @param int|string $recordId
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return bool
     */
    public function destroy($serviceId, $recordId)
    {
        if (ServiceRecordPolicy::destroy(auth()->user())) {
            $service = $this->service->findOrFail($serviceId);

            $record = $service->records()->findOrFail($recordId);

            $this->authorize($record);

            return $record->delete();
        }

        $this->unauthorized();
    }
}
