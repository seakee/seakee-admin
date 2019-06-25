<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('icon', 50)->default('fa-circle-o');
            $table->string('name', 100);
            $table->string('route_name');
	        $table->string('path')->comment('前端路由路径');
            $table->integer('father_id')->comment('-1：根目录');
            $table->integer('sort')->default(0);
            $table->tinyInteger('display')->default(1)->comment('0：隐藏,1：显示');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_menus');
    }
}
