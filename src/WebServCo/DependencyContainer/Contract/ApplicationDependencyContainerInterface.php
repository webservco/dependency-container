<?php

declare(strict_types=1);

namespace WebServCo\DependencyContainer\Contract;

/**
 * General application level dependency container.
 *
 * Common for all projects using this component.
 * Implementation also provided.
 */
interface ApplicationDependencyContainerInterface extends DependencyContainerInterface
{
    public function getFactoryContainer(): FactoryContainerInterface;

    public function getServiceContainer(): ServiceContainerInterface;
}
