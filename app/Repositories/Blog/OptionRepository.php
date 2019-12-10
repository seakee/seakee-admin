<?php
/**
 * File: OptionRepository.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/12/10 11:03 上午
 * Description:
 */

namespace App\Repositories\Blog;


use App\Models\Blog\Option;
use Illuminate\Support\Collection;

class OptionRepository
{
    /**
     * @var Option
     */
    protected $option;

    /**
     * OptionRepository constructor.
     *
     * @param Option $option
     */
    public function __construct(Option $option)
    {
        $this->option =$option;
    }

    /**
     * @return Option
     */
    public function getOption(): Option
    {
        return $this->option;
    }

    /**
     * @param Option $option
     */
    public function setOption(Option $option): void
    {
        $this->option = $option;
    }

    /**
     * @param array $data
     *
     * @return Option
     */
    public function store(array $data): Option
    {
        return $this->option->create($data);
    }

    /**
     * @param array $data
     * @param int   $id
     *
     * @return bool
     */
    public function update(array $data, int $id): bool
    {
        return $this->option->where('id', $id)->update($data);
    }

    /**
     * @param array|int $ids
     *
     * @return int
     */
    public function destroy($ids): int
    {
        return $this->option->destroy($ids);
    }

    /**
     * @param       $ids
     * @param array $columns
     *
     * @return mixed
     */
    public function find($ids, $columns = ['*'])
    {
        return $this->option->findOrFail($ids, $columns);
    }

    /**
     * @return Collection
     */
    public function list(): Collection
    {
        return $this->option->get(['name', 'value']);
    }
}
