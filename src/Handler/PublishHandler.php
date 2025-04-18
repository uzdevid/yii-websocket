<?php declare(strict_types=1);

namespace UzDevid\Yii\WebSocket\Handler;

use Closure;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionFunction;
use ReflectionMethod;
use RoadRunner\Centrifugo\Request\Publish;
use RoadRunner\Centrifugo\Request\RequestInterface;
use RuntimeException;
use UzDevid\Yii\Runner\Centrifugo\Handler\PublishHandlerInterface;
use UzDevid\Yii\WebSocket\Pattern\Matcher;
use UzDevid\Yii\WebSocket\Router;

class PublishHandler implements PublishHandlerInterface {
    /**
     * @param Router $router
     * @param Matcher $matcher
     * @param ContainerInterface $container
     */
    public function __construct(
        private readonly Router             $router,
        private readonly Matcher            $matcher,
        private readonly ContainerInterface $container
    ) {
    }

    /**
     * @param RequestInterface $request
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function handle(RequestInterface $request): void {
        /** @var Publish $request */
        foreach ($this->router->getRoutes() as $route) {
            $matchResult = $this->matcher->match($route->getPattern(), $request->channel);

            if ($matchResult === false) {
                continue;
            }

            $handler = $route->getHandler();
            $arguments = [$request, $matchResult->getArguments()];

            if (is_array($handler)) {
                [$class, $method] = $handler;

                if (is_string($class)) {
                    $class = $this->container->get($class);
                }

                $reflection = new ReflectionMethod($class, $method);
                $reflection->invokeArgs($class, $arguments);
                return;
            }

            if (($handler instanceof Closure) || (is_string($handler) && function_exists($handler))) {
                $reflection = new ReflectionFunction($handler);
                $reflection->invokeArgs($arguments);
                return;
            }

            if (is_string($handler)) {
                $instance = $this->container->get($handler);
                $reflection = new ReflectionMethod($instance, '__invoke');
                $reflection->invokeArgs($instance, $arguments);
                return;
            }

            throw new RuntimeException('Unsupported handler type');
        }
    }
}
