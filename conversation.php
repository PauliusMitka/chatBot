<?php
//Getting message from Ajax POST
$message = $_POST['text'];

//Getting access token and URL to chatbot
$apiKey = 'nyUl7wzXoKtgoHnd2fB0uRrAv0dDyLC+b4Y6xngpJDY=';
$headersPOST = [
    'x-inbenta-key: '.$apiKey,
    'Content-Type: application/json',
    'Accept: application/json',
];
$body = json_encode(array(
    "secret"  => "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJwcm9qZWN0IjoieW9kYV9jaGF0Ym90X2VuIn0.anf_eerFhoNq6J8b36_qbD4VqngX79-yyBKWih_eA1-HyaMe2skiJXkRNpyWxpjmpySYWzPGncwvlwz5ZRE7eg",
));
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => 'https://api.inbenta.io/v1/auth',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => $headersPOST,
    CURLOPT_POSTFIELDS => $body,
    ]);
$response = curl_exec($curl);
$response = json_decode($response);
$accessToken = $response->accessToken;
$expiration = $response->expiration;
$chatbotApiUrl =  $response->apis->chatbot;

//Conversation CALL
$conversationURL=$chatbotApiUrl.'/v1/conversation';
$headersPOSTconversation = [
    'x-inbenta-key: ' . $apiKey,
    'Authorization: ' . 'Bearer '.$accessToken
];
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $conversationURL,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => $headersPOSTconversation,
]);
$response = curl_exec($curl);
$response = json_decode($response);
$sessionToken = $response->sessionToken;
$sessionId = $response->sessionId;

//Conversation message CALL
$conversationURLsend=$chatbotApiUrl.'/v1/conversation/message';
$headersPOSTconversation = [
    'x-inbenta-key: ' . $apiKey,
    'Authorization: ' . 'Bearer '.$accessToken,
    'x-inbenta-session: ' . 'Bearer '.$sessionToken,
    'Content-Type: application/json',
    'Accept: application/json',
];
$bodyConversation = json_encode([
            "message" => "$message"
    ]
);
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $conversationURLsend,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => $headersPOSTconversation,
    CURLOPT_POSTFIELDS => $bodyConversation,
]);
$response = curl_exec($curl);
$response = json_decode($response);
$answer = $response->answers[0]->message;

//Sending back to answer to AJAX
echo $answer;




