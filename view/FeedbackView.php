<?PHP

/**
 * Simpla CMS
 *
 * @copyright 	2011 Denis Pikusov
 * @link 		http://simp.la
 * @author 		Denis Pikusov
 *
 * Отображение статей на сайте
 * Этот класс использует шаблоны articles.tpl и article.tpl
 *
 */
 
require_once('View.php');

class FeedbackView extends View
{
	function fetch()
	{
		if($this->request->method('post') && $this->request->post('feedback'))
		{
			$feedback->name         = $this->request->post('name');
			$feedback->email        = $this->request->post('email');
			$feedback->message      = $this->request->post('message');
			$captcha_code           = $this->request->post('captcha_code');
			
			$this->design->assign('name',  $feedback->name);
			$this->design->assign('email', $feedback->email);
			$this->design->assign('message', $feedback->message);
			
			if(empty($feedback->name))
				$this->design->assign('error', 'empty_name');
			elseif(empty($feedback->email))
				$this->design->assign('error', 'empty_email');
			elseif(empty($feedback->message))
				$this->design->assign('error', 'empty_text');
			elseif(empty($_SESSION['captcha_code']) || $_SESSION['captcha_code'] != $captcha_code || empty($captcha_code))
			{
				$this->design->assign('error', 'captcha');
			}
			else
			{
				$this->design->assign('message_sent', true);
				
				$feedback->ip = $_SERVER['REMOTE_ADDR'];
				$feedback_id = $this->feedbacks->add_feedback($feedback);
				
				// Отправляем email
				$this->notify->email_feedback_admin($feedback_id);				
				
				// Приберем сохраненную капчу, иначе можно отключить загрузку рисунков и постить старую
				unset($_SESSION['captcha_code']);
								
			}
	
		}

		if($this->page)
		{
			$this->design->assign('meta_title', $this->page->meta_title);
			$this->design->assign('meta_keywords', $this->page->meta_keywords);
			$this->design->assign('meta_description', $this->page->meta_description);
		}

		$body = $this->design->fetch('feedback.tpl');
		
		return $body;
	}
}
