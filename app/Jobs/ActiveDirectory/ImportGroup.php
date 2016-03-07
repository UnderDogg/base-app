<?php

namespace App\Jobs\ActiveDirectory;

use Adldap\Models\Group;
use App\Models\Role;
use App\Jobs\Job;

class ImportGroup extends Job
{
    /**
     * @var Group
     */
    protected $group;

    /**
     * Constructor.
     *
     * @param Group $group
     */
    public function __construct(Group $group)
    {
        $this->group = $group;
    }

    /**
     * Execute the job.
     *
     * @return Role
     */
    public function handle()
    {
        $label = $this->group->getName();
        $name = str_slug($label);

        // We'll create the role if it doesn't exist already.
        $role = Role::firstOrCreate(compact('name', 'label'));

        // We'll double check that it was successfully retrieved / created.
        if ($role instanceof Role) {
            // Retrieve the members from the AD group.
            $members = $this->group->getMembers();

            foreach ($members as $member) {
                // Import users that may not already be apart of our local DB.
                $user = $this->dispatch(new ImportUser($member));

                // Make sure the user isn't already apart of the role.
                $exists = $role->users()->find($user->getKey());

                if (!$exists) {
                    // Attach the user to the role if they
                    // aren't currently a member.
                    $role->users()->save($user);
                }
            }

            return $role;
        }

        return false;
    }
}
