<?php

declare(strict_types=1);

namespace App\Validate\Filters;

interface IBuildFilter
{
    public function addWork(callable $user_callback);
    public function getName():string;
    public function getCallback():array;
}