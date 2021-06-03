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
        $this->initialDirs();
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
}
