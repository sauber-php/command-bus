<?php

declare(strict_types = 1);

namespace Sauber\CommandBus;

use Sauber\Container\Container;
use Psr\Container\ContainerInterface;
use Sauber\CommandBus\Contracts\HandlerContract;
use Sauber\CommandBus\Contracts\DispatchContract;
use Sauber\CommandBus\Exceptions\DispatchNotFound;

final class CommandBus
{
    /**
     * @param array<class-string,array<string,class-string>> $commands
     * @param array<class-string,array<string,class-string>> $queries
     * @param ContainerInterface $container
     */
    public function __construct(
        protected array $commands = [],
        protected array $queries = [],
        protected readonly ContainerInterface $container = new Container(),
    ) {
    }

    /**
     * @param class-string<DispatchContract> $command
     * @param class-string<HandlerContract> $handler
     * @return void
     */
    public function command(string $command, string $handler): void
    {
        $this->commands[$command] = [
            'handler' => $handler,
        ];
    }

    /**
     * @param class-string<DispatchContract> $query
     * @param class-string<HandlerContract> $handler
     * @return void
     */
    public function query(string $query, string $handler): void
    {
        $this->queries[$query] = [
            'handler' => $handler,
        ];
    }

    public function dispatch(DispatchContract $event): mixed
    {
        $name = $event::class;

        if (! $this->registered(name: $name)) {
            throw new DispatchNotFound(message: "Could not dispatch [{$name}::class] as it has not been registered.", code: 404, );
        }

        $class = $this->commands[$name] ?? $this->queries[$name];

        /**
         * @var HandlerContract $class
         */
        $class = $this->container->get(
            id: $class['handler'],
        );

        return $class->handle(
            event: $event,
        );
    }

    /**
     * @param string $name
     * @return bool
     */
    public function registered(string $name): bool
    {
        return array_key_exists(
            key: $name,
            array: array_merge($this->commands(), $this->queries())
        );
    }

    /**
     * @return array<class-string,array<string,class-string>>
     */
    public function commands(): array
    {
        return $this->commands;
    }

    /**
     * @return array<class-string,array<string,class-string>>
     */
    public function queries(): array
    {
        return $this->queries;
    }
}
