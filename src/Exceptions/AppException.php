<?php


namespace App\Exceptions;


use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppException extends Exception
{
    private $data = [];

    public function render($request): JsonResponse
    {
        return failure($this->getMessage(), $this->getData(), $this->getCode());
    }

    public function getData()
    {
        return $this->data;
    }


    public function setData($data): void
    {
        $this->data = $data;
    }

}
