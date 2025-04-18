<?php declare(strict_types=1);

namespace UzDevid\Yii\WebSocket;

class Router {
    private array $routes = [];

    /**
     * @param Route ...$route
     * @return $this
     */
    public function routes(Route ...$route): static {
        $new = clone $this;
        $new->routes = $route;
        return $new;
    }

    /**
     * @return Route[]
     */
    public function getRoutes(): array {
        return $this->routes;
    }
}
