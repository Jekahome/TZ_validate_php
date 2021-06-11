<?php
declare(strict_types=1);

namespace App\Validate\Filters;

use App\Validate\AbstractValidator;
use App\Validate\ReturnValue;

class BuildFilter implements IBuildFilter
{
    private string $name;
    private string $error;
    private string $success;
    private array $callback;

    public function __construct(string $name, string $error = "", string $success = "")
    {
        $this->name = $name;
        $this->error = $error;
        $this->success = $success;
        $this->callback = [];
    }

    public function addwork(callable $userCallback)
    {
        array_push($this->callback, function (AbstractValidator $worker) use ($userCallback):ReturnValue {
            if ($userCallback($worker)) {
                return new ReturnValue(true, $this->success);
            }
            return new ReturnValue(false, $this->error);
        });
    }

    public function getName():string
    {
        return $this->name;
    }
    public function getCallback():array
    {
        return $this->callback;
    }
}