<?php

namespace App\Policies;

class IssueAttachmentPolicy extends Policy
{
    /**
     * The policy name.
     *
     * @var string
     */
    protected $name = 'Issue Attachments';

    /**
     * {@inheritdoc}
     */
    public $actions = [
        'View Issue Attachments',
        'Edit Issue Attachments',
        'Delete Issue Attachments',
        'Download Issue Attachments',
    ];

    /**
     * Returns true / false if the current user
     * can view issue attachments.
     *
     * @return bool
     */
    public function show()
    {
        return $this->canIf('view-issue-attachments');
    }

    /**
     * Returns true / false if the current user
     * can edit issue attachments.
     *
     * @return bool
     */
    public function edit()
    {
        return $this->canIf('edit-issue-attachments');
    }

    /**
     * Returns true / false if the current user
     * can edit issue attachments.
     *
     * @return bool
     */
    public function update()
    {
        return $this->edit();
    }

    /**
     * Returns true / false if the current user
     * can delete issue attachments.
     *
     * @return bool
     */
    public function destroy()
    {
        return $this->canIf('edit-issue-attachments');
    }

    /**
     * Returns true / false if the current user
     * can download issue attachments.
     *
     * @return bool
     */
    public function download()
    {
        return $this->canIf('download-issue-attachments');
    }
}
