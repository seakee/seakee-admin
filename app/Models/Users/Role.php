<?php

namespace App\Models\User;

use DB;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	/**
	 * Many-to-Many relations with the user model.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users()
	{
		return $this->belongsToMany('App\Models\Users\AdminUser', 'admin_users', 'role_id', 'user_id');
	}

	/**
	 * Many-to-Many relations with the permission model.
	 * Named "perms" for backwards compatibility. Also because "perms" is short and sweet.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function perms()
	{
		return $this->belongsToMany('App\Models\Users\Permission', 'permission_role', 'role_id', 'permission_id');
	}

	public static function getRoleIdList($userId){
		return DB::table('role_user')->select('role_id')->where('user_id', $userId)->get()->toArray();
	}
}
