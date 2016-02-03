<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\ServiceRecordRequest;
use App\Processors\Service\ServiceRecordProcessor;

class ServiceRecordController extends Controller
{
    /**
     * @var ServiceRecordProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param ServiceRecordProcessor $processor
     */
    public function __construct(ServiceRecordProcessor $processor)
    {
        $this->processor = $processor;
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
        return $this->processor->index($serviceId);
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
        return $this->processor->create($serviceId);
    }

    /**
     * Creates a record for the specified
     *
     * @param ServiceRecordRequest $request
     * @param int|string           $serviceId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ServiceRecordRequest $request, $serviceId)
    {
        if ($this->processor->store($request, $serviceId)) {
            flash()->success('Success!', 'Successfully created service record.');

            return redirect()->route('services.records.index', [$serviceId]);
        } else {
            flash()->error('Error!', 'There was an issue creating a service record. Please try again.');

            return redirect()->route('services.records.create', [$serviceId]);
        }
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
        return $this->processor->show($serviceId, $recordId);
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
        return $this->processor->edit($serviceId, $recordId);
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
        if ($this->processor->update($request, $serviceId, $recordId)) {
            flash()->success('Success!', 'Successfully updated service record.');

            return redirect()->route('services.records.show', [$serviceId]);
        } else {
            flash()->error('Error!', 'There was an issue updating this service record. Please try again.');

            return redirect()->route('services.records.edit', [$serviceId, $recordId]);
        }
    }

    /**
     * Deletes the specified service record.
     *
     * @param int|string           $serviceId
     * @param int|string           $recordId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($serviceId, $recordId)
    {
        if ($this->processor->destroy($serviceId, $serviceId)) {
            flash()->success('Success!', 'Successfully deleted service record.');

            return redirect()->route('services.records.index', [$serviceId]);
        } else {
            flash()->error('Error!', 'There was an issue deleting this service record. Please try again.');

            return redirect()->route('services.records.show', [$serviceId, $recordId]);
        }
    }
}
