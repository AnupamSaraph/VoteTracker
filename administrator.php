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
			fwrite($file,"..".$test." ".date("d/m/y h:i:s")." Logged In \n");
			fclose($file);
			echo "<html>
			  <head>
				<title> Administrator Account</title>
				<link rel='stylesheet' type='text/css' href='resource/css/style.css'/>
				<script type='text/javascript' src='resource/js/add_voter.js'></script>
			</head>
				<body>
					<div>
						 <div class='title'>
								<h1 style='color:white;background-color:black;'>OpenVote</h1>
								<h4 style='color:white;background-color:black;margin-bottom:0px;'>Administrator : ".$_SESSION['uid']." </h4>
						 <div>
						 
						 <div class='sidebar'>
							<h4 style='background-color:black; margin-top:1px; margin-bottom:0px;color:white;'>Main Menu</h4>
							<h4 style='background-color:#484848; margin-top:1px; margin-bottom:0px;'><a id='link' href='administrator.php?opt=a&subopt=aa'>Manage Issuers</a></h4>
							<h4 style='background-color:#484848; margin-top:1px; margin-bottom:0px;'><a id='link' href='administrator.php?opt=b&subopt=n/a'>Voters</a></h4>
                                                        <h4 style='background-color:#484848; margin-top:1px; margin-bottom:0px;'><a id='link' href='administrator.php?opt=c&subopt=n/a'>Constituency</a></h4>
							<h4 style='background-color:#484848; margin-top:1px; margin-bottom:0px;'><a id='link' href='administrator.php?opt=o&subopt=n/a'>Logout</a></h4>
						 </div>";
						 echo "<div class='content'>";
							 echo "<div class='content'>";
							 echo"<h4 style='background-color:#484848; margin-top:4px;color:white;'>ISSUER INFORMATION</h4>";
							 echo"<div style='margin-top:-18px;' id='nav'>
									<ul id='subnavbar'>
									<li><a href='administrator.php?opt=a&subopt=aa'>Approve</a></li>
									<li><a href='administrator.php?opt=a&subopt=bb'>Delete</a></li>
								  </ul>
								  </div>";
							 echo "</div>";
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
				<script type='text/javascript' src='resource/js/add_voter.js'></script>
			</head>
				<body>
					<div>
						 <div class='title'>
								<h1 style='color:white;background-color:black;'>OpenVote</h1>
								<h4 style='color:white;background-color:black;margin-bottom:0px;'>Administrator : ".$_SESSION['uid']." </h4>
						 <div>
						
						 <div class='sidebar'>
                                                    <h4 style='background-color:black; margin-top:1px; margin-bottom:0px;color:white;'>Main Menu</h4>
                                                    <h4 style='background-color:#484848; margin-top:1px; margin-bottom:0px;'><a id='link' href='administrator.php?opt=a&subopt=aa'>Manage Issuers</a></h4>
                                                    <h4 style='background-color:#484848; margin-top:1px; margin-bottom:0px;'><a id='link' href='administrator.php?opt=b&subopt=n/a'>Voters</a></h4>
                                                    <h4 style='background-color:#484848; margin-top:1px; margin-bottom:0px;'><a id='link' href='administrator.php?opt=c&subopt=n/a'>Constituency</a></h4>
                                                    <h4 style='background-color:#484848; margin-top:1px; margin-bottom:0px;'><a id='link' href='administrator.php?opt=o&subopt=n/a'>Logout</a></h4>
						 </div>";

					if($_REQUEST['opt'] == 'a')
					{	
						 echo "<div id='target' class='content'>";
							 echo "<div class='content'>";
							 
							 echo"<h4 style='background-color:#484848; margin-top:4px; color:white;'>ISSUER INFORMATION</h4>";
							 echo"<div style='margin-top:-18px;' id='nav'>
									<ul id='subnavbar'>
									<li><a href='administrator.php?opt=a&subopt=aa'>Approve</a></li>
									<li><a href='administrator.php?opt=a&subopt=bb'>Delete</a></li>
								  </ul>
								  </div>";
							
							if($_REQUEST['subopt'] == 'aa')
							{
								echo"<p><h4><font color='green'><span id='response_positive'></font></span></h4></p>";
								echo"<form name='issuer' method='post'>";
								echo "<input type='button' value='Approve Selected' onclick='addSelected(this.form.issuer_no)'/> <input type='reset' value='Clear All Checks'/>";
								$result= mysql_query("Select * from issuers where status='N' order by srno desc") or die(mysql_error());
								echo "<table  width='1100' align='center' cellpadding=5 cellspacing=2>";
								echo "<tr bgcolor='#C0C0C0'><th></th><th>Name</th><th>Registration Number</th><th>Website Address(Url)</th><th> Email </th><th>Status</th></tr>";
								$color = array('#DCDCDC', '#F5F5F5');
								for($i=0;$row=mysql_fetch_array($result);$i++)
								{
									echo"<tr bgcolor='".$color[$i%2]."'>";
									echo"<td align='center'><input type='checkbox' name='issuer_no' value='".$row['srno']."'/></td><td>".$row['name']."</td><td>".$row['reg_no']."</td><td>".$row['url']."</td>
													<td>".$row['email']."</td><td>Pending</td>";
									echo"</tr>";
								}
								echo "</table>
								</form>";
								echo "</div>";
							}
							else if($_REQUEST['subopt'] == 'bb')
							{
								echo"<p><h4><font color='green'><span id='response_positive'></font></span></h4></p>";
								echo"<form name='issuer' method='post'>";
								echo "<input type='button' value='Remove Selected' onclick='deleteSelected(this.form.issuer_no)'/> <input type='reset' value='Clear All Checks'/>";
								$result= mysql_query("Select * from issuers where status='Y' order by srno desc") or die(mysql_error());
								echo "<table  width='1100' align='center' cellpadding=5 cellspacing=2>";
								echo "<tr bgcolor='#C0C0C0'><th></th><th>Name</th><th>Registration Number</th><th>Website Address(Url)</th><th> Email </th><th>Status</th></tr>";
								$color = array('#DCDCDC', '#F5F5F5');
								for($i=0;$row=mysql_fetch_array($result);$i++)
								{
									echo"<tr bgcolor='".$color[$i%2]."'>";
									echo"<td align='center'><input type='checkbox' name='issuer_no' value='".$row['srno']."'/></td><td>".$row['name']."</td><td>".$row['reg_no']."</td><td>".$row['url']."</td>
													<td>".$row['email']."</td><td>Approved</td>";
									echo"</tr>";
								}
							    echo "</table>
								</form>";
								echo "</div>";
							}
							echo "</div>";
					}
					elseif($_REQUEST['opt'] == 'b')
					{ 
                                             echo "<div id='target' class='content'>";
                                             echo "<div class='content'>";
                                             echo"<h4 style='background-color:#484848; margin-top:0px;color:white;margin-bottom:2px;'>VOTER INFORMATION</h4>";
                                                echo "<div style='float:left;width:200px;margin-top:0px'>";
                                                    echo "<h4 style='background-color:grey; margin-top:0px; margin-bottom:1px;'>Active Issuers</h4>";
                                                    $sql="select * from issuers";
                                                    $res=mysql_query($sql);
                                                    $color = array('#66A3FF', '#B2D1FF');
                                                    $i=0;
                                                    while($row=mysql_fetch_array($res))
                                                    {
                                                        $i++;
                                                        echo "<h4 style='background-color:".$color[$i%2].";color:black; margin-top:0px; margin-bottom:1px;'><a href=#; style='text-decoration:none; color:black;' onClick=getIssuerVoters(".$row['issuer_no'].");>".$row['name']."</a></h4>";
                                                    }
                                                echo "</div>";
                                                echo "<div style='float:right;width:950px;' id='ajaxdata'></div>";
                                            echo "</div>";
					}
                                        elseif($_REQUEST['opt'] == 'c')
					{ 
                                             echo "<div id='target' class='content'>";
                                             echo "<div class='content'>";
                                             echo"<h4 style='background-color:#484848; margin-top:0px;color:white;margin-bottom:2px;'>CONSTITUENCY INFORMATION</h4>";
                                                echo "<div style='float:left;width:200px;margin-top:0px'>";
                                                    echo "<h4 style='background-color:grey; margin-top:0px; margin-bottom:1px;'>Active Issuers</h4>";
                                                    $sql="select * from issuers";
                                                    $res=mysql_query($sql);
                                                    $color = array('#66A3FF', '#B2D1FF');
                                                    $i=0;
                                                    while($row=mysql_fetch_array($res))
                                                    {
                                                        $i++;
                                                        echo "<h4 style='background-color:".$color[$i%2].";color:black; margin-top:0px; margin-bottom:1px;'><a href=#; style='text-decoration:none; color:black;' onClick=getIssuerInfo(".$row['issuer_no'].");>".$row['name']."</a></h4>";
                                                    }
                                                echo "</div>";
                                                echo "<div style='float:right;width:950px;' id='ajaxdata'></div>";
                                            echo "</div>";
					}
					elseif($_REQUEST['opt'] == 'o')
					{
						$name=(string)$_SESSION['uid'].'.txt';
						$file=fopen("logs/administrator/".$name,'a');
						fwrite($file,"..".$_SESSION['uid']." ".date("d/m/y h:i:s")." Logged Out\n");
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
					<tr><td></td><td><input type='submit' value='Login'/></td></tr>
				</table>
		   </form>
		   </div>";
}
echo "</body>	
	  </html>";
?>