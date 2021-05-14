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
  $ifZeroExecuted;
  
		$result = $mysqli->query('SELECT value FROM checkvalue
        WHERE name = "iszero"');
		
			if($result->num_rows > 0) {
			$resultRow = $result->fetch_array();
			$ifZeroExecuted=$resultRow['value'];
		
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
        
		//select GEN Current parameter
		$result = $mysqli->query('SELECT value FROM vitalparams
        WHERE Name = "U1 GEN FREQUENCY"');
		
		//print_r($result);
		
		if($result->num_rows > 0) {
			$resultRow = $result->fetch_array();
			$GENFrequency=$resultRow['value'];
		
		}
		
		//select GEN Frequency parameter
		$result = $mysqli->query('SELECT value FROM vitalparams
        WHERE Name = "U1 GEN CURRENT (V PHASE)"');
		
		//print_r($result);
		
		if($result->num_rows > 0) {
			$resultRow = $result->fetch_array();
			$GENCurrent=$resultRow['value'];
		
		}
 		if($ifZeroExecuted == 'true')
			If ($Load1 >5 && $Load2 >5)
			{
			$result = $mysqli->query("update checkvalue set value='false' where name='iszero'");
			} 
		
		echo $Load1;
		echo $Load2;
		echo $GENCurrent;
		echo $GENFrequency;
		echo $ifZeroExecuted;
		
		
	//userdefined function to trigger call	
			
    function calltrigger($LibraryID)
	{
		
   $curl = curl_init();
  
   curl_setopt_array($curl, array(
   CURLOPT_URL => "https://www.smsgateway.center/VoiceApi/rest/send?userId=enteryourid&password=test213&sendMethod=groupVoice&audioType=library&libraryId=$LibraryID&group=16142&reDial=2&redialInterval=5&format=json",
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


IF($ifZeroExecuted == 'false'){	
If ($Load1 < 1 || $Load2 < 1)	{
	calltrigger("3371666872129441075");
	$result = $mysqli->query("update checkvalue set value='true' where name='iszero'");
}
}

if($Load1<5 && $GENCurrent<5 && $GENFrequency<47){
	
  
	calltrigger("3371666872129441075");
	$result = $mysqli->query("update checkvalue set value='true' where name='iszero'");

	}
		
if($Load2<5 && $GENCurrent<5 && $GENFrequency<47){
	
	
	calltrigger("1024179104729546856");
	$result = $mysqli->query("update checkvalue set value='true' where name='iszero'");

   }

if($Load1<5 && $Load2<5 && $GENCurrent<5 && $GENFrequency<47) {
	
    calltrigger("8217139674957564161");
	$result = $mysqli->query("update checkvalue set value='true' where name='iszero'");

}



mysqli_close($mysqli);
		
?>