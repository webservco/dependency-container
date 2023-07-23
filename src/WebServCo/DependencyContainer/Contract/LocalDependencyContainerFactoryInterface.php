<?php

declare(strict_types=1);

namespace WebServCo\DependencyContainer\Contract;

interface LocalDependencyContainerFactoryInterface
{
    public function createLocalDependencyContainer(): LocalDependencyContainerInterface;
}
