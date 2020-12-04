<?php

namespace App\Exceptions;

use Exception;
use App\Models\Error;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

abstract class ApplicationException extends Exception
{
    abstract public function code(): int;

    abstract public function help(): string;

    abstract public function message(): string;

    /**
    * @SuppressWarnings(PHPMD.UnusedFormalParameter)
    */
    public function render(Request $request): Response
    {
        $error = new Error();
        $error->code = $this->code();
        $error->help = $this->help();
        $error->message = $this->message();

        return response($error->toJson(), $this->code());
    }
}
