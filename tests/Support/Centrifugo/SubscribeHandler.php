<?php declare(strict_types=1);

namespace UzDevid\Yii\WebSocket\Tests\Support\Centrifugo;

use RoadRunner\Centrifugo\Payload\SubscribeResponse;
use RoadRunner\Centrifugo\Request\RequestInterface;
use UzDevid\Yii\Runner\Centrifugo\Handler\SubscribeHandlerInterface;

class SubscribeHandler implements SubscribeHandlerInterface {
    public function handle(RequestInterface $request): void {
        $request->respond(new SubscribeResponse(['ok' => true]));
    }
}
