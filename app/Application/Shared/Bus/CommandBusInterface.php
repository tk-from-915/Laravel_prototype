<?php

namespace App\Application\Shared\Bus;

interface CommandBusInterface
{
    public function dispatch(object $command): mixed;
}
