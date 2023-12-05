<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendMail()
    {
        $to_name = 'Címzett Neve';
        $to_email = 'smitpeter777@gmail.com';
        $data = array('name'=>"Oktato", "body" => "Test mail");

        Mail::send('emails.welcome', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('Laravel Teszt Email');
            $message->from('from@example.com','Teszt Feladó');
        });

        echo "E-mail elküldve!";
    }
}

