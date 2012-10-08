<?php
    require 'database.php';
    $voter_id=$_POST['voter_id'];
    $voter_id=explode("#",$voter_id);
    $out_put=null;
    $flg=0;
    for($i=0;$i<count($voter_id);$i++)
    {
        $res=mysql_query("select active_inactive('$voter_id[$i]') as result")or die(mysql_error());
        $res=mysql_fetch_object($res);
        $cnt=$res->result;
        
        if($cnt == 1)
            $flg=1;
        else
            $flg=0;
             
    }
    if($flg=1)
          $out_put="<h4 style='color:green;'>Change Successfull</h4>";
    else
          $out_put="<h4 style='color:red;'>Fail. Try Again</h4>";
    echo $out_put;
?>
