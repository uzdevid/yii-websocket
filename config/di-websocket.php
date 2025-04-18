<?php declare(strict_types=1);

use UzDevid\Yii\Runner\Centrifugo\Handler\PublishHandlerInterface;
use UzDevid\Yii\WebSocket\Handler\PublishHandler;

return [
    PublishHandlerInterface::class => PublishHandler::class
];
