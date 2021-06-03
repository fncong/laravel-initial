<?php

namespace Fncong\LaravelInitial\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;

class GeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'fncong:generator {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成文件';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $model = $this->argument('model');

        $this->info('Enum 生成');
        $namespace_enum = new PhpNamespace('App\\Http\\Enums');
        $enum_class = new ClassType($model . 'Enum');
        $enum_class->setFinal();
        $enum_class->addProperty('attr', [])->setStatic();
        $namespace_enum->add($enum_class);
        $file_name = 'Http/Enums/' . $model . 'Enum.php';
        $this->put($file_name, $namespace_enum);

        return 0;
    }

    private function put($file_name, $namespace)
    {
        $file_head = "<?php\n\n";

        $ret = Storage::disk('generator')->exists($file_name);

        if ($ret) {
            if ($this->confirm('已存在，是否要强制替换')) {
                var_dump($file_name);
//                file_put_contents()
//                Storage::disk('generator')->put($file_name, $file_head . $namespace);
                $this->info('创建成功');
            } else {
                $this->warn('放弃替换');
            }
        } else {
//            Storage::disk('generator')->put($file_name, $file_head . $namespace);
            $this->info('创建成功');
        }
    }
}
