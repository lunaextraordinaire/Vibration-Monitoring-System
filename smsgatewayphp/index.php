<?php
//header('Content-Type: application/json');
//include('connect.php');
$mysqli = mysqli_connect("localhost","root","toor","mobility");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
date_default_timezone_set('Etc/UTC');
require 'PHPMailer-master/PHPMailerAutoload.php';
$host = "10.1.11.2";
$port = 25;
$SMTPAuth = false;
$username = "Mobility@domain.com";
$password = "Welcome123";
$setFrom = "Mobility@domain.com";
$setFromName = "Mobility";
$message = "<h3>Greetings</h3> </br>Keeping users in concern we are gently reminding you that  \"{{ComplianceName}}\" is expiring on {{ExpiryDate}}. </br></br><br><br>Please take the needful action.";
 

	
/*************************************************************************************************************************/
/****************Send daily Email To Responsible and next level before 7 days from expiry date starts here**********************/
/*************************************************************************************************************************/

	//$result = $mysqli->query("SELECT * FROM tbl_admin WHERE email = '".$email."' AND password = md5('".$password."')");
	//$result = $mysqli->query("SELECT * FROM `compliances` WHERE `ExpiryDate` <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)");
	$result = $mysqli->query("SELECT * FROM `compliances` WHERE DATE_FORMAT(STR_TO_DATE(`ExpiryDate`,'%d-%m-%Y'), '%Y-%m-%d') <= DATE_ADD(CURDATE(), INTERVAL 7 DAY) and DATE_FORMAT(STR_TO_DATE(`ExpiryDate`,'%d-%m-%Y'), '%Y-%m-%d') >= CURDATE()");
	if($result->num_rows > 0) {
		while($resultRow = $result->fetch_array()) {
			$rows[] = $resultRow;
		}		
		//$row = $result->fetch_array(MYSQLI_BOTH);
		foreach($rows as $row) {
		
		/*****************************************************/
		/****************Send SMTP Email**********************/
		/*****************************************************/
		//Create a new PHPMailer instance
		$mail = new PHPMailer;
		//Tell PHPMailer to use SMTP
		$mail->isSMTP();
		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$mail->SMTPDebug = 0;
		//Ask for HTML-friendly debug output
		$mail->Debugoutput = 'html';
		//Set the hostname of the mail server
		$mail->Host = $host;
		//Set the SMTP port number - likely to be 25, 465 or 587
		$mail->Port = $port;
		//Whether to use SMTP authentication
		$mail->SMTPAuth = $SMTPAuth;
		//Username to use for SMTP authentication
		//$mail->Username = $username;
		//Password to use for SMTP authentication
		//$mail->Password = $password;
		//Set who the message is to be sent from
		$mail->setFrom($setFrom, $setFromName);
		//Set an alternative reply-to address
		//$mail->addReplyTo($row['ResponsiblePersonEmail'], $row['ResponsiblePersonName']);
		//Set who the message is to be sent to
		$mail->addAddress($row['ResponsiblePersonEmail'], $row['ResponsiblePersonName']);
		$mail->addCC($row['NextlevelPersonEmail'], $row['NextlevelPersonName']);
		//Set the subject line
		$mail->Subject = '7days - Reminder: Expiring on '.$row['ExpiryDate'];
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$message1 = str_replace('{{ComplianceName}}',$row['Details'],$message);
		$message2 = str_replace('{{ExpiryDate}}',$row['ExpiryDate'],$message1);
		$mail->msgHTML($message2);
		//Replace the plain text body with one created manually
		$mail->AltBody = 'This is a plain-text message body';
		//Attach an image file
		$mail->addAttachment('images/phpmailer_mini.png');

		//send the message, check for errors
		if (!$mail->send()) {
			echo "Mailer Error for 7 days: " . $mail->ErrorInfo;
		} else {
			echo "Message sent!,  before 7 days from expiry date";
		}
		/*****************************************************/
		/****************Send SMTP Email**********************/
		/*****************************************************/
		}
		
		/*$stmt = $mysqli->prepare("UPDATE tbl_admin SET updated = ? WHERE id = ?");
		date_default_timezone_set("Asia/Kolkata"); 
		$datetime = date("Y-m-d H:i:s");
		$stmt->bind_param('si', $datetime, $row['id']);
		$stmt->execute();*/
	}
	
	
