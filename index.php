<?PHP 

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
				<form name='voter' method='post'>
				  <table>
					<tr><td>Name</td><td><input type='text' id='fname' name='fname'/></td><td><input type='text' id='mname' name='mname'/></td><td><input type='text' id='lname' name='lname'/></td></tr>
					<tr><td>Father's Name</td><td><input type='text' id='f_fname' name='f_fname'/></td><td><input type='text' id='f_mname' name='f_mname'/></td><td><input type='text' id='f_lname' name='f_lname'/></td></tr>
					<tr><td>Mother's Name</td><td><input type='text' id='m_fname' name='m_fname'/></td><td><input type='text' id='m_mname' name='m_mname'/></td><td><input type='text' id='m_lname' name='m_lname'/></td></tr>
					
					<tr><td>Gender</td><td><select id='gender' name='gender'><option value='male'>Male</option><option value='female'>Female</option></select></td></tr>
					<tr><td>Marital status</td><td><select id='rel' name='rel'><option value='single'>Single</option><option value='married'>Married</option></select></td></tr>
					
					<tr><td>Reg. Type</td><td><select id='reg' name='reg'><option value='public'>Public</option><option value='private'>Private</option></select></td></tr>
					<tr><td>Nation</td><td><input type='text' id='nation' name='nation'></td></tr>
					<tr><td>State</td><td><input type='text' id='state' name='state'></td></tr>
					<tr><td>City</td><td><input type='text' id='city' name='city'></td></tr>
					<tr><td>Colony</td><td><input type='text' id='colony' name='colony'></td></tr>
					<tr><td>Postal Pin</td><td><input type='text' id='pin' name='pin'></td></tr>
				  </table>
					<input type='Button' value='Submit' onclick=call(this.form);> <input type='reset' value='Clear' onclick='window.location.href=window.location.href'>
				</form>

				<p><h4 style='background-color:red;'><font color='white'><span id='txtHint2'></font></span></h4></p>
				<p><h4 style='background-color:green;'><font color='white'><span id='txtHint1'></font></span></h4></p>
				
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
						<tr><td>Registration No.</td><td><input type='text' name='registration_no'/></td></tr>
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
				<h1><a class='title' href='e_admin.php'>OpenVote</a></h1>
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
				<form name='profile' method='post'>
					<caption><font color='white'>Login to Manage Your Profile</font></caption>
					<hr>
					<table class='table_center'>
						<tr><td><font color='white'>User Name</font></td><td><input type='text' name='user_name'/></td></tr>
						<tr><td><font color='white'>Password</font></td><td><input type='password' name='password'/></td></tr>
						<tr><td></td><td><input type='submit' value='Login'/><input type='reset' value='cancel'/></td></tr>
					</table>
				</form>
		  </div>
		 <div style='border:1px solid white;'>	
				<font color='white' size='2'><a class='title' href=?opt=req>Request For Registration</a></font>
		 </div>
		 <div style='border:1px solid white;'>	
				<font color='white' size='2'><a class='title' href=?opt=cnt>Want to Conduct Election Click Here</a></font>
		 </div>

		</div>
	 </body>
	</html>";
}
?>