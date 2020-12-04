<?php
/**
 * File: OptionController.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/12/10 3:49 下午
 * Description:
 */

namespace Admin\Controllers\Blogs;


use App\Http\Controllers\Controller;
use App\Repositories\Blog\OptionRepository;

class OptionController extends Controller
{
    protected $optionRepository;

    public function __construct(OptionRepository $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }

    public function index()
    {
        return 'ddd';
    }
}
