<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use App\Conversations\bookAppointment; //to use conversation below

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->listen();
    }

    /**
     * Loaded through routes/botman.php
     * @param  BotMan $bot
     */

    // call the actual appointment conversation 
    public function start(BotMan $bot)
    {
        $bot->startConversation(new bookAppointment());
    }
}
