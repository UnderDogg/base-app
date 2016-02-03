<?php

namespace App\Policies;

class ServiceRecordPolicy extends Policy
{
    /**
     * The service record policy display name.
     *
     * @var string
     */
    protected $name = 'Service Record Policy';

    /**
     * The service record actions.
     *
     * @var array
     */
    public $actions = [
        'View Service Records',
        'Create Service Record',
        'View Service Record',
        'Edit Service Record',
        'Delete Service Record',
    ];

    /**
     * Returns true / false if the current user can view all services.
     *
     * @return bool
     */
    public function index()
    {
        return $this->canIf('view-services-records');
    }

    /**
     * Returns true / false if the current user can create services.
     *
     * @return bool
     */
    public function create()
    {
        return $this->canIf('create-service-record');
    }

    /**
     * Returns true / false if the current user can create services.
     *
     * @return bool
     */
    public function store()
    {
        return $this->create();
    }

    /**
     * Returns true / false if the current user can view service records.
     *
     * @return bool
     */
    public function show()
    {
        return $this->canIf('view-service-record');
    }

    /**
     * Returns true / false if the current user can edit services.
     *
     * @return bool
     */
    public function edit()
    {
        return $this->canIf('edit-service-record');
    }

    /**
     * Returns true / false if the current user can edit services.
     *
     * @return bool
     */
    public function update()
    {
        return $this->edit();
    }

    /**
     * Returns true / false if the current user can delete services.
     *
     * @return bool
     */
    public function destroy()
    {
        return $this->canIf('delete-service-record');
    }
}
