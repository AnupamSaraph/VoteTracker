<?php
    require 'database.php';
    $election_id =(int)$_POST['election_id'];
    session_start();
    $vot=$_SESSION['voter_id'];
    $sql ="select * from voter 
            where srno in(select voter_srno from voter_issuer 
                                where voter_id in (select voter_id from candidates
                                                            where status = 'Y' and election_id=".$election_id."))";
    $result="<form name='election_vote'><h4>Register Your Vote</h4><table width='535px'>";
    $color = array('#C1D5F8','#F0F4FD');
    $res=mysql_query($sql);
    for($i=0;$row=mysql_fetch_array($res);$i++)
    {
        $full_name =$row['v_fname']." ".$row['v_mname']." ".$row['v_lname'];
        $srno=$row['srno'];
        $query="select voter_id from voter_issuer where voter_srno =$srno";
        $get_voter_id=mysql_query($query);
        while($rw=mysql_fetch_array($get_voter_id))
        {
            $voter_id =$rw['voter_id'];
            $result .= "<tr bgcolor='".$color[$i%2]."'><td align='center'><input type='radio' id='vote' name='vote' value=".$voter_id."></td><td>".$full_name."</td></tr>";
        }
        
    }
    $result .="<tr bgcolor='#6495ED'><td align='center'><input type='radio' name='vote' value='NULL'><input type='hidden' name='voter_id' value='$vot'><input type='hidden' name='election_id' value='$election_id'></td><td>Null Vote</td></tr>
               <tr><td></td><td><input type='button' value='Register Vote' onClick=voteRegister(this.form)></td></tr></form>";
    echo $result;
?>
