<?php

namespace App\Models;

class DriveItemAccount extends Model
{
    /**
     * The drive item accounts table.
     *
     * @var string
     */
    protected $table = 'drive_item_accounts';

    /**
     * The drive item account permissions pivot table.
     *
     * @var string
     */
    protected $tableDriveItemAccountPermissionsPivot = 'drive_item_account_permissions';

    /**
     * The fillable drive item account attributes.
     *
     * @var array
     */
    protected $fillable = ['item_id', 'account_id'];

    /**
     * The belongsTo account relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(DriveAccount::class, 'account_id');
    }

    /**
     * The belongsTo item relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item()
    {
        return $this->belongsTo(DriveItem::class, 'item_id');
    }

    /**
     * The belongsToMany permissions relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(DrivePermission::class, $this->tableDriveItemAccountPermissionsPivot, 'account_id');
    }
}
