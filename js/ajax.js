// JavaScript Document

var getobj = false;
if(window.XMLHttpRequest)
{
	getobj= new XMLHttpRequest();
}
if(window.ActiveXObject)
{
	getobj= new ActiveXObject("Microsoft.XMLHTTP");
}
function subcat(subcat)                                   //  Select Subcategory
	{
     if(getobj)
			{
				url = "select_sbcat.php?subcat_id="+subcat;
				getobj.open("GET",url,true);
				getobj.onreadystatechange=function()
					{
						if(getobj.readyState==4 && getobj.status==200)
							{
								document.getElementById('d1').innerHTML = getobj.responseText;	
								showstuff(element);
							}
					}
				getobj.send(null);	
			}	
		}
function vendor(vendor)                                   //  Select Subcategory
	{
	var vendor;
	if(getobj)
			{
				url = "select_vendor.php?ven_id="+vendor;
				getobj.open("GET",url,true);
				getobj.onreadystatechange=function()
					{
						if(getobj.readyState==4 && getobj.status==200)
							{
								document.getElementById('detail').innerHTML = getobj.responseText;	
								showstuff(element);
							}
					}
				getobj.send(null);	
			}	
		}
function sendmail(sendmail)                                   //  Select Mail Id of Vendor
	{
	var sendmail;
	if(getobj)
			{
				url = "select_mail.php?email_id="+sendmail;
				getobj.open("GET",url,true);
				getobj.onreadystatechange=function()
					{
						if(getobj.readyState==4 && getobj.status==200)
							{
								document.getElementById('mailid').innerHTML = getobj.responseText;	
								showstuff(element);
							}
					}
				getobj.send(null);	
			}	
		}
function vname(vname)                                   //  Select title for deals
	{
	var vname;
	if(getobj)
			{
				url = "select_title.php?vname_id="+vname;     
				getobj.open("GET",url,true);
				getobj.onreadystatechange=function()
					{
						if(getobj.readyState==4 && getobj.status==200)
							{
								document.getElementById('d4').innerHTML = getobj.responseText;	
								showstuff(element);
							}
					}
				getobj.send(null);	
			}	
		}