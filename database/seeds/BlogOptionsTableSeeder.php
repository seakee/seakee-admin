<?php
/**
 * File: BlogOptionsTableSeeder.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/26 1:41 下午
 * Description:
 */

use Illuminate\Database\Seeder;

class BlogOptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('blog_options')->insert([
            'name'       => 'blog_url',
            'value'      => 'http://localhost',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('blog_options')->insert([
            'name'       => 'blog_home',
            'value'      => 'http://localhost',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('blog_options')->insert([
            'name'       => 'blog_name',
            'value'      => 'SeakeeBlog',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('blog_options')->insert([
            'name'       => 'blog_description',
            'value'      => 'Blog based build on Laravel, Vue and Element.',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('blog_options')->insert([
            'name'       => 'blog_keywords',
            'value'      => 'Seakee,Blog,Laravel,Vue,Element',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('blog_options')->insert([
            'name'       => 'blog_icp',
            'value'      => '京ICP备xxxxxxxx',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('blog_options')->insert([
            'name'       => 'comment_default_status',
            'value'      => '1',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('blog_options')->insert([
            'name'       => 'post_per_page',
            'value'      => '10',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
    }
}
