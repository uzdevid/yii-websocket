<?php declare(strict_types=1);

namespace UzDevid\Yii\WebSocket\Pattern;

class MatchResult {
    /**
     * @param array $arguments
     */
    public function __construct(
        private readonly array $arguments
    ) {
    }

    /**
     * @param string $name
     * @return string|int|null
     */
    public function getArgument(string $name): string|int|null {
        return $this->arguments[$name] ?? null;
    }

    /**
     * @return array
     */
    public function getArguments(): array {
        return $this->arguments;
    }
}
