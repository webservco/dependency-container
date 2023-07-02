<?php

declare(strict_types=1);

namespace WebServCo\DependencyContainer\Service;

use Psr\Log\LoggerInterface;
use WebServCo\Command\Contract\OutputFactoryInterface;
use WebServCo\Command\Contract\OutputInterface;
use WebServCo\Configuration\Contract\ConfigurationGetterFactoryInterface;
use WebServCo\Configuration\Contract\ConfigurationGetterInterface;
use WebServCo\DependencyContainer\Contract\ServiceContainerInterface;
use WebServCo\Log\Contract\LoggerFactoryInterface;
use WebServCo\Stopwatch\Contract\LapTimerInterface;

use function array_key_exists;

/**
 * A container for service objects.
 */
final class ServiceContainer implements ServiceContainerInterface
{
    private ?ConfigurationGetterInterface $configurationGetter = null;

    /**
     * List of loggers.
     *
     * @var array<string,\Psr\Log\LoggerInterface>
     */
    private array $loggers = [];

    /**
     * List of output services.
     *
     * @var array<string,\WebServCo\Command\Contract\OutputInterface>
     */
    private array $outputServices = [];

    public function __construct(
        private ConfigurationGetterFactoryInterface $configurationGetterFactory,
        // LapTimerInterface not created here, so we can work with an already started timer.
        private LapTimerInterface $lapTimer,
        private LoggerFactoryInterface $loggerFactory,
        private OutputFactoryInterface $outputFactory,
    ) {
    }

    public function getConfigurationGetter(): ConfigurationGetterInterface
    {
        if ($this->configurationGetter === null) {
            $this->configurationGetter = $this->configurationGetterFactory->createConfigurationGetter();
        }

        return $this->configurationGetter;
    }

    public function getLapTimer(): LapTimerInterface
    {
        return $this->lapTimer;
    }

    public function getLogger(string $channel): LoggerInterface
    {
        if (!array_key_exists($channel, $this->loggers)) {
            $this->loggers[$channel] = $this->loggerFactory->createLogger($channel);
        }

        return $this->loggers[$channel];
    }

    public function getOutputService(string $channel): OutputInterface
    {
        if (!array_key_exists($channel, $this->outputServices)) {
            $this->outputServices[$channel] = $this->outputFactory->createOutputService($this->getLogger($channel));
        }

        return $this->outputServices[$channel];
    }
}
