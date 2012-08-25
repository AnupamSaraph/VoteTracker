<?php 
require 'scripts/database.php';
$test = null;
sessionset:	
if ((isset($_REQUEST['username']))&& (isset($_REQUEST['password'])))
{
	
	$username=(string)$_REQUEST['username']; $password=(string)$_REQUEST['password'];
	$sql="select * from administrator where username='$username' and password='$password'";
	$result=mysql_query($sql);
    $count=mysql_num_rows($result);
	if($count == 1)
	{
		unset($count);
		session_start();
		$_SESSION['uid']= $username;
		$test=(string)$_SESSION['uid'];
		unset($_REQUEST['password']);
		unset($_REQUEST['username']);
		goto sessionset;
	}
	else
		header("Location: administrator.php");
}
elseif(isset($_SESSION['uid']))
{
		try
		{
			setcookie('username',$_SESSION['uid']);
			$name=(string)$_SESSION['uid'].'.txt';
			$file=fopen("logs/administrator/".$name,'a');
			fwrite($file,$test." ".date("d/m/y h:i:s")." Logged In \n ..");
			fclose($file);
			echo "<html>
			  <head>
				<title> Administrator Account</title>
				<link rel='stylesheet' type='text/css' href='resource/css/style.css'/>
			</head>
				<body>
					<div>
						 <div class='title'>
								<font color='white' size='10'><b>OpenVote</b></font><br>
								<font color='white'><b>Administrator : ".$_SESSION['uid']." </b></font>
						 <div>
						 
						 <div class='sidebar'>
							<ul id='nav'>
								<li><a id='link' href='administrator.php?opt=a'>Manage Issuers<hr class='w'></a></li>
								<li><a id='link' href='administrator.php?opt=b'>Approved Issuers<hr class='w'></a></li>
								<li><a id='link' href='administrator.php?opt=o'>Logout</a></li>
							</ul>
						 </div>
						 <div class='content'>";
					 		echo"<h4 style='background-color:black; margin-top:4px;'><font color='white'>Pending Requst for New Issuers</font></h4>
							<form>";
							echo "<input type='button' value='Approve Selected'/> <input type='reset' value='Clear All Checks'/>";
							$result= mysql_query("Select * from issuers where status='N' order by srno desc") or die(mysql_error());
							 echo "<table  width='1100' align='center' cellpadding=5 cellspacing=7>";
							 echo "<tr bgcolor='#C0C0C0'><th></th><th>Name</th><th>Registration Number</th><th>Website Address(Url)</th><th>Status</th></tr>";
							 $color = array('#DCDCDC', '#F5F5F5');
							 for($i=0;$row=mysql_fetch_array($result);$i++)
							{
								echo"<tr bgcolor='".$color[$i%2]."'>";
								echo"<td align='center'><input type='checkbox' name='' value='".$row['srno']."'/></td><td>".$row['name']."</td><td>".$row['reg_no']."</td><td>".$row['url']."</td><td>Pending</td>";
								echo"</tr>";
							}
						    echo "</table>
							</form>
							</div>";
					echo "</div>
			   </body>
		  </html>";
		}
		catch(Exception $e)
		{
			 echo 'Message: ' .$e->getMessage();
		}		
}
elseif(isset($_REQUEST['opt']))
{
	session_start();
	echo "<html>
			  <head>
				<title> Administrator Account</title>
				<link rel='stylesheet' type='text/css' href='resource/css/style.css'/>
			</head>
				<body>
					<div>
						 <div class='title'>
								<font color='white' size='10'><b>OpenVote</b></font><br>
								<font color='white'><b>Administrator : ".$_SESSION['uid']." </b></font>
						 <div>
						 
						 <div class='sidebar'>
							<ul id='nav'>
								<li><a id='link' href='administrator.php?opt=a'>Manage Issuers<hr class='w'></a></li>
								<li><a id='link' href='administrator.php?opt=b'>Approved Issuers<hr class='w'></a></li>
								<li><a id='link' href='administrator.php?opt=o'>Logout</a></li>
							</ul>
						 </div>";

					if($_REQUEST['opt'] == 'a')
					{	
						 echo "<div class='content'>";
					 		echo"<h4 style='background-color:black; margin-top:4px;'><font color='white'>Pending Requst for New Issuers</font></h4>
							<form>";
							echo "<input type='button' value='Approve Selected'/> <input type='reset' value='Clear All Checks'/>";
							$result= mysql_query("Select * from issuers where status='N' order by srno desc") or die(mysql_error());
							 echo "<table  width='1100' align='center' cellpadding=5 cellspacing=7>";
							 echo "<tr bgcolor='#C0C0C0'><th></th><th>Name</th><th>Registration Number</th><th>Website Address(Url)</th><th>Status</th></tr>";
							 $color = array('#DCDCDC', '#F5F5F5');
							 for($i=0;$row=mysql_fetch_array($result);$i++)
							{
								echo"<tr bgcolor='".$color[$i%2]."'>";
								echo"<td align='center'><input type='checkbox' name='' value='".$row['srno']."'/></td><td>".$row['name']."</td><td>".$row['reg_no']."</td><td>".$row['url']."</td><td>Pending</td>";
								echo"</tr>";
							}
						    echo "</table>
							</form>
							</div>";
					}
					elseif($_REQUEST['opt'] == 'b')
					{ 
						echo "<div class='content'>";
					 		echo"<h4 style='background-color:black; margin-top:4px;'><font color='white'>Pending Requst for New Issuers</font></h4>
							<form>";
							echo "<input type='button' value='Remove Selected'/> <input type='reset' value='Clear All Checks'/>";
							$result= mysql_query("Select * from issuers where status='Y' order by srno desc") or die(mysql_error());
							 echo "<table  width='1100' align='center' cellpadding=5 cellspacing=7>";
							 echo "<tr bgcolor='#C0C0C0'><th></th><th>Name</th><th>Registration Number</th><th>Website Address(Url)</th><th>Status</th></tr>";
							 $color = array('#DCDCDC', '#F5F5F5');
							 for($i=0;$row=mysql_fetch_array($result);$i++)
							{
								echo"<tr bgcolor='".$color[$i%2]."'>";
								echo"<td align='center'><input type='checkbox' name='' value='".$row['srno']."'/></td><td>".$row['name']."</td><td>".$row['reg_no']."</td><td>".$row['url']."</td><td>Pending</td>";
								echo"</tr>";
							}
						    echo "</table>
							</form>
							</div>";
					}
					elseif($_REQUEST['opt'] == 'o')
					{
						$name=(string)$_SESSION['uid'].'.txt';
						$file=fopen("logs/administrator/".$name,'a');
						fwrite($file,$_SESSION['uid']." ".date("d/m/y h:i:s")." Logged Out\n ..");
						fclose($file);
						session_destroy();
						header("Location: administrator.php");

					}
					echo "</div>
			   </body>
		  </html>";

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
			<h4 style='background-color:black;'><font color='white'>Administrator Login</font></h4>
			<form name='login' method='post' action='$_SERVER[PHP_SELF]'>
				<table align='center'>
					<tr><td>UserName</td><td><input type='text' name='username'/></td></tr>
					<tr><td>Password</td><td><input type='password' name='password'/></td></tr>
					<tr><td></td><td><input type='submit' value='Login'onclick='login(this.form);'/></td></tr>
				</table>
		   </form>
		   </div>";
}
echo "</body>	
	  </html>";
?>