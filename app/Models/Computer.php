<?php

namespace App\Models;

use Orchestra\Support\Facades\HTML;
use App\Models\Traits\HasUserTrait;

class Computer extends Model
{
    use HasUserTrait;

    /**
     * The computers table.
     *
     * @var string
     */
    protected $table = 'computers';

    /**
     * The computer users pivot table.
     *
     * @var string
     */
    protected $tablePivotUsers = 'computer_users';

    /**
     * The fillable computer attributes.
     *
     * @var array
     */
    protected $fillable = [
        'type_id',
        'os_id',
        'dn',
        'name',
        'description',
    ];

    /**
     * The belongsTo type relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function type()
    {
        return $this->belongsTo(ComputerType::class, 'type_id');
    }

    /**
     * The belongsTo operating system relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function os()
    {
        return $this->belongsTo(OperatingSystem::class, 'os_id');
    }

    /**
     * The hasOne access relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function access()
    {
        return $this->hasOne(ComputerAccess::class, 'computer_id');
    }

    /**
     * The belongsToMany users relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, $this->tablePivotUsers);
    }

    /**
     * Returns the complete computers operating system string.
     *
     * @return string|null
     */
    public function getCompleteOs()
    {
        if ($this->os instanceof OperatingSystem) {
            $os = $this->os->name;
            $version = $this->os->version;

            return sprintf('%s %s', $os, $version);
        }

        return null;
    }


    /**
     * Returns all access checks.
     *
     * @return string
     */
    public function getAccessChecks()
    {
        $ad = $this->getActiveDirectoryCheck();
        $wmi = $this->getWmiCheck();

        return implode(' ', [$ad, $wmi]);
    }

    /**
     * Returns a check mark or an x depending on
     * if the computer is accessed by AD.
     *
     * @return string
     */
    public function getActiveDirectoryCheck()
    {
        if ($this->access instanceof ComputerAccess) {
            $ad = $this->access->active_directory;
        } else {
            $ad = false;
        }

        return $this->createCheck($ad, 'Active Directory');
    }

    /**
     * Returns a check mark or an x depending on
     * if the computer is accessed by WMI.
     *
     * @return string
     */
    public function getWmiCheck()
    {
        if ($this->access instanceof ComputerAccess) {
            $wmi = $this->access->wmi;
        } else {
            $wmi = false;
        }

        return $this->createCheck($wmi, 'WMI');
    }

    /**
     * Creates a check mark or x icon depending if
     * bool is true or false.
     *
     * @param bool|false $bool
     * @param string     $text
     *
     * @return string
     */
    private function createCheck($bool = false, $text = '')
    {
        if ($bool) {
            $check =  HTML::create('i', '', ['class' => 'fa fa-check']);

            return HTML::raw("<span class='label label-success'>$check $text</span>");
        } else {
            $check = HTML::create('i', '', ['class' => 'fa fa-times']);

            return HTML::raw("<span class='label label-danger'>$check $text</span>");
        }
    }
}
