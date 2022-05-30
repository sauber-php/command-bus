<?php

declare(strict_types=1);

use Sauber\CommandBus\CommandBus;
use Sauber\CommandBus\Exceptions\DispatchNotFound;
use Sauber\CommandBus\Tests\Fixtures\TestCommand;
use Sauber\CommandBus\Tests\Fixtures\TestCommandHandler;
use Sauber\CommandBus\Tests\Fixtures\TestQuery;
use Sauber\CommandBus\Tests\Fixtures\TestQueryHandler;

it('can create a new command bus with empty params', function () {
    expect(
        new CommandBus(),
    )->toBeInstanceOf(
        CommandBus::class
    )->commands()->toBeArray()->toBeEmpty();
});

it('can register commands', function () {
    $bus = new CommandBus();

    expect(
        $bus->commands(),
    )->toBeEmpty()->toBeArray();

    $bus->command(
        command: TestCommand::class,
        handler: TestCommandHandler::class,
    );

    expect(
        $bus->commands(),
    )->toBeArray()->toEqual([
        TestCommand::class => [
            'handler' => TestCommandHandler::class,
        ]
    ]);
});

it('can register queries', function () {
    $bus = new CommandBus();

    expect(
        $bus->queries(),
    )->toBeEmpty()->toBeArray();

    $bus->query(
        query: TestQuery::class,
        handler: TestQueryHandler::class,
    );

    expect(
        $bus->queries(),
    )->toBeArray()->toEqual([
        TestQuery::class => [
            'handler' => TestQueryHandler::class,
        ]
    ]);
});

it('can check if a command or query has been registered', function () {
    $bus = new CommandBus();

    expect(
        $bus->registered(
            name: TestCommand::class,
        ),
    )->toBeBool()->toBeFalse();

    $bus->command(
        command: TestCommand::class,
        handler: TestCommandHandler::class,
    );

    expect(
        $bus->registered(
            name: TestCommand::class,
        ),
    )->toBeBool()->toBeTrue()
        ->and(
            $bus->registered(
                name: TestQuery::class,
            ),
        )->toBeBool()->toBeFalse();

    $bus->query(
        query: TestQuery::class,
        handler: TestQueryHandler::class,
    );

    expect(
        $bus->registered(
            name: TestQuery::class,
        ),
    )->toBeBool()->toBeTrue();
});

it('can dispatch a command', function () {
    $bus = new CommandBus();

    $bus->command(
        command: TestCommand::class,
        handler: TestCommandHandler::class
    );

    expect(
        $bus->dispatch(new TestCommand()),
    )->toBeString()->toEqual('test');
});

it('can dispatch a query', function () {
    $bus = new CommandBus();

    $bus->query(
        query: TestQuery::class,
        handler: TestQueryHandler::class
    );

    expect(
        $bus->dispatch(new TestQuery()),
    )->toBeString()->toEqual('test');
});

it('throws a dispatch not found if not registered', function () {
    $bus = new CommandBus();

    $bus->dispatch(
        event: new TestCommand(),
    );
})->throws(DispatchNotFound::class);
