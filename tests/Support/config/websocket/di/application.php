<?php declare(strict_types=1);

use Psr\Log\LoggerInterface;
use UzDevid\Yii\Runner\Centrifugo\Handler\ConnectHandlerInterface;
use UzDevid\Yii\Runner\Centrifugo\Handler\InvalidRequestHandlerInterface;
use UzDevid\Yii\Runner\Centrifugo\Handler\PublishHandlerInterface;
use UzDevid\Yii\Runner\Centrifugo\Handler\RefreshHandlerInterface;
use UzDevid\Yii\Runner\Centrifugo\Handler\RpcHandlerInterface;
use UzDevid\Yii\Runner\Centrifugo\Handler\SubRefreshHandlerInterface;
use UzDevid\Yii\Runner\Centrifugo\Handler\SubscribeHandlerInterface;
use UzDevid\Yii\WebSocket\Handler\PublishHandler;
use UzDevid\Yii\WebSocket\Router;
use UzDevid\Yii\WebSocket\Tests\Support\Centrifugo\ConnectHandler;
use UzDevid\Yii\WebSocket\Tests\Support\Centrifugo\InvalidRequestHandler;
use UzDevid\Yii\WebSocket\Tests\Support\Centrifugo\RefreshHandler;
use UzDevid\Yii\WebSocket\Tests\Support\Centrifugo\RpcHandler;
use UzDevid\Yii\WebSocket\Tests\Support\Centrifugo\SubRefreshHandler;
use UzDevid\Yii\WebSocket\Tests\Support\Centrifugo\SubscribeHandler;
use Yiisoft\Config\Config;
use Yiisoft\ErrorHandler\ErrorHandler;
use Yiisoft\ErrorHandler\Middleware\ErrorCatcher;
use Yiisoft\ErrorHandler\Renderer\PlainTextRenderer;
use Yiisoft\ErrorHandler\ThrowableRendererInterface;
use Yiisoft\Test\Support\Log\SimpleLogger;

/** @var Config $config */

return [
    LoggerInterface::class => SimpleLogger::class,
    ThrowableRendererInterface::class => PlainTextRenderer::class,

    ErrorCatcher::class => [
        'forceContentType()' => ['text/plain'],
        'withRenderer()' => ['text/plain', PlainTextRenderer::class],
    ],

    ErrorHandler::class => [
        'reset' => function () {
            /** @var ErrorHandler $this */
            $this->debug(false);
        },
    ],
    //
    ConnectHandlerInterface::class => ConnectHandler::class,
    RefreshHandlerInterface::class => RefreshHandler::class,
    SubscribeHandlerInterface::class => SubscribeHandler::class,
    SubRefreshHandlerInterface::class => SubRefreshHandler::class,
    PublishHandlerInterface::class => PublishHandler::class,
    InvalidRequestHandlerInterface::class => InvalidRequestHandler::class,
    RpcHandlerInterface::class => RpcHandler::class,
    //
    Router::class => static function () use ($config) {
        return (new Router())->routes(...$config->get('routes'));
    }
];
