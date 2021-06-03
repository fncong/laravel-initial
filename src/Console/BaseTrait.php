<?php


namespace Fncong\LaravelInitial\Console;


use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;
use Nette\Utils\FileSystem;

trait BaseTrait
{
    public function validatorInterface()
    {
        $interface = new PhpNamespace('App\\Http\\Validators');
        $validator_class = new ClassType("ValidatorInterface");
        $validator_class->setInterface();
        $interface->add($validator_class);

        $validator_class->addMethod('rules')->setReturnType('array')->setPublic();
        $validator_class->addMethod('scenes')->setPublic()->addParameter('scene');
        $validator_class->addMethod('messages')->setReturnType('array')->setPublic();
        $validator_class->addMethod('attributes')->setReturnType('array')->setPublic();

        return $interface;
    }

    private function put($file_name, $namespace)
    {
        $file_name = app_path('') . '/' . $file_name;


        $is_exists = file_exists($file_name);
        if ($is_exists) {
            if ($this->confirm('已存在，是否要强制替换')) {
                $this->file($file_name, $namespace);
                $this->info('创建成功');
            } else {
                $this->warn('放弃替换');
            }
        } else {
            $this->file($file_name, $namespace);
            $this->info('创建成功');
        }
    }

    private function file($file_name, $namespace)
    {
        $file = new PhpFile();
        $file->addNamespace($namespace);
        FileSystem::write($file_name, $file);
    }
}
