<?php
/**
 * File: AdminPermission.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/26 11:16 上午
 * Description:
 */

namespace App\Models\Users;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminPermission extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'display_name', 'description',
    ];

    /**
     * Many-to-Many relations with role model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Users\AdminRole', 'admin_permission_role', 'permission_id', 'role_id');
    }
}
