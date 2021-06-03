<?php

namespace App\Http\Services;

use App\Exceptions\ServiceException;

abstract class BaseService
{
    private $message;


    /**
     * @param $msg
     * @param bool $data
     * @param int $code
     * @throws ServiceException
     */
    protected function failure($msg, $data = [], $code = 0): void
    {
        $exception = new ServiceException($msg, $code);
        $exception->setData($data);
        throw $exception;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }
}
