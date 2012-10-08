<?PHP
require("..\lib\PHPMailer\class.phpmailer.php");
define('GUSER', 'voteopen@gmail.com'); // GMail username
define('GPWD', 'v0te0pen'); // GMail password

/* if(smtpmailer('11030142111@sicsr.ac.in', '', 'voteopen@gmail.com', 'Digvijay Mohite', 'HI sample maill', 'Mail has been Send.!'))
{
	echo "Mail Send";
}
else
{
	echo $error;
} */

function smtpmailer($to, $from, $from_name, $subject, $body) { 
	global $error;
	$mail = new PHPMailer();  // create a new object
	$mail->SetLanguage( 'es', 'PHPMailer/language/' );
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true;  // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 465; 
	$mail->Username = GUSER;  
	$mail->Password = GPWD;           
	$mail->SetFrom($from, $from_name);
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AddAddress($to);
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo; 
		return false;
	} else {
		$error = 'Message sent!';
		return true;
	}
}

?>