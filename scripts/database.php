<?php
	$con = mysql_connect("localhost","openvote","openvote");
	if (!$con)
	   die('Could not connect: ' . mysql_error());
	else
	{
		mysql_select_db("openvote", $con);
	}
?> 