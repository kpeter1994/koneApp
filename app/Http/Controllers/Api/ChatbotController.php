<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class ChatbotController extends Controller
{
    public function saveQuestion()
    {

    }
   public function sendMessage(Request $request)
   {
       $response = Http::post('http://localhost:5005/webhooks/rest/webhook',[
           'sender' => 'Rasa',
           'message' => $request->message
       ]);

         return $response->json();
   }
}
