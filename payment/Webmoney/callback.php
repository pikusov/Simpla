<?php

/**
 * Simpla CMS
 *
 * @copyright 	2011 Denis Pikusov
 * @link 		http://simplacms.ru
 * @author 		Denis Pikusov
 *
 * К этому скрипту обращается webmoney в процессе оплаты
 *
 */
 
// Работаем в корневой директории
chdir ('../../');
require_once('api/Simpla.php');

$simpla = new Simpla();

// Это предварительный запрос?
if(isset($_POST['LMI_PREREQUEST']) && $_POST['LMI_PREREQUEST']==1)
{
	$pre_request = 1;
}
else
{
	$pre_request = 0;
}

// Кошелек продавца
// Кошелек продавца, на который покупатель совершил платеж. Формат - буква и 12 цифр.
$merchant_purse = $_POST['LMI_PAYEE_PURSE'];

// Сумма платежа
// Сумма, которую заплатил покупатель. Дробная часть отделяется точкой.
$amount = $_POST['LMI_PAYMENT_AMOUNT'];
       
// Внутренний номер покупки продавца
// В этом поле передается id заказа в нашем магазине.
$order_id = $_POST['LMI_PAYMENT_NO'];

// Флаг тестового режима
// Указывает, в каком режиме выполнялась обработка запроса на платеж. Может принимать два значения: 
// 0: Платеж выполнялся в реальном режиме, средства переведены с кошелька покупателя на кошелек продавца; 
// 1: Платеж выполнялся в тестовом режиме, средства реально не переводились.
$test_mode = $_POST['LMI_MODE'];

// Внутренний номер счета в системе WebMoney Transfer
// Номер счета в системе WebMoney Transfer, выставленный покупателю от имени продавца
// в процессе обработки запроса на выполнение платежа сервисом Web Merchant Interface.
// Является уникальным в системе WebMoney Transfer.
$wm_order_id = $_POST['LMI_SYS_INVS_NO'];

// Внутренний номер платежа в системе WebMoney Transfer
// Номер платежа в системе WebMoney Transfer, выполненный в процессе обработки запроса
// на выполнение платежа сервисом Web Merchant Interface.
// Является уникальным в системе WebMoney Transfer.
$wm_transaction_id = $_POST['LMI_SYS_TRANS_NO'];

// Кошелек покупателя
// Кошелек, с которого покупатель совершил платеж.
$payer_purse = $_POST['LMI_PAYER_PURSE'];

// WMId покупателя
// WM-идентификатор покупателя, совершившего платеж.
$payer_wmid = $_POST['LMI_PAYER_WM'];

// Номер ВМ-карты (электронного чека)
// Номер чека Paymer.com или номер ВМ-карты, присутствует только в случае,
// если покупатель производит оплату чеком Пеймер или ВМ-картой.
$paymer_number = $_POST['LMI_PAYMER_NUMBER'];


// Paymer.com e-mail покупателя
// Email указанный покупателем, присутствует только в случае,
// если покупатель производит оплату чеком Paymer.com или ВМ-картой.
$paymer_email = $_POST['LMI_PAYMER_EMAIL'];

// Номер телефона покупателя
// Номер телефона покупателя, присутствует только в случае,
// если покупатель производит оплату с телефона в Keeper Mobile.
$mobile_keeper_phone = $_POST['LMI_TELEPAT_PHONENUMBER'];

// Номер платежа в Keeper Mobile
// Номер платежа в Keeper Mobile, присутствует только в случае,
// если покупатель производит оплату с телефона в Keeper Mobile.
$mobile_keeper_order_id = $_POST['LMI_TELEPAT_ORDERID'];

// Срок кредитования	LMI_PAYMENT_CREDITDAY
// В случае если покупатель платит с своего кошелька типа C на кошелек продавца типа D
// (вариант продажи продавцом своих товаров или услуг в кредит), в данном параметре указывается срок кредитования в днях.
// Настоятельно рекомендуем обязательно проверять сооветствие данного параметра
// в форме оповещения о платеже значению параметра в форме запроса платежа.
$credit_days = $_POST['LMI_PAYMENT_CREDITDAYS'];

