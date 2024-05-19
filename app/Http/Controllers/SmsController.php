<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Twilio\Rest\Client;

class SmsController extends Controller
{
    public function sms_page()
    {
        return view('sms_page');
    }

    public function send_sms(Request $request)
    {
        define('WP_DEBUG_DISPLAY', true);
        $receiver_number = '07943289303';
        $message = 'SMSFrom Web Journey';
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_TOKEN");
        $twilio_number = getenv("TWILIO_FROM");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            // Where to send a text message (your cell phone?)
            '+447943289303',
            array(
                'from' => $twilio_number,
                'body' => 'I sent this message in under 10 minutes!'
            )
        ); 
    }
}
