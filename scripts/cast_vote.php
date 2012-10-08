<?php
    require 'database.php';
    $elected_voter_id=$_POST['elected_voter'];
    $voter_id=$_POST['voter_id'];
    $election_id=$_POST['election_id'];
    $result=null;
    
    $res=mysql_query("select cast_vote('$elected_voter_id','$voter_id',$election_id)as value")or die(mysql_error());
    $res=mysql_fetch_object($res);
    $res=$res->value;
    
    if($res == 1)
        $result="<h4 style='color:green;'>Vote Registered. Thank You.</h4>";
    else
        $result="<h4 style='color:red;'>You have already Registered.</h4>";
    
    echo $result;
?>
