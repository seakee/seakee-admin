<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use DB;

class Permission extends Model
{
	/**
	 * Many-to-Many relations with role model.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function roles()
	{
		return $this->belongsToMany('App\Models\Users\Role', 'admin_permission_role', 'permission_id', 'role_id');
	}

	public static function getPermissionIdList($roleId){
		return DB::table('permission_role')->select('permission_id')->whereIn('role_id', $roleId)->get();
	}

	public static function getPermissionList($permissionId){
		return DB::table('admin_permissions')->whereIn('id', $permissionId)->get()->all();
	}
}
