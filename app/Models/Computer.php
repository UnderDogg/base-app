<?php

namespace App\Models;

use App\Models\Traits\HasUserTrait;
use JJG\Ping;
use Orchestra\Support\Facades\HTML;

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
     * The hasMany statuses relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statuses()
    {
        return $this->hasMany(ComputerStatus::class, 'computer_id');
    }

    /**
     * The hasMany disks relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function disks()
    {
        return $this->hasMany(ComputerHardDisk::class, 'computer_id');
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
    public function getOperatingSystemAttribute()
    {
        if ($this->os instanceof OperatingSystem) {
            $os = $this->os->name;
            $version = $this->os->version;

            return sprintf('%s %s', $os, $version);
        }
    }

    /**
     * Returns all access checks.
     *
     * @return string
     */
    public function getAccessChecksAttribute()
    {
        $ad = $this->ad_access_check;
        $wmi = $this->wmi_access_check;

        return implode(' ', [$ad, $wmi]);
    }

    /**
     * Returns a check mark or an x depending on
     * if the computer is accessed by AD.
     *
     * @return string
     */
    public function getActiveDirectoryAccessCheckAttribute()
    {
        return $this->createCheck($this->active_directory_access, 'Active Directory');
    }

    /**
     * Returns true / false if the current computer
     * can be accessed by Active Directory.
     *
     * @return bool
     */
    public function getActiveDirectoryAccessAttribute()
    {
        if ($this->access instanceof ComputerAccess) {
            return $this->access->active_directory;
        }

        return false;
    }

    /**
     * Returns a check mark or an x depending on
     * if the computer is accessed by WMI.
     *
     * @return string
     */
    public function getWmiAccessCheckAttribute()
    {
        return $this->createCheck($this->wmi_access, 'WMI');
    }

    /**
     * Returns true / false if the current
     * computer can be accessed by WMI.
     *
     * @return bool|ComputerAccess
     */
    public function getWmiAccessAttribute()
    {
        if ($this->access instanceof ComputerAccess) {
            return $this->access->wmi;
        }

        return false;
    }

    /**
     * Retrieves the online status of the computer and
     * displays a label based off the response.
     *
     * @return string
     */
    public function getOnlineStatusAttribute()
    {
        $status = $this->statuses()->latest()->first();

        if ($status instanceof ComputerStatus) {
            $daysAgo = $status->created_at_human;

            if ($status->online) {
                return $this->createCheck(true, "Online ($daysAgo)");
            } else {
                return $this->createCheck(false, "Offline ($daysAgo)");
            }
        }

        return $this->createCheck(false, 'Offline');
    }

    /**
     * Pings the current computer to see if it's online.
     *
     * @return bool|int
     */
    public function ping()
    {
        return (new Ping($this->name, 5))->ping();
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
    protected function createCheck($bool = false, $text = '')
    {
        if ($bool) {
            $check = HTML::create('i', '', ['class' => 'fa fa-check']);

            return HTML::raw("<span class='label label-success'>$check $text</span>");
        } else {
            $check = HTML::create('i', '', ['class' => 'fa fa-times']);

            return HTML::raw("<span class='label label-danger'>$check $text</span>");
        }
    }
}
