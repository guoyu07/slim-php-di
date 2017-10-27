<?php

/*
 * slim-php-di (https://github.com/juliangut/slim-php-di).
 * Slim Framework PHP-DI container implementation.
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/slim-php-di
 * @author Julián Gutiérrez <juliangut@gmail.com>
 */

declare(strict_types=1);

namespace Jgut\Slim\PHPDI\Tests;

use Invoker\Invoker;
use Jgut\Slim\PHPDI\CallableStrategy;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Route callback strategy tests.
 */
class CallableStrategyTest extends TestCase
{
    public function testInvokable()
    {
        $callable = function () {
            // Empty
        };
        $parameters = [
            'param' => 'value',
        ];

        $request = $this->getMockBuilder(ServerRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        /* @var ServerRequestInterface $request */
        $response = $this->getMockBuilder(ResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        /* @var ResponseInterface $response */

        $invoker = $this->getMockBuilder(Invoker::class)
            ->disableOriginalConstructor()
            ->getMock();
        $invoker->expects(self::once())
            ->method('call')
            ->with($callable, array_merge(['request' => $request, 'response' => $response], $parameters));
        /* @var \Invoker\InvokerInterface $invoker */

        $handler = new CallableStrategy($invoker);

        $handler($callable, $request, $response, $parameters);
    }
}