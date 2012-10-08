<?php
    require 'database.php';
    $election_id=$_POST['election_id'];
    $output="<form><input type='button' value='Active/InActive' onClick='active_inactive(this.form)'><input type='reset' value='Clear'><span id='res'></span><table width='900px'><tr bgcolor=grey><th></th><th>Voter Id</th><th>Constituency Name</th><th>State</th><th>Name</th><th>No Of Votes</th><th>Email</th></tr>";
    
    $sql="Select * from candidates where election_id=$election_id";
    $result=mysql_query($sql)or die(mysql_error());
    $color = array('#66A3FF', '#B2D1FF');
    $i=0;
    while($row=mysql_fetch_array($result))
    {
        $const_id=$row['const_id'];
        $status=$row['status'];
        $cons_name=mysql_query("select * from constituency where srno=$const_id");
        while($rw=mysql_fetch_array($cons_name))
            $const_id=$rw['name'];
        
        $voter_id=$row['voter_id'];
        $candidate_info="select * from voter where srno=(select voter_srno from voter_issuer where voter_id='".$voter_id."')";

        $candidate=mysql_query($candidate_info)or die(mysql_error());
        
        while($rs=mysql_fetch_array($candidate))
        {
            if($status == 'Y')
                $status ="<td bgcolor='green' style='color:white;'>Active</td>";
            else
                $status="<td bgcolor='red' style='color:white;'>Inactive</td>";
            $sql_cnt="Select get_result($election_id,'".$voter_id."')as count";
            $sql_cnt=mysql_query($sql_cnt);
            $cnt=mysql_fetch_object($sql_cnt);
            $cnt=$cnt->count;
            $output .="<tr bgcolor=".$color[$i%2]."><td><input type='checkbox' name='candidate_id' value='$voter_id'></td><td>$voter_id</td><td>".$const_id."</td>".$status."<td>".$rs['v_fname']." ".$rs['v_mname']." ".$rs['v_lname']."</td><td align='center'>".$cnt."</td><td>".$rs['email']."</td></tr>"; 
        }
        $i++;
      
    }
    $output .="</table></form>";
    echo $output;
?>
