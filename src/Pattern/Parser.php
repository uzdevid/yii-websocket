<?php
declare(strict_types=1);

namespace UzDevid\Yii\WebSocket\Pattern;

use Exception;
use RuntimeException;

class Parser {
    public const VARIABLE_REGEX = <<<'REGEX'
\{
    \s* ([a-zA-Z_][a-zA-Z0-9_-]*) \s*
    (?:
        : \s* ([^{}]*(?:\{(?-1)\}[^{}]*)*)
    )?
}
REGEX;

    public const DEFAULT_DISPATCH_REGEX = '[^:]+';

    /**
     * @param string $route
     * @return array
     * @throws Exception
     */
    public function parse(string $route): array {
        $routeWithoutClosingOptionals = rtrim($route, ']');
        $numOptionals = strlen($route) - strlen($routeWithoutClosingOptionals);

        $segments = preg_split('~' . self::VARIABLE_REGEX . '(*SKIP)(*F) | \[~x', $routeWithoutClosingOptionals);
        if ($numOptionals !== count($segments) - 1) {
            if (preg_match('~' . self::VARIABLE_REGEX . '(*SKIP)(*F) | \]~x', $routeWithoutClosingOptionals)) {
                throw new RuntimeException('Optional segments can only occur at the end of a route');
            }
            throw new RuntimeException("Number of opening '[' and closing ']' does not match");
        }

        $currentRoute = '';
        $routeData = [];
        foreach ($segments as $n => $segment) {
            if ($segment === '' && $n !== 0) {
                throw new RuntimeException('Empty optional part');
            }

            $currentRoute .= $segment;
            $routeData[] = $this->parsePlaceholders($currentRoute);
        }
        return $routeData;
    }

    private function parsePlaceholders(string $route): array {
        if (!preg_match_all(
            '~' . self::VARIABLE_REGEX . '~x',
            $route,
            $matches,
            PREG_OFFSET_CAPTURE | PREG_SET_ORDER
        )) {
            return [$route];
        }

        $offset = 0;
        $routeData = [];
        foreach ($matches as $set) {
            if ($set[0][1] > $offset) {
                $routeData[] = substr($route, $offset, $set[0][1] - $offset);
            }

            $routeData[] = [
                $set[1][0],
                isset($set[2]) && $set[2][0] !== '' ? trim($set[2][0]) : self::DEFAULT_DISPATCH_REGEX
            ];

            $offset = (int) $set[0][1] + strlen($set[0][0]);
        }

        if ($offset !== strlen($route)) {
            $routeData[] = substr($route, $offset);
        }

        return $routeData;
    }
}
