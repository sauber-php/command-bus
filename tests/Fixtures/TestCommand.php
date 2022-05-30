<?php

declare(strict_types=1);

namespace Sauber\CommandBus\Tests\Fixtures;

use Sauber\CommandBus\Contracts\DispatchContract;

final class TestCommand implements DispatchContract
{
    public function __construct(
        public readonly string $name = 'test',
    ) {}
}
