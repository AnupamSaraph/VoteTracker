<?PHP
require 'database.php';

$cnt=mysql_query("select * from issuers");
$cnt = mysql_num_rows($cnt);
echo $cnt;

?>