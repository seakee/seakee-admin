<?php
/**
 * File: CommentRepository.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/12/10 11:03 上午
 * Description:
 */

namespace App\Repositories\Blog;


use App\Models\Blog\Comment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CommentRepository
{
    /**
     * @var Comment
     */
    protected $comment;

    /**
     * CommentRepository constructor.
     *
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @param array $data
     *
     * @return Comment
     */
    public function store(array $data): Comment
    {
        return $this->comment->create($data);
    }

    /**
     * @param array $data
     * @param int   $id
     *
     * @return bool
     */
    public function update(array $data, int $id): bool
    {
        return $this->comment->where('id', $id)->update($data);
    }

    /**
     * @param array|int $ids
     *
     * @return int
     */
    public function destroy($ids): int
    {
        return $this->comment->destroy($ids);
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
            return $this->comment->onlyTrashed()->where($where)->paginate($perPage, $columns, 'page', $page);
        }

        return $this->comment->where($where)->paginate($perPage, $columns, 'page', $page);
    }

    /**
     * @param       $ids
     * @param array $columns
     *
     * @return mixed
     */
    public function find($ids, $columns = ['*'])
    {
        return $this->comment->findOrFail($ids, $columns);
    }

    /**
     * @param array $ids
     *
     * @return bool|null
     */
    public function restore(array $ids)
    {
        return $this->comment->withTrashed()->whereIn('id', $ids)->restore();
    }

    /**
     * @param array $ids
     *
     * @return mixed
     */
    public function forceDelete(array $ids)
    {
        return $this->comment->find($ids)->forceDelete();
    }
}
