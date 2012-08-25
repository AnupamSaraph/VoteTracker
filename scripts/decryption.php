<?PHP

echo "<html><head><title>Decryption</title></head><body>";

if(!isset($_POST['number']))
{
	echo "<h3>Decryption</h3>";
	echo "<form method='post' action='".$_SERVER['PHP_SELF']."'>
			Enter Number:<input type='text' name='number' size='17' maxlength='16'/>";
	echo "<input type='submit' value='Submit'/>";
	echo "</form>";
}
else
{	
	$number=$_POST['number'];
	$check_sum=substr($number,-1);
	$pre=substr($number,0,2);
	$pre=ord(substr($pre,0,-1)).ord(substr($pre,-1));


	$number=substr($number,2,13);
	$number= $pre.$number;
	echo "<br/><br/>".$number."";
	$ans=sum($number);
	while($ans >9)
	{
		$ans=sum($ans);
	}
	echo "<br/><b>Sum of Above Digits :</b> ".$ans."";
	
	if(isPrime($ans))
	{
		echo "<br/><br/><b>Number is Prime</b>";
		$num= odd_even($number,6,4);
		echo "<br />".$num."";
	}
	else 
	{
		echo "<br/><br/><b>Number is Not Prime</b>";
		$num= odd_even($number,3,2);
		echo "<br />".$num."";
	}

	$voter_id_sum=sum($num);
	echo "<br/><br/><b>This is Product</b>=".$voter_id_sum."";
	
	$voter_id_sum=(int)$voter_id_sum+(int)$check_sum;
	echo "<br/><br/>Number after adding Check Sum :".$voter_id_sum."";

	if($voter_id_sum % 10 == 0)
		echo "<br/><h4>This is Valid Number</h4>";
	else
		echo "<br/><h4>This is NOT Valid Number</h4>";

	echo "<br/ ><br /><a href='2.php'>Back</a>";
}

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