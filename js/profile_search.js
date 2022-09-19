function searched_result(mem_id)
{
	var XMLHttpRequestObject = false;

	if(window.XMLHttpRequest)
	{
		XMLHttpRequestObject = new XMLHttpRequest;
	}
	else if(window.ActiveXObject)
	{
		XMLHttpRequestObject = new ActiveXObject;
	}
	var terms = mem_id.split('_');
	url = base_url+'/search_panel/member_details/'+terms[1];
	
	XMLHttpRequestObject.open("POST", url);
	XMLHttpRequestObject.onreadystatechange = function()
	{
		if((XMLHttpRequestObject.readyState == 4))
		{
			var div = document.getElementById('member_detail');
			div.innerHTML = XMLHttpRequestObject.responseText;
			
			var div = document.createElement('div');
			div.setAttribute('id','div_result');
			
			var table = document.createElement('table');
			table.setAttribute('cellpadding','10');
			table.setAttribute('cellspacing','10');
			var tr = document.createElement('tr');
			var td = document.createElement('td');
			var label = document.createElement('label');
			var link = document.createElement('a');
			link.setAttribute('onclick', "javascript:window.opener.location.href='"+base_url+"/members/personal/"+terms[0]+"';javascript:window.close();");
			link.setAttribute('href', '#');
			link.appendChild(document.createTextNode('Profile'));
			td.appendChild(link);
			tr.appendChild(td);
			
			var td = document.createElement('td');
			var link = document.createElement('a');
			link.setAttribute('onclick', "javascript:window.opener.location.href='"+base_url+"/members/index/"+terms[0]+"';javascript:window.close();");
			link.setAttribute('href', '#');
			link.appendChild(document.createTextNode('Geneology'));
			td.appendChild(link);
			tr.appendChild(td);
			
			
			table.appendChild(tr);
			div.appendChild(table);
			
			var div2 = document.getElementById('searched_result');
			div2.innerHTML = '';
			div2.appendChild(div);
		}
	}
	XMLHttpRequestObject.send(null);

	return;
}

function getData()
{
	var XMLHttpRequestObject = false;

	if(window.XMLHttpRequest)
	{
		XMLHttpRequestObject = new XMLHttpRequest;
	}
	else if(window.ActiveXObject)
	{
		XMLHttpRequestObject = new ActiveXObject;
	}
	var sd = document.getElementById('start_day').value;
	var ed = document.getElementById('end_date').value;
	if((sd == '') || (ed == ''))
	{
		alert('Please select both dates to search.');
		return;
	}
	url = base_url+'/search_panel/member_by_date?start_date='+sd+'&end_date='+ed;
	XMLHttpRequestObject.open("POST", url);
	XMLHttpRequestObject.onreadystatechange= function()
	{
		var div = document.getElementById('div_id');
		div.innerHTML = "";
		div.innerHTML = XMLHttpRequestObject.responseText;
		div.setAttribute('style','display:true;');
	}
	XMLHttpRequestObject.send(null);
}