<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_post_meta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('post_id')->default(0)->unsigned();
            $table->string('name', 100)->index('name');
            $table->text('value');
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('blog_posts')
                ->onUpdate('cascade')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_post_meta');
    }
}
