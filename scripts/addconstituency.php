<?php
 require 'database.php';
 
 $const_name = $_POST['const_name'];
 $issuer_id = $_POST['issuer_no'];
 $desc=$_POST['desc'];
 
 $response = null;
 
 if($const_name != null && $issuer_id != null)
 {
     $result=mysql_query("Select * from constituency where issuer_id='$issuer_id' and name='$const_name'")or die(mysql_error());
     $count=mysql_num_rows($result);
     if($count == 0)
     {
         mysql_query("insert into constituency(name,issuer_id,description) values('$const_name',$issuer_id,'$desc')")or die(mysql_error());
         $response = 1;
     }
         
 }
 else
     $response=0;
 
 echo $response;
?>
