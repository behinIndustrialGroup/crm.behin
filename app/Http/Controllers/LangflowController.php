<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Mkhodroo\AltfuelTicket\Models\TicketComment;
use stdClass;

class LangflowController extends Controller
{
    public static function ticketLastCommentReply(Request $request)
    {
        $lastCommentResponse = CreateTicketController::getLastComment($request->ticket_id);
        $question = $lastCommentResponse->getData()->last_comment;
        $reply = self::run($question);
        return response()->json(['message' => $reply]);
    }

    public static function run($question, $sessionId = null)
    {

        $curl = curl_init();

        $data = [
            "input_value" => $question,
            "output_type" => "chat",
            "input_type" => "chat",
            "session_id" => (string) $sessionId,
            "tweaks" => [
                "Agent-lCMES" => new stdClass(),
                "ChatInput-sr1BR" => new stdClass(),
                "ChatOutput-YRLDS" => new stdClass(),
                "URL-SP0nv" => new stdClass(),
                "CalculatorTool-v4RbN" => new stdClass()
            ]
        ];

        // مقداردهی تنظیمات cURL
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://altfuel.darkube.app/api/v1/run/' . env('LANGFLOW_FLOW_ID') . '?stream=false',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data), // داده‌های JSON به‌درستی اینجا رمزگذاری می‌شوند
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . env('APPLICATION_TOKEN')
            ),
        ));

        $response = curl_exec($curl);
        Log::info("Response of Langflow");
        Log::info($response);
        curl_close($curl);

        $decodedResponse = json_decode($response, true);
        if (isset($decodedResponse['outputs'][0]['outputs'][0]['results']['message']['text'])) {
            $reply = $decodedResponse['outputs'][0]['outputs'][0]['results']['message']['text'];
        } else {
            $reply = 'خطا در دریافت پاسخ';
        }
        return $reply;
    }
}
