<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('post_id')->default(0)->unsigned();
            $table->bigInteger('parent_id')->default(0)->unsigned();
            $table->integer('author_id')->default(0)->unsigned();
            $table->string('author_ip');
            $table->text('content');
            $table->tinyInteger('approved')->default(1);
            $table->string('agent');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('blog_posts')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('author_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_comments');
    }
}
