<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('icon', 50)->default('fa-circle-o');
            $table->string('menu_name', 100);
            $table->string('route_name');
            $table->integer('father_id')->comment('-1：根目录');
            $table->integer('sort')->default(0);
            $table->tinyInteger('display')->default(1)->comment('0：隐藏,1：显示');
            $table->tinyInteger('is_custom')->default(0)->comment('0：非自定义1：自定义');
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
        Schema::dropIfExists('menus');
    }
}
