<?php
/**
 * File: PostRepository.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/12/4 4:46 下午
 * Description:
 */

namespace App\Repositories\Blog;


use App\Models\Blog\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PostRepository
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * @return Post
     */
    public function getPost(): Post
    {
        return $this->post;
    }

    /**
     * @param Post $post
     */
    public function setPost(Post $post): void
    {
        $this->post = $post;
    }

    /**
     * @param array $data
     *
     * @return Post
     */
    public function store(array $data): Post
    {
        return $this->post->create($data);
    }

    /**
     * @param array $data
     * @param int   $id
     *
     * @return bool
     */
    public function update(array $data, int $id): bool
    {
        return $this->post->where('id', $id)->update($data);
    }

    /**
     * @param array|int $ids
     *
     * @return int
     */
    public function destroy($ids): int
    {
        return $this->post->destroy($ids);
    }

    /**
     * @param array $where
     * @param int   $perPage
     * @param int   $page
     * @param array $columns
     *
     * @return LengthAwarePaginator
     */
    public function paginate(array $where, int $perPage, int $page, $columns = ['*']): LengthAwarePaginator
    {
        return $this->post->where($where)->paginate($perPage, $columns, 'page', $page);
    }

    /**
     * @param       $ids
     * @param array $columns
     *
     * @return mixed
     */
    public function find($ids, $columns = ['*'])
    {
        return $this->post->findOrFail($ids, $columns);
    }
}
