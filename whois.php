<?php

$domain = 'sicsr.ac.in';
$whois = '';
$connection = @fsockopen('whois.domaintools.com', 43);
if ($connection) {
    @fputs($connection, $domain ."\r\n");
    while (!feof($connection)) {
        $whois .= @fgets($connection, 128);
    }
}
fclose($connection);
echo $whois;
?>