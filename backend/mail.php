<?php 
//echo phpinfo();
$to_email=trim($_POST['to']);
$subject = $_POST['subject'];
$message = $_POST['message'];
/*$to_email = 'yadavrani822@gmail.com';
$subject = 'Testing PHP Mail';
$message = 'This mail is sent using the PHP mail function';*/
$headers = 'From: noreply @ company . com';
if(mail($to_email,$subject,$message,$headers))
{
	echo "Mail sent successfully";
}
else{
	echo "error";
}

?>