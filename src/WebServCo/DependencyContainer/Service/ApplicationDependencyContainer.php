<?php

declare(strict_types=1);

namespace WebServCo\DependencyContainer\Service;

use WebServCo\Configuration\Factory\ServerConfigurationGetterFactory;
use WebServCo\DependencyContainer\Contract\ApplicationDependencyContainerInterface;
use WebServCo\DependencyContainer\Contract\FactoryContainerInterface;
use WebServCo\DependencyContainer\Contract\ServiceContainerInterface;
use WebServCo\DependencyContainer\Factory\FactoryContainerFactory;
use WebServCo\Log\Factory\ContextFileLoggerFactory;
use WebServCo\Stopwatch\Contract\LapTimerInterface;

use function rtrim;
use function sprintf;

use const DIRECTORY_SEPARATOR;

/**
 * A simple opinionated Application dependency container
 */
final class ApplicationDependencyContainer implements ApplicationDependencyContainerInterface
{
    private ?FactoryContainerInterface $factoryContainer = null;
    private ?ServiceContainerInterface $serviceContainer = null;

    public function __construct(private string $projectPath, private LapTimerInterface $lapTimer)
    {
        // Make sure path contains trailing slash (trim + add back).
        $this->projectPath = rtrim($this->projectPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    public function getFactoryContainer(): FactoryContainerInterface
    {
        if ($this->factoryContainer === null) {
            $factoryContainerFactory = new FactoryContainerFactory(
                new ContextFileLoggerFactory(sprintf('%s/var/log/', $this->projectPath)),
            );
            $this->factoryContainer = $factoryContainerFactory->createFactoryContainer();
        }

        return $this->factoryContainer;
    }

    public function getServiceContainer(): ServiceContainerInterface
    {
        if ($this->serviceContainer === null) {
            $this->serviceContainer = new ServiceContainer(
                new ServerConfigurationGetterFactory(),
                $this->lapTimer,
                $this->getFactoryContainer()->getLoggerFactory(),
                $this->getFactoryContainer()->getOutputFactory(),
            );
        }

        return $this->serviceContainer;
    }
}
