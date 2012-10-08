<?php 
 session_start();
 require 'scripts/database.php';
 $voter_id=$_SESSION['voter_id'];
 $date =date("Y-m-d");
 $constituency;
 $description;
 $sql ="select * from constituency
                where srno =(Select const_id from voter_issuer
                                       where voter_id = '".$voter_id."')";
 $sql=mysql_query($sql)or die(mysql_error());
 while($row=mysql_fetch_array($sql))
 {
      $constituency=$row['name'];
      $description=$row['description'];
 }
 
echo "<html>
      <head><title>Profile</title>
      <link rel='stylesheet' type='text/css' href='resource/css/style.css'/>
      <script type='text/javascript' src='resource/js/add_voter.js'></script>
      <script type='text/javascript' src='resource/js/RGraph.bar.js'></script>
      <script type='text/javascript' src='resource/js/RGraph.common.core.js'></script>
      </head>";   
   
echo "<body>
        <div>
            <div class='title1'>
		<font color='white' size='10'><b>OpenVote</b></font><br>
	   </div>
          <div class='sidebar'>
		<h4 style='background-color:#484848; margin-top:-3px; margin-bottom:0px'><font color='white'>Main Menu</font></h4>
		<h4 style='background-color:grey; margin-top:1px; margin-bottom:0px'><a id='link' href='voter_profile.php?opt=a'>Home</a></h4>
                <h4 style='background-color:grey; margin-top:1px; margin-bottom:0px'><a id='link' href='voter_profile.php?opt=b'>Register As Candidate</a></h4>
                <h4 style='background-color:grey; margin-top:1px; margin-bottom:0px'><a id='link' href='voter_profile.php?opt=c'>Audit Election</a></h4>
                <h4 style='background-color:grey; margin-top:1px; margin-bottom:0px'><a id='link' href='voter_profile.php?opt=d'>Logout</a></h4>
	 </div>
        </div>";

        if($_REQUEST['opt']=='a')
        {
            
            echo "<div class='content'>";
            echo "<h3 style='background-color:#D2D2D2;margin-top:0px'>Home</h3>";
            $issuer_name;
                echo "<div style='float:left;width:535px;'>";
                echo "<b>Profile Information</b>";
                    $sql="select name from issuers where issuer_no = (Select issuer_id from voter_issuer where voter_id ='".$voter_id."');";
                    if($result=mysql_fetch_array(mysql_query($sql)))
                        $issuer_name=$result['name'];
                    echo "<table width='400px'>
                            <tr><td><b>Voter Id</b></td><td>".$voter_id."</td></tr>
                            <tr><td><b>Organisation Name</b></td><td>".$issuer_name."</td></tr>
                            <tr><td><b>Constituency/Department</b></td><td>".$constituency."</td></tr>
                            <tr><td valign='top'><b>Description</b></td><td>".$description."</td></tr>
                        </table>";
                echo "<div style='width:535px;' id='election_result'></div>"; 
                echo "<p><h4><span id='result'></span></h4></p>";
                echo "</div>";

                echo "<div style='float:right;width:600px;'><b>You Have Election to Cast Vote</b>";
                $sql ="select * from elections where start_date <='".$date."' AND end_date >='".$date."' AND sr_no in (select election_id from elections_voterissuer where const_id = (select const_id from voter_issuer where voter_id ='".$voter_id."'))";
                $result=mysql_query($sql);
                $color = array('#C1D5F8','#F0F4FD');
                echo "<table align='center' width='600px'><caption>Click On Election to Vote</caption>";
                for($i=0;$row=mysql_fetch_array($result);$i++)
                {
                    echo "<tr bgcolor='".$color[$i%2]."'><td><a href='#' style='text-decoration:none; color:black;' onClick=election(".$row['sr_no'].");><b>".$row['election_name']."</b></a></td><td>".$row['election_purpose']."</td></tr>";
                }
                echo "<table>";
                echo "</div>";
           
           echo "</div>";
           
        }
        else if($_REQUEST['opt'] =='b')
        {
                echo "<div class='content'><h3 style='background-color:#D2D2D2;margin-top:0px'>Register As Candidate</h3>";
                echo "<div style='float:left; width:600px;'>";
                echo "<h4> Select Election</h4>";
            //    $result=mysql_query("select const_id, election_id from elections_voterissuer where const_id =(select const_id from voter_issuer where voter_id ='".$voter_id."')")or die(mysql_error());
                $sql ="select * from elections where start_date <='".$date."' AND end_date >='".$date."' AND sr_no in (select election_id from elections_voterissuer where const_id = (select const_id from voter_issuer where voter_id ='".$voter_id."'))";
                echo "<form method='post' name='candidate'>";
                $color = array('#C1D5F8','#F0F4FD');
                echo "<table width='600px'>";
                echo "<tr><td><input type='hidden' name='voter_id' value='".$voter_id."'></td><td></td></tr>";
                echo "<tr bgcolor='#6495ED'><td></td><th>Election Name</th><th>Purpose</th></tr>";
               
        /*        for($i=0;$row=mysql_fetch_array($result);$i++)
                {
                    $election_id=$row['election_id'];
                    $const_id=$row['const_id'];
                    $query = "select * from elections where start_date<='".$date."' AND end_date>='".$date."' AND sr_no in(select election_id from elections_voterissuer where const_id =".$const_id.")";
                    $res=mysql_query($query) or die(mysql_error());
                    while($rw=mysql_fetch_array($res))
                    {
                        echo "<tr bgcolor='".$color[$i%2]."'><td align='center'><input type=checkbox name='elections' value='".$rw['sr_no']."'></td><td>".$rw['election_name']."</td><td>".$rw['election_purpose']."</td></tr>";
                    }
                }*/
                $result=mysql_query($sql);
                 for($i=0;$row=mysql_fetch_array($result);$i++)
                {
                    echo "<tr bgcolor='".$color[$i%2]."'><td align='center'><input type=checkbox name='elections' value='".$row['sr_no']."'></td><td><b>".$row['election_name']."</b></td><td>".$row['election_purpose']."</td></tr>";
                }
            echo "<tr><td></td><td></td><td><input type='button' value='Apply' onclick=register_as_candidate(this.form)><input type='reset' value='Clear'></td></tr>";
            echo "</table>";
            echo "<form>";
            echo "<div id='candidate'></div>";
            echo "</div>";
            echo "<div style='float:right;width:535px'>";
            echo "<h4>Constituency Information</h4>";
            
             echo "<table width='550px;'>
                   <tr><td><b>Constituency Name</b></td><td>".$constituency."</td></tr>
                   <tr><td><b>Description</b></td><td>". $description."</td></tr>
                   </table>";
             
             echo "</div>";
               
             echo "</div>";
              
        }
        else if($_REQUEST['opt'] == 'c')
        {
             echo "<div class='content'><h3 style='background-color:#D2D2D2;margin-top:0px'>Audit</h3>";
                echo "<div style='float:left;width:300px;'>"; 
                echo "<h3 style='margin-bottom:0px;'>Select Election To View Result</h3>";
                $sql ="select * from elections where start_date <='".$date."' AND end_date >='".$date."' AND sr_no in (select election_id from elections_voterissuer where const_id = (select const_id from voter_issuer where voter_id ='".$voter_id."'))";
                $result=mysql_query($sql);
                $color = array('#C1D5F8','#F0F4FD');
                for($i=0;$row=  mysql_fetch_array($result);$i++)
                {
                    echo "<h4 style='background-color:".$color[$i%2].";margin-bottom:1px;margin-top:1px;'><a href=# style='text-decoration:none;color:black;'onclick='getResult(".$row['sr_no'].")'>".$row['election_name']."</a></h4>";
                }
                echo"</div>";
             echo "<div id='election_result' style='float:right;width:850px;'><canvas id='cvs' width='600' height='400'>[No canvas support]</canvas> </div>";
             echo "</div>";
        }
        else if($_REQUEST['opt'] == 'd')
        {
             session_destroy();
	     header("Location: index.php");
        }
echo"</body>
    </html>";

?>