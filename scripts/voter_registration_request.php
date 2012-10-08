<?php
    require 'database.php';
    require 'email.php';
    
    $issuer_id=$_POST['issuer_id'];
    $voter_name=$_POST['voter_name'];
    $email=$_POST['email'];
    $response ="<h4 style='color:white;background-color:red;'>Please Enter All Information</h4>";
    if($issuer_id !=0 && $voter_name != null && $email != null)
    {
        $result=mysql_query("Select * from voter where email ='".$email."'");
        $count=mysql_num_rows($result);
        if($count == 0)
        {
            $msg="Please Click on This Link To Complete Your Registration http://localhost/OpenVote/scripts/add_new_voter.php?id=$email&s_id=$issuer_id";
            $voter_name=  explode(" ", $voter_name);
            $fname=$voter_name[0];
            $mname=$voter_name[1];
            $lname=$voter_name[2];
            
            $sql ="insert into voter(v_fname,v_mname,v_lname,f_fname,f_mname,f_lname,m_fname,m_mname,m_lname,gender,marital_status,reg,nation,state,city,colony,postal_pin,email,status)
                                    value('".$fname."','".$mname."','".$lname."','N/A','N/A','N/A','N/A','N/A','N/A','-','-','N/A','N/A','N/A','N/A','N/A','N/A','".$email."','W')";
            if(smtpmailer($email, 'voteopen@gmail.com', 'Open Vote', 'Voter Verification', $msg))
            {
		$url = 'N/A';
		mysql_query($sql)or die(mysql_error());
		$response ="<h4 style='color:white;background-color:green;'>Verifiaction Email Has Been Send To Your Email Address</h4>";
            }
        }
        else
            $response="<h4 style='color:white;background-color:red'>You Already Registered</h4>";
    }
    echo $response;
?>
