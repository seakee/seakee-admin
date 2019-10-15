<?php
/**
 * File: FileController.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/10/15 11:47 上午
 * Description:
 */

namespace Admin\Controllers\Commons;


use Admin\Requests\Commons\FileRequest;
use App\Http\Controllers\Controller;
use App\Services\Common\FileService;

class FileController extends Controller
{
    /**
     * @var FileService
     */
    protected $fileService;

    /**
     * FileController constructor.
     *
     * @param FileService $fileService
     */
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Upload avatar
     *
     * @param FileRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function avatar(FileRequest $request)
    {
        $this->fileService->setDisk(config('admin.storage.public'));

        $path = $this->fileService->uploadFile('avatar', $request->file('avatar'));

        return json_response(200, 'success', $path);
    }
}
