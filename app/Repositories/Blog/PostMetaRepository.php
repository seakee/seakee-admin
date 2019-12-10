<?php
/**
 * File: PostMetaRepository.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/12/10 11:04 上午
 * Description:
 */

namespace App\Repositories\Blog;


use App\Models\Blog\PostMeta;
use Illuminate\Support\Collection;

class PostMetaRepository
{
    /**
     * @var PostMeta
     */
    protected $postMeta;

    /**
     * PostMetaRepository constructor.
     *
     * @param PostMeta $postMeta
     */
    public function __construct(PostMeta $postMeta)
    {
        $this->postMeta = $postMeta;
    }

    /**
     * @return PostMeta
     */
    public function getPostMeta(): PostMeta
    {
        return $this->postMeta;
    }

    /**
     * @param PostMeta $postMeta
     */
    public function setPostMeta(PostMeta $postMeta): void
    {
        $this->postMeta = $postMeta;
    }

    /**
     * @param array $data
     *
     * @return PostMeta
     */
    public function store(array $data): PostMeta
    {
        return $this->postMeta->create($data);
    }

    /**
     * @param array $data
     * @param int   $id
     *
     * @return bool
     */
    public function update(array $data, int $id): bool
    {
        return $this->postMeta->where('id', $id)->update($data);
    }

    /**
     * @param array|int $ids
     *
     * @return int
     */
    public function destroy($ids): int
    {
        return $this->postMeta->destroy($ids);
    }

    /**
     * @param       $ids
     * @param array $columns
     *
     * @return mixed
     */
    public function find($ids, $columns = ['*'])
    {
        return $this->postMeta->findOrFail($ids, $columns);
    }

    /**
     * @return Collection
     */
    public function list(): Collection
    {
        return $this->postMeta->get(['name', 'value']);
    }
}
