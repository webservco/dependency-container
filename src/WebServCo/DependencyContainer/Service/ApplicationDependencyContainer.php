<?php

declare(strict_types=1);

namespace WebServCo\DependencyContainer\Service;

use WebServCo\Configuration\Factory\ServerConfigurationGetterFactory;
use WebServCo\Data\Contract\Extraction\DataExtractionContainerInterface;
use WebServCo\Data\Factory\Extraction\DataExtractionContainerFactory;
use WebServCo\DependencyContainer\Contract\ApplicationDependencyContainerInterface;
use WebServCo\DependencyContainer\Contract\FactoryContainerInterface;
use WebServCo\DependencyContainer\Contract\ServiceContainerInterface;
use WebServCo\DependencyContainer\Factory\FactoryContainerFactory;
use WebServCo\Http\Container\Message\Request\RequestServiceContainer;
use WebServCo\Http\Container\Message\Response\ResponseServiceContainer;
use WebServCo\Http\Contract\Message\Request\Container\RequestServiceContainerInterface;
use WebServCo\Http\Contract\Message\Response\Container\ResponseServiceContainerInterface;
use WebServCo\Log\Factory\ContextFileLoggerFactory;
use WebServCo\Stopwatch\Contract\LapTimerInterface;

use function rtrim;
use function sprintf;

use const DIRECTORY_SEPARATOR;

/**
 * A simple opinionated Application dependency container
 *
 * PHPMD error CouplingBetweenObjects could be solved by using only implementations and not also interfaces.
 *
 * @todo solve CouplingBetweenObjects
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
final class ApplicationDependencyContainer implements ApplicationDependencyContainerInterface
{
    private ?DataExtractionContainerInterface $dataExtractionContainer = null;
    private ?FactoryContainerInterface $factoryContainer = null;

    private ?RequestServiceContainerInterface $requestServiceContainer = null;

    private ?ResponseServiceContainerInterface $responseServiceContainer = null;

    private ?ServiceContainerInterface $serviceContainer = null;

    public function __construct(private string $projectPath, private LapTimerInterface $lapTimer)
    {
        // Make sure path contains trailing slash (trim + add back).
        $this->projectPath = rtrim($this->projectPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    public function getDataExtractionContainer(): DataExtractionContainerInterface
    {
        if ($this->dataExtractionContainer === null) {
            $dataExtractionContainerFactory = new DataExtractionContainerFactory();
            $this->dataExtractionContainer = $dataExtractionContainerFactory->createDataExtractionContainer(true);
        }

        return $this->dataExtractionContainer;
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

    public function getRequestServiceContainer(): RequestServiceContainerInterface
    {
        if ($this->requestServiceContainer === null) {
            $this->requestServiceContainer = new RequestServiceContainer();
        }

        return $this->requestServiceContainer;
    }

    public function getResponseServiceContainer(): ResponseServiceContainerInterface
    {
        if ($this->responseServiceContainer === null) {
            $this->responseServiceContainer = new ResponseServiceContainer();
        }

        return $this->responseServiceContainer;
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
