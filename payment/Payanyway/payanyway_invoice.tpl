{* Страница заказа *}

{$meta_title = "Ваш заказ №`$invoice.transaction`" scope=parent}

{if $invoice.status == 'CREATED'}
	<H1>Создано платежное поручение.</H1>
	{if $invoice.system == 'post'}
		<p>Операция оплаты  почтовым переводом создана и находится в обработке. Для завершения операции <a target="_blank" href="https://www.payanyway.ru/mailofrussiablank.htm?operationId={$invoice.transaction}">распечатайте</a> бланк почтового перевода и проведите электронный платеж в любом отделении связи <a target="_blank" href="http://www.russianpost.ru">Почты России</a>. Для просмотра бланка в формате PDF необходимо иметь установленную на Вашем компьютере программу <a target="_blank" href="http://get.adobe.com/reader/">Adobe Acrobat Reader.</a></p>
	{elseif $invoice.system == 'banktransfer'}
		<p>Операция оплаты банковским переводом создана и находится в обработке. Для завершения операции <a onclick="window.open('https://www.payanyway.ru/wiretransferreceipt.htm?transactionId={$invoice.transaction}&paymentSystem.unitId={$invoice.unitid}','newwindow','1,0,0,0,0,resizable=1,scrollbars=1,width=730,height=670');return false;" href="#">распечатайте</a> бланк платежного поручения и оплатите квитанцию в любом российском банке.</p>
	{elseif $invoice.system == 'forward'}
		<h3>Для оплаты через Форвард Мобайл номер счета для пополнения: {$invoice.transaction}</h3>
		<br>
		<p>Операция создана, но не оплачена. Для завершения операции Вам необходимо произвести перечисление средств в систему <b>МОНЕТА.РУ</b> через Форвард Мобайл, используя вместо номера счета для пополнения данный код:</p>
		<br>
		<p>{$invoice.transaction}</p>
		<br>
		<p>Сумма: {$invoice.amount}</p>
		<br>
		<p>Внешняя комиссия: {$invoice.payerFee}</p>
		<br>
		<p>Сумма к оплате: {$invoice.payerAmount}</p>
	{elseif $invoice.system == 'ciberpay'}
		<h3>Для оплаты через CiberPay номер счета для пополнения: {$invoice.transaction}</h3>
		<br>
		<p>Операция создана, но не оплачена. Для завершения операции Вам необходимо произвести перечисление средств в систему <b>МОНЕТА.РУ</b> через CiberPay, используя вместо номера счета для пополнения данный код:</p>
		<br>
		<p>{$invoice.transaction}</p>
		<br>
		<p>Сумма: {$invoice.amount}</p>
		<br>
		<p>Внешняя комиссия: {$invoice.payerFee}</p>
		<br>
		<p>Сумма к оплате: {$invoice.payerAmount}</p>
	{elseif $invoice.system == 'novoplat'}
		<h3>Для оплаты через NovoPlat номер счета для пополнения: {$invoice.transaction}</h3>
		<br>
		<p>Операция создана, но не оплачена. Для завершения операции Вам необходимо произвести перечисление средств в систему <b>PayAnyWay</b> через NovoPlat, используя данный код:</p>
		<br>
		<p>{$invoice.transaction}</p>
		<br>
		<p>Сумма: {$invoice.amount}</p>
		<br>
		<p>Внешняя комиссия: {$invoice.payerFee}</p>
		<br>
		<p>Сумма к оплате: {$invoice.payerAmount}</p>
	{elseif $invoice.system == 'platika'}
		<h3>Для оплаты через PLATiKA номер счета для пополнения: {$invoice.transaction}</h3>
		<br>
		<p>Операция создана, но не оплачена. Для завершения операции Вам необходимо произвести перечисление средств в систему <b>МОНЕТА.РУ</b> через систему PLATiKA, используя вместо номера счета для пополнения данный код:</p>
		<br>
		<p>{$invoice.transaction}</p>
		<br>
		<p>Сумма: {$invoice.amount}</p>
		<br>
		<p>Внешняя комиссия: {$invoice.payerFee}</p>
		<br>
		<p>Сумма к оплате: {$invoice.payerAmount}</p>
	{elseif $invoice.system == 'mcb'}
		<h3>Для оплаты через терминалы МосКредитБанка номер счета для пополнения: {$invoice.transaction}</h3>
		<br>
		<p>Операция создана, но не оплачена. Для завершения операции Вам необходимо произвести перечисление средств в систему <b>МОНЕТА.РУ</b> через терминалы Московского Кредитного Банка, используя вместо номера счета для пополнения данный код:</p>
		<br>
		<p>{$invoice.transaction}</p>
		<br>
		<p>Сумма: {$invoice.amount}</p>
		<br>
		<p>Внешняя комиссия: {$invoice.payerFee}</p>
		<br>
		<p>Сумма к оплате: {$invoice.payerAmount}</p>
	{elseif $invoice.system == 'eleksnet'}
		<h3>Для оплаты в Элекснет номер счета для пополнения: {$invoice.transaction}</h3>
		<br>
		<p>Операция создана, но не оплачена. Для завершения операции Вам необходимо произвести перечисление средств в систему <b>PayAnyWay</b> через терминалы Элекснет, используя данный код:</p>
		<br>
		<p>{$invoice.transaction}</p>
		<br>
		<p>Сумма: {$invoice.amount}</p>
		<br>
		<p>Внешняя комиссия: {$invoice.payerFee}</p>
		<br>
		<p>Сумма к оплате: {$invoice.payerAmount}</p>
	{elseif $invoice.system == 'comepay'}
		<h3>Для оплаты в ComePay номер счета для пополнения: {$invoice.transaction}</h3>
		<br>
		<p>Операция создана, но не оплачена. Для завершения операции Вам необходимо произвести перечисление средств в систему <b>PayAnyWay</b> через терминалы ComePay, используя данный код:</p>
		<br>
		<p>{$invoice.transaction}</p>
		<br>
		<p>Сумма: {$invoice.amount}</p>
		<br>
		<p>Внешняя комиссия: {$invoice.payerFee}</p>
		<br>
		<p>Сумма к оплате: {$invoice.payerAmount}</p>
	{elseif $invoice.system == 'gorod'}
		<h3>Для оплаты через "Федеральную Систему ГОРОД" номер счета для пополнения: {$invoice.transaction}</h3>
		<br>
		<p>Операция создана, но не оплачена. Для завершения операции Вам необходимо произвести перечисление средств в систему <b>PayAnyWay</b> через "Федеральную Систему ГОРОД", используя данный код:</p>
		<br>
		<p>{$invoice.transaction}</p>
		<br>
		<p>Сумма: {$invoice.amount}</p>
		<br>
		<p>Внешняя комиссия: {$invoice.payerFee}</p>
		<br>
		<p>Сумма к оплате: {$invoice.payerAmount}</p>
	{elseif $invoice.system == 'contact'}
		<h3>Для оплаты в системе "Contact" номер счета для пополнения: {$invoice.transaction}</h3>
		<br>
		<p>Операция создана, но не оплачена. Для завершения операции Вам необходимо произвести перечисление средств в систему <b>МОНЕТА.РУ</b> через систему "Contact", используя вместо номера счета для пополнения данный код:</p>
		<br>
		<p>{$invoice.transaction}</p>
		<br>
		<p>Сумма: {$invoice.amount}</p>
		<br>
		<p>Внешняя комиссия: {$invoice.payerFee}</p>
		<br>
		<p>Сумма к оплате: {$invoice.payerAmount}</p>
	{elseif $invoice.system == 'euroset'}
		<h3>Для оплаты через Евросеть номер счета для пополнения: {$invoice.transaction}</h3>
		<br>
		<p>Операция создана, но не оплачена. Для завершения операции Вам необходимо произвести перечисление средств в систему <b>PayAnyWay</b> через Евросеть, используя данный код:</p>
		<br>
		<p>{$invoice.transaction}</p>
		<br>
		<p>Сумма: {$invoice.amount}</p>
		<br>
		<p>Внешняя комиссия: {$invoice.payerFee}</p>
		<br>
		<p>Сумма к оплате: {$invoice.payerAmount}</p>
	{elseif $invoice.system == 'alfaclick'}
		<h3></h3>
		<br>
		<p></p>
		<br>
		<p>{$invoice.transaction}</p>
		<br>
		<p>Сумма: {$invoice.amount}</p>
		<br>
		<p>Внешняя комиссия: {$invoice.payerFee}</p>
		<br>
		<p>Сумма к оплате: {$invoice.payerAmount}</p>
	{elseif $invoice.system == 'megafon'}
		<h3>Для оплаты через Союзтелеком используйте идентификатор: {$invoice.transaction}</h3>
		<p>Услуга 'Мобильный платеж Мегафон' ('Оплата по SMS для абонентов Мегафон') - это простой, безопасный и доступный каждому способ моментальной оплаты.</p>
		<br>
		<p>Обратите внимание!<br/>· Двоеточия между частями SMS обязательны<br/>· После списания суммы покупки на вашем счете должно остаться не менее 10 руб.</p>
		<br>
		<p>Операция создана, но не оплачена. Для завершения операции Вам необходимо произвести перечисление средств, послав SMS через оператора Мегафон (только в России) на короткий номер <b>843808</b> вида:</p>
		<br>
		<p><b>503</b>[двоеточие]<b>ИДЕНТИФИКАТОР</b></p>
		<br>
		<p>В данном случае: 503:{$invoice.transaction}</p>
		<br>
		<p>Сумма: {$invoice.amount}</p>
		<br>
		<p>Внешняя комиссия: {$invoice.payerFee}</p>
		<br>
		<p>Сумма к оплате: {$invoice.payerAmount}</p>
	{elseif $invoice.system == 'mts'}
		<p>Услуга 'Мобильный платеж МТС' ('Оплата по SMS для абонентов МТС') - это простой, безопасный и доступный каждому способ моментальной оплаты.</p>
		<br>
		<p>Операция создана, но не оплачена.</p>
		<br>
		<p>Вам придет SMS с просьбой подтвердить платеж. Если Вы согласны, отправьте в ответ на это SMS цифру 1. После отправки подтверждения Вы получите SMS-уведомление об успешной оплате. Со счета телефона будет списана указанная сумма.</p>
		<br>
		<p>Сумма: {$invoice.amount}</p>
		<br>
		<p>Внешняя комиссия: {$invoice.payerFee}</p>
		<br>
		<p>Сумма к оплате: {$invoice.payerAmount}</p>
	{elseif $invoice.system == 'kassiranet'}
		<h3>Для оплаты номер счета для пополнения: {$invoice.transaction}</h3>
		<br>
		<p>Операция создана, но не оплачена. Для завершения операции Вам необходимо произвести перечисление средств в систему <b>Монета.Ру</b>, используя вместо номера счета для пополнения данный код:</p>
		<br>
		<p>{$invoice.transaction}</p>
		<br>
		<p>Сумма: {$invoice.amount}</p>
		<br>
		<p>Внешняя комиссия: {$invoice.payerFee}</p>
		<br>
		<p>Сумма к оплате: {$invoice.payerAmount}</p>
	{elseif $invoice.system == 'sberbank'}
		<h3>Для оплаты через "Сбербанк" номер счета для пополнения: {$invoice.transaction}</h3>
		<br>
		<p>Операция создана, но не оплачена. Для завершения операции Вам необходимо произвести перечисление средств в систему <b>МОНЕТА.РУ</b> через "Сбербанк", используя вместо номера счета для пополнения данный код:</p>
		<br>
		<p>{$invoice.transaction}</p>
		<br>
		<p>Вы также можете перейти по <a target="_blank" href="https://online.sberbank.ru/PhizIC/private/payments/servicesPayments/edit.do?recipient=113368&field(_TCM_IDENT_WlsZid1)={$invoice.transaction}">ссылке</a> для оплаты с помощью системы СбербанкОнлайн.</p>
		<br/>
		<p>Сумма: {$invoice.amount}</p>
		<br>
		<p>Внешняя комиссия: {$invoice.payerFee}</p>
		<br>
		<p>Сумма к оплате: {$invoice.payerAmount}</p>
	{/if}
{else}
	<H1>Ошибка создания платежного поручения.</H1>
	{$invoice.error_message}
{/if}


