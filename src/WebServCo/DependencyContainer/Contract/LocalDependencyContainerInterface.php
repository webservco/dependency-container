<?php

declare(strict_types=1);

namespace WebServCo\DependencyContainer\Contract;

/**
 * Local (project specific) dependency container.
 *
 * Does not specify any methods and no implementation provided.
 * Should be extended and implemented locally at project / module / controller level as needed.
 */
interface LocalDependencyContainerInterface extends DependencyContainerInterface
{
}
