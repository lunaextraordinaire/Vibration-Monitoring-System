<?php

$mysqli = mysqli_connect("localhost","root","toor","mobility");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  $Load1;
  $Load2;
  $GENCurrent;
  $GENFrequency;
  $ifZeroExecutedLoad1;
  $ifZeroExecutedLoad2;
    
	
		$result = $mysqli->query('SELECT value FROM checkvalue
        WHERE name = "isLoad1"');
		
			if($result->num_rows > 0) {
			$resultRow = $result->fetch_array();
			$ifZeroExecutedLoad1=$resultRow['value'];
		
		}
		
		$result = $mysqli->query('SELECT value FROM checkvalue
        WHERE name = "isLoad2"');
		
			if($result->num_rows > 0) {
			$resultRow = $result->fetch_array();
			$ifZeroExecutedLoad2=$resultRow['value'];
		
		}
		   
 		//select U1 parameter
		$result = $mysqli->query('SELECT value FROM vitalparams
        WHERE Name = "U1 GEN MW"');
		
		//print_r($result);
		
		if($result->num_rows > 0) {
			$resultRow = $result->fetch_array();
			$Load1=$resultRow['value'];
		
		}
		
		//select U2 parameter
		$result = $mysqli->query('SELECT value FROM vitalparams
        WHERE Name = "U2 GEN MW"');
		
		//print_r($result);
		
		if($result->num_rows > 0) {
			$resultRow = $result->fetch_array();
			$Load2=$resultRow['value'];
		
		}
        
		//select GEN Frequency parameter
		$result = $mysqli->query('SELECT value FROM vitalparams
        WHERE Name = "U1 GEN FREQUENCY"');
		
		//print_r($result);
		
		if($result->num_rows > 0) {
			$resultRow = $result->fetch_array();
			$GENFrequency=$resultRow['value'];
		
		}
		
		//select GEN Current parameter
		$result = $mysqli->query('SELECT value FROM vitalparams
        WHERE Name = "U1 GEN CURRENT (V PHASE)"');
		
		//print_r($result);
		
		if($result->num_rows > 0) {
			$resultRow = $result->fetch_array();
			$GENCurrent=$resultRow['value'];
		
		} 
		if($ifZeroExecutedLoad1 == 'true')
			If ($Load1 >5)
			{
			$result = $mysqli->query("update checkvalue set value='false' where name='isLoad1'");
			} 
		
 		if($ifZeroExecutedLoad2 == 'true')
			If ($Load2 >5)
			{
			$result = $mysqli->query("update checkvalue set value='false' where name='isLoad2'");
			} 
		
		echo $Load1;
		echo $Load2;
		echo $GENCurrent;
		echo $GENFrequency;
		echo $ifZeroExecutedLoad1;
		echo $ifZeroExecutedLoad2;
		
		
	//userdefined function to trigger call	
			
    function calltrigger($LibraryID)
	{
		
   $curl = curl_init();
  
   curl_setopt_array($curl, array(
   CURLOPT_URL => "https://www.smsgateway.center/VoiceApi/rest/send?userId=enteryourid&password=test213&sendMethod=groupVoice&audioType=library&libraryId=$LibraryID&group=16142&format=json",
   CURLOPT_RETURNTRANSFER => true,
   CURLOPT_ENCODING => "",
   CURLOPT_MAXREDIRS => 10,
   CURLOPT_SSL_VERIFYPEER => false,
   CURLOPT_CUSTOMREQUEST => "GET",
   CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);

$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error Get #:" . $err;
} else {
  echo $response;
}
	
}	

//user defined function to trigger SMS

function SMSTrigger($MSGContent){
	
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.smsgateway.center/SMSApi/rest/send",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "userId=enteryourid&password=test213&senderId=Trex&sendMethod=groupMsg&msgType=text&group=16142&msg=$MSGContent&duplicateCheck=true&format=json",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/x-www-form-urlencoded"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}	
	
	
}	

//condition of Load1 with current and Frequency

IF($ifZeroExecutedLoad1 == 'false'){	

if(($Load1<5 && $GENCurrent<5) || ($Load1<5 && $GENFrequency<47) || ($Load1<5) || ($GENCurrent<5 && $GENFrequency<47)){
	
	calltrigger("3371666872129441075");
	SMSTrigger("This is for your information that Unit no __ has tripped. Kindly dial the following Number  
Dial number %2D 1800 000 000 
Thanks XYZ");
	$result = $mysqli->query("update checkvalue set value='true' where name='isLoad1'");
	
	
	echo "Load 1 tripped";

}
}



//condition of Load2 with current and Frequency

if($ifZeroExecutedLoad2 == 'false'){
if(($Load2<5 && $GENCurrent<5) || ($Load2<5 && $GENFrequency<47)|| ($Load2<5)){

	calltrigger("1024179104729546856");
	SMSTrigger("This is for your information that Unit no __ has tripped. Kindly dial the following Number  
Dial number %2D 1800 000 000 
Thanks XYZ");
	$result = $mysqli->query("update checkvalue set value='true' where name='isLoad2'"); 
	echo "Load 2 tripped";
    
}
}	






mysqli_close($mysqli);
		
?>