<?php
 $to = "digvijaymohite@ymail.com";
 $subject = "Hi!";
 $body = "Hi,\n\nHow are you?";
 echo "hi";
 if (mail($to, $subject, $body)) {
   echo("<p>Message successfully sent!</p>");
  } else {
   echo("<p>Message delivery failed...</p>");
  }
 ?>