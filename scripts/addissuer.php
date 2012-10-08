<?php
 
 require 'database.php';
 require 'email.php';

 $i_name = (string)$_POST['i_name'];
 $registration_no = (string)$_POST['registration_no'];
 $url = (string)$_POST['url'];
 $email=(string)$_POST['email'];
 $status = 'N';

 $response = null;

 if($i_name != null && $registration_no != null)
 {
	 $cnt=mysql_query("select * from issuers");
	 $cnt = mysql_num_rows($cnt);
	 $cnt= $cnt+ 1;

	$msg ="Please Click on link to Complete Your Registration http://localhost/OpenVote/scripts/issuerverification.php?id=$cnt";
	if(smtpmailer($email, 'voteopen@gmail.com', 'Open Vote', 'Issuer Verification', $msg))
	 {
		$url = 'N/A';
		mysql_query("INSERT INTO issuers(name,reg_no,url,status,issuer_no,email) 
					values('$i_name','$registration_no','$url','$status','$cnt','$email')")or die(mysql_error());
		$response = 1;
	 }
}
 else
	$response = 0;

echo $response;

?>