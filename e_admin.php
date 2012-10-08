<?PHP
require 'scripts/database.php';
$date =date("Y-m-d");
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
                                <script type='text/javascript' src='resource/js/add_voter.js'></script>
                                <script type='text/javascript' src='resource/js/add_voter.js'></script>
                                <script type='text/javascript' src='resource/js/RGraph.bar.js'></script>
                                <script type='text/javascript' src='resource/js/RGraph.common.core.js'></script>
			 </head>
			<body>
			<div>
				<div class='title1'>
					<font color='white' size='10'><b>OpenVote</b></font><br>
				</div>
				 <div class='sidebar'>
					<h4 style='background-color:#484848; margin-top:1px; margin-bottom:0px;'><font color='white'>Main Menu</font></h4>
					<h4 style='background-color:black; margin-top:1px; margin-bottom:0px;'><a id='link' href='e_admin.php?opt=a&subopt=aa'>Voters</a></h4>
                			<h4 style='background-color:black; margin-top:1px; margin-bottom:0px;'><a id='link' href='e_admin.php?opt=b&subopt=aa'>Issue Token</a></h4>
                        		<h4 style='background-color:black; margin-top:1px; margin-bottom:0px;'><li><a id='link' href='e_admin.php?opt=c&subopt=aa'>Election Process</a></h4>
					<h4 style='background-color:black; margin-top:1px; margin-bottom:0px;'><a id='link' href='e_admin.php?opt=d&subopt=aa'>Audit</a></h4>
					<h4 style='background-color:black; margin-top:1px; margin-bottom:0px;'><a id='link' href='e_admin.php?opt=e&subopt=aa'>Organisation Profile</a></h4>
					<h4 style='background-color:black; margin-top:1px; margin-bottom:0px;'><a id='link' href='e_admin.php?opt=o&subopt=aa'>Logout</a></h4>
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
                                <script type='text/javascript' src='resource/js/add_voter.js'></script>
                                <script type='text/javascript' src='resource/js/add_voter.js'></script>
                                <script type='text/javascript' src='resource/js/RGraph.bar.js'></script>
                                <script type='text/javascript' src='resource/js/RGraph.common.core.js'></script>
			 </head>
			<body>
			<div>
				<div class='title1'>
					<font color='white' size='10'><b>OpenVote</b></font><br>
				</div>
				 <div class='sidebar'>
					<h4 style='background-color:#484848; margin-top:1px; margin-bottom:0px;'><font color='white'>Main Menu</font></h4>
					<h4 style='background-color:black; margin-top:1px; margin-bottom:0px;'><a id='link' href='e_admin.php?opt=a&subopt=aa'>Voters</a></h4>
					<h4 style='background-color:black; margin-top:1px; margin-bottom:0px;'><a id='link' href='e_admin.php?opt=b&subopt=aa'>Issue Token</a></h4>
					<h4 style='background-color:black; margin-top:1px; margin-bottom:0px;'><a id='link' href='e_admin.php?opt=c&subopt=aa'>Election Process</a></h4>
					<h4 style='background-color:black; margin-top:1px; margin-bottom:0px;'><a id='link' href='e_admin.php?opt=d&subopt=aa'>Audit</a></h4>
					<h4 style='background-color:black; margin-top:1px; margin-bottom:0px;'><a id='link' href='e_admin.php?opt=e&subopt=aa'>Organisation Profile</a></h4>
					<h4 style='background-color:black; margin-top:1px; margin-bottom:0px;'><a id='link' href='e_admin.php?opt=o&subopt=aa'>Logout</a></h4>
					
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
			$result= mysql_query("select * from voter where status = 'W' and srno in(select voter_srno from voter_issuer where issuer_id=".$_SESSION['issuer_id'].") order by srno desc;") or die(mysql_error());
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
					<td>Y</td>";
					echo"</tr>";
			}
			echo "</table>
			</form>";
			echo "</div>";
		}
                elseif($_REQUEST['subopt'] == 'bb')
		{
			echo"<form name='voter_waiting' method='post'>";
			echo "<input type='button' value='Remove Selected' onclick='#'/> <input type='reset' value='Clear All Checks'/>";
			$result= mysql_query("select * from voter where status = 'Y' and srno in(select voter_srno from voter_issuer where issuer_id=".$_SESSION['issuer_id'].") order by srno desc;") or die(mysql_error());
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
					<td>W</td>";
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
		 echo"<div class='content'>";
		 echo"<h4 style='background-color:#484848; margin-top:4px;'><font color='white'>ELECTION PROCESS</font></h4>";
		 echo"<div style='margin-top:-18px;' id='nav'>
				<ul id='subnavbar'>
					<li><a href='e_admin.php?opt=c&subopt=aa'>CreateElection</a></li>
					<li><a href='e_admin.php?opt=c&subopt=bb'>ManageCandidate</a></li>
					<li><a href='e_admin.php?opt=c&subopt=cc'>Constituency/Department</a><li>
				</ul>
			   </div>";
		 echo "</div>";
                 
                 if($_REQUEST['subopt'] == 'aa')
                 {
                     echo"<div class='content' style='margin-top:-40px;'>
                            <h3>Create Election</h3>
                            
                            <form name='election' method='post'>
                               <div style='float:left; width:550px'>
                                    <table>
                                    <tr><td>Election Name</td><td><input type='text' name='e_name' size=50></td></tr>
                                    <tr><td valign='top'>Election Purpose</td><td><textarea name='purpose' cols=50 rows=10></textarea></td></tr>
                                    <tr><td>Start Date</td><td><input type='date' name='start_date'> eg. yyyy/mm/dd</td></tr>
                                    <tr><td>End Date</td><td><input type='date' name='end_date'> eg. yyyy/mm/dd</td></tr>
                                    </table><br><br>
                                     <input type='button' value='Create' onclick=addelection(this.form.constituency);><input type='reset' value='Clear'>
                                     <p><h4 style='background-color:red;'><font color='white'><span id='txtHint2'></font></span></h4></p>
                                     <p><h4 style='background-color:green;'><font color='white'><span id='txtHint1'></font></span></h4></p>
                                </div>
                                
                                <div style='float:right; width:550px;'>
                                     Select Constituency For Election
                                     <table>";
                                     $issuer_id=$_SESSION['issuer_id'];
                                     $result = mysql_query("select * from constituency where issuer_id ='".$issuer_id."'")or die(mysql_error());
                                     while($row=mysql_fetch_array($result)) 
                                     {
                                          echo "<tr><td><input type='checkbox' name='constituency' value='".$row['srno']."' >".$row['name']."</td></tr>";
                                     }
                                     echo "</table>
                                 </div>
                               
                            </form>
                          </div>";
                 }
                 else if($_REQUEST['subopt'] == 'bb')
                 {
                      $issuer_id=$_SESSION['issuer_id'];
                     echo"<div class='content' style='margin-top:-40px;'>
                            <h3 style='margin-bottom:1px;'>Managing Candidate</h3>";
                     $sql="select * from elections where start_date <='".$date."' AND end_date >='".$date."' and sr_no in(select election_id from elections_voterissuer where issuer_id=$issuer_id)";
                     $result=mysql_query($sql);
                     echo"<div style='float:left;width:250px;'>";
                     echo "<h4 style='background-color:black;margin-top:0px;margin-bottom:1px;color:white;'>Select Election</h4>";
                     $color = array('#E6E6E6','#999999');
                     for($i=0;$row=mysql_fetch_array($result);$i++)
                     {
                         echo "<h4 style='margin-top:0px;margin-bottom:1px;background-color:".$color[$i%2].";'><a href=# style='text-decoration:none;color:black;' onClick=getCandidates(".$row['sr_no'].")>".$row['election_name']."</a></h4>";
                     }
                     echo "</div>";
                     echo "<div id='candidates_names' style='float:right;width:900px;'></div>";
                     echo "</div>";
                     
                 }
                 else if($_REQUEST['subopt'] == 'cc')
                 {
                     echo"<div class='content' style='margin-top:-40px;'>
                            <h3>Managing Constituency</h3>
                            
                          <div style='float:left; border:1px black solid; width:500px'>
                            <h4 style='background-color:#484848; margin-top:0px;'><font color='white'>Add New Constituency</font></h4>
                                <form name='constituency' method='post'>
                                    <table>
                                        <tr><td>Name</td><td><input type='text' name='c_name' /></td></tr>
                                        <tr><td></td><td><input type='hidden' name='issuer_id' value=".$_SESSION['issuer_id']."></td></tr>
                                        <tr><td valign='top'>Description</td><td><textarea name='description' rows='5' cols='40'></textarea></td></tr>
                                        <tr><td></td><td><input type='submit'value='Add Constituency' onclick=addconstituency(this.form);></td></tr>
                                    </table>
                                    <p><h4 style='background-color:red;'><font color='white'><span id='txtHint2'></font></span></h4></p>
				    <p><h4 style='background-color:green;'><font color='white'><span id='txtHint1'></font></span></h4></p>
                                </form>
                          </div>";
                          
                    echo"<div style='float:right; border:1px black solid; width:630px'>
                            <h4 style='background-color:#484848; margin-top:0px;'><font color='white'>List of Existing Constituency</font></h4>";
                            
                    echo"<table width='630px'>
                          <tr bgcolor='#C0C0C0'><th>Sr.no</th><th>Name</th><th>No Of Voters</th></tr>";
                    $color = array('#66A3FF', '#B2D1FF');
                    $issuer_id=$_SESSION['issuer_id'];
                    $result= mysql_query("Select srno,name from constituency where issuer_id=$issuer_id") or die(mysql_error());
                    for($i=1;$row=mysql_fetch_array($result);$i++)
                    {
                        $const_id=$row['srno'];
                        $cnt=mysql_fetch_object(mysql_query("SELECT get_constituency_voters_no('$issuer_id',$const_id) as result"));
                        $cnt=$cnt->result;
                        echo"<tr bgcolor='".$color[$i%2]."'>";
                        echo"<td>$i</td><td>".$row['name']."</td><td>$cnt</td>";
                        echo"</tr>";
                    }
                    echo"</table>
                       </div>
                     </div>";
                 }
                 
	}
	else if($_REQUEST['opt'] == 'd')
	{
                 $issuer_id=$_SESSION['issuer_id'];
		 echo "<div class='content'>";
		 echo"<h4 style='background-color:#484848; margin-top:4px;'><font color='white'>AUDIT</font></h4>";
                 echo "<form name='election'><table><tr><td>Election Name</td><td><select name='election_id' onchange=e_admin_audit(form.this);><option>Select Election</option>";
                        $sql=mysql_query("select * from elections where sr_no in(select election_id from elections_voterissuer where issuer_id='".$issuer_id."')")or die(mysql_error());
                        while($result=mysql_fetch_array($sql))
                        {
                            echo "<option value='".$result['sr_no']."'>".$result['election_name']."</option>";
                        }
                 echo "</select></td></tr></table></form>";
                 echo "<div>";
                 echo "<div id='ajax_election' style='float:left;width:300px;'></div>";
                 echo "<div id'graph'  style='float:right;'>";
                 echo "<canvas id='cvs' width='700' height='400'>[No canvas support]</canvas>";
                 echo "</div>";
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