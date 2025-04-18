<?php declare(strict_types=1);

namespace UzDevid\Yii\WebSocket;

use Closure;

class Route {
    private array|Closure|string $handlerDefinition;

    /**
     * @param string $pattern
     */
    private function __construct(
        private readonly string $pattern
    ) {
    }

    /**
     * @param string $pattern
     * @return static
     */
    public static function create(string $pattern): static {
        return new self($pattern);
    }

    public function action(array|callable|string $handlerDefinition): static {
        $new = clone $this;
        $new->handlerDefinition = $handlerDefinition;
        return $new;
    }

    /**
     * @return string
     */
    public function getPattern(): string {
        return $this->pattern;
    }

    /**
     * @return array|callable|string
     */
    public function getHandler(): array|callable|string {
        return $this->handlerDefinition;
    }
}
