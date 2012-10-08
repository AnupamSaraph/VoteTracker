<?php
    require 'database.php';
    $output =null;
     $election_id=$_POST['election_id'];
    $result=mysql_query("Select * from elections where sr_no=$election_id")or die(mysql_error());
    $output ="<table width=300px>";
    while($rw=mysql_fetch_array($result))
    {
        $output .="<tr><td><b>Name</b></td><td>".$rw['election_name']."</td></tr>";
        $output .="<tr><td><b>StartDate</b></td><td>".$rw['start_date']."</td></tr>";
        $output .="<tr><td><b>EndDate</b></td><td>".$rw['end_date']."</td></tr>";
        $output .="<tr><td valign='top'><b>Purpose</b></td><td>".$rw['election_purpose']."</td></tr>";
    }
    $output .="</table><br/>";
    $output .="<h4 style='margin-top:0px;margin-bottom:0px;'>List of Candidates</h4>";
    $output.="<table width=300px><tr style='background-color:grey;color:white;'><th>Sr.no</th><th>Name</th><th>Count</th></tr>";
    
    $sql =" select * from voter where srno in(select voter_srno from voter_issuer where voter_id in (select voter_id from candidates where election_id=$election_id));";
    $sql=mysql_query($sql)or die(mysql_error());
    $i=1;
    $color = array('#C1D5F8','#F0F4FD');
    while($row=mysql_fetch_array($sql))
    {
        $candidate_id=$row['srno'];
        $candidate_id="select voter_id from voter_issuer where voter_srno=(select srno from voter where srno=$candidate_id)";
        $candidate_id=mysql_query($candidate_id)or die(mysql_error());
        $candidate_voter_id=null;
        while($rw=mysql_fetch_array($candidate_id))
        {
            $candidate_voter_id=$rw['voter_id'];
        }
        $candidate_vote_count=mysql_query("select get_result($election_id,'".$candidate_voter_id."')as count");
        $candidate_vote_count=mysql_fetch_object($candidate_vote_count);
        $candidate_vote_count=$candidate_vote_count->count;
        
        $output .="<tr bgcolor='".$color[$i%2]."'><td>$i</td><td>".$row['v_fname']." ".$row['v_mname']." ".$row['v_lname']."</td><td>$candidate_vote_count</td></tr>";
        $i++;
    }
    $output .="</table>";
    echo $output;
?>
