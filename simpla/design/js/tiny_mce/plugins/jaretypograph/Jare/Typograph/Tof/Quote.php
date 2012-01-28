<?php
/**
 * @see Jare_Typograph_Tof
 */
require_once 'Jare/Typograph/Tof.php';

/**
 * Jare_Typograph_Tof_Quote
 * 
 * @copyright  	Copyright (c) 2009 E.Muravjev Studio (http://emuravjev.ru)
 * @license    	http://emuravjev.ru/works/tg/eula/
 * @version 	2.0.0
 * @author 		Arthur Rusakov <arthur@emuravjev.ru>
 * @category    Jare
 * @package 	Jare_Typograph
 * @subpackage 	Tof
 */
class Jare_Typograph_Tof_Quote extends Jare_Typograph_Tof
{
	/**
	 * Типы кавычек
	 */
	const QUOTE_FIRS_OPEN = '&laquo;';
    const QUOTE_FIRS_CLOSE = '&raquo;';
    const QUOTE_CRAWSE_OPEN = '&bdquo;';
    const QUOTE_CRAWSE_CLOSE = '&ldquo;';
    
	/**
	 * Базовые параметры тофа
	 *
	 * @var array
	 */
    protected $_baseParam = array(
		'quotes_outside_a' => array(
			'_disable'		=> false,
			'pattern' 		=> '/(\<%%\_\_.+?\>)\"(.+?)\"(\<\/%%\_\_.+?\>)/s',
			'replacement' 	=> '"\1\2\3"'),
		'open_quote' => array(
			'_disable'		=> false,
			'function_link' => '_buildOpenQuote'),
		'close_quote' => array(
			'_disable'		=> false,
			'function_link' => '_buildCloseQuote'),
		'optical_alignment' => array(
			'_disable'		=> false,
			'function_link' => '_buildOpticalAlignment'),
		);

	/**
	 * Расстановка закрывающих кавычек
	 * 
	 * @return 	void
	 */
	protected function _buildOpenQuote()
	{
		$regExpMask = '/(^|\(|\s|\>)(\"|\\\")(\S+)/iu';

		while(preg_match($regExpMask, $this->_text)) {
			$this->_text = preg_replace($regExpMask . 'e', '"\1" . self::QUOTE_FIRS_OPEN . "\3"', $this->_text);
		}
	}
	
	/**
	 * Расстановка закрывающих кавычек
	 * 
	 * @return 	void
	 */
	protected function _buildCloseQuote()
	{
		$regExpMask = '/([a-zа-я0-9]|\.|\&hellip\;|\!|\?|\>)(\"|\\\")+(\.|\&hellip\;|\;|\:|\?|\!|\,|\s|\)|\<\/|$)/ui';

		while(preg_match($regExpMask, $this->_text)) {
			$this->_text = preg_replace($regExpMask . 'e', '"\1" . self::QUOTE_FIRS_CLOSE . "\3"', $this->_text);
		}
	}
	
	/**
	 * Оптическое выравнивание открывающей кавычки
	 *
	 * @return 	void
	 */
	protected function _buildOpticalAlignment()
	{
		$this->_text = preg_replace('/([a-zа-я\-]{3,})(\040|\&nbsp\;|\t)(\&laquo\;)/uie', '"\1" . $this->_buildTag("\2", "span",array("style" => "margin-right:0.44em;")) . $this->_buildTag("\3", "span", array("style" => "margin-left:-0.44em;"))', $this->_text);
		$this->_text = preg_replace('/(\n|\r|^)(\&laquo\;)/ei', '"\1" . $this->_buildTag("\2", "span", array("style" => "margin-left:-0.44em;"))', $this->_text);
	}
}