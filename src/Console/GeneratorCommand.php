<?php

namespace Fncong\LaravelInitial\Console;

use App\Http\Controllers\Controller;
use App\Http\Validators\BaseValidator;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;
use Nette\Utils\FileSystem;

class GeneratorCommand extends Command
{
    use BaseTrait;

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

    private $model = '';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->model = $this->argument('model');

        $this->enum();
        $namespace_validator = $this->validator();
        $namespace_service = $this->apiService();
        $admin_namespace_service = $this->adminService();

        $this->apiController($namespace_service, $namespace_validator);
        $this->adminController($admin_namespace_service, $namespace_validator);
        return 0;
    }

    public function apiController($namespace_service, $namespace_validator)
    {
        $this->info('ApiController 生成');
        $namespace_controller = new PhpNamespace("App\\Http\\Controllers\\Api");
        $namespace_controller->addUse(Controller::class);
        $namespace_controller->addUse(Request::class);

        $controller_class = new ClassType($this->model . 'Controller');
        $controller_class->addExtend(Controller::class);


        $con_method = $controller_class->addMethod('__construct');
        $con_method->addParameter('request')->setType(Request::class);
        $con_method->setBody('parent::__construct($request);
$this->middleware(\'auth:sanctum\');
');


        $index_method = $controller_class->addMethod('index');
        $store_body = '$params = $this->request->only([]);
$this->validator(' . $this->model . 'Validator::class, $params, "api-index");
return success("", $service->index($params));
';
        $index_method->setBody($store_body);
        $index_method->addParameter('service')->setType($namespace_service->getName() . '\\' . $this->model . 'Service');

        $show_method = $controller_class->addMethod('show');
        $show_method->addParameter('service')->setType($namespace_service->getName() . '\\' . $this->model . 'Service');
        $show_method->addParameter('id');
        $show_method->setBody('return success(\'\', $service->show($id));');

        $namespace_controller->add($controller_class);
        $namespace_controller->addUse($namespace_service->getName() . '\\' . $this->model . 'Service');
        $namespace_controller->addUse($namespace_validator->getName() . '\\' . $this->model . 'Validator');
        $file_name = "Http/Controllers/Api/{$this->model}Controller.php";
        $this->put($file_name, $namespace_controller);

    }

    public function adminController($namespace_service, $namespace_validator)
    {
        $this->info('AdminController 生成');
        $namespace_controller = new PhpNamespace("App\\Http\\Controllers\\Admin");
        $namespace_controller->addUse(Controller::class);
        $namespace_controller->addUse(Request::class);

        $controller_class = new ClassType($this->model . 'Controller');
        $controller_class->addExtend(Controller::class);


        $con_method = $controller_class->addMethod('__construct');
        $con_method->addParameter('request')->setType(Request::class);
        $con_method->setBody('parent::__construct($request);
$this->middleware(\'auth:sanctum\');
');


        $index_method = $controller_class->addMethod('index');
        $store_body = '$params = $this->request->only([]);
$this->validator(' . $this->model . 'Validator::class, $params, "api-index");
return success(\'ok\', $service->index($params));
';
        $index_method->setBody($store_body);
        $index_method->addParameter('service')->setType($namespace_service->getName() . '\\' . $this->model . 'Service');

        $show_method = $controller_class->addMethod('show');
        $show_method->addParameter('service')->setType($namespace_service->getName() . '\\' . $this->model . 'Service');
        $show_method->addParameter('id');
        $show_method->setBody('return success(\'ok\', $service->show($id));');

        $create_method = $controller_class->addMethod('create');
        $create_method->addParameter('service')->setType($namespace_service->getName() . '\\' . $this->model . 'Service');

        $store_method = $controller_class->addMethod('store');
        $store_body = '$params = $this->request->only([]);
$this->validator(' . $this->model . 'Validator::class, $params, \'store\');
return success(\'新增成功\', $service->store($params));
';
        $store_method->setBody($store_body);
        $store_method->addParameter('service')
            ->setType($namespace_service->getName() . '\\' . $this->model . 'Service');


        $edit_method = $controller_class->addMethod('edit');
        $edit_method->addParameter('service')->setType($namespace_service->getName() . '\\' . $this->model . 'Service');

        $update_method = $controller_class->addMethod('update');
        $update_body = '$params = $this->request->only([]);
$this->validator(' . $this->model . 'Validator::class, $params, \'update\');
return success(\'修改成功\', $service->update($id,$params));
';
        $update_method->setBody($update_body);
        $update_method->addParameter('service')->setType($namespace_service->getName() . '\\' . $this->model . 'Service');
        $update_method->addParameter('id');


        $destroy_body = 'return success(\'删除成功\', $service->destroy($id));';
        $destroy_method = $controller_class->addMethod('destroy');
        $destroy_method->setBody($destroy_body);
        $destroy_method->addParameter('service')->setType($namespace_service->getName() . '\\' . $this->model . 'Service');
        $destroy_method->addParameter('id');

        $namespace_controller->add($controller_class);
        $namespace_controller->addUse($namespace_service->getName() . '\\' . $this->model . 'Service');
        $namespace_controller->addUse($namespace_validator->getName() . '\\' . $this->model . 'Validator');
        $file_name = "Http/Controllers/Admin/{$this->model}Controller.php";
        $this->put($file_name, $namespace_controller);

    }

    public function apiService()
    {
        $this->info('ApiService 生成');
        $namespace_service = new PhpNamespace("App\\Http\\Services\\Api");
        $class = new ClassType($this->model . 'Service');
        $class->addExtend("App\\Http\\Services\\BaseService");
        $namespace_service->addUse("App\\Models\\{$this->model}");
        $namespace_service->add($class);
        $namespace_service->addUse("App\\Http\\Services\\BaseService");

        $method = $class->addMethod('index');
        $method->addParameter('params')->setType('array');
        $method->addBody("return {$this->model}::query()->orderByDesc('id')->paginate();");


        $method = $class->addMethod('show');
        $method->addParameter('id');
        $method->addBody("return {$this->model}::query()->where('id',\$id)->firstOrFail();");


        $file_name = "Http/Services/Api/{$this->model}Service.php";
        $this->put($file_name, $namespace_service);
        return $namespace_service;
    }

    public function adminService()
    {
        $this->info('AdminService 生成');
        $namespace_service = new PhpNamespace("App\\Http\\Services\\Admin");
        $class = new ClassType($this->model . 'Service');
        $class->addExtend("App\\Http\\Services\\BaseService");
        $namespace_service->addUse("App\\Models\\{$this->model}");
        $namespace_service->add($class);
        $namespace_service->addUse("App\\Http\\Services\\BaseService");

        $method = $class->addMethod('index');
        $method->addParameter('params')->setType('array');
        $method->addBody("return {$this->model}::query()->orderByDesc('id')->paginate();");


        $method = $class->addMethod('show');
        $method->addParameter('id');
        $method->addBody("return {$this->model}::query()->where('id',\$id)->firstOrFail();");

        $method = $class->addMethod('store');
        $method->addParameter('params')->setType('array');
        $method->addBody("return true;");

        $method = $class->addMethod('update');
        $method->addParameter('id');
        $method->addParameter('params')->setType('array');
        $method->addBody("return {$this->model}::query()->create(\$params);");

        $method = $class->addMethod('destroy');
        $method->addParameter('id');
        $method->addBody("return true;");

        $file_name = "Http/Services/Admin/{$this->model}Service.php";
        $this->put($file_name, $namespace_service);
        return $namespace_service;
    }

    public function validator()
    {
        $this->info('Validator 生成');
        $table = Str::snake(Str::pluralStudly($this->model));
        $builder = Db::getSchemaBuilder();
        $table_columns = $builder->getColumnListing($table);
        $message = [];
        $rule = [];
        foreach ($table_columns as $index => $item) {
            if (!in_array($item, ['id', 'created_at', 'updated_at'])) {
                $message[$item] = $rule[$item] = '';
            }
        }

        $namespace_validator = new PhpNamespace('App\\Http\\Validators');
        $validator_class = new ClassType("{$this->model}Validator");
        $validator_class->setFinal();
        $validator_class->addExtend(BaseValidator::class);

        $validator_class->addProperty('scenes', ['admin-index' => [], 'admin-store' => [], 'admin-update' => []]);

        $rules_method = $validator_class->addMethod('rules')->setReturnType('array');
        $rules_method->setBody("return ?;", [$rule]);

        $message_method = $validator_class->addMethod('messages')->setReturnType('array');;
        $message_method->setBody("return ?;", [$message]);

        $attributes_method = $validator_class->addMethod('attributes')->setReturnType('array');;
        $attributes_method->setBody("return [];");

        $namespace_validator->add($validator_class);
        $file_name = "Http/Validators/{$this->model}Validator.php";
        $this->put($file_name, $namespace_validator);
        return $namespace_validator;
    }

    public function enum()
    {
        $this->info('Enum 生成');
        $namespace_enum = new PhpNamespace('App\\Http\\Enums');
        $enum_class = new ClassType($this->model . 'Enum');
        $enum_class->setFinal();
        $enum_class->addProperty('attr', [])->setStatic();
        $namespace_enum->add($enum_class);
        $file_name = 'Http/Enums/' . $this->model . 'Enum.php';
        $this->put($file_name, $namespace_enum);
    }


}
