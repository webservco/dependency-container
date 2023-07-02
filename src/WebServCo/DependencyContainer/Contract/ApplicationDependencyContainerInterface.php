<?php

declare(strict_types=1);

namespace WebServCo\DependencyContainer\Contract;

interface ApplicationDependencyContainerInterface extends DependencyContainerInterface
{
    public function getFactoryContainer(): FactoryContainerInterface;

    public function getServiceContainer(): ServiceContainerInterface;
}