// Контрольная подпись
$hash = $_POST['LMI_HASH'];

// Дата и время выполнения платежа
// Дата и время реального прохождения платежа в системе WebMoney Transfer в формате "YYYYMMDD HH:MM:SS"
$date = $_POST['LMI_SYS_TRANS_DATE'];


// Метод оплаты
$payment_method_id = $_POST['PAYMENT_METHOD_ID'];


////////////////////////////////////////////////
// Выберем заказ из базы
////////////////////////////////////////////////
$order = $simpla->orders->get_order(intval($order_id));
if(empty($order))
	die('Оплачиваемый заказ не найден');
 
// Нельзя оплатить уже оплаченный заказ  
if($order->paid)
	die('Этот заказ уже оплачен');

////////////////////////////////////////////////
// Выбираем из базы соответствующий метод оплаты
////////////////////////////////////////////////
$method = $simpla->payment->get_payment_method(intval($order->payment_method_id));
if(empty($method))
	die("Неизвестный метод оплаты");
 
$settings = unserialize($method->settings);
       
       
////////////////////////////////////
// Проверка контрольной подписи (только для оповещения об успешной оплате, не для pre_request)
////////////////////////////////////
// Контрольная подпись данных о платеже позволяет продавцу проверять как источник данных,
// так и целостность данных, переданных на Result URL через "Форму оповещения о платеже".
// При формировании контрольной подписи сервис Web Merchant Interface "склеивает" значения полей,
// передаваемых "Формой оповещения о платеже"
if($pre_request != 1)
{
	$str = $merchant_purse.$amount.$order_id.$test_mode.$wm_order_id.$wm_transaction_id.$date.$settings['secret_key'].$payer_purse.$payer_wmid;
	$md5 = strtoupper(md5($str));
	if($md5 !== $hash)
	{
		die("Контрольная подпись не верна");
	}
}

////////////////////////////////////
// Проверка суммы платежа
////////////////////////////////////
       
//  Первые буквы кошельков
$merchant_purse_first_letter = strtoupper($merchant_purse[0]);
$payer_purse_first_letter = strtoupper($payer_purse[0]);
       
// Если первые буквы кошельков не совпадают - ошибка
if(($first_purse_letter = $merchant_purse_first_letter) != $payer_purse_first_letter)
	die("Типы кошельков продавца и покупателя не совпадают");

// Сумма заказа у нас в магазине
$order_amount = $simpla->money->convert($order->total_price, $method->currency_id, false);
       
// Должна быть равна переданной сумме
if($order_amount != $amount || $amount<=0)
	die("Неверная сумма оплаты");

////////////////////////////////////
// Проверка кошелька продавца
////////////////////////////////////
if($merchant_purse != $settings['purse'])
	die("Неверный кошелек продавца");
  
////////////////////////////////////
// Проверка наличия товара
////////////////////////////////////
$purchases = $simpla->orders->get_purchases(array('order_id'=>intval($order->id)));
foreach($purchases as $purchase)
{
	$variant = $simpla->variants->get_variant(intval($purchase->variant_id));
	if(empty($variant) || (!$variant->infinity && $variant->stock < $purchase->amount))
	{
		die("Нехватка товара $purchase->product_name $purchase->variant_name");
	}
}
       
// Запишем
if(!$pre_request)
{
	// Установим статус оплачен
	$simpla->orders->update_order(intval($order->id), array('paid'=>1));

	// Спишем товары  
	$simpla->orders->close(intval($order->id));
}

if(!$pre_request)
{
	$simpla->notify->email_order_user(intval($order->id));
	$simpla->notify->email_order_admin(intval($order->id));
}

die("Yes");
