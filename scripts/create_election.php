<?php
require 'database.php';

$const_id=$_POST['app'];
$election_name = $_POST['e_name'];
$purpose = $_POST['e_purpose'];
$start_date=$_POST['start_date'];
$end_date=$_POST['end_date'];

$const_id_arr=explode("#",$const_id);
$response=0;
if($const_id_arr != null && $election_name != null && $purpose != null && $start_date != null && $end_date != null)
{
    mysql_query("insert into elections(election_name,election_purpose,start_date,end_date) 
                 values('$election_name','$purpose','$start_date','$end_date')")or die(mysql_error());
    
    for($i=0;$i< count($const_id_arr)-1;$i++)
    {
        mysql_query("select add_election($const_id_arr[$i],'$election_name','$start_date','$end_date')")or die(mysql_error());
        $response=1;
    }
        
}
else
    $response=0;

echo $response;
    

?>
