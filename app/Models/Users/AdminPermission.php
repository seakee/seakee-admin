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
}