/*************************************************************************************************************************/
/****************Send daily Email To Responsible and next level before 7 days from expiry date ends here**********************/
/*************************************************************************************************************************/

/*************************************************************************************************************************/
/****************Send Email To Responsible  before 60 days from expiry date starts here***********************************/
/*************************************************************************************************************************/
	//$result = $mysqli->query("SELECT * FROM tbl_admin WHERE email = '".$email."' AND password = md5('".$password."')");
	//$result = $mysqli->query("SELECT * FROM `compliances` WHERE `ExpiryDate` = DATE_ADD(CURDATE(), INTERVAL 60 DAY)");
	//$result = $mysqli->query("SELECT * FROM `compliances` WHERE DATE_FORMAT(STR_TO_DATE(`ExpiryDate`,'%d-%m-%Y'), '%Y-%m-%d') <= DATE_ADD(CURDATE(), INTERVAL 60 DAY) and DATE_FORMAT(STR_TO_DATE(`ExpiryDate`,'%d-%m-%Y'), '%Y-%m-%d') >= CURDATE()");
	$result60 = $mysqli->query("SELECT * FROM `compliances` WHERE DATE_FORMAT(STR_TO_DATE(`ExpiryDate`,'%d-%m-%Y'), '%Y-%m-%d') = DATE_ADD(CURDATE(), INTERVAL 60 DAY)");
	if($result60->num_rows > 0) {
		$rows = array();
		while($resultRow60 = $result60->fetch_array()) {
			$rows[] = $resultRow60;
		}		
		//$row = $result->fetch_array(MYSQLI_BOTH);
		foreach($rows as $row) {
		
		
		/*****************************************************/
		/****************Send SMTP Email**********************/
		/*****************************************************/
		//Create a new PHPMailer instance
		$mail = new PHPMailer;
		//Tell PHPMailer to use SMTP
		$mail->isSMTP();
		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$mail->SMTPDebug = 0;
		//Ask for HTML-friendly debug output
		$mail->Debugoutput = 'html';
		//Set the hostname of the mail server
		$mail->Host = $host;
		//Set the SMTP port number - likely to be 25, 465 or 587
		$mail->Port = $port;
		//Whether to use SMTP authentication
		$mail->SMTPAuth = $SMTPAuth;
		//Username to use for SMTP authentication
		//$mail->Username = $username;
		//Password to use for SMTP authentication
		//$mail->Password = $password;
		//Set who the message is to be sent from
		$mail->setFrom($setFrom, $setFromName);
		//Set an alternative reply-to address
		//$mail->addReplyTo($row['ResponsiblePersonEmail'], $row['ResponsiblePersonName']);
		//Set who the message is to be sent to
		$mail->addAddress($row['ResponsiblePersonEmail'], $row['ResponsiblePersonName']);
		//Set the subject line
		$mail->Subject = '60days - Reminder: Expiring on '.$row['ExpiryDate'];
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$message1 = str_replace('{{ComplianceName}}',$row['Details'],$message);
		$message2 = str_replace('{{ExpiryDate}}',$row['ExpiryDate'],$message1);
		$mail->msgHTML($message2);		//Replace the plain text body with one created manually
		$mail->AltBody = 'This is a plain-text message body';
		//Attach an image file
		$mail->addAttachment('images/phpmailer_mini.png');

		//send the message, check for errors
		if (!$mail->send()) {
			echo "Mailer Error for 60 days: " . $mail->ErrorInfo;
		} else {
			echo "Message sent!, before 60 days from expiry date";
		}
		}
	}
/*************************************************************************************************************************/
/****************Send Email To Responsible  before 60 days from expiry date ends here*************************************/
/*************************************************************************************************************************/
		
