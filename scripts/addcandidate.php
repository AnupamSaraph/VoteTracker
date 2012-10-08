<?php
require 'database.php';

$election_id=explode('#',$_POST['election_id']);
$voter_id=(string)$_POST['voter_id'];
$res=null;
if($election_id != null && $voter_id != null)
{    
    for($i=0;$i<count($election_id)-1;$i++)
    {
        $query=mysql_query("Select count(*) from candidates where voter_id='".$voter_id."' and election_id=$election_id[$i]")or die(mysql_error());
        $query=mysql_fetch_row($query);
        $count=$query[0];
        
       if($count == 0)
        {
            $sql ="Select add_candidate(".$election_id[$i].",'".$voter_id."') as status";
            $cnt=mysql_fetch_object(mysql_query($sql));
            $cnt=$cnt->status;
            if($cnt == 1)
            {
            $res ="<h4 style='color:green'>Registration Successful</h4>";

            }
            else
            {
                $res ="<h4 style='color:red'Registration Failed.Please Try Again</h4>";
            }
        }
        else
        {
            $res ="<h4 style='color:red'>Registration Failed.Please Try Again</h4>";
        }
            
        
    }
    
}
echo $res;

?>
