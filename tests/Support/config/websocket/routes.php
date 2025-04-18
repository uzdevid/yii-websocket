<?php declare(strict_types=1);

use UzDevid\Yii\WebSocket\Route;
use UzDevid\Yii\WebSocket\Tests\Support\Handler\NewsMessageHandler;

return [
    Route::create('news:{id}')->action([NewsMessageHandler::class, 'publish'])
];
