<?php

namespace App\Models;

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
     * The belongsToMany users relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, $this->tablePivotUsers);
    }
}
