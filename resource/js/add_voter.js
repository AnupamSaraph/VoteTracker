var xmlhttp;

if(window.XMLHttpRequest)
		xmlhttp=new XMLHttpRequest();
	else
		xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');

//***************Function for Voter Registration*******************

function call()
{
	var url="fname="+document.voter.fname.value +
			"&mname="+document.voter.mname.value +
		    "&lname="+document.voter.lname.value +
		    "&f_fname="+document.voter.f_fname.value +
		    "&f_mname="+document.voter.f_mname.value +
		    "&f_lname="+document.voter.f_lname.value +
		    "&m_fname="+document.voter.m_fname.value +
		    "&m_mname="+document.voter.m_mname.value +
		    "&m_lname="+document.voter.m_lname.value +
		    "&gender="+document.voter.gender.value +
		    "&rel="+document.voter.rel.value +
		    "&reg="+document.voter.reg.value +
		    "&nation="+document.voter.nation.value +
		    "&state="+document.voter.state.value +
			"&city="+document.voter.city.value +
		    "&colony="+document.voter.colony.value +
		    "&pin="+document.voter.pin.value;
	xmlhttp.onreadystatechange=function()
	{	
//		alert(xmlhttp.readyState);
//		alert(xmlhttp.status);
		if(xmlhttp.readyState==4 && xmlhttp.status==200)
		{
				if(xmlhttp.responseText == 1)
						document.getElementById('txtHint1').innerHTML="Your Request has Been Registered. Will Receive Your Voter Id Soon.";
				else
						document.getElementById('txtHint2').innerHTML="Please Enter all the Information";
		}
	}
	xmlhttp.open("post","scripts/addvoter.php",true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length",url.length);
	xmlhttp.send(url);
}

//*****************Functino for Issuer Registration*********************

function addissuer()
{
	var url ="i_name="+document.issuer.i_name.value +                
			 "&registration_no="+document.issuer.registration_no.value +
			 "&url="+document.issuer.url.value;

	xmlhttp.onreadystatechange=function()
	{	
//		alert(xmlhttp.readyState);
//		alert(xmlhttp.status);
		if(xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		 	if(xmlhttp.responseText == 1)
			{
				document.getElementById('txtHint1').innerHTML="Your Request has Benn Registered. Will Receive Your Details Soon";
		//		alert(xmlhttp.responseText);
			}
			else
			{
				document.getElementById('txtHint2').innerHTML="Please Enter All the Informatino";
		//		alert(xmlhttp.responseText);
			}
		}
	}
	xmlhttp.open("post","scripts/addissuer.php",true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length",url.length);
	xmlhttp.send(url);
}

//*******************Function for Approving Issuers*******************

function getSelected(opt)
{
    var selected = new Array();
    var index = 0;
    for (var intLoop = 0; intLoop < opt.length; intLoop++) 
	{
        if ((opt[intLoop].selected) ||(opt[intLoop].checked)) 
		{
             index = selected.length;
             selected[index] = new Object;
             selected[index].value = opt[intLoop].value;
             selected[index].index = intLoop;
        }
     }
    return selected;
}
function addSelected(opt) 
{
     var sel = getSelected(opt);
     var a="";
     for (var item in sel)       
           a += sel[item].value + "#";

	 var url ="app="+a;
     xmlhttp.onreadystatechange=function()
	{
		 if(xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			 if(xmlhttp.responseText == 1)
				document.getElementById('response_positive').innerHTML="Select Issuer Approve Successfully";
			 else
				document.getElementById('response_positive').innerHTML="Fail to Approve. Try Again."; 
		}
	}
	xmlhttp.open("post","scripts/approveissuer.php",true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length",url.length);
	xmlhttp.send(url);			 
}

//**********************function for deletion Issuers************************


function deleteSelected(opt) 
{
	 alert(opt);
     var sel = getSelected(opt);
     var a="";
     for (var item in sel)       
           a += sel[item].value + "#";
	 alert("hi"+a);

	 var url ="app="+a;
     xmlhttp.onreadystatechange=function()
	{
		if(xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			 if(xmlhttp.responseText == 1)
				document.getElementById('response_positive').innerHTML="Select Issuer Deleted Successfully";
			 else
				document.getElementById('response_positive').innerHTML="Fail to Delete. Try Again."; 
		}
	}
	xmlhttp.open("post","scripts/deleteissuer.php",true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length",url.length);
	xmlhttp.send(url);			 
}
























