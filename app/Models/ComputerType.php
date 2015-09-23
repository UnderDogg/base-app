<?php

namespace App\Models;

class ComputerType extends Model
{
    /**
     * The computer types table.
     *
     * @var string
     */
    protected $table = 'computer_types';

    /**
     * The fillable computer type attributes.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * The hasMany computers relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function computers()
    {
        return $this->hasMany(Computer::class, 'type_id', 'id');
    }
}
