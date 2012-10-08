<?php
require 'database.php';

if(isset($_REQUEST['user_name']) && isset($_REQUEST['password']))
{
		
	   	$username=$_REQUEST['user_name'];
		$password=$_REQUEST['password'];
		$issuer_no=$_REQUEST['id'];

		mysql_query("insert into e_admin(username,password,issuer_id) values('$username','$password','$issuer_no')") or die(mysql_error());
		mysql_query("update issuers set status = 'Y' where issuer_no = $issuer_no ") or die(mysql_error());
		echo "<html><head><title></title><body>";
                echo "<div style='vertical-align: middle;position:absolute;left:280px;top:70px;'><h4>Your account has be activated. You Can Login in to your Account</h4></div>";
                echo "</body></html>";

}
else if (isset($_REQUEST['id']))
{
	$id=$_REQUEST['id'];
	$cnt=mysql_query("select * from issuers where issuer_no=$id");
	$cnt = mysql_num_rows($cnt);
	
	if($cnt == 1)
    {
		echo "<html><head><title>Issuer Verification</title>
			 <link rel='stylesheet' type='text/css' href='../resource/css/style.css'/>
			 </head>";
		echo "<body>";
		
		echo " <div class='registration'>
			   <h4 style='background-color:black;'><font color='white'>Issuer Verifiaction Form</font></h4>
			   <form name='verification' action='$_SERVER[PHP_SELF]'>
					<table align='center'>
					    <tr><td></td><td><input type='hidden' name='id' value=$id />
						<tr><td>User Name</td><td><input type='text' name='user_name'/></td></tr>
						<tr><td>Domain Name</td><td><input type='text' name='domain'/></td></tr>
						<tr><td>Website address</td><td><input type='text' name='url'/></td></tr>
						<tr><td>Password</td><td><input type='password' name='password'/></td></tr>
						<tr><td></td><td><input type='submit' value='Register'/><input type='reset' value='clear'/></td></tr>
					</table>
			   </form></div>";
		echo "</body></html>";
	}
	else
		echo "Link Expired...!";
}
else
	echo "Link Expired";



?>
