<?php


$API_URL = 'https://api.line.me/v2/bot/message';
$ACCESS_TOKEN = 'NO5Ikf6bY505IFnixJrF4Fxmn+btkZLFg4FZTtHY4kfo8BMJSkhvwx7nmRuiCG486Lg7iw7Q6Uo26n25LJxiddZNkyUxS34d+UklSkbd79KZvsTnk7owqJ/u88KNzfEWl5AgeLFlCuMaLfi5LQw+9wdB04t89/1O/w1cDnyilFU='; 
$channelSecret = 'ccb0744709d906333ea566a90b234135';


$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array



if ( sizeof($request_array['events']) > 0 ) {

    foreach ($request_array['events'] as $event) {

        $reply_message = '';
        $reply_token = $event['replyToken'];

        $text = $event['message']['text'];
        
        if($text == "ทดสอบ"){
            $text_return = "ตอบกลับ ทดสอบ";
        }
        $data = [
            'replyToken' => $reply_token,
             //'messages' => [['type' => 'text', 'text' => json_encode($request_array) ]]  //Debug Detail message
            'messages' => [['type' => 'text', 'text' => $text_return ]]
        ];
        $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);

        $send_result = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);

        echo "Result: ".$send_result."\r\n";
    }
}

echo "OK";




function send_reply_message($url, $post_header, $post_body)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

?>
