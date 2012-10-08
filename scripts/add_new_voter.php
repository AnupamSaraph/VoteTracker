<?php
 require 'database.php';
 require 'email.php';

 if(isset($_POST['f_fname']))
 {
        $issuer_id=$_POST['issuer_id'];
        $s_fname=(string)$_POST['s_fname'];
        $s_mname=(string)$_POST['s_mname'];
        $s_lname=(string)$_POST['s_lname'];
        $fname=(string)$_POST['fname'];    
        $mname=(string)$_POST['mname'];
        $lname=(string)$_POST['lname'];
        $f_fname=(string)$_POST['f_fname'];
        $f_mname=(string)$_POST['f_mname'];
        $f_lname=(string)$_POST['f_lname'];
        $m_fname=(string)$_POST['m_fname'];
        $m_mname=(string)$_POST['m_mname'];
        $m_lname=(string)$_POST['m_lname'];
        $gender=(string)$_POST['gender'];
        $marital_status=(string)$_POST['rel'];
        $nation=(string)$_POST['nation'];
        $state=(string)$_POST['state'];
        $city=(string)$_POST['city'];
        $colony=(string)$_POST['colony'];
        $pin=(string)$_POST['pin'];
        $const_id=$_POST['const'];
        $email=$_POST['email'];
        $password=$_POST['voter_password'];
        
        if($const_id != 'NOTSELECTED' && $fname != null && $mname != null && $lname != null && $f_fname != null && $f_mname != null && $f_lname != null && $m_fname != null && $m_mname != null && $m_lname != null && $gender != null && $marital_status != null && $nation != null && $state != null && $city != null && $colony != null && $pin != null && $password != null)
        {
            $result=mysql_query("Select * from voter where v_fname='".$s_fname."'AND v_mname='".$s_mname."' AND v_lname='".$s_lname."' AND email='".$email."' AND status='W'");
            $count = mysql_num_rows($result);
            echo $count;
            if($count == 1)
            {
                $srno=null;
                
                if($gender == "male")
                        $gender = "M";
                else
                        $gender = "F";

                if($marital_status == "single")
                        $marital_status = "S";
                else
                        $marital_status = "M";
                $status = "Y";
                
                $sql_update = "update voter set 
                                        v_fname='$fname',
                                        v_mname='$mname',
                                        v_lname='$lname',
                                        f_fname='$f_fname',
                                        f_mname='$f_mname',
                                        f_lname='$f_lname',
                                        m_fname='$m_fname',
                                        m_mname='$m_mname',
                                        m_lname='$m_lname',
                                        gender='$gender',
                                        marital_status='$marital_status',
                                        nation='$nation',
                                        state='$state',
                                        city='$city',
                                        colony='$colony',
                                        postal_pin='$pin',
                                        status='$status' where email='$email'";

                mysql_query($sql_update)or die(mysql_error());
                
                $res=mysql_query("select * from voter where email='".$email."'");
                $cnt=mysql_num_rows($res);
                if($cnt ==1)
                {
                    $row=mysql_fetch_array($res);
                    $srno=$row['srno'];
                }
                $voter_id=$issuer_id."Voter".$srno;
                mysql_query("insert into voter_issuer(voter_srno,const_id,voter_id,issuer_id)
                                values(".$srno.",".$const_id.",'".$voter_id."','".$issuer_id."')");
                
                //generate voter_id here....
                mysql_query("insert into voter_login(voter_id,password) values('".$voter_id."','".$password."')") or die(mysql_error());
                $msg="You are successfully Registerd with OpenVote Your Login ID :".$voter_id." And password:".$password."";
                smtpmailer($email, 'voteopen@gmail.com', 'Open Vote', 'Registration Successfull', $msg);
                
                echo "You have Registered Successfully";
            }
            else
                echo "Please Enter Correct Information";
        }
 }
 else
 {
        $email=$_REQUEST['id'];
        $issuer_id=$_REQUEST['s_id'];
        $f_name=null;
        $m_name=null;
        $l_name=null;

        $result=mysql_query("Select * from voter where status='W' and email='".$email."'");
        $row=mysql_fetch_array($result);
        $f_name=$row['v_fname'];
        $m_name=$row['v_mname'];
        $l_name=$row['v_lname'];
        $count=mysql_num_rows($result);
        if($count == 1)
        {
            echo "<div><form method='post' action=$_SERVER[PHP_SELF]><table align='center'>
                    <tr><td><input type='hidden' name='s_fname' value='".$f_name."'/><input type='hidden' name='s_mname' value='".$m_name."'/><input type='hidden' name='s_lname' value='".$l_name."'/><input type='hidden' name='issuer_id' value='".$issuer_id."'/><input type='hidden' name='email' value='".$email."'/></td></tr> 
                    <tr><td>Name</td><td><input type='text' id='fname' name='fname'/></td><td><input type='text' id='mname' name='mname'/></td><td><input type='text' id='lname' name='lname'/></td></tr>
                    <tr><td>Father's Name</td><td><input type='text' id='f_fname' name='f_fname'/></td><td><input type='text' id='f_mname' name='f_mname'/></td><td><input type='text' id='f_lname' name='f_lname'/></td></tr>
                    <tr><td>Mother's Name</td><td><input type='text' id='m_fname' name='m_fname'/></td><td><input type='text' id='m_mname' name='m_mname'/></td><td><input type='text' id='m_lname' name='m_lname'/></td></tr>
                    <tr><td>Gender</td><td><select id='gender' name='gender'><option value='male'>Male</option><option value='female'>Female</option></select></td></tr>
                    <tr><td>Marital status</td><td><select id='rel' name='rel'><option value='single'>Single</option><option value='married'>Married</option></select></td></tr>";
            echo"<tr><td>Select Constituency</td><td><select name='const'><option value='NOTSELECTED'>Select Constituency</option>";
            $result=mysql_query("Select * from constituency where issuer_id='".$issuer_id."'");
            while($row=mysql_fetch_array($result))
            {
                echo "<option value='".$row['srno']."'>".$row['name']."</option>";
            }
            echo "</select></td></tr>"; 
            echo "<tr><td>Nation</td><td><input type='text' id='nation' name='nation'></td></tr>
                    <tr><td>State</td><td><input type='text' id='state' name='state'></td></tr>
                    <tr><td>City</td><td><input type='text' id='city' name='city'></td></tr>
                    <tr><td>Colony</td><td><input type='text' id='colony' name='colony'></td></tr>
                    <tr><td>Postal Pin</td><td><input type='text' id='pin' name='pin'></td></tr>
                    <tr><td>Password</td><td><input type='password' name='voter_password'></td></tr>
                    <tr><td></td><td><input type='submit' value='submit'><input type='reset' value='clear'></td></tr>
                </table></form></div>";
        }
        else
        {
            echo "You are Already Registered";
        }
 }
?>
