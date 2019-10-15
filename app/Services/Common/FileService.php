<?php
/**
 * File: FileService.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/10/15 10:41 上午
 * Description:
 */

namespace App\Services\Common;


use Storage;

class FileService
{
    /**
     * Disk Instances
     *
     * @var string
     */
    protected $disk;

    /**
     * Prefix Path
     *
     * @var string
     */
    protected $prefixPath;

    /**
     * FileService constructor.
     */
    public function __construct()
    {
        $this->setDisk();
    }

    /**
     * @return string
     */
    public function getDisk(): string
    {
        return $this->disk;
    }

    /**
     * @param string $disk
     */
    public function setDisk(string $disk = ''): void
    {
        $this->disk = $disk ?: config('filesystems.default');
    }

    /**
     * @return string
     */
    public function getPrefixPath(): string
    {
        return $this->prefixPath;
    }

    /**
     * @param string $prefixPath
     */
    public function setPrefixPath(string $prefixPath = ''): void
    {
        $this->prefixPath = $prefixPath;
    }

    /**
     * Storing Files By Contents Or Resource
     *
     * @param $path
     * @param $contents
     *
     * @return string
     */
    public function uploadContents($path, $contents)
    {
        $rs = Storage::disk($this->disk)->put($this->prefixPath . $path, $contents);

        return $rs ? $path : '';
    }

    /**
     * Storing Files By File Streaming
     *
     * @param $path
     * @param $file
     *
     * @return mixed
     */
    public function uploadFile($path, $file)
    {
        return Storage::disk($this->disk)->putFile($this->prefixPath . $path, $file);
    }
}
