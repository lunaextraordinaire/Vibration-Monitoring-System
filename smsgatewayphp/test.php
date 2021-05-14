<?php

$mysqli = mysqli_connect("localhost","root","toor","mobility");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  $Load1=485;
  $Load2=3;
  $GENCurrent=56;
  $GENFrequency=46;
  $ifZeroExecutedLoad1='false';
  $ifZeroExecutedLoad2='false';
    
	
		
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
   CURLOPT_URL => "https://www.smsgateway.center/VoiceApi/rest/send?userId=enteryourid&password=test213&sendMethod=groupVoice&audioType=library&libraryId=$LibraryID&group=16308&format=json",
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
  CURLOPT_POSTFIELDS => "userId=enteryourid&password=test213&senderId=Trex&sendMethod=groupMsg&msgType=text&group=16308&msg=$MSGContent&duplicateCheck=true&format=json",
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

echo "Load 1 enter";

if(($Load1<5 && $GENCurrent<5) || ($Load1<5 && $GENFrequency<47) || ($Load1<5) || ($GENCurrent<5 && $GENFrequency<47)){
	
	//calltrigger("3371666872129441075");
	SMSTrigger("This is for your information that Unit no 01 has tripped. Kindly dial the following Arkadin call conference number %26 participant code followed by Hash%28%23%29%2D
Dial number %2D 1800 120 1079 ,Participant code 27206175%23
Thanks CCR");
	$result = $mysqli->query("update checkvalue set value='true' where name='isLoad1'");
	
	echo "Load 1 tripped";

}
}



//condition of Load2 with current and Frequency

if($ifZeroExecutedLoad2 == 'false'){
if(($Load2<5 && $GENCurrent<5) || ($Load2<5 && $GENFrequency<47)|| ($Load2<5)){

	//calltrigger("1024179104729546856");
	SMSTrigger("This is for your information that Unit no 02 has tripped. Kindly dial the following Arkadin call conference number %26 participant code followed by Hash%28%23%29%2D
Dial number %2D 1800 120 1079 ,Participant code 27206175%23
Thanks CCR");
	$result = $mysqli->query("update checkvalue set value='true' where name='isLoad2'"); 
	echo "Load 2 tripped";
    
}
}	

//condition with frequency
/* IF($ifZeroExecuted == 'false'){	

if(($Load1<5 && $GENFrequency<47) || ($Load2<5 && $GENFrequency<47)){
	
  if($Load1<5){
	calltrigger("3371666872129441075");
	$result = $mysqli->query("update checkvalue set value='true' where name='iszero'");
	
	echo "Load 1 tripped";
}
  if($Load2<5){
	 calltrigger("1024179104729546856");
	$result = $mysqli->query("update checkvalue set value='true' where name='iszero'"); 
	echo "Load 2 tripped";
    }
}
} */	
	
//condition for station tripped
/* IF($ifZeroExecuted == 'false'){
if($Load1<5 && $Load2<5) {
	
    calltrigger("8217139674957564161");
	$result = $mysqli->query("update checkvalue set value='true' where name='iszero'");

} 
}*/




mysqli_close($mysqli);
		
?>