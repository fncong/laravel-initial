<?php


namespace App\Exceptions;


use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UnauthenticatedException extends Exception
{
    public function render($request): JsonResponse
    {
        return failure($this->getMessage())->setStatusCode(401);
    }
}
