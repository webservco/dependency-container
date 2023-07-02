<?php

declare(strict_types=1);

namespace WebServCo\DependencyContainer\Factory;

use WebServCo\Command\Factory\OutputServiceFactory;
use WebServCo\DependencyContainer\Contract\FactoryContainerInterface;
use WebServCo\DependencyContainer\Service\FactoryContainer;
use WebServCo\Http\Factory\Message\Response\ResponseFactory;
use WebServCo\Http\Factory\Message\Stream\StreamFactory;
use WebServCo\Http\Service\Message\Response\StatusCodeService;
use WebServCo\Log\Contract\LoggerFactoryInterface;

final class FactoryContainerFactory
{
    public function __construct(private LoggerFactoryInterface $loggerFactory)
    {
    }

    public function createFactoryContainer(): FactoryContainerInterface
    {
        $streamFactory = new StreamFactory();

        $responseFactory = new ResponseFactory(
            new StatusCodeService(),
            $streamFactory,
        );

        return new FactoryContainer($this->loggerFactory, new OutputServiceFactory(), $responseFactory, $streamFactory);
    }
}
