<?php

declare(strict_types=1);

namespace WebServCo\DependencyContainer\Contract;

use Psr\Log\LoggerInterface;
use WebServCo\Command\Contract\OutputInterface;
use WebServCo\Configuration\Contract\ConfigurationGetterInterface;
use WebServCo\Session\Contract\SessionServiceInterface;
use WebServCo\Stopwatch\Contract\LapTimerInterface;

interface ServiceContainerInterface extends DependencyContainerInterface
{
    public function getConfigurationGetter(): ConfigurationGetterInterface;

    public function getLapTimer(): LapTimerInterface;

    public function getLogger(string $channel): LoggerInterface;

    public function getOutputService(string $channel): OutputInterface;

    public function getSessionService(): SessionServiceInterface;
}
