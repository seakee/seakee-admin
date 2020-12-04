<?php
/**
 * File: OptionService.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/12/13 10:19 上午
 * Description:
 */

namespace App\Services\Blog;


use App\Repositories\Blog\OptionRepository;

class OptionService
{
    protected $optionRepository;

    public function __construct(OptionRepository $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }

    /**
     * @return OptionRepository
     */
    public function getOptionRepository(): OptionRepository
    {
        return $this->optionRepository;
    }

    /**
     * @param OptionRepository $optionRepository
     */
    public function setOptionRepository(OptionRepository $optionRepository): void
    {
        $this->optionRepository = $optionRepository;
    }

    /**
     * @return array|mixed|null
     */
    public function all()
    {
        $tags = ['blog', 'options'];
        $options = cache_tags($tags, 'all');

        if (empty($options)){
            $options = $this->optionRepository->list()->toArray();
            cache_tags($tags, 'all', $options);
        }

        return response()->getCallback();
    }
}
