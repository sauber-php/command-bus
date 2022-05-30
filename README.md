<a href="https://supportukrainenow.org/"><img src="https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/banner-direct.svg" width="100%"></a>

# Sauber Command Bus

<!-- BADGES_START -->
![GitHub release (latest by date)](https://img.shields.io/github/v/release/sauber-php/command-bus)
![Tests](https://github.com/sauber-php/command-bus/workflows/tests/badge.svg)
![Static Analysis](https://github.com/sauber-php/command-bus/workflows/static/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/sauber-php/command-bus.svg?style=flat-square)](https://packagist.org/packages/phpfox/container)
![GitHub](https://img.shields.io/github/license/sauber-php/command-bus)
<!-- BADGES_END -->

This is the repository for the Command Bus Component for the Sauber PHP Framework.

## Installation

You should not need to install this package directly, as it comes pre-installed with the `sauber-php/sauber` template
however if you want to use this on its own then please install this using composer:

```bash
composer require sauber-php/command-bus
```

## Usage

To create a new command bus, you can either pass it some default commands and queryies as well as a container,
as long as it implements the `ContainerInterface` PSR.

```php
use Sauber\CommandBus\CommandBus;
use Sauber\Container\Container;

$bus = new CommandBus(
    commands: [],
    queries: [],
    container: new Container(),
);
```

One thing to bear in mind, with static analysis, is that commands and their handlers implements a specific
interface that is typed. Please ensure that commands and queries both implements the `DispatchContract` as these
classes need to be dispatched, and the handlers must implement the `HandlerContract` also. This will not cause issues in registering commands
and queries (other than static analysis issues), but it will cause issues in dispatching commands and queries.

### Registering a Command and Dispatching it

```php
use Sauber\CommandBus\CommandBus;
use Sauber\CommandBus\Tests\Fixtures\TestCommand;
use Sauber\CommandBus\Tests\Fixtures\TestCommandHandler;

$bus = new CommandBus();

$bus->command(
    command: TestCommand::class,
    handler: TestCommandHandler::class,
);

$result = $bus->dispatch(
    event: new TestCommand(),
);

echo $result; // will echo 'test'.
```

### Registering a Query and dispatching it

```php
use Sauber\CommandBus\CommandBus;
use Sauber\CommandBus\Tests\Fixtures\TestQuery;
use Sauber\CommandBus\Tests\Fixtures\TestQueryHandler;

$bus = new CommandBus();

$bus->query(
    query: TestQuery::class,
    handler: TestQueryHandler::class,
);

$result = $bus->dispatch(
    event: new TestQuery(),
);

echo $result; // will echo 'test'.
```

## Testing

To run the tests:

```bash
./vendor/bin/pest
```

## Static Analysis

To check the static analysis:

```bash
./vendor/bin/phpstan analyse
```

## Changelog

Please see [the Changelog](CHANGELOG.md) for more information on what has changed recently.

