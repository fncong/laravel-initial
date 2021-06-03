<?php


namespace App\Http\Validators;


use App\Exceptions\ValidatorSceneNotFoundExException;
use Illuminate\Support\Str;

abstract class BaseValidator implements ValidatorInterface
{
    public $scenes = [];

    /**
     * @param $scene
     * @return array
     * @throws ValidatorSceneNotFoundExException
     */
    public function scenes($scene)
    {
        $ret_rule = [];
        if (array_key_exists($scene, $this->scenes)) {
            $scene_rules = $this->scenes[$scene];
            foreach ($scene_rules as $scene_rule) {
                foreach ($this->rules() as $key => $rule) {
                    if ($scene_rule === $key) {
                        $ret_rule[$key] = $rule;
                    }
                }
            }
            return $ret_rule;
        }

        $scene_name = 'scene' . Str::studly($scene);
        if (!method_exists($this, $scene_name)) {
            throw new ValidatorSceneNotFoundExException($scene . '验证场景不存在');
        }
        $ret_rule = $this->$scene_name();
        return $ret_rule;
    }

    public function only(array $rules)
    {
        foreach ($rules as $scene_rule) {
            foreach ($this->rules() as $key => $rule) {
                if ($scene_rule === $key) {
                    $ret_rule[$key] = $rule;
                }
            }
        }
        return $ret_rule;
    }
}
