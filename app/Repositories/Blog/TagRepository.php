<?php
/**
 * File: TagRepository.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/12/10 11:02 上午
 * Description:
 */

namespace App\Repositories\Blog;


use App\Models\Blog\Tag;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TagRepository
{
    /**
     * @var Tag 
     */
    protected $tag;

    /**
     * TagRepository constructor.
     *
     * @param Tag $tag
     */
    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return Tag
     */
    public function getTag(): Tag
    {
        return $this->tag;
    }

    /**
     * @param Tag $tag
     */
    public function setTag(Tag $tag): void
    {
        $this->tag = $tag;
    }

    /**
     * @param array $data
     *
     * @return Tag
     */
    public function store(array $data): Tag
    {
        return $this->tag->create($data);
    }

    /**
     * @param array $data
     * @param int   $id
     *
     * @return bool
     */
    public function update(array $data, int $id): bool
    {
        return $this->tag->where('id', $id)->update($data);
    }

    /**
     * @param array|int $ids
     *
     * @return int
     */
    public function destroy($ids): int
    {
        return $this->tag->destroy($ids);
    }

    /**
     * @param array $where
     * @param int   $perPage
     * @param int   $page
     * @param array $columns
     * @param bool  $trashed
     *
     * @return LengthAwarePaginator
     */
    public function paginate(array $where, int $perPage, int $page, $columns = ['*'], $trashed = false): LengthAwarePaginator
    {
        if ($trashed) {
            return $this->tag->onlyTrashed()->where($where)->paginate($perPage, $columns, 'page', $page);
        }

        return $this->tag->where($where)->paginate($perPage, $columns, 'page', $page);
    }

    /**
     * @param       $ids
     * @param array $columns
     *
     * @return mixed
     */
    public function find($ids, $columns = ['*'])
    {
        return $this->tag->findOrFail($ids, $columns);
    }

    /**
     * @param array $ids
     *
     * @return bool|null
     */
    public function restore(array $ids)
    {
        return $this->tag->withTrashed()->whereIn('id', $ids)->restore();
    }

    /**
     * @param array $ids
     *
     * @return mixed
     */
    public function forceDelete(array $ids)
    {
        return $this->tag->find($ids)->forceDelete();
    }
}
