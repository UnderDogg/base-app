<?php

namespace App\Policies;

use App\Models\User;

class IssueAttachmentPolicy
{
    /**
     * Returns true / false if the current user
     * can view issue attachments.
     *
     * @return bool
     */
    public function show(User $user)
    {
        return $user->can('issue.attachments.show');
    }

    /**
     * Returns true / false if the current user
     * can edit issue attachments.
     *
     * @return bool
     */
    public function edit(User $user)
    {
        return $user->can('issues.attachments.edit');
    }

    /**
     * Returns true / false if the current user
     * can edit issue attachments.
     *
     * @return bool
     */
    public function update(User $user)
    {
        return $this->edit($user);
    }

    /**
     * Returns true / false if the current user
     * can delete issue attachments.
     *
     * @return bool
     */
    public function destroy(User $user)
    {
        return $user->can('issues.attachments.destroy');
    }

    /**
     * Returns true / false if the current user
     * can download issue attachments.
     *
     * @return bool
     */
    public function download(User $user)
    {
        return $user->can('issues.attachments.download');
    }
}
