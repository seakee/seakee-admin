<?php
/**
 * File: PostController.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/12/10 1:32 下午
 * Description:
 */

namespace Admin\Controllers\Blogs;


use Admin\Requests\Blogs\PostRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Blog\CategoryRepository;
use App\Repositories\Blog\PostMetaRepository;
use App\Repositories\Blog\PostRepository;
use App\Repositories\Blog\TagRepository;

class PostController extends Controller
{
    /**
     * @var PostRepository
     */
    protected $post;

    /**
     * @var PostMetaRepository
     */
    protected $meta;

    /**
     * @var TagRepository
     */
    protected $tag;

    /**
     * @var CategoryRepository
     */
    protected $category;

    /**
     * PostController constructor.
     *
     * @param PostRepository     $post
     * @param PostMetaRepository $meta
     * @param TagRepository      $tag
     * @param CategoryRepository $category
     */
    public function __construct(PostRepository $post, PostMetaRepository $meta, TagRepository $tag, CategoryRepository $category)
    {
        $this->post     = $post;
        $this->meta     = $meta;
        $this->tag      = $tag;
        $this->category = $category;
    }

    public function index(PostRequest $request)
    {

    }

    /**
     * 
     */
    public function store(PostRequest $request)
    {
        $posts = filter_request_params([], $request);
        $metas = filter_request_params([], $request);
        $tags = filter_request_params([], $request);
        $categories = filter_request_params([], $request);
    }
}
