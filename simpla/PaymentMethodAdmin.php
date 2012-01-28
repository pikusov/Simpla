<?PHP
require_once('api/Simpla.php');

class PaymentMethodAdmin extends Simpla
{	

	public function fetch()
	{	
		if($this->request->method('post'))
		{
			$payment_method->id 			= $this->request->post('id', 'intgeger');
			$payment_method->enabled 		= $this->request->post('enabled', 'boolean');
			$payment_method->name 			= $this->request->post('name');
			$payment_method->currency_id	= $this->request->post('currency_id');
			$payment_method->description	= $this->request->post('description');
			$payment_method->module			= $this->request->post('module', 'string');
			
			$payment_settings = $this->request->post('payment_settings');

	 		if(!$payment_deliveries = $this->request->post('payment_deliveries'))
	 			$payment_deliveries = array();

			if(empty($payment_method->id))
			{
  				$payment_method->id = $this->payment->add_payment_method($payment_method);
  				$this->design->assign('message_success', 'Добавлено');
	    	}
	    	else
	    	{
	    		$this->payment->update_payment_method($payment_method->id, $payment_method);
  				$this->design->assign('message_success', 'Обновлено');
	    	}
	    	if($payment_method->id)
	    	{
	    		$this->payment->update_payment_settings($payment_method->id, $payment_settings);	    	
	    		$this->payment->update_payment_deliveries($payment_method->id, $payment_deliveries);
	    	}
		}
		else
		{
			$payment_method->id = $this->request->get('id', 'integer');
			if(!empty($payment_method->id))
			{
				$payment_method = $this->payment->get_payment_method($payment_method->id);
				$payment_settings =  $this->payment->get_payment_settings($payment_method->id);
			}
			else
			{
				$payment_settings = array();
			}
			$payment_deliveries = $this->payment->get_payment_deliveries($payment_method->id);
		}
		$this->design->assign('payment_deliveries', $payment_deliveries);	
		// Связанные способы доставки
		$deliveries = $this->delivery->get_deliveries();
		$this->design->assign('deliveries', $deliveries);

		$this->design->assign('payment_method', $payment_method);
		$this->design->assign('payment_settings', $payment_settings);
		$payment_modules = $this->payment->get_payment_modules();
		$this->design->assign('payment_modules', $payment_modules);
		
		$currencies = $this->money->get_currencies();
		$this->design->assign('currencies', $currencies);
		
		
  	  	return $this->design->fetch('payment_method.tpl');
	}
	
}

