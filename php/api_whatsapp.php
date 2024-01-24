<?php
//https://www.twilio.com/pt-br/docs/whatsapp/quickstart/php

require_once '../vendor/autoload.php';
use Twilio\Rest\Client;

//define("OCORREU_ERRO_API", "Ocorreu erro ao enviar mensagem para WhatsApp");
define("MENSAGEM_ENVIADA", "Mensagem enviada para WhatsApp");

// $sid = getenv("TWILIO_ACCOUNT_SID");
// $token = getenv("TWILIO_AUTH_TOKEN");
$sid = 'AC878cd1ca1ae8f97abaf914b84c6d7201';
$token = '57d7fd235a2f6223ce07f93a192b419b';
$twilio = new Client($sid, $token);

function sendWhatsAppMessage(string $varWhatsAppMessage) {
  $message = $GLOBALS['twilio']->messages
  ->create("whatsapp:+555499768826", // to
           [
               "from" => "whatsapp:+14155238886",
               "body" => $varWhatsAppMessage
           ]
  );
  return MENSAGEM_ENVIADA;
  //return $message->sid;
  
  // try {
  //   $message = $GLOBALS['twilio']->messages
  //                 ->create("whatsapp:+555499768826", // to
  //                          [
  //                              "from" => "whatsapp:+14155238886",
  //                              "body" => $varWhatsAppMessage
  //                          ]
  //                 );
  //   return $message->date_sent;
  // } 
  // catch (Exception $e) {
  //   return OCORREU_ERRO_API;
  // }

}


// $message = $twilio->messages
//                   ->create("whatsapp:+5554999382540", // to
//                            [
//                                "from" => "whatsapp:+555499768826",
//                                "body" => "teste de mensagem"
//                            ]
//                   );

//print($message->sid);

?>