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
			 "&url="+document.issuer.url.value +
		     "&email="+document.issuer.email.value;

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
	// alert(opt);
     var sel = getSelected(opt);
     var a="";
     for (var item in sel)       
           a += sel[item].value + "#";
//	 alert("hi"+a);

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

//*******************function for adding Constituency***********************

function addconstituency()
{
    var url ="const_name="+document.constituency.c_name.value +
             "&desc="+document.constituency.description.value+
	     "&issuer_no="+document.constituency.issuer_id.value;
//alert (url);
	xmlhttp.onreadystatechange=function()
	{	
	//	alert(xmlhttp.readyState);
	//	alert(xmlhttp.status);
		if(xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		 	if(xmlhttp.responseText == 1)
			{
				document.getElementById('txtHint1').innerHTML="Constituency Added";
	//			alert(xmlhttp.responseText);
			}
			else
			{
				document.getElementById('txtHint2').innerHTML="Constituency Already Added.";
	//			alert(xmlhttp.responseText);
			}
		}
	}
	xmlhttp.open("post","scripts/addconstituency.php",true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length",url.length);
	xmlhttp.send(url);
}

//**********************function for Creating Election***********************

function addelection(opt)
{
    var sel=getSelected(opt);
    var a="";
    for(var item in sel)
        a +=sel[item].value+"#";
//  alert(a);
   var url="app="+a+
         "&e_name="+document.election.e_name.value+
         "&e_purpose="+document.election.purpose.value+
         "&start_date="+document.election.start_date.value+
         "&end_date="+document.election.end_date.value;
     alert(url);
   
   xmlhttp.onreadystatechange=function()
  {	
        if(xmlhttp.readyState==4 && xmlhttp.status==200)
	{
		if(xmlhttp.responseText == 1)
		{
                       document.getElementById('txtHint1').innerHTML="Election Created";
	//		alert("hello"+xmlhttp.responseText);
		}
		else
		{
                   	document.getElementById('txtHint2').innerHTML="Some Problem With Election Creation. Contact Administrator";
	//        	alert("bye"+xmlhttp.responseText);
		}
	}
	}
	xmlhttp.open("post","scripts/create_election.php",true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length",url.length);
	xmlhttp.send(url);
   
}
//**************************Register as Candidate************************************
function register_as_candidate(opt)
{
    var sel=getSelected(opt);
    var a="";
    for(var item in sel)
        a +=sel[item].value+"#";
    var url="election_id="+a+"&voter_id="+document.candidate.voter_id.value;
    xmlhttp.onreadystatechange=function()
    {
        if(xmlhttp.readyState == 4 && xmlhttp.status==200)
        {
               document.getElementById('candidate').innerHTML=xmlhttp.responseText;
          //     alert(xmlhttp.responseText);
        }
    }
    xmlhttp.open("post","scripts/addcandidate.php",true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.setRequestHeader("Content-length",url.length);
    xmlhttp.send(url);
}

//**********************Cast Vote For Eleciton************************

function election(election_id)
{
    var url="election_id="+election_id;
    xmlhttp.onreadystatechange=function()
    {
        if(xmlhttp.readyState == 4 && xmlhttp.status ==200)
            {
                document.getElementById('election_result').innerHTML=xmlhttp.responseText;
            }
    }
    xmlhttp.open("post","scripts/getCandidates.php",true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.setRequestHeader("Content-length",url.length);
    xmlhttp.send(url);
}

//******************Voter Request For Registration********************

function voter_registration_request()
{
    
    var url="issuer_id="+document.voter.issuer_name.value+"&voter_name="+document.voter.voter_name.value+"&email="+document.voter.voter_email.value;
   xmlhttp.onreadystatechange=function()
    {
        if(xmlhttp.readyState == 4 && xmlhttp.status ==200)
        {
            document.getElementById('txtHint1').innerHTML=xmlhttp.responseText;
           
        }
    }
    xmlhttp.open("post","scripts/voter_registration_request.php",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.setRequestHeader("Content-length",url.length);
    xmlhttp.send(url);
    
}

//*******************Register Vote************************************

function getCheckedRadio(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
       	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}

function voteRegister(opt)
{
    var elected_voter_id =getCheckedRadio(opt);
    var url="elected_voter="+elected_voter_id+"&voter_id="+document.election_vote.voter_id.value+"&election_id="+document.election_vote.election_id.value;
    xmlhttp.onreadystatechange=function()
    {
        if(xmlhttp.readyState == 4 && xmlhttp.status ==200)
        {
            document.getElementById('result').innerHTML=xmlhttp.responseText;
           
        }
    }
    xmlhttp.open("post","scripts/cast_vote.php",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.setRequestHeader("Content-length",url.length);
    xmlhttp.send(url);
}

//**************************Election Results********************

function getResult(opt)
{
   var url="election_id="+opt;
   
   xmlhttp.onreadystatechange=function()
    {
        if(xmlhttp.readyState == 4 && xmlhttp.status ==200)
        {
             var values=xmlhttp.responseText;
             //alert(values);
             var data = new Array();
             data=values.split("&");
                          
             var candidates= new Array()
             candidates=data[0].split(",");
                          
             var score= new Array()
             score=data[1].split(",");
             
             var len=score.length-1;
             
             var numbers=new Array(len);
             for(var i=0;i<len;i++)
                  numbers[i]=parseInt(score[i]);
             
            var bar = new RGraph.Bar('cvs',numbers);
            bar.Set('chart.labels', candidates);
            bar.Draw(); 
           
        }
    }
    xmlhttp.open("post","scripts/election_result.php",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.setRequestHeader("Content-length",url.length);
    xmlhttp.send(url);
}

//*********************getCandidates**********************
function getCandidates(opt)
{
    var url="election_id="+opt;
    xmlhttp.onreadystatechange=function()
    {
        if(xmlhttp.readyState == 4 && xmlhttp.status ==200)
        {
            document.getElementById('candidates_names').innerHTML=xmlhttp.responseText;
           
        }
    }
    xmlhttp.open("post","scripts/getCandidates_admin.php",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.setRequestHeader("Content-length",url.length);
    xmlhttp.send(url);
    
}
//***************active_inactive(this.form)********************
function active_inactive(opt)
{
    var sel=getSelected(opt);
    var a="";
    for(var item in sel)
        a +=sel[item].value+"#";
    var url="voter_id="+a;
    if(a !=null)
    {
              xmlhttp.onreadystatechange=function()
              {
                   if(xmlhttp.readyState == 4 && xmlhttp.status ==200)
                   {
                       document.getElementById('res').innerHTML=xmlhttp.responseText;
                       
                   }
               }
               xmlhttp.open("post","scripts/active_inactive.php",true);
               xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
               xmlhttp.setRequestHeader("Content-length",url.length);
               xmlhttp.send(url);  
    }
}

//**********************getIssuerVoters(".$row['issuer_no'].")**********************

function getIssuerVoters(opt)
{
     var url="opt=a&issuer_id="+opt;
     xmlhttp.onreadystatechange=function()
      {
          if(xmlhttp.readyState == 4 && xmlhttp.status ==200)
          {
             document.getElementById('ajaxdata').innerHTML=xmlhttp.responseText;
          }
      }
      xmlhttp.open("post","scripts/super_admin.php",true);
      xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
      xmlhttp.setRequestHeader("Content-length",url.length);
      xmlhttp.send(url); 
}

//**********************getIssuerInfo(".$row['issuer_no'].")***************************

function getIssuerInfo(opt)
{
     var url="opt=b&issuer_id="+opt;
     xmlhttp.onreadystatechange=function()
      {
          if(xmlhttp.readyState == 4 && xmlhttp.status ==200)
          {
             document.getElementById('ajaxdata').innerHTML=xmlhttp.responseText;
          }
      }
      xmlhttp.open("post","scripts/super_admin.php",true);
      xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
      xmlhttp.setRequestHeader("Content-length",url.length);
      xmlhttp.send(url);   
}
//*****************************getElection($srno)*******************************

function getElection(opt)
{
   
     var url="opt=c&const_id="+opt;
     xmlhttp.onreadystatechange=function()
      {
          if(xmlhttp.readyState == 4 && xmlhttp.status ==200)
          {
             document.getElementById('ajaxdata').innerHTML=xmlhttp.responseText;
          }
      }
      xmlhttp.open("post","scripts/super_admin.php",true);
      xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
      xmlhttp.setRequestHeader("Content-length",url.length);
      xmlhttp.send(url); 
}

//***************************e_admin_audit()************************************

function e_admin_audit()
{
    var election_id=document.election.election_id.value;
    var url="election_id="+election_id;
         xmlhttp.onreadystatechange=function()
      {
          if(xmlhttp.readyState == 4 && xmlhttp.status ==200)
          {

             document.getElementById('ajax_election').innerHTML=xmlhttp.responseText;
             getResult(election_id);
             
          }
      }
      xmlhttp.open("post","scripts/e_admin_candidates.php",true);
      xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
      xmlhttp.setRequestHeader("Content-length",url.length);
      xmlhttp.send(url); 
    
}









