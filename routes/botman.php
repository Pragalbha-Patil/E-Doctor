<?php
use App\Http\Controllers\BotManController;
use App\Http\Controllers\EdocController;

$botman = resolve('botman');

// $botman->hears('Hi', function ($bot) {
//     $bot->reply('Hello!');
// });
$botman->hears('hi|hey|hello|hi!|hey!|hello!', BotManController::class.'@start');
//$botman->hears('hi|hey|hello|hi!|hey!|hello!', EdocController::class.'@start');
$botman->fallback(function($bot) {
    $bot->reply('Sorry, I did not understand these commands. Try again with a hey!');
});
