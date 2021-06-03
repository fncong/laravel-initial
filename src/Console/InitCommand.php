<?php

namespace Fncong\LaravelInitial\Console;

use Illuminate\Console\Command;
use Nette\Utils\FileSystem;

class InitCommand extends Command
{
    use BaseTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'fncong:initial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '初始化目录';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->initialDirs();
        $this->file();
        return 0;
    }

    public function initialDirs()
    {
        $dirs = ['Http/Enums', 'Http/Services', 'Http/Validators', 'Http/Controllers/Api', 'Http/Controllers/Admin', 'Libraries'];
        foreach ($dirs as $index => $dir) {
            $concurrentDirectory = app_path($dir);
            if (is_dir($concurrentDirectory)) {
                $this->output->warning($concurrentDirectory . ' 目录已经存在');
            } else {
                if (!mkdir($concurrentDirectory) && !is_dir($concurrentDirectory)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
                }
                $this->output->success($concurrentDirectory . ' 已经创建');
            }
        }
    }

    public function file()
    {
        FileSystem::copy(base_path('vendor/fncong/laravel-initial/src') . '/Validators/ValidatorInterface.php', app_path('Http/Validators') . '/ValidatorInterface.php');
        FileSystem::copy(base_path('vendor/fncong/laravel-initial/src') . '/Validators/BaseValidator.php', app_path('Http/Validators') . '/BaseValidator.php');
        FileSystem::copy(base_path('vendor/fncong/laravel-initial/src') . '/Services/BaseService.php', app_path('Http/Services') . '/BaseService.php');


        FileSystem::copy(base_path('vendor/fncong/laravel-initial/src') . '/Exceptions/AppException.php', app_path('Exceptions') . '/AppException.php');
        FileSystem::copy(base_path('vendor/fncong/laravel-initial/src') . '/Exceptions/ClassNotFoundException.php', app_path('Exceptions') . '/ClassNotFoundException.php');
        FileSystem::copy(base_path('vendor/fncong/laravel-initial/src') . '/Exceptions/InvalidAcceptException.php', app_path('Exceptions') . '/InvalidAcceptException.php');
        FileSystem::copy(base_path('vendor/fncong/laravel-initial/src') . '/Exceptions/ServiceException.php', app_path('Exceptions') . '/ServiceException.php');
        FileSystem::copy(base_path('vendor/fncong/laravel-initial/src') . '/Exceptions/ServiceUnavailableException.php', app_path('Exceptions') . '/ServiceUnavailableException.php');
        FileSystem::copy(base_path('vendor/fncong/laravel-initial/src') . '/Exceptions/UnauthenticatedException.php', app_path('Exceptions') . '/UnauthenticatedException.php');
        FileSystem::copy(base_path('vendor/fncong/laravel-initial/src') . '/Exceptions/ValidatorSceneNotFoundExException.php', app_path('Exceptions') . '/ValidatorSceneNotFoundExException.php');
        FileSystem::copy(base_path('vendor/fncong/laravel-initial/src') . '/Exceptions/ValidatorException.php', app_path('Exceptions') . '/ValidatorException.php');

//        $interface = $this->validatorInterface();
//        $file_name = '/Http/Validators/ValidatorInterface.php';
//        $this->put($file_name, $interface);
    }
}
