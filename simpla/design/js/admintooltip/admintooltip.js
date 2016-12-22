$(function() {
	if(!('live' in jQuery.fn))
	{
		jQuery.fn.extend({
			live: function (event, callback) {
				if (this.selector) {
					jQuery(document).on(event, this.selector, callback);
				}
			}
		});
	}
	$("<a href='simpla/' class='admin_bookmark'></a>").appendTo('body');
	tooltip = $("<div class='tooltip'><div class='tooltipHeader'></div><div class='tooltipBody'></div><div class='tooltipFooter'></div></div>").appendTo($('body'));
	$('.tooltip').live('mouseleave', function(){tooltipcanclose=true;setTimeout("close_tooltip();", 300);});
	$('.tooltip').live('mouseover', function(){tooltipcanclose=false;});

	$('[data-page]').live('mouseover', show_tooltip);
	$('[data-category]').live('mouseover', show_tooltip);
	$('[data-brand]').live('mouseover', show_tooltip);
	$('[data-product]').live('mouseover', show_tooltip);
	$('[data-post]').live('mouseover', show_tooltip);
	$('[data-feature]').live('mouseover', show_tooltip);
});

function show_tooltip()
{
	tooltipcanclose=false;
	tooltip.show();
	$(this).live('mouseleave', function(){tooltipcanclose=true;setTimeout("close_tooltip();", 500);});



	flip = !($(this).offset().left+tooltip.width()+25 < $('body').width());

	tooltip.css('top',  $(this).height() + 5 + $(this).offset().top + 'px');
	tooltip.css('left', ($(this).offset().left + $(this).outerWidth()*0.5 - (flip ? tooltip.width()-40 : 0)  + 0) + 'px');
	tooltip.find('.tooltipHeader').addClass(flip ? 'tooltipHeaderFlip' : 'tooltipHeaderDirect').removeClass(flip ? 'tooltipHeaderDirect' : 'tooltipHeaderFlip');

	from = encodeURIComponent(window.location);
	tooltipcontent = '';

	if(id = $(this).attr('data-page'))
	{
		tooltipcontent = "<a href='simpla/index.php?module=PageAdmin&id="+id+"&return="+from+"' class=admin_tooltip_edit>Редактировать</a>";
		tooltipcontent += "<a href='simpla/index.php?module=PageAdmin&return="+from+"' class=admin_tooltip_add>Добавить страницу</a>";
	}

	if(id = $(this).attr('data-category'))
	{
		tooltipcontent = "<a href='simpla/index.php?module=CategoryAdmin&id="+id+"&return="+from+"' class=admin_tooltip_edit>Редактировать</a>";
		tooltipcontent += "<a href='simpla/index.php?module=ProductAdmin&category_id="+id+"&return="+from+"' class=admin_tooltip_add>Добавить товар</a>";
	}

	if(id = $(this).attr('data-brand'))
	{
		tooltipcontent = "<a href='simpla/index.php?module=BrandAdmin&id="+id+"&return="+from+"' class=admin_tooltip_edit>Редактировать</a>";
	}

	if(id = $(this).attr('data-product'))
	{
		tooltipcontent = "<a href='simpla/index.php?module=ProductAdmin&id="+id+"&return="+from+"' class=admin_tooltip_edit>Редактировать</a>";
	}

	if(id = $(this).attr('data-post'))
	{
		tooltipcontent = "<a href='simpla/index.php?module=PostAdmin&id="+id+"&return="+from+"' class=admin_tooltip_edit>Редактировать</a>";
	}

	if(id = $(this).attr('data-feature'))
	{
		tooltipcontent = "<a href='simpla/index.php?module=FeatureAdmin&id="+id+"&return="+from+"' class=admin_tooltip_edit>Редактировать</a>";
	}

	$('.tooltipBody').html(tooltipcontent);
}

function close_tooltip()
{
	if(tooltipcanclose)
	{
		tooltipcanclose=false;
		tooltip.hide();
	}
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
