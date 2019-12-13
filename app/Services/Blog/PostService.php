<?php
/**
 * File: PostService.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/12/4 5:29 下午
 * Description:
 */

namespace App\Services\Blog;


use App\Repositories\Blog\PostRepository;

class PostService
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }


}
