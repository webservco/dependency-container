<?php

declare(strict_types=1);

namespace WebServCo\DependencyContainer\Service;

use Override;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use WebServCo\Command\Contract\OutputFactoryInterface;
use WebServCo\DependencyContainer\Contract\FactoryContainerInterface;
use WebServCo\Log\Contract\LoggerFactoryInterface;

/**
 * A container for factory objects.
 */
final class FactoryContainer implements FactoryContainerInterface
{
    public function __construct(
        private LoggerFactoryInterface $loggerFactory,
        private OutputFactoryInterface $outputFactory,
        private ResponseFactoryInterface $responseFactory,
        private StreamFactoryInterface $streamFactory,
    ) {
    }

    #[Override]
    public function getLoggerFactory(): LoggerFactoryInterface
    {
        return $this->loggerFactory;
    }

    #[Override]
    public function getOutputFactory(): OutputFactoryInterface
    {
        return $this->outputFactory;
    }

    #[Override]
    public function getResponseFactory(): ResponseFactoryInterface
    {
        return $this->responseFactory;
    }

    #[Override]
    public function getStreamFactory(): StreamFactoryInterface
    {
        return $this->streamFactory;
    }
}
