<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Presenters\Service\ServiceRecordPresenter;
use App\Http\Requests\Service\ServiceRecordRequest;
use App\Jobs\Service\Record\Store;
use App\Jobs\Service\Record\Update;
use App\Models\Service;
use App\Policies\ServiceRecordPolicy;

class ServiceRecordController extends Controller
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
        if (ServiceRecordPolicy::index(auth()->user())) {
            $service = $this->service->findOrFail($serviceId);

            $records = $this->presenter->table($service->records());

            $navbar = $this->presenter->navbar($service);

            return view('pages.services.records.index', compact('records', 'navbar', 'service'));
        }

        $this->unauthorized();
    }

    /**
     * Displays the form for creating a record for the specified service.
     *
     * @param int|string $serviceId
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
     * Creates a record for the specified.
     *
     * @param ServiceRecordRequest $request
     * @param int|string           $serviceId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ServiceRecordRequest $request, $serviceId)
    {
        if (ServiceRecordPolicy::create(auth()->user())) {
            $service = $this->service->findOrFail($serviceId);

            if ($this->dispatch(new Store($request, $service))) {
                flash()->success('Success!', 'Successfully created service record.');

                return redirect()->route('services.records.index', [$serviceId]);
            }

            flash()->error('Error!', 'There was an issue creating a service record. Please try again.');

            return redirect()->route('services.records.create', [$serviceId]);
        }

        $this->unauthorized();
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ServiceRecordRequest $request, $serviceId, $recordId)
    {
        if (ServiceRecordPolicy::edit(auth()->user())) {
            $service = $this->service->findOrFail($serviceId);

            $record = $service->records()->findOrFail($recordId);

            if ($this->dispatch(new Update($request, $record))) {
                flash()->success('Success!', 'Successfully updated service record.');

                return redirect()->route('services.records.show', [$serviceId]);
            }

            flash()->error('Error!', 'There was an issue updating this service record. Please try again.');

            return redirect()->route('services.records.edit', [$serviceId, $recordId]);
        }

        $this->unauthorized();
    }

    /**
     * Deletes the specified service record.
     *
     * @param int|string $serviceId
     * @param int|string $recordId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($serviceId, $recordId)
    {
        if (ServiceRecordPolicy::destroy(auth()->user())) {
            $service = $this->service->findOrFail($serviceId);

            $record = $service->records()->findOrFail($recordId);

            $this->authorize($record);

            if ($record->delete()) {
                flash()->success('Success!', 'Successfully deleted service record.');

                return redirect()->route('services.records.index', [$serviceId]);
            }

            flash()->error('Error!', 'There was an issue deleting this service record. Please try again.');

            return redirect()->route('services.records.show', [$serviceId, $recordId]);
        }

        $this->unauthorized();
    }
}
