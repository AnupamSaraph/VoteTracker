<?php
require 'scripts/database.php';

 $result= mysql_query("Select * from issuers where status='N'") or die(mysql_error());
  echo "<table border=1 cellpadding=5 cellspacing=5>";
  echo "<tr><th></th><th>Name</th><th>Registration Number</th><th>Website Address(Url)</th></tr>";
  while($row = mysql_fetch_array($result))
  {
  	echo"<tr>";
    echo"<td><input type='checkbox' name='' value='".$row['srno']."'/></td><td>".$row['name']."</td><td>".$row['reg_no']."</td><td>".$row['url']."</td>";
	echo"</tr>";
 
  }
  echo "</table>";
	 echo "hi";
?>