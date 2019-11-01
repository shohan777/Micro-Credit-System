<?php
if (isset($_REQUEST['email']))  {
$emailvalue =  $_POST['email']; 
$subjectvalue =  $_POST['subject']; 
$messagevalue =  $_POST['message']; 

$to      = 'md.jewelmia52@gmail.com';
$subject = $subjectvalue;
$message = $messagevalue;
$headers = "From: {$emailvalue}" . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
 //Email response
  echo "<h2 style='color:green;'>Thank you for contacting us!</h2>";
}else{
	echo "<h2 style='color:red'>Email delivery failed!</h2>";
}
?> 