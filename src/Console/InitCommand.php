<?php

namespace Fncong\LaravelInitial\Console;

use Illuminate\Console\Command;

class InitCommand extends Command
{
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
        if (!mkdir($concurrentDirectory = app_path("Http/Enums")) && !is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }
        if (!mkdir($concurrentDirectory = app_path("Http/Services")) && !is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }
        if (!mkdir($concurrentDirectory = app_path("Http/Validators")) && !is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }
        if (!mkdir($concurrentDirectory = app_path("Http/Controllers/Api")) && !is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }
        if (!mkdir($concurrentDirectory = app_path("Http/Controllers/Admin")) && !is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }
        if (!mkdir($concurrentDirectory = app_path('Libraries')) && !is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }

        return 0;
    }
}
