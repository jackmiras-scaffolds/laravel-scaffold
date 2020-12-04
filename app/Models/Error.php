<?php

namespace App\Models;

use JsonSerializable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;

class Error implements Arrayable, Jsonable, JsonSerializable
{
    public int $code;
    public string $help;
    public string $message;

    public function __construct(int $code = 400, string $help = '', string $message = '')
    {
        $this->code = $code;
        $this->help = $help;
        $this->message = $message;
    }

    public function toJson($options = 0)
    {
        return (string) json_encode($this->jsonSerialize(), $options);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'help' => $this->help,
        ];
    }
}
