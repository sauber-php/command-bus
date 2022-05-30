<?php

declare(strict_types=1);

namespace Sauber\CommandBus\Tests\Fixtures;

use Sauber\CommandBus\Contracts\DispatchContract;
use Sauber\CommandBus\Contracts\HandlerContract;

final class TestQueryHandler implements HandlerContract
{
    public function handle(DispatchContract $event): mixed
    {
        return $event->name;
    }
}
