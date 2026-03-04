<?php

namespace App\Application\Shared\Bus;

interface QueryBusInterface
{
    public function dispatch(object $query): mixed;
}
