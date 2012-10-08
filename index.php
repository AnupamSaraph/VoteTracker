<?PHP 
require 'scripts/database.php';
if(isset($_POST['login_username']) && isset($_POST['login_password']))
{
    require 'scripts/database.php';
    $username=(string)$_POST['login_username'];
    $password=(string)$_POST['login_password'];
        
    $sql="select * from voter_login where voter_id='$username' and password='$password'";
    $result=mysql_query($sql);
    $count=mysql_num_rows($result);
    if($count == 1)
    {
        echo $count;
        unset($count);
        session_start();
        $_SESSION['voter_id']=$username;
        header("Location: voter_profile.php?opt=a");
       	unset($_REQUEST['password']);
	unset($_REQUEST['username']);
        echo "hello";
     
    }    
}

echo "
	<html>
		<head>
			<title>OpenVote</title>
			 <link rel='stylesheet' type='text/css' href='resource/css/style.css'/>";
if(isset($_REQUEST["opt"]))
{
	$opt = $_REQUEST["opt"];
	$opt= (string)$opt;
	if($opt == 'req')
	{
		echo "
		<script type='text/javascript' src='resource/js/add_voter.js'></script>
		</head>
		 <body>
		  <div class='registration'>
			 <div>	
						<h1>OpenVote</h1>
			 </div>
			 <div>
				<h4 style='background-color:black;'><font color='white'>Voter Registration Form</font></h4>
				<form name='voter'>";
                                echo"<table>";
                               $sql ="Select * from issuers where status = 'Y'"; 
                               $result=mysql_query($sql);
                               echo"<tr><td>Select Issuer</td><td>";
                               echo"<select name='issuer_name'><option value='0'>Select Issuer</option>";
                               while($row=mysql_fetch_array($result))
                               {
                                  echo "<option value='".$row['issuer_no']."'>".$row['name']."</option>";
                               }
                               echo "</select></td></tr>";
                               echo "<tr><td>Full Name</td><td><input type='text' name='voter_name' size='65'></td></tr>";
                               echo "<tr><td>Email</td><td><input type='text' name='voter_email' size='30'></td></tr>";
			       echo "</table>
					<input type='button' value='Submit' onClick=voter_registration_request()><input type='reset' value='Clear' onclick='window.location.href=window.location.href'>
				</form>
				<p><h4><span id='txtHint1'></span></h4></p>
				
			</div>
		  </div>
		 </body>
		</html>";		
	}
	else if($opt == 'cnt')
	{
		echo "
			<script type='text/javascript' src='resource/js/add_voter.js'></script>
			</head><body>
			 <div class='registration'>
				<div>	
					<h1>OpenVote</h1>
				</div>
				 <div>
					<h4 style='background-color:black;'><font color='white'>New Issuing Authority Registration</font></h4>
					<form name='issuer' method='post'>
					  <table>
						<tr><td>Name</td><td><input type='text' name='i_name'/></td></tr>
						<tr><td>Registered Domain Name:</td><td><input type='text' name='registration_no'/></td></tr>
						<tr><td>Email:</td><td><input type='text' name='email'/></td></tr>
						<tr><td>Website Address(URL)</td><td><input type='text' name='url'/></td></tr>
					  </table>
						<input type='Button' value='Submit' onclick=addissuer(this.form);> <input type='reset' value='Clear' onclick='window.location.href=window.location.href'>
					</form>
					<p><h4 style='background-color:red;'><font color='white'><span id='txtHint2'></font></span></h4></p>
					<p><h4 style='background-color:green;'><font color='white'><span id='txtHint1'></font></span></h4></p>
				</div>
			</div>
		 </body>";
	}
	else
		echo "Sorry For Problem Please Refresh this Page.";
}
else
{
  echo "</head><body>
		<div class='centered'>
		  
		  <div style='border:2px solid white;'>	
				<h1 style='color:white;'>OpenVote</h1>
		  </div>

		  <div class='div_left'>
				<br><br>
				<caption><font color='white'>Having Token Number</font></caption>
				<hr>
				<form name='token' method='post'>	
					<table class='table_center'>
						<tr><td><font color='white'>Enter Token Number</font></td><td><input type='text' name='token'/></td></tr>
						<tr><td><font color='white'>Enter Voter Id</font></td><td><input type='Password' name='voter_id' maxlength='16'/></td></tr>
						<tr><td></td><td><input type='submit' value='Enter'/><input type='reset' value='Clear'/></td></tr>
					</table>
				</form>
		  </div>
		  
		  <div class='div_right'>
				<br><br>
				<form name='profile' method='post' action=$_SERVER[PHP_SELF]>
					<caption><font color='white'>Login to Manage Your Profile</font></caption>
					<hr>
					<table class='table_center'>
						<tr><td><font color='white'>User Name</font></td><td><input type='text' name='login_username'/></td></tr>
						<tr><td><font color='white'>Password</font></td><td><input type='password' name='login_password'/></td></tr>
						<tr><td></td><td><input type='submit' id='submit' value='Login'/><input type='reset' value='cancel'/></td></tr>
					</table>
				</form>
		  </div>
		 <div style='border:1px solid white;'>	
				<font color='white' size='2'><a style='text-decoration:none;color:white;' href=?opt=req>Request For Registration</a></font>
		 </div>
		 <div style='border:1px solid white;'>	
				<font color='white' size='2'><a style='text-decoration:none;color:white;' href=?opt=cnt>Want to Conduct Election Click Here</a></font>
		 </div>

		</div>
	 </body>
	</html>";
}
?>