/*************************************************************************************************************************/
/****************Send Email To Responsible  before 30 days from expiry date starts here***********************************/
/*************************************************************************************************************************/
	//$result = $mysqli->query("SELECT * FROM tbl_admin WHERE email = '".$email."' AND password = md5('".$password."')");
	//$result = $mysqli->query("SELECT * FROM `compliances` WHERE `ExpiryDate` = DATE_ADD(CURDATE(), INTERVAL 30 DAY)");
	//$result = $mysqli->query("SELECT * FROM `compliances` WHERE DATE_FORMAT(STR_TO_DATE(`ExpiryDate`,'%d-%m-%Y'), '%Y-%m-%d') <= DATE_ADD(CURDATE(), INTERVAL 30 DAY) and DATE_FORMAT(STR_TO_DATE(`ExpiryDate`,'%d-%m-%Y'), '%Y-%m-%d') >= CURDATE()");
	$result30 = $mysqli->query("SELECT * FROM `compliances` WHERE DATE_FORMAT(STR_TO_DATE(`ExpiryDate`,'%d-%m-%Y'), '%Y-%m-%d') = DATE_ADD(CURDATE(), INTERVAL 30 DAY)");
	if($result30->num_rows > 0) {
		$rows = array();
		while($resultRow30 = $result30->fetch_array()) {
			$rows[] = $resultRow30;
		}		
		//$row = $result->fetch_array(MYSQLI_BOTH);
		foreach($rows as $row) {
		/*****************************************************/
		/****************Send SMTP Email**********************/
		/*****************************************************/
		//Create a new PHPMailer instance
		$mail = new PHPMailer;
		//Tell PHPMailer to use SMTP
		$mail->isSMTP();
		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$mail->SMTPDebug = 0;
		//Ask for HTML-friendly debug output
		$mail->Debugoutput = 'html';
		//Set the hostname of the mail server
		$mail->Host = $host;
		//Set the SMTP port number - likely to be 25, 465 or 587
		$mail->Port = $port;
		//Whether to use SMTP authentication
		$mail->SMTPAuth = $SMTPAuth;
		//Username to use for SMTP authentication
		//$mail->Username = $username;
		//Password to use for SMTP authentication
		//$mail->Password = $password;
		//Set who the message is to be sent from
		$mail->setFrom($setFrom, $setFromName);
		//Set an alternative reply-to address
		//$mail->addReplyTo($row['ResponsiblePersonEmail'], $row['ResponsiblePersonName']);
		//Set who the message is to be sent to
		$mail->addAddress($row['ResponsiblePersonEmail'], $row['ResponsiblePersonName']);
		//Set the subject line
		$mail->Subject = '30days - Reminder: Expiring on '.$row['ExpiryDate'];
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$message1 = str_replace('{{ComplianceName}}',$row['Details'],$message);
		$message2 = str_replace('{{ExpiryDate}}',$row['ExpiryDate'],$message1);
		$mail->msgHTML($message2);		//Replace the plain text body with one created manually
		$mail->AltBody = 'This is a plain-text message body';
		//Attach an image file
		$mail->addAttachment('images/phpmailer_mini.png');

		//send the message, check for errors
		if (!$mail->send()) {
			echo "Mailer Error for 30 days: " . $mail->ErrorInfo;
		} else {
			echo "Message sent!, before 30 days from expiry date";
		}
		}
	}
/*************************************************************************************************************************/
/****************Send Email To Responsible  before 30 days from expiry date ends here*************************************/
/*************************************************************************************************************************/
		
