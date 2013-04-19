	
function CurrencyFormatted(amount)
{
	var i = parseFloat(amount),
			minus = '';
			
	if(isNaN(i)) { i = 0.00; }
	
	if(i < 0) { minus = '-'; }
	i = Math.abs(i);
	i = parseInt((i + .005) * 100);
	i = i / 100;
	s = new String(i);
	if(s.indexOf('.') < 0) { s += '.00'; }
	if(s.indexOf('.') == (s.length - 2)) { s += '0'; }
	s = minus + s;
	return s;
}

function CommaFormatted(amount)
{
	var delimiter = ",",
			a = amount.split('.',2),
			d = a[1],
			i = parseInt(a[0]),
			minus = '';
			
	if(isNaN(i)) { return ''; }
	
	if(i < 0) { minus = '-'; }
	i = Math.abs(i);
	
	var n = new String(i),
			a = [];
			
	while(n.length > 3)
	{
		var nn = n.substr(n.length-3);
		a.unshift(nn);
		n = n.substr(0,n.length-3);
	}
	if(n.length > 0) { a.unshift(n); }
	n = a.join(delimiter);
	if(d.length < 1) { amount = n; }
	else { amount = n + '.' + d; }
	amount = minus + amount;
	return amount;
}

function inttocurr(amount) 
{
	var curr = CurrencyFormatted(amount);
	return CommaFormatted(curr);
}