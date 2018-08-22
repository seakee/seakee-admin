<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use DB;

class AdminPermission extends Model
{
	/**
	 * Many-to-Many relations with role model.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function roles()
	{
		return $this->belongsToMany('App\Models\Users\AdminRole', 'admin_permission_role', 'permission_id', 'role_id');
	}

	public static function getPermissionIdList($roleId){
		return DB::table('admin_permission_role')->select('permission_id')->whereIn('role_id', $roleId)->get();
	}

	public static function getPermissionList($permissionId){
		return DB::table('admin_permissions')->whereIn('id', $permissionId)->get()->all();
	}
}
