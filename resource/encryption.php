<?PHP

echo "<html><head><title>Encryption</title></head><body>";

if(!isset($_POST['number']))
{
	echo "<h3>Encryption</h3>";
	echo "<form method='post' action='".$_SERVER['PHP_SELF']."'>
			Enter Number:<input type='text' name='pre' size='2' maxlength='2'/> 
						 <input type='text' name='number' size='13' maxlength='13'/>";
	echo "<input type='submit' value='Submit'/>";
	echo "</form>";
}
else
{
	$num=$_POST['pre'].$_POST['number'];
	echo "<b>Your Number :</b> $num";
	echo "<br />";
    
	$ascii_no1= substr($_POST['pre'],0,-1);
	$ascii_no2=substr($_POST['pre'],-1);
	
	echo "<br /><b>ASCII Values</b> <br />";
	echo "$ascii_no1 =".ord($ascii_no1)."<br/> ";
	echo "$ascii_no2 =".ord($ascii_no2)."";

	
	$voter_id=ord($ascii_no1).ord($ascii_no2).$_POST['number'];
	echo "<br/></br><b>Voter id</b>=". $voter_id."";
	$ans=sum($voter_id);
	while($ans >9)
	{
		$ans=sum($ans);
	}
	echo "<br/><br/><b>Sum of Above Digits :</b> ".$ans."";
	
	if(isPrime($ans))
	{
		echo "<br/><br/><b>Number is Prime</b>";
		$voter_id= odd_even($voter_id,6,4);
		echo "<br />".$voter_id."";
	}
	else 
	{
		echo "<br/><br/><b>Number is Not Prime</b>";
		$voter_id= odd_even($voter_id,3,2);
		echo "<br />".$voter_id."";
	}
	//add the products 
	$voter_id_sum=sum($voter_id);
	echo "<br/><br/><b>This is Product</b>=".$voter_id_sum."";
	$final_ans=$voter_id_sum % 10;
	$check_sum=10-$final_ans;

	echo "<br/><br/><b>Encrypted Number :</b> ".$_POST['pre'].$_POST['number'].$check_sum."";

	echo "<br/ ><br /><a href='1.php'>Back</a>";
}

echo "</body></html>";


//Function for Addition of Digits 
function sum($val_num)
{	
	$val=str_split($val_num,1);
	$sum=0;
	$cnt=count($val);

	for($i=0;$i<$cnt;$i++)
	{
		$sum=$sum+$val[$i];
	}

	return $sum;
}

function isPrime($val)
{
	if($val <2)
		return false;
	for($i=2;$i<=($val/2);$i++)
	{
		if($val % $i ==0)
			return false;
	}
	return true;
}

function odd_even($voter_id,$even,$odd)
{
	$arr=str_split($voter_id,1);
	$voter_id_ans;
	for($i=0;$i<count($arr);$i++)
	{
		if($i%2==0)
		{
			$voter_id_ans[$i]=$arr[$i] * $even;
		}
		else
			$voter_id_ans[$i]=$arr[$i] * $odd;
	}
	echo "<br />";
//	print_r($voter_id_ans);
	$voter_id_ans=implode($voter_id_ans);
	return $voter_id_ans;
}

?>