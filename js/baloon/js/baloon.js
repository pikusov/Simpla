// (C) Netlogic, 2003

function CreateBaloon() {
	baloon = document.createElement('DIV');
	baloon.setAttribute('id', 'baloon');

	baloonHeader = document.createElement('DIV');
	baloonHeader.setAttribute('id', 'baloonHeader');
	baloonHeader.setAttribute('class', 'direct');

	baloonBody   = document.createElement('DIV');
	baloonBody.setAttribute('id', 'baloonBody');

	baloonFooter = document.createElement('DIV');
	baloonFooter.setAttribute('id', 'baloonFooter');

	baloonBody.innerText = 'baloon';

	baloon.appendChild(baloonHeader);
	baloon.appendChild(baloonBody);
	baloon.appendChild(baloonFooter);

	baloon.onmouseover   = function(e) { this.style.filter = "Alpha(Opacity='100')"; this.style.cursor = 'pointer'; this.style.MozOpacity = '1';}
	baloon.onmouseout    = function(e) { this.style.filter = "Alpha(Opacity='75')";  this.style.cursor = 'auto'; this.style.MozOpacity = '0.75'; }
	baloon.onselectstart = function(e) { return false; }
	baloon.onclick       = function(e) { this.style.display = 'none'; }

	document.body.appendChild(baloon);

	window.onresize      = function(e) { document.getElementById('baloon').style.display = 'none'; }
}

function ShowBaloon(i) {
	baloon = document.getElementById('baloon');

	document.getElementById('baloonBody').innerHTML = i.getAttribute('data-notice') && i.getAttribute('data-notice').length ? i.getAttribute('data-notice') : 'ERROR';
	baloon.style.display = 'block';

	var xleft=0;
	var xtop=0;
	o = i;

	do {
		xleft += o.offsetLeft;
		xtop  += o.offsetTop;

	} while (o=o.offsetParent);

	xwidth  = i.offsetWidth  ? i.offsetWidth  : i.style.pixelWidth;
	xheight = i.offsetHeight ? i.offsetHeight : i.style.pixelHeight;

	bwidth =  baloon.offsetWidth  ? baloon.offsetWidth  : baloon.style.pixelWidth;

	w = window;

	xbody  = document.compatMode=='CSS1Compat' ? w.document.documentElement : w.document.body;
	dwidth = xbody.clientWidth  ? xbody.clientWidth   : w.innerWidth;
	bwidth = baloon.offsetWidth ? baloon.offsetWidth  : baloon.style.pixelWidth;

	flip = !(xwidth - 10 + xleft + bwidth < dwidth);

	if(i.type == 'checkbox')
		baloon.style.top  = xheight + 10 + xtop + 'px';
	else
		baloon.style.top  = xheight - 10 + xtop + 'px';
	baloon.style.left = (xleft + xwidth - (flip ? bwidth : 0)  - 25) + 'px';

	document.getElementById('baloonHeader').className = flip ? 'baloonHeaderFlip' : 'baloonHeaderDirect';

	i.focus();
	return false;
}


// (C) Netlogic, 2003

function ValidateForms() {
	for (i = 0; i < document.forms.length; i++) {
		if(document.forms[i].onsubmit) continue;

		document.forms[i].onsubmit = function(e) {
			var form = e ? e.target : window.event.srcElement;

			for(var i=0; i<form.elements.length; i++) {
				var value = form.elements[i].value;

				switch(form.elements[i].type) {
					case 'text':
					case 'password':
					case 'textarea':
						pattern = form.elements[i].getAttribute('data-format');

						if(pattern) {
							switch(pattern) {
								case 'string':
									if(!value.length) {
										return ValidateNotice(form.elements[i]);
									}
									break;

								case 'number':
									if(!isNumeric(value)) {
										return ValidateNotice(form.elements[i]);
									}
									break;

								case 'url':
									if(!isUrl(value)) {
										return ValidateNotice(form.elements[i]);
									}
									break;

								case 'email':
									if(!isEmail(value)) {
										return ValidateNotice(form.elements[i]);
									}
									break;

								default:	
									if(!isPattern(pattern, value)) {
										return ValidateNotice(form.elements[i]);
									}
									break;
							}
						}
						break;

					case 'radio':
					case 'checkbox':
						min = form.elements[i].getAttribute('min') ? form.elements[i].getAttribute('min') : 0;
						max = form.elements[i].getAttribute('max') ? form.elements[i].getAttribute('max') : document.getElementsByName(form.elements[i].getAttribute('name')).length;

						if(min || max) {
							var items = document.getElementsByName(form.elements[i].getAttribute('name'));
							var count = 0;

							for(var l=0; l<items.length; l++){
								if(items[l].checked) {
									count++;
								}
							}

							if(count < min || count > max) {
								return ValidateNotice(form.elements[i]);
							}
						}
						break;

					case 'select-one':
					case 'select-multiple':
						selected = form.elements[i].options[form.elements[i].selectedIndex];
						if(selected && selected.getAttribute('notselected')) {
							return ValidateNotice(form.elements[i]);
						}
						break;

						break;

					case 'file':
						break;

					case 'image':
					case 'button':
					case 'submit':
					case 'reset':
						break;

					default:
						break;
				}
			}

			return true;
		}
	}

}

function isUrl(str) {
	return isPattern("^https?:\\/\\/(?:[a-z0-9_-]{1,32}(?::[a-z0-9_-]{1,32})?@)?(?:(?:[a-z0-9-]{1,128}\\.)+(?:com|net|org|mil|edu|arpa|gov|biz|info|aero|inc|name|[a-z]{2})|(?!0)(?:(?!0[^.]|255)[0-9]{1,3}\\.){3}(?!0|255)[0-9]{1,3})(?:\\/[a-z0-9.,_@%&?+=\\~\\/-]*)?(?:#[^ '\"&<>]*)?$", str.toLowerCase());
}

function isNumeric(str) {
	return isPattern("^[0-9]+$", str);
}

function isInteger(str) {
	return isNumeric(str);
}

function isFloat(str) {
	return isPattern("^[1-9]?[0-9]+(\\.[0-9]+)?$", str);
}

function isEmail(str) {
	return isPattern("^([a-z0-9_-]+)(\\.[a-z0-9_-]+)*@((([a-z0-9-]+\\.)+(com|net|org|mil|edu|gov|arpa|info|biz|inc|name|[a-z]{2}))|([0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}))$", str.toLowerCase());
}

function isPattern(pattern, str) {
	if(str.length && pattern.length) {
		var re = new RegExp(pattern, "g");
		return re.test(str);
	}

	return false;
}

function ValidateNotice(input) {
	ShowBaloon(input);
	return false;
}



function init_balloon()
{
	ValidateForms();
	CreateBaloon();
}

if (window.attachEvent) {
	window.attachEvent("onload", init_balloon);
} else if (window.addEventListener) {
	window.addEventListener("DOMContentLoaded", init_balloon, false);
} else {
	document.addEventListener("DOMContentLoaded", init_balloon, false);
}

