window.onload = function() {
	CreateTooltip();
	SetTooltips();
}

function CreateTooltip() {
	tooltip = document.createElement('DIV');
	tooltip.setAttribute('id', 'tooltip');

	tooltipHeader = document.createElement('DIV');
	tooltipHeader.setAttribute('id', 'tooltipHeader');
	tooltipHeader.setAttribute('class', 'direct');

	tooltipBody   = document.createElement('DIV');
	tooltipBody.setAttribute('id', 'tooltipBody');

	tooltipFooter = document.createElement('DIV');
	tooltipFooter.setAttribute('id', 'tooltipFooter');

	tooltipBody.innerText = 'tooltip';

	tooltip.appendChild(tooltipHeader);
	tooltip.appendChild(tooltipBody);
	tooltip.appendChild(tooltipFooter);
	tooltipcanclose=true;

	tooltip.onmouseover   = function(e) { this.style.filter = "Alpha(Opacity='100')"; this.style.MozOpacity = '1';  tooltipcanclose=false;}
	tooltip.onmouseout    = function(e) { this.style.filter = "Alpha(Opacity='85')"; this.style.MozOpacity = '0.85'; tooltipcanclose=true; setTimeout("CloseTooltip();", 1000);}

	tooltip.onclick       = function(e) {   tooltipcanclose=true; CloseTooltip(); }

	document.body.appendChild(tooltip);

	window.onresize      = function(e) {  tooltipcanclose=true; CloseTooltip(); }
	document.body.onclick= function(e) {  tooltipcanclose=true; CloseTooltip(); }
	
	adminpanel = document.createElement('A');
	adminpanel.setAttribute('style', 'position:absolute; left:3%; top:0px;z-index:1000;');
	adminpanel.setAttribute('href', 'simpla /');
	adminpanel.innerHTML = "<img  title='Перейти в панель' alt='Перейти на сайт' border=0 src='js/admintooltip/i/bookmark.gif'>";
    document.body.appendChild(adminpanel);
	
}

function CloseTooltip()
{
  if(tooltipcanclose)
    document.getElementById('tooltip').style.display = 'none';
}

function SetTooltips() {
	elements = document.getElementsByTagName("body")[0].getElementsByTagName("*");

	for (i = 0; i <elements.length; i++)
	{
		tooltip = elements[i].getAttribute('tooltip');
		if(tooltip)
		{
		    elements[i].onmouseout = function(e) {tooltipcanclose=true;setTimeout("CloseTooltip();", 1000);};		
			switch(tooltip)
			{	
				case 'product':					   			   
				   elements[i].onmouseover = function(e) {AdminProductTooltip(this,  this.getAttribute('product_id'));tooltipcanclose=false;}
				break;
				case 'hit':					   			   
				   elements[i].onmouseover = function(e) {AdminHitTooltip(this,  this.getAttribute('product_id'));tooltipcanclose=false;tooltipcanclose=false;}
				break;
				case 'category':					   				   
				   elements[i].onmouseover = function(e) {AdminCategoryTooltip(this,  this.getAttribute('category_id'));tooltipcanclose=false;}
				break;
				case 'news':					   				   
				   elements[i].onmouseover = function(e) {AdminNewsTooltip(this,  this.getAttribute('news_id'));tooltipcanclose=false;}
				break;
				case 'article':					   				   
				   elements[i].onmouseover = function(e) {AdminArticleTooltip(this,  this.getAttribute('article_id'));tooltipcanclose=false;}
				break;
				case 'page':					   				   
				   elements[i].onmouseover = function(e) {AdminPageTooltip(this,  this.getAttribute('id')); tooltipcanclose=false;}
				break;
				case 'currency':					   				   
				   elements[i].onmouseover = function(e) {AdminCurrencyTooltip(this); tooltipcanclose=false;}
				break;
			}


		}
		
	}

}


function ShowTooltip(i, content) {

	tooltip = document.getElementById('tooltip');

	document.getElementById('tooltipBody').innerHTML = content;
	tooltip.style.display = 'block';

	var xleft=0;
	var xtop=0;
	o = i;

	do {
		xleft += o.offsetLeft;
		xtop  += o.offsetTop;

	} while (o=o.offsetParent);

	xwidth  = i.offsetWidth  ? i.offsetWidth  : i.style.pixelWidth;
	xheight = i.offsetHeight ? i.offsetHeight : i.style.pixelHeight;

	bwidth =  tooltip.offsetWidth  ? tooltip.offsetWidth  : tooltip.style.pixelWidth;

	w = window;

	xbody  = document.compatMode=='CSS1Compat' ? w.document.documentElement : w.document.body;
	dwidth = xbody.clientWidth  ? xbody.clientWidth   : w.innerWidth;
	bwidth = tooltip.offsetWidth ? tooltip.offsetWidth  : tooltip.style.pixelWidth;

	flip = !( 25 + xleft + bwidth < dwidth);

	tooltip.style.top  = xheight - 3 + xtop + 'px';
	tooltip.style.left = (xleft - (flip ? bwidth : 0)  + 25) + 'px';

	document.getElementById('tooltipHeader').className = flip ? 'tooltipHeaderFlip' : 'tooltipHeaderDirect';

	return false;
}

