<?php
/**
 * File: Menu.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/26 3:56 下午
 * Description:
 */

namespace App\Models\Menus;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_menus';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'icon', 'name', 'route_name', 'path', 'father_id', 'sort', 'display'
    ];
}
