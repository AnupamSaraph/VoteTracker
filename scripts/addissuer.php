<?php
 require 'database.php';

 $i_name = (string)$_POST['i_name'];
 $registration_no = (string)$_POST['registration_no'];
 $url = (string)$_POST['url'];
 $status = 'N';

 $response = null;

 if($i_name != null && $registration_no != null)
 {
    $url = 'N/A';
	mysql_query("INSERT INTO issuers(name,reg_no,url,status,issuer_no) values('$i_name','$registration_no','$url','$status','N/A')")or die(mysql_error());
	$response = 1;
 }
 else if($i_name !=null && $url != null)
 {
	$registration_no = 'N/A';
	mysql_query("INSERT INTO issuers(name,reg_no,url,status,issuer_no) values('$i_name','$registration_no','$url','$status','N/A')")or die(mysql_error());
	$response = 1;
 }
 else
	$response = 0;

echo $response;

?>