<?php
    $accessToken = 'NO5Ikf6bY505IFnixJrF4Fxmn+btkZLFg4FZTtHY4kfo8BMJSkhvwx7nmRuiCG486Lg7iw7Q6Uo26n25LJxiddZNkyUxS34d+UklSkbd79KZvsTnk7owqJ/u88KNzfEWl5AgeLFlCuMaLfi5LQw+9wdB04t89/1O/w1cDnyilFU=';
    
    $content = file_get_contents('php://input');
    $arrayJson = json_decode($content, true);
    
    $arrayHeader = array();
    $arrayHeader[] = "Content-Type: application/json";
    $arrayHeader[] = "Authorization: Bearer {$accessToken}";
    
    //รับข้อความจากผู้ใช้
    
#ตัวอย่าง Message Type "Text"

	$stat = 0;
	while(TRUE){
		$message = $arrayJson['events'][0]['message']['text'];
		if($message == "สวัสดี"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = "สวัสดีจ้าาา";
        replyMsg($arrayHeader,$arrayPostData);
		break;
    }
	else if($message == "ตารางสอน"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
		
		/*"quickReply": {
    "items": [
      {
        "type": "action",
        "imageUrl": "https://f.ptcdn.info/716/040/000/o3npyu1b2ovxUqEPxDb-o.jpg",
        "action": {
          "type": "message",
          "label": "วันรับเงินเดือน",
          "text": "วันรับเงินเดือน"
        }
      }
	  */
	  
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = "กรุณาพิมพ์เลขนิสิต111";
		$arrayPostData['messages'][0]['quickReply']['items'][0]['type'] = "action";
		$arrayPostData['messages'][0]['quickReply']['items'][0]['imageUrl'] = "https://f.ptcdn.info/716/040/000/o3npyu1b2ovxUqEPxDb-o.jpg";
		$arrayPostData['messages'][0]['quickReply']['items'][0]['action']['label'] =  "วันรับเงินเดือน";
		$arrayPostData['messages'][0]['quickReply']['items'][0]['action']['text'] =  "วันรับเงินเดือน";
		
		replyMsg($arrayHeader,$arrayPostData);
        break;
		
    }

    #ตัวอย่าง Message Type "Sticker"
    else if($message == "ฝันดี"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "sticker";
        $arrayPostData['messages'][0]['packageId'] = "2";
        $arrayPostData['messages'][0]['stickerId'] = "46";
        replyMsg($arrayHeader,$arrayPostData);
		break;
    }
    #ตัวอย่าง Message Type "Image"
    else if($message == "รูปน้องแมว"){
        $image_url = "https://i.pinimg.com/originals/cc/22/d1/cc22d10d9096e70fe3dbe3be2630182b.jpg";
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "image";
        $arrayPostData['messages'][0]['originalContentUrl'] = $image_url;
        $arrayPostData['messages'][0]['previewImageUrl'] = $image_url;
        replyMsg($arrayHeader,$arrayPostData);
		break;
    }
    #ตัวอย่าง Message Type "Location"
    else if($message == "พิกัดสยามพารากอน"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "location";
        $arrayPostData['messages'][0]['title'] = "สยามพารากอน";
        $arrayPostData['messages'][0]['address'] =   "13.7465354,100.532752";
        $arrayPostData['messages'][0]['latitude'] = "13.7465354";
        $arrayPostData['messages'][0]['longitude'] = "100.532752";
        replyMsg($arrayHeader,$arrayPostData);
		break;
    }
    #ตัวอย่าง Message Type "Text + Sticker ใน 1 ครั้ง"
    else if($message == "ลาก่อน"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = "อย่าทิ้งกันไป";
        $arrayPostData['messages'][1]['type'] = "sticker";
        $arrayPostData['messages'][1]['packageId'] = "1";
        $arrayPostData['messages'][1]['stickerId'] = "131";
        replyMsg($arrayHeader,$arrayPostData);
		break;
    }
	
	}
    
function replyMsg($arrayHeader,$arrayPostData){
        $strUrl = "https://api.line.me/v2/bot/message/reply";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$strUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);    
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arrayPostData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close ($ch);
    }
   //exit;
?>
