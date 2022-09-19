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
	url = get_pay_url+'?start_date='+sd+'&end_date='+ed;
	XMLHttpRequestObject.open("POST", url);
	var table = document.getElementById('my_table');
	table.innerHTML = "";
	XMLHttpRequestObject.onreadystatechange = function(){
		if((XMLHttpRequestObject.readyState == 4))
		{
			table.innerHTML = XMLHttpRequestObject.responseText;
			table.setAttribute('style','display:true;');
		}
	}
	XMLHttpRequestObject.send(null);
}

function show_form(ID)
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
	url = base_url+'/payments/member_details/'+ID;
	var div = document.getElementById('search_res');
	div.innerHTML = '';
	
	var div = document.getElementById('date_pick');
	div.setAttribute('style', 'display:none;');
	
	XMLHttpRequestObject.open("POST", url);
	XMLHttpRequestObject.onreadystatechange = function()
	{
		var form = document.createElement('form');
		form.setAttribute('id','pay_form');
		form.setAttribute('action', '');
		
		var IP = document.createElement('input');
		IP.setAttribute('type','hidden');
		IP.setAttribute('id','pay_id');
		IP.setAttribute('name','pay_id');
		IP.setAttribute('value',ID);
		form.appendChild(IP);
		
		var label = document.createElement('label');
		label.appendChild(document.createTextNode('Amount to Pay :'));
		form.appendChild(label);
		
		form.innerHTML = form.innerHTML+ XMLHttpRequestObject.responseText;
        
          
		var BR = document.createElement('br');
		form.appendChild(BR);
		
		var label = document.createElement('label');
		label.appendChild(document.createTextNode('Cheque No :'));
		form.appendChild(label);
		
		var IP = document.createElement('input');
		IP.setAttribute('id','cheque_no');
		IP.setAttribute('name','cheque_no');
		form.appendChild(IP);
		
		var BR = document.createElement('br');
		form.appendChild(BR);

		var label = document.createElement('label');
		label.appendChild(document.createTextNode('Remarks :'));
		form.appendChild(label);
		
		var IP = document.createElement('input');
		IP.setAttribute('id','remarks');
		IP.setAttribute('name','remarks');
		form.appendChild(IP);
		
		var BR = document.createElement('br');
		form.appendChild(BR);

		var label = document.createElement('label');
		label.appendChild(document.createTextNode('Paid On :'));
		form.appendChild(label);
		
		var div = document.getElementById('search_res');
		div.innerHTML = '';
		div.appendChild(form);
		
		var div = document.getElementById('date_pick');
		div.setAttribute('style', 'display:true;');
	}
	XMLHttpRequestObject.send(null);
}
function final_payment()
{
	
	var net = document.getElementById('net').value;
	if(net == 0 )
	{
		alert('You cannot pay this member');
		return;
	}
	var chq = document.getElementById('cheque_no').value;
	if(chq == "")
	{
		alert('Please enter the cheque no.');
		chq.focus();
		return;
	}
	var the_date = document.getElementById('pay_ip').value;
	if(the_date == "")
	{
		alert('Please enter the date.');
		the_date.focus();
		return;
	}
	var id = document.getElementById('pay_id').value;
	var remarks = document.getElementById('remarks').value;
	var url = get_pay_url+'?remarks='+remarks+'&id='+id+'&amount='+net+'&cheque_no='+chq+'&date='+the_date;
	var XMLHttpRequestObject = false;
	if(window.XMLHttpRequest)
	{
		XMLHttpRequestObject = new XMLHttpRequest;
	}
	else if(window.ActiveXObject)
	{
		XMLHttpRequestObject = new ActiveXObject;
	}
	XMLHttpRequestObject.open("POST", url);
	XMLHttpRequestObject.send(null);
	XMLHttpRequestObject.onreadystatechange = function()
	{
		var div = document.getElementById('search_res');
		div.innerHTML = "";
		div.innerHTML = XMLHttpRequestObject.responseText;
		var div = document.getElementById('date_pick');
		div.innerHTML = "";
	}
}
function final_payment1()
{
	
	var net = document.getElementById('net').value;
	if(net == 0 )
	{
		alert('You cannot pay this member');
		return;
	}
	var chq = document.getElementById('cheque_no').value;
	if(chq == "")
	{
		alert('Please enter the cheque no.');
		chq.focus();
		return;
	}
	var the_date = document.getElementById('pay_ip').value;
	if(the_date == "")
	{
		alert('Please enter the date.');
		the_date.focus();
		return;
	}
	var id = document.getElementById('pay_id').value;
	var remarks = document.getElementById('remarks').value;
	var url = get_pay_url+'?remarks='+remarks+'&id='+id+'&amount='+net+'&cheque_no='+chq+'&date='+the_date;
	var XMLHttpRequestObject = false;
	if(window.XMLHttpRequest)
	{
		XMLHttpRequestObject = new XMLHttpRequest;
	}
	else if(window.ActiveXObject)
	{
		XMLHttpRequestObject = new ActiveXObject;
	}
	XMLHttpRequestObject.open("POST", url);
	XMLHttpRequestObject.send(null);
	XMLHttpRequestObject.onreadystatechange = function()
	{
		var div = document.getElementById('search_res');
		div.innerHTML = "";
		div.innerHTML = XMLHttpRequestObject.responseText;
		var div = document.getElementById('date_pick');
		div.innerHTML = "";
	}
	
}

function search_payments(ID)
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
	url = base_url+'/payments/member_payments/'+ID;
	XMLHttpRequestObject.open("POST", url);
	XMLHttpRequestObject.onreadystatechange = function()
	{
		var div = document.getElementById('search_id');
		div.innerHTML = '';
		div.innerHTML = XMLHttpRequestObject.responseText;
		
		div.setAttribute('style', 'border: 1px solid #D8D7D7;height: auto; margin-bottom: 0;margin-left: 4px;margin-top: 5px;padding: 10px;padding:10px;text-decoration: none;display: true;');
	}
	XMLHttpRequestObject.send(null);
}