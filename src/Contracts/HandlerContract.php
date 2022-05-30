<?php

declare(strict_types=1);

namespace Sauber\CommandBus\Contracts;

interface HandlerContract
{
    /**
     * @param DispatchContract $event
     * @return mixed
     */
    public function handle(DispatchContract $event): mixed;
}
