<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class bookAppointment extends Conversation
{
    /**
     * First question
     */
    public function startconv()
    {
        $question = Question::create("What type of service are you looking for?")
            ->fallback('Unable to ask question')
            ->callbackId('startconv')
            ->addButtons([
                Button::create('Book appointment')->value('book'),
                Button::create('Cancel appointment')->value('cancel'),
                Button::create('View appointment')->value('view'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'book') {
                    // $joke = json_decode(file_get_contents('http://api.icndb.com/jokes/random'));
                    // $this->say($joke->value->joke);
                    $this->bookapp();
                } else if($answer->getValue() === 'cancel') {
                    $this->cancelapp();
                } else if($answer->getValue() === 'view') {
                    $this->viewapp();
                }

            }
        });
    }

    public function bookapp() {
        dd('book');
    }

    public function cancelapp() {
        dd('cancel');
    }

    public function viewapp() {
        dd('view');
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->startconv();
    }
}
