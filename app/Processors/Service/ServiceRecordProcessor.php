<?php

namespace App\Processors\Service;

use App\Http\Presenters\Service\ServiceRecordPresenter;
use App\Http\Requests\Service\ServiceRecordRequest;
use App\Jobs\Service\Record\Store;
use App\Jobs\Service\Record\Update;
use App\Models\Service;
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
     * @return \Illuminate\View\View
     */
    public function index($serviceId)
    {
        $service = $this->service->findOrFail($serviceId);

        $this->authorize($service->records()->getRelated());

        $records = $this->presenter->table($service->records());

        $navbar = $this->presenter->navbar($service);

        return view('pages.services.records.index', compact('records', 'navbar', 'service'));
    }

    /**
     * Displays the form for creating a new service record.
     *
     * @param int|string $serviceId
     *
     * @return \Illuminate\View\View
     */
    public function create($serviceId)
    {
        $service = $this->service->findOrFail($serviceId);

        $record = $service->records()->getRelated();

        $this->authorize($record);

        $form = $this->presenter->form($service, $record);

        return view('pages.services.records.create', compact('form', 'service'));
    }

    /**
     * Creates a record for the specified service.
     *
     * @param ServiceRecordRequest $request
     * @param int|string           $serviceId
     *
     * @return bool
     */
    public function store(ServiceRecordRequest $request, $serviceId)
    {
        $service = $this->service->findOrFail($serviceId);

        $this->authorize($service->records()->getRelated());

        return $this->dispatch(new Store($request, $service));
    }

    /**
     * Displays the specified service record.
     *
     * @param int|string $serviceId
     * @param int|string $recordId
     *
     * @return \Illuminate\View\View
     */
    public function show($serviceId, $recordId)
    {
        $service = $this->service->findOrFail($serviceId);

        $record = $service->records()->findOrFail($recordId);

        $this->authorize($record);

        return view('pages.services.records.show', compact('service', 'record'));
    }

    /**
     * Displays the form for editing the specified service record.
     *
     * @param int|string $serviceId
     * @param int|string $recordId
     *
     * @return \Illuminate\View\View
     */
    public function edit($serviceId, $recordId)
    {
        $service = $this->service->findOrFail($serviceId);

        $record = $service->records()->findOrFail($recordId);

        $this->authorize($record);

        $form = $this->presenter->form($service, $record);

        return view('pages.servicess.records.edit', compact('form', 'service', 'record'));
    }

    /**
     * Updates the specified service record.
     *
     * @param ServiceRecordRequest $request
     * @param int|string           $serviceId
     * @param int|string           $recordId
     *
     * @return bool
     */
    public function update(ServiceRecordRequest $request, $serviceId, $recordId)
    {
        $service = $this->service->findOrFail($serviceId);

        $record = $service->records()->findOrFail($recordId);

        $this->authorize($record);

        return $this->dispatch(new Update($request, $record));
    }

    /**
     * Deletes the specified service record.
     *
     * @param int|string $serviceId
     * @param int|string $recordId
     *
     * @return bool
     */
    public function destroy($serviceId, $recordId)
    {
        $service = $this->service->findOrFail($serviceId);

        $record = $service->records()->findOrFail($recordId);

        $this->authorize($record);

        return $record->delete();
    }
}
