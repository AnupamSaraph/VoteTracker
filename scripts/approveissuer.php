<?php
require 'database.php';
$url =(string)$_POST['app'];

$url= explode("#",$url);
$array_size = count($url);

session_start();
$name=(string)$_SESSION['uid'].'.txt';
$file=fopen("../logs/administrator/".$name,'a');

for($i=0;$i<$array_size;$i++)
{
	$result=get_issuer_number($url[$i]);
	$sql = "update issuers set status = 'Y',issuer_no ='".$result."' where srno = '".$url[$i]."'";
	mysql_query($sql) or die("0");
	fwrite($file,"..".$_SESSION['uid']." ".date("d/m/y h:i:s")." Approved Issuer ID=".$url[$i]." \n");
}
mysql_close($con);
echo "1";
fclose($file);

function get_issuer_number($srno)
{
	$result=$srno * 10;
	return $result;
}
?>