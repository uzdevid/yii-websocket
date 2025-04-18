<?php declare(strict_types=1);

namespace UzDevid\Yii\WebSocket\Tests;

use Psr\Log\LoggerInterface;
use UzDevid\Yii\Runner\Centrifugo\Handler\ConnectHandlerInterface;
use UzDevid\Yii\Runner\Centrifugo\Handler\InvalidRequestHandlerInterface;
use UzDevid\Yii\Runner\Centrifugo\Handler\PublishHandlerInterface;
use UzDevid\Yii\Runner\Centrifugo\Handler\RefreshHandlerInterface;
use UzDevid\Yii\Runner\Centrifugo\Handler\RpcHandlerInterface;
use UzDevid\Yii\Runner\Centrifugo\Handler\SubRefreshHandlerInterface;
use UzDevid\Yii\Runner\Centrifugo\Handler\SubscribeHandlerInterface;
use UzDevid\Yii\WebSocket\Handler\PublishHandler;
use UzDevid\Yii\WebSocket\Route;
use UzDevid\Yii\WebSocket\Router;
use UzDevid\Yii\WebSocket\Tests\Support\Centrifugo\ConnectHandler;
use UzDevid\Yii\WebSocket\Tests\Support\Centrifugo\InvalidRequestHandler;
use UzDevid\Yii\WebSocket\Tests\Support\Centrifugo\RefreshHandler;
use UzDevid\Yii\WebSocket\Tests\Support\Centrifugo\RpcHandler;
use UzDevid\Yii\WebSocket\Tests\Support\Centrifugo\SubRefreshHandler;
use UzDevid\Yii\WebSocket\Tests\Support\Centrifugo\SubscribeHandler;
use UzDevid\Yii\WebSocket\Tests\Support\Handler\NewsMessageHandler;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Di\Container;
use Yiisoft\Di\ContainerConfig;
use Yiisoft\ErrorHandler\ErrorHandler;
use Yiisoft\ErrorHandler\Middleware\ErrorCatcher;
use Yiisoft\ErrorHandler\Renderer\PlainTextRenderer;
use Yiisoft\ErrorHandler\ThrowableRendererInterface;
use Yiisoft\Test\Support\Log\SimpleLogger;

class Helper {
    /**
     * @throws InvalidConfigException
     */
    public static function createContainer(): Container {
        $config = ContainerConfig::create()->withDefinitions([
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
            ConnectHandlerInterface::class => ConnectHandler::class,
            RefreshHandlerInterface::class => RefreshHandler::class,
            InvalidRequestHandlerInterface::class => InvalidRequestHandler::class,
            SubscribeHandlerInterface::class => SubscribeHandler::class,
            SubRefreshHandlerInterface::class => SubRefreshHandler::class,
            PublishHandlerInterface::class => PublishHandler::class,
            RpcHandlerInterface::class => RpcHandler::class,

            Router::class => static function () {
                return (new Router())->routes(
                    Route::create('news:{id}')->action([NewsMessageHandler::class, 'publish'])
                );
            }
        ]);

        return new Container($config);
    }
}
