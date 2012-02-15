{* Информера корзины (отдаётся аяксом) *}

{if $cart->total_products>0}
	В <a href="./cart/">корзине</a>
	{$cart->total_products} {$cart->total_products|plural:'товар':'товаров':'товара'}
	на {$cart->total_price|convert} {$currency->sign|escape}
{else}
	Корзина пуста
{/if}
