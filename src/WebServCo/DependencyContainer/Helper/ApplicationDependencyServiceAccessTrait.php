<?php

declare(strict_types=1);

namespace WebServCo\DependencyContainer\Helper;

use Psr\Log\LoggerInterface;
use WebServCo\Command\Contract\OutputInterface;
use WebServCo\Configuration\Contract\ConfigurationGetterInterface;
use WebServCo\DependencyContainer\Contract\ApplicationDependencyContainerInterface;
use WebServCo\Stopwatch\Contract\LapTimerInterface;

/**
 * Convenience trait for less code writing.
 */
trait ApplicationDependencyServiceAccessTrait
{
    protected ApplicationDependencyContainerInterface $applicationDependencyContainer;

    public function getConfigurationGetter(): ConfigurationGetterInterface
    {
        return $this->applicationDependencyContainer->getServiceContainer()->getConfigurationGetter();
    }

    public function getLapTimer(): LapTimerInterface
    {
        return $this->applicationDependencyContainer->getServiceContainer()->getLapTimer();
    }

    public function getLogger(string $channel): LoggerInterface
    {
        return $this->applicationDependencyContainer->getServiceContainer()->getLogger($channel);
    }

    public function getOutputService(string $channel): OutputInterface
    {
        return $this->applicationDependencyContainer->getServiceContainer()->getOutputService($channel);
    }
}
