<?PHP
require 'scripts/database.php';
sessionset:
if (isset($_REQUEST['username']) && isset($_REQUEST['password']))
{
	$username=(string)$_REQUEST['username']; $password=(string)$_REQUEST['password'];
	$sql="select * from e_admin where username='$username' and password='$password'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	$count=mysql_num_rows($result);
	if($count == 1)
	{
		unset($count);
		session_start();
		$_SESSION['user']= $username;
		$_SESSION['issuer_id']=$row['issuer_id'];
		unset($_REQUEST['password']);
		unset($_REQUEST['username']);
		goto sessionset;
	}
	else
		header("Location: e_admin.php");
}
else if(isset($_SESSION['user']))
{
	$name=(string)$_SESSION['user'].'.txt';
	$file=fopen("logs/e_admin/".$name,'a');
	fwrite($file,"..".$_SESSION['user']."-".$_SESSION['issuer_id']." ".date("d/m/y h:i:s")." Logged In \n");
	fclose($file);
	echo"<html>
			<head>
				<title>Election Administrator </title>
				<link rel='stylesheet' type='text/css' href='resource/css/style.css'/>
			 </head>
			<body>
			<div>
				<div class='title1'>
					<font color='white' size='10'><b>OpenVote</b></font><br>
				</div>
				 <div class='sidebar'>
					<h4 style='background-color:#484848; margin-top:2px;'><font color='white'>Main Menu</font></h4>
						<ul id='nav's style='margin-top:-18px;' >
							<li><a id='link' href='e_admin.php?opt=a&subopt=aa'>Voters<hr class='w'></a></li>
							<li><a id='link' href='e_admin.php?opt=b'>Issue Token<hr class='w'></a></li>
							<li><a id='link' href='e_admin.php?opt=c'>Election Process<hr class='w'></a></li>
							<li><a id='link' href='e_admin.php?opt=d'>Audit<hr class='w'></a></li>
							<li><a id='link' href='e_admin.php?opt=e'>Organisation Profile<hr class='w'></a></li>
							<li><a id='link' href='e_admin.php?opt=o'>Logout</a></li>
						</ul>
				 </div>
			</div>
			</body>	
		</html>";
}
elseif(isset($_REQUEST['opt']))
{
	session_start();
	echo "<html>
			<head>
				<title>Election Administrator </title>
				<link rel='stylesheet' type='text/css' href='resource/css/style.css'/>
			 </head>
			<body>
			<div>
				<div class='title1'>
					<font color='white' size='10'><b>OpenVote</b></font><br>
				</div>
				 <div class='sidebar'>
					<h4 style='background-color:#484848; margin-top:2px;'><font color='white'>Main Menu</font></h4>
						<ul id='nav's style='margin-top:-18px;' >
							<li><a id='link' href='e_admin.php?opt=a&subopt=aa'>Voters<hr class='w'></a></li>
							<li><a id='link' href='e_admin.php?opt=b'>Issue Token<hr class='w'></a></li>
							<li><a id='link' href='e_admin.php?opt=c'>Election Process<hr class='w'></a></li>
							<li><a id='link' href='e_admin.php?opt=d'>Audit<hr class='w'></a></li>
							<li><a id='link' href='e_admin.php?opt=e'>Organisation Profile<hr class='w'></a></li>
							<li><a id='link' href='e_admin.php?opt=o'>Logout</a></li>
						</ul>
				</div>";

	if($_REQUEST['opt'] == 'a')
	{
		 echo "<div class='content'>";
		 echo"<h4 style='background-color:#484848; margin-top:4px;'><font color='white'>VOTER INFORMATION</font></h4>";
		 echo"<div style='margin-top:-18px;' id='nav'>
				<ul id='subnavbar'>
					<li><a href='e_admin.php?opt=a&subopt=aa'>Approve</a></li>
					<li><a href='e_admin.php?opt=a&subopt=bb'>Delete</a></li>
					<li><a href='e_admin.php?opt=a&subopt=cc'>RequestForVoterVerification</a></li>
				</ul>
			   </div>";
		 if($_REQUEST['subopt'] == 'aa')
		{
			echo"<form name='voter' method='post'>";
			echo "<input type='button' value='Remove Selected' onclick='#'/> <input type='reset' value='Clear All Checks'/>";
			$result= mysql_query("Select * from voter where status='N' order by srno desc") or die(mysql_error());
			echo "<table  width='1130' align='left' cellpadding=5 cellspacing=1>";
			echo "<tr bgcolor='#C0C0C0'><th></th><th>Name</th><th>Fathers Name</th><th>Mothers Name</th>
				  <th>Gender</th><th>M.S</th><th>Type</th><th>Nation</th><th>State</th><th>City</th><th>Locality</th><th>Pin</th><th>Status</th></tr>";
			$color = array('#66A3FF', '#B2D1FF');
			for($i=0;$row=mysql_fetch_array($result);$i++)
			{
				echo"<tr bgcolor='".$color[$i%2]."'>";
				echo"<td align='center'><input type='checkbox' name='issuer_no' value='".$row['srno']."'/></td>
		     		<td>".$row['v_fname']." ".$row['v_mname']." ".$row['v_lname']."</td>
					<td>".$row['f_fname']." ".$row['f_mname']." ".$row['f_lname']."</td>
					<td>".$row['m_fname']." ".$row['m_mname']." ".$row['m_lname']."</td>
					<td>".$row['gender']."</td>
					<td>".$row['marital_status']."</td>
					<td>".$row['reg']."</td>
					<td>".$row['nation']."</td>
					<td>".$row['state']."</td>
					<td>".$row['city']."</td>
					<td>".$row['colony']."</td>
					<td>".$row['postal_pin']."</td>
					<td>N</td>";
					echo"</tr>";
			}
			echo "</table>
			</form>";
			echo "</div>";
		}
		echo "</div>";
	}
	else if($_REQUEST['opt'] == 'b')
	{
		 echo "<div class='content'>";
		 echo"<h4 style='background-color:#484848; margin-top:4px;'><font color='white'>TOKEN INFORMATION</font></h4>";
		 echo"<div style='margin-top:-18px;' id='nav'>
				<ul id='subnavbar'>
					<li><a href='#'>Approve</a></li>
					<li><a href='#'>Delete</a></li>
				</ul>
			   </div>";
		 echo "</div>";
	}
	else if($_REQUEST['opt'] == 'c')
	{
		 echo "<div class='content'>";
		 echo"<h4 style='background-color:#484848; margin-top:4px;'><font color='white'>ELECTION PROCESS</font></h4>";
		 echo"<div style='margin-top:-18px;' id='nav'>
				<ul id='subnavbar'>
					<li><a href='#'>CreateElection</a></li>
					<li><a href='#'>ManageCandidate</a></li>
					<li><a href='#'>Constituency/Department</a><li>
				</ul>
			   </div>";
		 echo "</div>";
	}
	else if($_REQUEST['opt'] == 'd')
	{
		 echo "<div class='content'>";
		 echo"<h4 style='background-color:#484848; margin-top:4px;'><font color='white'>AUDIT</font></h4>";
		 echo"<div style='margin-top:-18px;' id='nav'>
				<ul id='subnavbar'>
					<li><a href='#'>Reports</a></li>
				</ul>
			   </div>";
		 echo "</div>";
	}
	else if($_REQUEST['opt'] == 'e')
	{
		 echo "<div class='content'>";
		 echo"<h4 style='background-color:#484848; margin-top:4px;'><font color='white'>ORGANISATION PROFILE</font></h4>";
		 echo"<div style='margin-top:-18px;' id='nav'>
				<ul id='subnavbar'>
					<li><a href='#'>Edit</a></li>
				</ul>
			   </div>";
		 echo "</div>";
	}
	elseif($_REQUEST['opt'] == 'o')
	{
		$name=(string)$_SESSION['user'].'.txt';
		$file=fopen("logs/e_admin/".$name,'a');
		fwrite($file,"..".$_SESSION['user']."-".$_SESSION['issuer_id']." ".date("d/m/y h:i:s")." Logged Out\n");
		fclose($file);
		session_destroy();
		header("Location: e_admin.php");
	}

}
else
{
	echo "<html>
		 <head>
			<title> OpenVote Administrator </title>
			 <link rel='stylesheet' type='text/css' href='resource/css/style.css'/>
		</head>
	 <body>";
    echo "	<div class='registration'>
			<h4 style='background-color:black;'><font color='white'>Election Administrator Login</font></h4>
			<form name='login' method='post' action='$_SERVER[PHP_SELF]'>
				<table align='center'>
					<tr><td>UserName</td><td><input type='text' name='username'/></td></tr>
					<tr><td>Password</td><td><input type='password' name='password'/></td></tr>
					<tr><td></td><td><input type='submit' value='Login'/></td></tr>
				</table>
		   </form>
		   </div>";

}
echo "</body></html>";
?>