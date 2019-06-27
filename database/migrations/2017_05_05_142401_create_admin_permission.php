<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    // Create table for storing permissions
	    Schema::create('admin_permissions', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('name')->unique();
		    $table->string('display_name')->nullable();
		    $table->string('description')->nullable();
		    $table->softDeletes();
		    $table->timestamps();
	    });

	    // Create table for associating permissions to roles (Many-to-Many)
	    Schema::create('admin_permission_role', function (Blueprint $table) {
		    $table->integer('permission_id')->unsigned();
		    $table->integer('role_id')->unsigned();

		    $table->foreign('permission_id')->references('id')->on('admin_permissions')
			    ->onUpdate('cascade')->onDelete('cascade');
		    $table->foreign('role_id')->references('id')->on('admin_roles')
			    ->onUpdate('cascade')->onDelete('cascade');

		    $table->primary(['permission_id', 'role_id']);
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::drop('admin_permission_role');
	    Schema::drop('admin_permissions');
    }
}
