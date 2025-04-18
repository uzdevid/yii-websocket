<?php declare(strict_types=1);

namespace UzDevid\Yii\WebSocket\Tests\Support\Centrifugo;

use RoadRunner\Centrifugo\Request\RequestInterface;
use UzDevid\Yii\Runner\Centrifugo\Handler\InvalidRequestHandlerInterface;

class InvalidRequestHandler implements InvalidRequestHandlerInterface {
    public function handle(RequestInterface $request): void {
        // TODO: Implement handle() method.
    }
}
