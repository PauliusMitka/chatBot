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
$flag=$response->answers[0]->flags[0];


if($flag==='no-results' && $message!=='force'){
    $contador=$_COOKIE["Contador"]++;
    intval($contador);
    $contador=$contador+1;
    setcookie("Contador", $contador, time()+3600);
}
if($_COOKIE["Contador"]===2){
//* I'm not very sure how to call all STAR WARS characters since i dont know the tables names.
    //This code should work if i knew what table to call
/*
 *     $SwapiAPIURL='https://inbenta-graphql-swapi-prod.herokuapp.com/api';
    $headersPOSTSwapi = [
        'Content-Type: application/json',
    ];
    $bodyConversationSwapi = json_encode([
            "query" => "allCharacters(first: 10){characters{name}}" <------- HERE I SHOULD PUT THE TABLES NAME
        ]
    );
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $SwapiAPIURL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => $headersPOSTSwapi,
        CURLOPT_POSTFIELDS => $bodyConversationSwapi,
    ]);
    $response = curl_exec($curl);
    $response = json_decode($response);
   **Maybe in te response i should pick the correct answer...
    $answer=$response
 */
    //This is some temporally answer...
    $answer='Darth Vader
    Luke Skywalker
    Obi-Wan Kenobi
    Leia Organa
    Han Solo
    Yoda...';
    setcookie("Contador", 0, time()+3600);
    echo $answer;
}
elseif($message==='force'){
    //* I'm not very sure how to call all STAR WARS films since i dont know the tables names.
    //This code should work if i knew what table to call
    /*
     *     $SwapiAPIURL='https://inbenta-graphql-swapi-prod.herokuapp.com/api';
        $headersPOSTSwapi = [
            'Content-Type: application/json',
        ];
        $bodyConversationSwapi = json_encode([
                "query" => "allFilms(first: 10){films{name}}" <------- HERE I SHOULD PUT THE TABLES NAME
            ]
        );
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $SwapiAPIURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => $headersPOSTSwapi,
            CURLOPT_POSTFIELDS => $bodyConversationSwapi,
        ]);
        $response = curl_exec($curl);
        $response = json_decode($response);
       **Maybe in te response i should pick the correct answer...
        $answer=$response
     */
    //This is some temporally answer...
    $answer='Episode I – The Phantom Menace
    Episode II – Attack of the Clones
    Episode III – Revenge of the Sith
    Episode IV – A New Hope
    Episode V – The Empire Strikes Back
    Episode VI – Return of the Jedi...';
    echo $answer;
}
else{
    echo $answer;
}









