<?php

declare(strict_types=1);

namespace WebServCo\DependencyContainer\Contract;

use WebServCo\Data\Contract\Extraction\DataExtractionContainerInterface;
use WebServCo\Http\Contract\Message\Request\Container\RequestServiceContainerInterface;
use WebServCo\Http\Contract\Message\Response\Container\ResponseServiceContainerInterface;

/**
 * General application level dependency container.
 *
 * Common for all projects using this component.
 * Implementation also provided.
 */
interface ApplicationDependencyContainerInterface extends DependencyContainerInterface
{
    public function getDataExtractionContainer(): DataExtractionContainerInterface;

    public function getFactoryContainer(): FactoryContainerInterface;

    public function getRequestServiceContainer(): RequestServiceContainerInterface;

    public function getResponseServiceContainer(): ResponseServiceContainerInterface;

    public function getServiceContainer(): ServiceContainerInterface;
}
