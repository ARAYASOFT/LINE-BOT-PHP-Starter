<?php
$access_token = 'SYiBwdoGr6MPMZDzM1Dc/Su7NFrMpbCZ7bBq/dBXcYO8gZ1QY0FofBAA6Dn8BRcak9YwZWsBDU2g+V9/KydFkPCObE6Fnd8UzREOb14Tb0uEzAStO7CbriJrkkTOHFj4caAfaiwcWnPiSRtgR7UoAgdB04t89/1O/w1cDnyilFU=';

$json_str = file_get_contents('php://input'); //接收REQUEST的BODY
$json_obj = json_decode($json_str); //轉JSON格式
//產生回傳給line server的格式
$sender_userid = $json_obj->events[0]->source->userId;
$sender_txt = $json_obj->events[0]->message->text;
$sender_replyToken = $json_obj->events[0]->replyToken;

// $myfile = fopen("log.txt", "w+") or die("Unable to open file!"); //設定一個log.txt 用來印訊息
// fwrite($myfile, "\xEF\xBB\xBF" . $json_str); //在字串前加入\xEF\xBB\xBF轉成utf8格式
// fclose($myfile);
var_dump(
	$json_obj
);
$call_line_api = "https://api.line.me/v2/bot/message/push";
$response = array();

if ($sender_txt == "reply") {
    $call_line_api = "https://api.line.me/v2/bot/message/reply";
    $response = array(
        "replyToken" => $sender_replyToken,
        "messages" => array(
            array(
                "type" => "text",
                "text" => "Hello, 你說: " . $sender_txt,
            ),
        ),
    );
} else if ($sender_txt == "image") {
    $call_line_api = "https://api.line.me/v2/bot/message/reply";
    $response = array(
        "replyToken" => $sender_replyToken,
        "messages" => array(
            array(
                "type" => "image",
                "originalContentUrl" => "https://www.w3schools.com/css/paris.jpg",
                "previewImageUrl" => "https://www.nasa.gov/sites/default/themes/NASAPortal/images/feed.png",
            ),
        ),
    );
} else if ($sender_txt == "location") {
    $call_line_api = "https://api.line.me/v2/bot/message/reply";
    $response = array(
        "replyToken" => $sender_replyToken,
        "messages" => array(
            array(
                "type" => "location",
                "title" => "my location",
                "address" => "〒150-0002 東京都渋谷区渋谷２丁目２１−１",
                "latitude" => 35.65910807942215,
                "longitude" => 139.70372892916203,
            ),
        ),
    );
} else if ($sender_txt == "sticker") {
    $call_line_api = "https://api.line.me/v2/bot/message/reply";
    $response = array(
        "replyToken" => $sender_replyToken,
        "messages" => array(
            array(
                "type" => "sticker",
                "packageId" => "1",
                "stickerId" => "1",
            ),
        ),
    );
} else if ($sender_txt == "sing") {
    $call_line_api = "https://api.line.me/v2/bot/message/reply";
    $response = array(
        "replyToken" => $sender_replyToken,
        "messages" => array(
            array(
                "type" => "sticker",
                "packageId" => "1",
                "stickerId" => "11",
            ),
        ),
    );
} else if ($sender_txt == "btn") {
    $call_line_api = "https://api.line.me/v2/bot/message/reply";
    $response = array(
        "replyToken" => $sender_replyToken,
        "messages" => array(
            array(
                "type" => "template",
                "altText" => "這是範本",
                "template" => array(
                    "type" => "buttons",
                    "thumbnailImageUrl" => "https://www.w3schools.com/css/paris.jpg",
                    "title" => "Menu",
                    "text" => "Please select",
                    "actions" => array(
                        array(
                            "type" => "postback",
                            "label" => "是",
                            "data" => "action=yes&itemid=123",
                        ),
                        array(
                            "type" => "postback",
                            "label" => "否",
                            "data" => "action=no&itemid=456",
                        ),
                    ),
                ),
            ),
        ),
    );
} else {
    $call_line_api = "https://api.line.me/v2/bot/message/reply";
    $response = array(
        "replyToken" => $sender_replyToken,
        "messages" => array(
            array(
                "type" => "text",
                "text" => $sender_txt,
            ),
        ),
    );
}

//回傳給line server
$header[] = "Content-Type: application/json";
$header[] = "Authorization: Bearer " . $access_token;
$ch = curl_init($call_line_api);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
$result = curl_exec($ch);
curl_close($ch);

echo $result . "\r\n";

// fwrite($myfile, $result);
// fclose($myfile);
