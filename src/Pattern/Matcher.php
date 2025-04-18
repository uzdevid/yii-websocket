<?php declare(strict_types=1);

namespace UzDevid\Yii\WebSocket\Pattern;

use Exception;

class Matcher {
    /**
     * @param Parser $parser
     */
    public function __construct(
        private readonly Parser $parser
    ) {
    }

    /**
     * @throws Exception
     */
    public function match(string $pattern, string $input): MatchResult|false {
        $routes = $this->parser->parse($pattern);

        foreach ($routes as $routeData) {
            [$regex, $paramNames] = $this->buildRegex($routeData);

            if (preg_match($regex, $input, $matches)) {
                $params = [];

                foreach ($paramNames as $index => $name) {
                    $params[$name] = $matches[$index + 1] ?? null;
                }

                return new MatchResult($params);
            }
        }

        return false;
    }

    private function buildRegex(array $routeData): array {
        $regex = '~^';
        $paramNames = [];

        foreach ($routeData as $part) {
            if (is_string($part)) {
                $regex .= preg_quote($part, '~');
            } elseif (is_array($part)) {
                $regex .= '(' . $part[1] . ')';
                $paramNames[] = $part[0];
            }
        }

        $regex .= '$~';
        return [$regex, $paramNames];
    }
}
