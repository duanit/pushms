<?php
	//กำหนดค่า Access-Control-Allow-Origin ให้ เครื่อง อื่น ๆ สามารถเรียกใช้งานหน้านี้ได้
	header("Access-Control-Allow-Origin: *");
	
	header("Content-Type: application/json; charset=UTF-8");
	
	header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
	
	header("Access-Control-Max-Age: 3600");
	
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	
	$requestMethod = $_SERVER["REQUEST_METHOD"];
	
	
	if($requestMethod == 'GET'){
	  
		echo "API Push Massage Line";
	}
	

	$data = file_get_contents("php://input");

	
	$result = json_decode($data,true);
	
	$to = $result['to'];
    $messages = $result['messages'];
	//$token = "PbZyVMMiBc+Ojs2zLpYPoUchXHk6+w0WX+3xW6dP/o8lNefP6z7nB3N+FTXsqtTak5RGsRs5lTmZPuUbJbzJQJpqeqcWvjhyDBsiY+qvRH00OiDmm0Y7ehnT2LDmBVCFMOApoSnUxtQRII15yOv5vQdB04t89/1O/w1cDnyilFU=";
	$token = "c7ggOzXDq1ASmGlfYj/9KoRtz2MtEWIwqQ3StpzsO87typJG7y6X2xu8vF8u6fSWezyLGMfNL0sNJev9WNpHLjXqOzP1IpcIjaS4yDQTJvCXa3UejIepBFuFW+yD/9Jt+dU+ueNWl+3jHGbUvP+BmwdB04t89/1O/w1cDnyilFU=";
	$header = array(
    "Authorization: Bearer ".$token,
    "Content-Type: application/json",
    "Postman-Token: dbd927f8-5eb5-4619-8549-b22b45d10401",
    "cache-control: no-cache"
  );
	if($requestMethod == 'POST'){
	
		if(!empty($result)){

$curl = curl_init();


curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.line.me/v2/bot/message/push",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\r\n    
\"to\": \"".$to."\",\r\n    
\"messages\":[\r\n        
{\r\n            
\"type\":\"text\",\r\n            
\"text\":\"".$messages."\"\r\n        
}\r\n    ]\r\n}",
  CURLOPT_HTTPHEADER => $header,
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

	if ($err) {
		date_default_timezone_set("Asia/Bangkok");
		$date = date("Y-m-d");
		$time = date("H:i:s");
	
		$myfile = fopen("log/log$date.txt", "a") or die("Unable to open file!");
	
		$log = $date."-".$time.",".$result['to'].",".$result['messages'].","."fail"."\n";
	
		
	    fwrite($myfile,$log);
	    fclose($myfile);
	    echo json_encode(['status' => '1','message' => $err]);	
	} else {

		date_default_timezone_set("Asia/Bangkok");
			$date = date("Y-m-d");
			$time = date("H:i:s");
		
			$myfile = fopen("logMS/log$date.txt", "a") or die("Unable to open file!");
		
			$log = $date."-".$time.",".$result['to'].",".$result['messages'].","."success"."\n";
		
			
		fwrite($myfile,$log);
		fclose($myfile);
		echo json_encode(['status' => '0','message' => 'Send Message Complete']);
	}
		
}
			
}
	
