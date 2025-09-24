<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class SmsController extends Controller
{
    public function sendSms(Request $request)
    {
        $request->validate([
            'mobile_numbers' => 'required|array',
            'message' => 'required|string',
        ]);

        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $twilioNumber = env('TWILIO_PHONE_NUMBER');

        if (!$sid || !$token || !$twilioNumber) {
            return response()->json(['error' => 'Twilio credentials not configured.'], 500);
        }

        try {
            $twilio = new Client($sid, $token);
            foreach ($request->mobile_numbers as $number) {
                $twilio->messages->create(
                    $number,
                    ['from' => $twilioNumber, 'body' => $request->message]
                );
            }
            return response()->json(['success' => 'SMS sent successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}