/*************************************************************************************************************************/
/****************Send Email To Responsible  before 15 days from expiry date starts here***********************************/
/*************************************************************************************************************************/
	//$result = $mysqli->query("SELECT * FROM tbl_admin WHERE email = '".$email."' AND password = md5('".$password."')");
	//$result = $mysqli->query("SELECT * FROM `compliances` WHERE `ExpiryDate` = DATE_ADD(CURDATE(), INTERVAL 15 DAY)");
	//$result = $mysqli->query("SELECT * FROM `compliances` WHERE DATE_FORMAT(STR_TO_DATE(`ExpiryDate`,'%d-%m-%Y'), '%Y-%m-%d') <= DATE_ADD(CURDATE(), INTERVAL 15 DAY) and DATE_FORMAT(STR_TO_DATE(`ExpiryDate`,'%d-%m-%Y'), '%Y-%m-%d') >= CURDATE()");
	$result15 = $mysqli->query("SELECT * FROM `compliances` WHERE DATE_FORMAT(STR_TO_DATE(`ExpiryDate`,'%d-%m-%Y'), '%Y-%m-%d') = DATE_ADD(CURDATE(), INTERVAL 15 DAY)");
	if($result15->num_rows > 0) {
		$rows = array();
		while($resultRow15 = $result15->fetch_array()) {
			$rows[] = $resultRow15;
		}		
		//$row = $result->fetch_array(MYSQLI_BOTH);
		foreach($rows as $row) {
		/*****************************************************/
		/****************Send SMTP Email**********************/
		/*****************************************************/
		//Create a new PHPMailer instance
		$mail = new PHPMailer;
		//Tell PHPMailer to use SMTP
		$mail->isSMTP();
		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$mail->SMTPDebug = 0;
		//Ask for HTML-friendly debug output
		$mail->Debugoutput = 'html';
		//Set the hostname of the mail server
		$mail->Host = $host;
		//Set the SMTP port number - likely to be 25, 465 or 587
		$mail->Port = $port;
		//Whether to use SMTP authentication
		$mail->SMTPAuth = $SMTPAuth;
		//Username to use for SMTP authentication
		//$mail->Username = $username;
		//Password to use for SMTP authentication
		//$mail->Password = $password;
		//Set who the message is to be sent from
		$mail->setFrom($setFrom, $setFromName);
		//Set an alternative reply-to address
		//$mail->addReplyTo($row['ResponsiblePersonEmail'], $row['ResponsiblePersonName']);
		//Set who the message is to be sent to
		$mail->addAddress($row['ResponsiblePersonEmail'], $row['ResponsiblePersonName']);
		//Set the subject line
		$mail->Subject = '15 days - Reminder: Expiring on '.$row['ExpiryDate'];
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$message1 = str_replace('{{ComplianceName}}',$row['Details'],$message);
		$message2 = str_replace('{{ExpiryDate}}',$row['ExpiryDate'],$message1);
		$mail->msgHTML($message2);		//Replace the plain text body with one created manually
		$mail->AltBody = 'This is a plain-text message body';
		//Attach an image file
		$mail->addAttachment('images/phpmailer_mini.png');

		//send the message, check for errors
		if (!$mail->send()) {
			echo "Mailer Error for 15 days: " . $mail->ErrorInfo;
		} else {
			echo "Message sent!, before 15 days from expiry date";
		}
		}
	}
/*************************************************************************************************************************/
/****************Send Email To Responsible  before 15 days from expiry date ends here*************************************/
/*************************************************************************************************************************/
		
		
/*************************************************************************************************************************/
/*************Update notification table based based on compliances table's status value starts here***********************/
/*************************************************************************************************************************/		
$resultStatus = $mysqli->query("SELECT * FROM `compliances`");
	if($resultStatus->num_rows > 0) {
		$rows = array();
		$row = $resultStatus->fetch_array(MYSQLI_BOTH);
		while($resultRowStatus = $resultStatus->fetch_array()) {
			$rows[] = $resultRowStatus;
		}		
		//$row = $result->fetch_array(MYSQLI_BOTH);
		foreach($rows as $row) {
			if($row['Status'] == 'new' || $row['Status'] == 'edited') {
				$event ="edit";
				//$ExpiryDate = date_parse_from_format('d/M/Y', $row['ExpiryDate']);
				if($row['ExpiryDate'] != '')
				{
				$ExpiryDate = date('d M, Y', strtotime($row['ExpiryDate']));
				if ($ExpiryDate == date('d M, Y')) {
					$event = "expiry";
				}
				if($row['Status'] == 'new') {
					$event = "new";	
				}
				$ComplianceName = $row['Details'];
				
				$result = $mysqli->query("SELECT * FROM `notifications` where ComplianceId = ".$row['Id']);
				if($result->num_rows > 0) {
					
					$stmt = $mysqli->prepare("UPDATE notifications SET 	ComplianceName = ?, EventDate = ?, Event = ? WHERE ComplianceId = ?");
					/*$stmt = $mysqli->prepare("UPDATE tbl_adds SET title = ?, name = ?, publish_date = ?, expiry_date=?, image = ?, updated = ? WHERE id = ?");*/
					//date_default_timezone_set("Asia/Kolkata"); 
					//$datetime = date("Y-m-d H:i:s");
					$EventDate = date("Y-m-d");
					$stmt->bind_param('sssi', $ComplianceName, $EventDate, $event, $row['Id']);
				}else{
					$stmt = $mysqli->prepare("INSERT INTO notifications(ComplianceName, EventDate, Event, ComplianceId) VALUES (?, ?, ?, ?)");
					$EventDate = date("Y-m-d");
					$stmt->bind_param('sssi', $ComplianceName, $EventDate, $event, $row['Id']);
				}
				}
			}
		}
		
	}
/*************************************************************************************************************************/
/*************Update notification table based based on compliances table's status value ends here***********************/
/*************************************************************************************************************************/
?>