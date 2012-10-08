<?php
require 'database.php';
$election_id=$_POST['election_id'];
//$output =null;

$result=null;
$candidate_name=null;
$score=null;


$sql="select * from candidates where election_id=$election_id";
$result=mysql_query($sql)or die(mysql_error());
while($row=mysql_fetch_array($result))
{
       
    $candidate_id=$row['voter_id'];
    $count=mysql_query("Select get_result($election_id,'".$candidate_id."') as cnt")or die(mysql_error());
    $count=mysql_fetch_object($count);
    $count=$count->cnt;
    
    $sql="Select * from voter where srno=(select voter_srno from voter_issuer where voter_id='".$candidate_id."')";
    $res=mysql_query($sql)or die(mysql_error());
    $full_name;
    while($name=mysql_fetch_array($res))
    {
        $full_name=$name['v_fname'];
    }
    $candidate_name .=$full_name.",";
    $score .=$count.",";
    
    
}

$result =$candidate_name."&".$score;

echo $result;
?>
