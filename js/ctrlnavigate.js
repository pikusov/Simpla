document.onkeydown = NavigateThrough;

function NavigateThrough (event)
{
	if (!document.getElementsByClassName) return;

	if (window.event) event = window.event;

	if (event.ctrlKey)
	{
		var link = null;
		var href = null;
		switch (event.keyCode ? event.keyCode : event.which ? event.which : null)
		{
			case 0x25:
				link = document.getElementsByClassName('prev_page_link')[0];
				break;
			case 0x27:
				link = document.getElementsByClassName('next_page_link')[0];
				break;
		}

		if (link && link.href) document.location = link.href;
		if (href) document.location = href;
	}			
}
