<?php declare(strict_types=1);

namespace UzDevid\Yii\WebSocket\Tests\Support\Handler;

use JsonException;
use RoadRunner\Centrifugo\Payload\PublishResponse;
use RoadRunner\Centrifugo\Request\Publish;

class NewsMessageHandler {
    /**
     * @throws JsonException
     */
    public function publish(Publish $request, array $arguments): void {
        $request->respond(new PublishResponse(['ok' => true]));
    }
}
