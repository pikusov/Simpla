<?PHP

/**
 * Simpla CMS
 *
 */

require_once('api/Simpla.php');


class PaymentModule extends Simpla
{
 
	public function checkout_form()
	{
		$form = '<input type=submit value="Оплатить">';	
		return $form;
	}
	public function settings()
	{
		$form = '<input type=submit value="Оплатить">';	
		return $form;
	}
}
