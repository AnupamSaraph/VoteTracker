<?php
    require 'database.php';
    $opt=$_POST['opt'];
    $output=null;
    if($opt == 'a')
    {
        $issuer_name=null;
        $issuer_id=$_POST['issuer_id'];
        $res=mysql_query("select name from issuers where issuer_no=$issuer_id")or die(mysql_error());
        while($row= mysql_fetch_array($res))
            $issuer_name=$row['name'];
        
        $output ="<h4 style='margin-top:0px;margin-bottom:0px;'>$issuer_name</h4>";
        $res=mysql_query("select * from voter where srno in(select voter_srno from voter_issuer where issuer_id=$issuer_id)")or die(mysql_error());
        $output .="<table width='950px';>";
        $output .="<tr bgcolor='grey'style='color:white;'><th>Voter Id</th><th>Constituency</th><th>Name</th><th>Gender</th><th>Nation</th><th>State</th><th>Email</th></tr>";
        $color=array('#C2E0FF', '#99CCFF');
        $i=1;
        while($row=mysql_fetch_array($res))
        {
            $voter_id=null;
            $const_id=null;
            $srno=$row['srno'];
            $id=mysql_query("Select * from voter_issuer where voter_srno=$srno")or die(mysql_error());
            while($rw=mysql_fetch_array($id))
            {
                $voter_id=$rw['voter_id'];
                $const_id=$rw['const_id'];
            }
            $id=mysql_query("Select * from constituency where srno=$const_id")or die(mysql_error());
            while($rw=mysql_fetch_array($id))
            {
                $const_id=$rw['name'];
            }
            
            $output .="<tr bgcolor=".$color[$i%2]."><td>$voter_id</td><td>".$const_id."</td><td>".$row['v_fname']." ".$row['v_mname']." ".$row['v_lname']."</td><td align='center'>".$row['gender']."</td><td>".$row['nation']."</td><td>".$row['state']."</td><td>".$row['email']."</td></tr>";
            $i++;
        }
        $output .="</table>";
    }
    else if($opt == 'b')
    {
        $issuer_id=$_POST['issuer_id'];
        $result =mysql_query("select * from constituency where issuer_id=$issuer_id");
        $color=array('#C2E0FF', '#99CCFF');
        $i=1;
        $output ="<table width='950px'><tr style='color:white;background-color:grey;'><th>Sr.no</th><th>No. Of Voters</th><th>No Of Election</th><th>Name</th><th>Description</th></tr>";
        while($row=mysql_fetch_array($result))
        {
            $cnt=mysql_query("Select get_constituency_voters_no('".$issuer_id."',".$row['srno'].")as count");
            $cnt=  mysql_fetch_object($cnt);
            $cnt=$cnt->count;
            $srno=$row['srno'];
            $election_cnt=mysql_query("select count(*) from elections_voterissuer where const_id=$srno")or die(mysql_error());
            $r_cnt= mysql_fetch_row($election_cnt);
            $election_cnt=$r_cnt[0];
            
            $output .="<tr bgcolor='".$color[$i%2]."'><td align='center'>".$i."</td><td align='center'>".$cnt."</td><td align='center'>".$election_cnt."</td><td><a href=# style='text-decoration:none;color:black;'onClick=getElection($srno); >".$row['name']."</a></td><td>".$row['description']."</td></tr>";
            $i++; 
        }
        $output .="</table>";
    }
    else if($opt =='c')
    {   
        $output=null;
        $const_id=$_POST['const_id'];
        $output ="<table width='950px'><tr style='color:white;background-color:grey;'><th>Sr.no</th><th>Start Date</th><th>End Date</th><th>Candidates No</th><th>Name</th><th>Purpose</th></tr>";
        $result=mysql_query("select * from elections where sr_no in(select election_id from elections_voterissuer where const_id=$const_id)")or die(mysql_error());
        $color=array('#C2E0FF', '#99CCFF');
        $i=1;
        while($row=mysql_fetch_array($result))
        {
            $srno=$row['sr_no'];
            $cand_cnt=mysql_query("select count(*) from candidates where election_id=$srno")or die(mysql_err0r());
            $cand_cnt=mysql_fetch_row($cand_cnt);
            $cand_cnt=$cand_cnt[0];
            $output .= "<tr bgcolor=".$color[$i%2]."><td>$i</td><td>".$row['start_date']."</td><td>".$row['end_date']."</td><td align='center'>$cand_cnt</td><td>".$row['election_name']."</td><td>".$row['election_purpose']."</td></tr>";
        }
        $output .="</table>";
      
    }
    else
    {
        echo "hello";
    }
    echo $output;
?>
