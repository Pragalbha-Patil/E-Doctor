<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

use App\DoctorModel;
use App\AppModel;
use Validator;
use DB;
use PaytmWallet;
use View;
use ButtonTemplate;

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
                } else {
                    $this->say('Invalid option. Try again.');
                    $this->run();
                }

            }
            else {
                $this->say('Invalid option. Try again.');
                $this->run();
            }
        });
    }

    public function bookapp() {

        $findifSlotAvail =  DoctorModel::where('status', '=', '0'); //improvise this
        if($findifSlotAvail) {
            //ask details
            $this->askName();
        }
        else if(!$findifSlotAvail) {
            $this->say("Oops, looks like the doctor isnt free.");
            return 0;
        }
        else  {
            //server error
            return 0;
        }
        
    }
    public function askName() {
        $this->ask('Please enter your name', function(Answer $answer){
            $validator = Validator::make(['name' => $answer->getText()], [
                'name' => 'regex:/^[a-zA-Z ]+$/',
            ]);
            if ($validator->fails()) {
                return $this->repeat('That doesn\'t look like a valid name. Please enter a valid name.');
            }
            $this->bot->userStorage()->save([
                'name' => $answer->getText(),
            ]);
            $this->say('Nice to meet you '.$answer->getText());
            $this->askEmail();
        });
    }

    public function askEmail() {
        $this->ask('What is your email?', function (Answer $answer) {
            $validator = Validator::make(['email' => $answer->getText()], [
                'email' => 'email',
            ]);
            if ($validator->fails()) {
                return $this->repeat('That doesn\'t look like a valid email. Please enter a valid email.');
            }
            $this->bot->userStorage()->save([
                'email' => $answer->getText(),
            ]);
            $this->askMobile();
        });
    }

    public function askMobile() {
        $this->ask('Please enter your mobile number', function (Answer $answer) {
            $validator = Validator::make(['mobile' => $answer->getText()], [
                'mobile' => 'required|regex:/^[6-9]\d{9}$/', //will ONLY validate indian mobile numbers.
            ]);
            if ($validator->fails()) {
                return $this->repeat('Please enter a valid mobile number.');
            }

            $mobcheck = AppModel::where('umobile','=', $answer)->first();
            if($mobcheck) {
                $this->say('uh huh, you already have an appointment scheduled with this mobile number. Try viewing the appointment instead.');
                // $this->error();
                return 'same mobile number';
            }
            else if(!$mobcheck) {
                $this->bot->userStorage()->save([
                    'mobile' => $answer->getText(),
                ]);
            }
            else {
                //error
            }
            $this->askGender();
        });
    }

    public function askGender() {
        $question = Question::create("Select your gender to get better treatment")
            ->fallback('Unable to ask question')
            ->callbackId('startconv')
            ->addButtons([
                Button::create('Male')->value('male'),
                Button::create('Female')->value('female'),
                Button::create('Other')->value('other'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $this->bot->userStorage()->save([
                    'gender' => $answer->getText(),
                ]);
            }
            else {
                $this->say('Invalid option. Try again.');
                $this->run();
            }
            $this->askDate();
        });
    }

    public function askDate() {
        //$fetchdates = DoctorModel::all('date')->where('status','=', 0);
        $fetchdates = DB::table('doctor_appointment_mapping')->where('status' , 0)->distinct()->get();
        $buttonArray = [];
        foreach($fetchdates as $fetchdates) {
            //echo ' '.$dates->date;
            $dates = date("d-m-Y", strtotime($fetchdates->date)); //formatting date in ddmmyyyy format
            $button = Button::create($dates)->value($dates);
            $buttonArray[] = $button;   
        }
        if(!$buttonArray) {
            $this->say('Oops, looks like the doctor isn\'t free.');
        }
        else {
            $question = Question::create('Select the date')
                ->callbackId('select_date')
                ->addButtons($buttonArray);
            $this->ask($question, function (Answer $answer) {
                if ($answer->isInteractiveMessageReply()) {
                    $this->bot->userStorage()->save([
                        'date' => $answer->getValue(),
                    ]);
                    $this->askTime();
                }
                else {
                    $this->say('Invalid option. Try again.');
                    $this->run();
                }
            });
        }
    }

    public function askTime(){
        $user = $this->bot->userStorage()->find();
        $selectedDate = date("Y-m-d", strtotime($user->get('date')));
        $fetchTime = DoctorModel::select('time')->where('date', $selectedDate)->where('status', 0)->get();
        // dd($fetchTime->time); // time is in hh:mm:ss format so beware.
        $buttonArray = [];
        if($fetchTime) {
            foreach ($fetchTime as $fetchTime) {
                $time =  date("g:i a", strtotime($fetchTime->time)); // this'll convert time to 12 hrs for user convinience.
                $button = Button::create($time)->value($time);
                $buttonArray[] = $button;
            }
            $question = Question::create('Select a time slot')
                ->callbackId('select_time')
                ->addButtons($buttonArray);
            $this->ask($question, function (Answer $answer) {
                if ($answer->isInteractiveMessageReply()) {
                    $this->bot->userStorage()->save([
                        'time' => $answer->getValue(),
                    ]);
                    $this->confirmBooking();
                }
                else {
                    $this->say('Invalid option. Try again.');
                    $this->run();
                }
            });
        }
        else {
            $this->say('error occured! code:timefault404');
        }
    }

    public function confirmBooking() {
        $appdata = new AppModel;
        $user = $this->bot->userStorage()->find();
        $appdata->uname = $user->get('name');
        $appdata->uemail = $user->get('email');
        $appdata->umobile = $user->get('mobile');
        $appdata->ugender = $user->get('gender');
        $bookingDate = date("Y-m-d", strtotime($user->get('date')));
        $appdata->adate = $bookingDate;
        $bookingTime = date("H:i", strtotime($user->get('time')));
        $appdata->atime = $bookingTime;
        //generating token below don't mind me.
        $uname = $user->get('name');
        $umob = $user->get('mobile');
        $adate = $user->get('date');
        $atime = $user->get('time');

        $unametok = mb_substr($uname, 0, 4);
        $umobtok = mb_substr($umob, 6, 10);
        $timetok = mb_substr($atime,0,4);
        $token = ''.$unametok.''.$umobtok.''.$adate.''.$timetok;
        $finaltoken = strtoupper($token);
        $date = date("Y-m-d", strtotime($adate));
        $time = date("H:i:s", strtotime($atime));
        $time12 = date("g:i:s", strtotime($atime));
        // dd($finaltoken);
        $someoneisfast = AppModel::where('adate', $date)->where('atime', $time12)->first();
        if($someoneisfast) {
            $this->say("Sorry, this slot was booked by someone else. Please try with different slots.");
            $this->askDate();
        }
        else {
            $appdata->atoken = $finaltoken;
            $appdata->save();
            // Updating status to avoid multiple bookings
            $docModel = new DoctorModel;
            $status = $docModel::where('date', $date)->where('time', $time)->first();
            $status->status = 1;
            $status->save();
            // Message below
            $message = '------------------------------------------------ <br>';
            $message .= 'Name : ' . $user->get('name') . '<br>';
            $message .= 'Email : ' . $user->get('email') . '<br>';
            $message .= 'Mobile : ' . $user->get('mobile') . '<br>';
            $message .= 'Date : ' . $user->get('date') . '<br>';
            $message .= 'Time : ' . $user->get('time') . '<br>';
            $message .= 'Token : ' . $finaltoken . '<br>';
            $message .= '------------------------------------------------';
            $this->say('Here are your booking details. <br><br>' . $message);
            $this->say('Save the token for viewing and cancelling the appointment');
        }
    }

    public function cancelapp() {
        $this->ask('Enter your token to cancel appointment.', function(Answer $answer){
            $entToken = $answer->getText();
            // getting appointment details
            $status = AppModel::where('atoken', $entToken)->first();
            if($status) {
                $date = $status->adate;
                $time = $status->atime;
                $model = DoctorModel::where('date', $date)->where('time', $time)->first();
                $model->status = 0;
                $model->save();
                $tokenCheck = AppModel::where('atoken' , $entToken)->delete();
                if($tokenCheck) {
                    $this->say('We\'ve cancelled your appointment.');
                }
                else {
                    $this->say('Invalid token number.');
                    $this->run();
                }
            }
            else {
                $this->say('Invalid token number.');
                $this->run();
            }
        });
    }

    public function viewapp() {
        $this->ask('Enter your token or mobile number to view scheduled appointment.', function(Answer $answer){
            $entToken = str_replace(' ', '', $answer->getText());
            $tokenCheck = AppModel::where('atoken' , $entToken)->first();
            if(!$tokenCheck) {
                $tokenCheck = AppModel::where('umobile', $entToken)->first();
            }
            if($tokenCheck) {
                $message = '------------------------------------------------ <br>';
                $message .= 'Name : ' . $tokenCheck->uname . '<br>';
                $message .= 'Email : ' . $tokenCheck->uemail . '<br>';
                $message .= 'Mobile : ' . $tokenCheck->umobile . '<br>';
                $message .= 'Date : ' . $tokenCheck->adate . '<br>';
                $message .= 'Time : ' . $tokenCheck->atime . '<br>';
                $message .= 'Token : ' . $tokenCheck->atoken . '<br>';
                $message .= '------------------------------------------------';
                $this->say('Here are your booking details. <br><br>' . $message);
            }
            else {
                $this->say('Invalid token or mobile number.');
            }
        });
    }

    public function error() {
        $this->say('Error occured.');
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->startconv();
    }
}
