<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('author_id')->default(0)->unsigned()->index('author_id');
            $table->longText('content');
            $table->longText('hide_content');
            $table->text('title');
            $table->text('excerpt');
            $table->tinyInteger('status')->default(1)->comment('1.已发布2.待发布3.草稿4.已删除');
            $table->tinyInteger('comment_status')->default(1);
            $table->string('name')->index('name');
            $table->timestamp('posted_at')->nullable();
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
        Schema::dropIfExists('blog_posts');
    }
}
