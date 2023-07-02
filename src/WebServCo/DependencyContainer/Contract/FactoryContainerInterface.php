<?php

declare(strict_types=1);

namespace WebServCo\DependencyContainer\Contract;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use WebServCo\Command\Contract\OutputFactoryInterface;
use WebServCo\Log\Contract\LoggerFactoryInterface;

interface FactoryContainerInterface extends DependencyContainerInterface
{
    public function getLoggerFactory(): LoggerFactoryInterface;

    public function getOutputFactory(): OutputFactoryInterface;

    public function getResponseFactory(): ResponseFactoryInterface;

    public function getStreamFactory(): StreamFactoryInterface;
}
