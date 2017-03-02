<?php
$access_token = 'SYiBwdoGr6MPMZDzM1Dc/Su7NFrMpbCZ7bBq/dBXcYO8gZ1QY0FofBAA6Dn8BRcak9YwZWsBDU2g+V9/KydFkPCObE6Fnd8UzREOb14Tb0uEzAStO7CbriJrkkTOHFj4caAfaiwcWnPiSRtgR7UoAgdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;