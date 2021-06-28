<?php
date_default_timezone_set("Asia/Bangkok");
$date = date("Y-m-d");
$time = date("H:i:s");
$json = file_get_contents('php://input');
$request = json_decode($json, true);
$queryText = $request["queryResult"]["queryText"];


//$queryText = json_encode($request["originalDetectIntentRequest"]);
$userId = $request['originalDetectIntentRequest']['payload']['data']['source']['userId'];
$groupId = $request['originalDetectIntentRequest']['payload']['data']['source']['groupId'];
$replyTokens = $request['originalDetectIntentRequest']['payload']['data']['replyToken'];

//global $argv;
//$dir = dirname(getcwd(). '/' . $argv[0]).'/storage/app/public';
$myfile = fopen("log/log$date.txt", "a") or die("Unable to open file!");

$log = $date."-".$time.",".$groupId.",".$queryText.",".$replyTokens."\n";

fwrite($myfile,$log);
fclose($myfile);


	$messages = [];
	$messages['replyToken'] = $replyTokens;

    $messages['messages'][0] = getFormatTextMessage("User Id : ".$userId);
	$encodeJson = json_encode($messages);

	$LINEDatas['url'] = "https://api.line.me/v2/bot/message/reply";
  	//$LINEDatas['token'] = "PbZyVMMiBc+Ojs2zLpYPoUchXHk6+w0WX+3xW6dP/o8lNefP6z7nB3N+FTXsqtTak5RGsRs5lTmZPuUbJbzJQJpqeqcWvjhyDBsiY+qvRH00OiDmm0Y7ehnT2LDmBVCFMOApoSnUxtQRII15yOv5vQdB04t89/1O/w1cDnyilFU=";
	  $LINEDatas['token'] = "c7ggOzXDq1ASmGlfYj/9KoRtz2MtEWIwqQ3StpzsO87typJG7y6X2xu8vF8u6fSWezyLGMfNL0sNJev9WNpHLjXqOzP1IpcIjaS4yDQTJvCXa3UejIepBFuFW+yD/9Jt+dU+ueNWl+3jHGbUvP+BmwdB04t89/1O/w1cDnyilFU=";

  	$results = sentMessage($encodeJson,$LINEDatas);



	function getFormatTextMessage($text)
	{
		$datas = [];
		$datas['type'] = 'text';
		$datas['text'] = $text;

		return $datas;
	}

	function sentMessage($encodeJson,$datas)
	{
		$datasReturn = [];
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $datas['url'],
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $encodeJson,
		  CURLOPT_HTTPHEADER => array(
		    "authorization: Bearer ".$datas['token'],
		    "cache-control: no-cache",
		    "content-type: application/json; charset=UTF-8",
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		    $datasReturn['result'] = 'E';
		    $datasReturn['message'] = $err;
		} else {
		    if($response == "{}"){
			$datasReturn['result'] = 'S';
			$datasReturn['message'] = 'Success';
		    }else{
			$datasReturn['result'] = 'E';
			$datasReturn['message'] = $response;
		    }
		}

		return $datasReturn;
	}
?>