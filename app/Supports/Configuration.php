<?php
/**
 * File: Configuration.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top
 * Date: 2019/9/26 3:42 下午
 * Description:
 */

namespace App\Supports;

use Illuminate\Config\Repository;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Config\Repository as RepositoryContract;

class Configuration
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * 应用配置文件名称
     */
    const CONFIG_FILE = '.config.yml';

    /**
     * Configuration constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app   = $app;
        $this->files = new Filesystem();
    }

    /**
     * 应用配置文件完整路径
     *
     * @return string
     */
    protected function configFilePath(): string
    {
        return $this->app->environmentPath() . DIRECTORY_SEPARATOR . self::CONFIG_FILE;
    }

    /**
     * @return RepositoryContract
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getConfiguration(): RepositoryContract
    {
        $items = [];
        if ($this->files->exists($file = $this->configFilePath())) {
            $items = $this->app->make(Parser::class)->parse($this->files->get($file)) ?: $items;
        }

        return new Repository($items);
    }

    /**
     * @return array
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getAppConfig(): array
    {
        return $this->parse($this->getConfiguration()->all());
    }

    /**
     * @param      $key
     * @param null $value
     *
     * @return RepositoryContract
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function set($key, $value = null): RepositoryContract
    {
        $config = $this->getConfiguration();

        if (is_array($key)){
            array_mds_merge($key, $config->all());
        }

        $config->set($key, $value);
        // Perform the configuration save operation.
        $this->save($config);

        return $config;
    }

    /**
     * @param RepositoryContract $config
     */
    public function save(RepositoryContract $config)
    {
        $target = dirname($this->configFilePath());
        if (!$this->files->isDirectory($target)) {
            $this->files->makeDirectory($target, 0755, true);
        }

        $this->files->put($this->configFilePath(), $this->app->make(Dumper::class)->dump($config->all(), 10));
    }

    /**
     * Converts a multidimensional array to a basic array of point divisions.
     *
     * @param array  $target 目标数组
     * @param string $pre 数组前缀
     * @param array  $org 原始数组
     *
     * @return array
     */
    protected function parse(array $target, string $pre = '', array $org = []): array
    {
        if (!is_array($target)) {
            return [];
        }

        foreach ($target as $key => $value) {
            $key   = $pre ? $pre . '.' . $key : $key;
            $value = value($value);

            if (is_array($value) || (is_object($value) && $value = (array)$value)) {
                $org = $this->parse($value, $key, $org);
                continue;
            }

            $org[$key] = $value;
        }

        return $org;
    }
}
