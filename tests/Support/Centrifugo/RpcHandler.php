<?php declare(strict_types=1);

namespace UzDevid\Yii\WebSocket\Tests\Support\Centrifugo;

use RoadRunner\Centrifugo\Request\RequestInterface;
use UzDevid\Yii\Runner\Centrifugo\Handler\RpcHandlerInterface;

class RpcHandler implements RpcHandlerInterface {
    public function handle(RequestInterface $request): void {

    }
}
