# webservco/dependency-container

A PHP component/library. Please see [webservco/sandbox](https://webservco.github.io/sandbox/) for an example project using these types of components.

Hand-wired containers that create the application's shared services when they're first needed.

- Requires: a writable `var/log/` directory in the project, configuration loaded with `webservco/configuration`
- Related: `webservco/controller` (passes the containers to every controller), `webservco/session`, `webservco/log`, `webservco/http` (services it creates)

---

## Installation

```shell
composer require webservco/dependency-container
```

---

## Usage

Create one application container in the entry point and pass it to the factories that need it.

```php
use WebServCo\DependencyContainer\Service\ApplicationDependencyContainer;

// \WebServCo\DependencyContainer\Contract\ApplicationDependencyContainerInterface
$applicationDependencyContainer = new ApplicationDependencyContainer($projectPath, $lapTimer);

$serviceContainer = $applicationDependencyContainer->getServiceContainer();
// \Psr\Log\LoggerInterface, written to var/log/
$logger = $serviceContainer->getLogger('application');
$host = $serviceContainer->getConfigurationGetter()->getString('DB_HOST');

$responseFactory = $applicationDependencyContainer->getFactoryContainer()->getResponseFactory();
$dataExtractionContainer = $applicationDependencyContainer->getDataExtractionContainer();
```

### Module containers

Module-specific services (database storage, form factories) go in your own container. It implements `LocalDependencyContainerInterface`, and a `LocalDependencyContainerFactoryInterface` creates it. Controllers receive it as their second constructor argument. See `src/Project/Factory/Container/` in the `webservco/sandbox` project.

---

## Contracts

| Interface | Implementation | Purpose |
| --- | --- | --- |
| `Contract\ApplicationDependencyContainerInterface` | `Service\ApplicationDependencyContainer` | Entry point to all the containers below. |
| `Contract\ServiceContainerInterface` | `Service\ServiceContainer` | Configuration getter, lap timer, loggers and output services by channel, session service. |
| `Contract\FactoryContainerInterface` | `Service\FactoryContainer` | Logger, output, PSR-17 response and stream factories. |
| `Contract\LocalDependencyContainerInterface` | your container | Module-specific dependencies. |
| `Contract\LocalDependencyContainerFactoryInterface` | your factory | Creates the module container. |

The application container also returns the data extraction container (`webservco/data`) and the request and response service containers (`webservco/http-request-service`, `webservco/http-response-service`). Namespaces are relative to `WebServCo\DependencyContainer\`.

---

## Notes

Nothing is created until something asks for it, and after that the same object comes back every time. Loggers and output services are cached per channel name.

The lap timer is passed in from outside because it should start before the container exists.

The session service reads the `COOKIE_*` and `SESSION_*` keys described in `webservco/session`. It's only created when you ask for it.

---

## Development

```shell
# Start project.
ddev start
# Install dependencies.
ddev c u
# Run all validations.
ddev c c
# Run unit tests.
ddev c test:dox
```

---

## License

[MIT](LICENSE.md)
