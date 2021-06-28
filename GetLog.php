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
	$token = "PbZyVMMiBc+Ojs2zLpYPoUchXHk6+w0WX+3xW6dP/o8lNefP6z7nB3N+FTXsqtTak5RGsRs5lTmZPuUbJbzJQJpqeqcWvjhyDBsiY+qvRH00OiDmm0Y7ehnT2LDmBVCFMOApoSnUxtQRII15yOv5vQdB04t89/1O/w1cDnyilFU=";
	$header = array(
    "Authorization: Bearer ".$token,
    "Content-Type: application/json",
    "Postman-Token: dbd927f8-5eb5-4619-8549-b22b45d10401",
    "cache-control: no-cache"
  );
	if($requestMethod == 'POST'){
	
		

    $curl = curl_init();


    curl_setopt_array($curl, array(
    
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_HTTPHEADER => $header,
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

        $file = fopen("logMS/logMS.txt", "r");
        $i = 0;
        while (!feof($file)) {
            $line_of_text .= fgets($file);
        }
       
        $members = explode("\n", $line_of_text);
        fclose($file);

        if(count($members) < 4){
            $i = 4;
        }else{
            $i = (count($members) - 4);
        }
       
        for($i;$i<count($members);$i++){
            if($members[$i] != ""){
                 $oho = explode(",",$members[$i]) ;
                 $dataSendDate[] .= $oho[0] ;
                 $datasendUser[] .= $oho[1] ;
                 $datasendMessage[] .= $oho[2] ;
                 $datasendStatus[] .= $oho[3] ;
            }
         }
 
         //print_r(explode(",",$members[0]));
         $data = array(
             'sendDate' => $dataSendDate,
             'sendUser' => $datasendUser,
             'sendMessage' => $datasendMessage,
             'sendStatus' => $datasendStatus
         );

        echo json_encode(['status' => '0','data' => $data]);
		//echo json_encode(['status' => '0','message' => 'Send Message Complete']);
	
	}
?>