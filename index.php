<?php
// ref from https://gist.github.com/remmel/fcbf60fd5364c443e74f407593ad50c8
// parameters
$hubVerifyToken = 'TOKEN123456ABCD';
$accessToken = "EAASWGE5SxgcBABJLTmlniJRet6dYqJQynfEW83JQxRe6QmXrrZClZA8z4tZAkUtdk3JKul9ZAQXcXeOiTeZAZAQSk2dYhZAd2KjEMA34xww3LcFRID3VzabDnKXl7Ows9Y2EROlFZA5JO6uDCSZAHDsmUuwNuizRdrFUOKQqEZAyZA4HgZDZD";

// check token at setup
if ($_REQUEST['hub_verify_token'] === $hubVerifyToken) {
  echo $_REQUEST['hub_challenge'];
  exit;
}

// handle bot's anwser
$input = json_decode(file_get_contents('php://input'), true);

$senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
$messageText = $input['entry'][0]['messaging'][0]['message']['text'];


$answer = "I don't understand. Ask me 'hi' or 'chanmyae'.";
if($messageText == "hi") {
    $answer = "Hello";
} else if ($messageText == "chanmyae") {
    $answer = "Handsome coder :3 ";
}

$response = [
    'recipient' => [ 'id' => $senderId ],
    'message' => [ 'text' => $answer ]
];
$ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_exec($ch);
curl_close($ch);

//based on http://stackoverflow.com/questions/36803518