function AdminProductTooltip(element, object_id)
{
  from =  window.location; 
  content = "<p><a href='admin/index.php?section=Product&item_id="+object_id+"&from="+from+"' class=admin_tooltip_edit>Редактировать</a></p>";
  content += "<p><a href='admin/index.php?section=Storefront&action=move_up&item_id="+object_id+"&from="+from+"' class=admin_tooltip_up>Поднять</a></p>";
  content += "<p><a href='admin/index.php?section=Storefront&action=move_down&item_id="+object_id+"&from="+from+"' class=admin_tooltip_down>Опустить</a></p>";
  content += "<p><a href='admin/index.php?section=Storefront&set_hit="+object_id+"&from="+from+"' class=admin_tooltip_hit>Хит</a></p>";
  content += "<p><a href='admin/index.php?section=Storefront&set_enabled="+object_id+"&from="+from+"' class=admin_tooltip_delete>Скрыть</a></p>";
  ShowTooltip(element, content);
}

function AdminHitTooltip(element, object_id)
{
  from =  window.location; 
  content = "<p><a href='admin/index.php?section=Product&item_id="+object_id+"&from="+from+"' class=admin_tooltip_edit>Редактировать</a></p>";
  content += "<p><a href='admin/index.php?section=Storefront&set_hit="+object_id+"&from="+from+"' class=admin_tooltip_hit>Не хит</a></p>";
  content += "<p><a href='admin/index.php?section=Storefront&set_enabled="+object_id+"&from="+from+"' class=admin_tooltip_delete>Скрыть</a></p>";
  ShowTooltip(element, content);
}

function AdminCategoryTooltip(element, object_id)
{
  from =  window.location; 
  content = "<p><a href='admin/index.php?section=Category&item_id="+object_id+"&from="+from+"' class=admin_tooltip_edit>Редактировать</a></p>";
  content += "<p><a href='admin/index.php?section=Product&category="+object_id+"&from="+from+"' class=admin_tooltip_add>Добавить товар</a></p>";
  content += "<p><a href='admin/index.php?section=Categories&set_enabled="+object_id+"&from="+from+"' class=admin_tooltip_delete>Скрыть</a></p>";
  ShowTooltip(element, content);
}

function AdminNewsTooltip(element, object_id)
{
  from =  window.location; 
  content = "<p><a href='admin/index.php?section=NewsItem&item_id="+object_id+"&from="+from+"' class=admin_tooltip_edit>Редактировать</a></p>";
  content += "<p><a href='admin/index.php?section=NewsItem&from="+from+"' class=admin_tooltip_add>Добавить новость</a></p>";
  content += "<p><a href='admin/index.php?section=NewsLine&set_enabled="+object_id+"&from="+from+"' class=admin_tooltip_delete>Скрыть</a></p>";
  ShowTooltip(element, content);
}

function AdminArticleTooltip(element, object_id)
{
  from =  window.location; 
  content = "<p><a href='admin/index.php?section=Article&item_id="+object_id+"&from="+from+"' class=admin_tooltip_edit>Редактировать</a></p>";
  content += "<p><a href='admin/index.php?section=Article&from="+from+"' class=admin_tooltip_add>Добавить новость</a></p>";
  content += "<p><a href='admin/index.php?section=Articles&set_enabled="+object_id+"&from="+from+"' class=admin_tooltip_delete>Скрыть</a></p>";
  ShowTooltip(element, content);
}

function AdminPageTooltip(element, object_id)
{
  from =  window.location; 
  content = "<p><a href='simpla/index.php?module=PageAdmin&id="+object_id+"&return="+from+"' class=admin_tooltip_edit>Редактировать</a></p>";
  content += "<p><a href='simpla/index.php?section=Sections&action=move_up&item_id="+object_id+"&from="+from+"' class=admin_tooltip_up>Поднять</a></p>";
  content += "<p><a href='simpla/index.php?section=Sections&action=move_down&item_id="+object_id+"&from="+from+"' class=admin_tooltip_down>Опустить</a></p>";
  content += "<p><a href='simpla/index.php?section=Sections&set_enabled="+object_id+"&from="+from+"' class=admin_tooltip_delete>Скрыть</a></p>";
  ShowTooltip(element, content);
}

function AdminCurrencyTooltip(element)
{
  from =  window.location; 
  content = "<p><a href='admin/index.php?section=Currency&from="+from+"' class=admin_tooltip_edit>Изменить курсы валют</a></p>";
  ShowTooltip(element, content);
}