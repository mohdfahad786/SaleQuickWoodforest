var item_count = 0;
	
function addF()
{
	var row = document.createElement('tr');
	var td = document.createElement('td');
	var p = document.createElement('p');
	var span = document.createElement('span');
	var theInput = document.createElement('input');
	theInput.setAttribute('type', 'text');
	theInput.setAttribute('name', 'items['+item_count+'][quantity]');
	theInput.setAttribute('size', '30');
	theInput.setAttribute('value', '');
	td.appendChild(theInput);
	row.appendChild(td);
	
	
	var td = document.createElement('td');
	var p = document.createElement('p');
	var span = document.createElement('span');
	var theInput = document.createElement('input');
	theInput.setAttribute('type', 'text');
	theInput.setAttribute('name', 'items['+item_count+'][quantity]');
	theInput.setAttribute('size', '30');
	theInput.setAttribute('value', '');
	td.appendChild(theInput);
	row.appendChild(td);
	var td = document.createElement('td');
	var p = document.createElement('p');
	var span = document.createElement('span');
	var theInput = document.createElement('input');
	theInput.setAttribute('type', 'text');
	theInput.setAttribute('name', 'items['+item_count+'][quantity]');
	theInput.setAttribute('size', '30');
	theInput.setAttribute('value', '');
	td.appendChild(theInput);
	row.appendChild(td);
	
	var td = document.createElement('td');
	var p = document.createElement('p');
	var span = document.createElement('span');
	var theInput = document.createElement('input');
	theInput.setAttribute('type', 'text');
	theInput.setAttribute('name', 'items['+item_count+'][quantity]');
	theInput.setAttribute('size', '30');
	theInput.setAttribute('value', '');
	td.appendChild(theInput);
	row.appendChild(td);
	
	
	
	var div_in = document.getElementById('item_area');
	div_in.appendChild(row);
	item_count++;
	return false;
}
