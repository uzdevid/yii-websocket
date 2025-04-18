<?php
declare(strict_types=1);

namespace UzDevid\Yii\WebSocket\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use UzDevid\Yii\WebSocket\Pattern\Matcher;
use UzDevid\Yii\WebSocket\Pattern\MatchResult;
use UzDevid\Yii\WebSocket\Pattern\Parser;

class PatternMatchTest extends TestCase {
    /**
     * @throws Exception
     */
    public function testMatch(): void {
        $matcher = new Matcher(new Parser());

        $result = $matcher->match('news:{id}[:{lang}]', 'news:123:en');

        $this->assertInstanceOf(MatchResult::class, $result);
        $this->assertEquals(['id' => '123', 'lang' => 'en'], $result->getArguments());

        $this->assertFalse($matcher->match('user:{id}', 'user'));
    }
}
