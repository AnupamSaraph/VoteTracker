<?php
require 'database.php';

$fname=(string)$_POST['fname'];    
$mname=(string)$_POST['mname'];
$lname=(string)$_POST['lname'];

$f_fname=(string)$_POST['f_fname'];
$f_mname=(string)$_POST['f_mname'];
$f_lname=(string)$_POST['f_lname'];

$m_fname=(string)$_POST['m_fname'];
$m_mname=(string)$_POST['m_mname'];
$m_lname=(string)$_POST['m_lname'];

$gender=(string)$_POST['gender'];
$marital_status=(string)$_POST['rel'];
$reg=(string)$_POST['reg'];

$nation=(string)$_POST['nation'];
$state=(string)$_POST['state'];
$city=(string)$_POST['city'];
$colony=(string)$_POST['colony'];
$pin=(string)$_POST['pin'];

$response = null;

if($fname != null && $mname != null && $lname != null && $f_fname != null && $f_mname != null && $f_lname != null && $m_fname != null && $m_mname != null && $m_lname != null && $gender != null && $marital_status != null && $reg != null && $nation != null && $state != null && $city != null && $colony != null && $pin != null)
{
	
	if($gender == "male")
		$gender = "M";
	else
		$gender = "F";
	
	if($marital_status == "single")
		$marital_status = "S";
	else
		$marital_status = "M";
	$status = "N";
	
	mysql_query("INSERT INTO voter (v_fname,v_mname,v_lname,f_fname,f_mname,f_lname,m_fname,m_mname,m_lname,gender,marital_status,reg,nation,state,city,colony,postal_pin,status)
	VALUES('$fname','$mname','$lname','$f_fname','$f_mname','$f_lname','$m_fname','$m_mname','$m_lname','$gender','$marital_status','$reg','$nation','$state','$city','$colony','$pin','$status')")or die(mysql_error());
	
	$response = 1;
	
}
else
{
	$response = 0;
}
mysql_close($con);
echo $response;
?>