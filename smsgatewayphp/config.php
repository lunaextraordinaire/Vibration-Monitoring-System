<?php
$mysqli = mysqli_connect("localhost","root","toor","mobility");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
/*se
{
 echo 'kkk';	
}*/

session_start();

?>