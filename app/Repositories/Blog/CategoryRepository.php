<?php
/**
 * File: CategoryRepository.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/12/10 11:02 上午
 * Description:
 */

namespace App\Repositories\Blog;


use App\Models\Blog\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryRepository
{
    /**
     * @var Category
     */
    protected $category;

    /**
     * CategoryRepository constructor.
     *
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @param array $data
     *
     * @return Category
     */
    public function store(array $data): Category
    {
        return $this->category->create($data);
    }

    /**
     * @param array $data
     * @param int   $id
     *
     * @return bool
     */
    public function update(array $data, int $id): bool
    {
        return $this->category->where('id', $id)->update($data);
    }

    /**
     * @param array|int $ids
     *
     * @return int
     */
    public function destroy($ids): int
    {
        return $this->category->destroy($ids);
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
            return $this->category->onlyTrashed()->where($where)->paginate($perPage, $columns, 'page', $page);
        }

        return $this->category->where($where)->paginate($perPage, $columns, 'page', $page);
    }

    /**
     * @param       $ids
     * @param array $columns
     *
     * @return mixed
     */
    public function find($ids, $columns = ['*'])
    {
        return $this->category->findOrFail($ids, $columns);
    }

    /**
     * @param array $ids
     *
     * @return bool|null
     */
    public function restore(array $ids)
    {
        return $this->category->withTrashed()->whereIn('id', $ids)->restore();
    }

    /**
     * @param array $ids
     *
     * @return mixed
     */
    public function forceDelete(array $ids)
    {
        return $this->category->find($ids)->forceDelete();
    }
}
