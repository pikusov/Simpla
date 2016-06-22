<?php
chdir ('../../');
require_once('api/Simpla.php');

if (isset($_POST["m_operation_id"]) && isset($_POST["m_sign"]))
{
	// загрузка заказа
	
	$simpla = new Simpla();
	$order_id = $_POST['m_orderid'];
	$order = $simpla->orders->get_order(intval($order_id));
	
	if(!empty($order))
	{
		$method = $simpla->payment->get_payment_method(intval($order->payment_method_id));
		
		if(!empty($method))
		{
			$err = false;
			$message = '';
			$settings = unserialize($method->settings);
			
			// запись логов
			
			$log_text = 
			"--------------------------------------------------------\n" .
			"operation id		" . $_POST['m_operation_id'] . "\n" .
			"operation ps		" . $_POST['m_operation_ps'] . "\n" .
			"operation date		" . $_POST['m_operation_date'] . "\n" .
			"operation pay date	" . $_POST['m_operation_pay_date'] . "\n" .
			"shop				" . $_POST['m_shop'] . "\n" .
			"order id			" . $_POST['m_orderid'] . "\n" .
			"amount				" . $_POST['m_amount'] . "\n" .
			"currency			" . $_POST['m_curr'] . "\n" .
			"description		" . base64_decode($_POST['m_desc']) . "\n" .
			"status				" . $_POST['m_status'] . "\n" .
			"sign				" . $_POST['m_sign'] . "\n\n";
			
			$log_file = $settings['payeer_log'];
			
			if (!empty($log_file))
			{
				file_put_contents($_SERVER['DOCUMENT_ROOT'] . $log_file, $log_text, FILE_APPEND);
			}
			
			// проверка цифровой подписи и ip

			$sign_hash = strtoupper(hash('sha256', implode(":", array(
				$_POST['m_operation_id'],
				$_POST['m_operation_ps'],
				$_POST['m_operation_date'],
				$_POST['m_operation_pay_date'],
				$_POST['m_shop'],
				$_POST['m_orderid'],
				$_POST['m_amount'],
				$_POST['m_curr'],
				$_POST['m_desc'],
				$_POST['m_status'],
				$settings['payeer_secret']
			))));
			
			$valid_ip = true;
			$sIP = str_replace(' ', '', $settings['payeer_ip_list']);
			
			if (!empty($sIP))
			{
				$arrIP = explode('.', $_SERVER['REMOTE_ADDR']);
				if (!preg_match('/(^|,)(' . $arrIP[0] . '|\*{1})(\.)' .
				'(' . $arrIP[1] . '|\*{1})(\.)' .
				'(' . $arrIP[2] . '|\*{1})(\.)' .
				'(' . $arrIP[3] . '|\*{1})($|,)/', $sIP))
				{
					$valid_ip = false;
				}
			}
			
			if (!$valid_ip)
			{
				$message .= " - ip-адрес сервера не является доверенным\n" .
				"   доверенные ip: " . $sIP . "\n" .
				"   ip текущего сервера: " . $_SERVER['REMOTE_ADDR'] . "\n";
				$err = true;
			}

			if ($_POST['m_sign'] != $sign_hash)
			{
				$message .= " - не совпадают цифровые подписи\n";
				$err = true;
			}
			
			if (!$err)
			{
				// проверка суммы
				
				if ($_POST['m_amount'] != $order->total_price)
				{
					$message .= " - неправильная сумма\n";
					$err = true;
				}
				
				// проверка статуса
				
				if (!$err)
				{
					switch ($_POST['m_status'])
					{
						case 'success':
							$simpla->orders->update_order(intval($order_id),
								array(
								'paid' => 1,
								'status' => $settings['payeer_order_status']
							));
							
							$simpla->notify->email_order_user(intval($order_id));
							$simpla->orders->close(intval($order_id));
							break;
							
						default:
							$message .= " - статус платежа не является success\n";
							$err = true;
							break;
					}
				}
			}
			
			if ($err)
			{
				$to = $settings['payeer_email'];

				if (!empty($to))
				{
					$message = "Не удалось провести платёж через систему Payeer по следующим причинам:\n\n" . $message . "\n" . $log_text;
					$headers = "From: no-reply@" . $_SERVER['HTTP_HOST'] . "\r\n" . 
					"Content-type: text/plain; charset=utf-8 \r\n";
					mail($to, 'Ошибка оплаты', $message, $headers);
				}
				
				exit($order_id . '|error');
			}
			else
			{
				exit($order_id . '|success');
			}
		}
	}
}