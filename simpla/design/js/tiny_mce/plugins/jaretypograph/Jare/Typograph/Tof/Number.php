<?php
/**
 * @see Jare_Typograph_Tof
 */
require_once 'Jare/Typograph/Tof.php';

/**
 * Jare_Typograph_Tof_Number
 * 
 * @copyright  	Copyright (c) 2009 E.Muravjev Studio (http://emuravjev.ru)
 * @license    	http://emuravjev.ru/works/tg/eula/
 * @version 	2.0.0
 * @author 		Arthur Rusakov <arthur@emuravjev.ru>
 * @category    Jare
 * @package 	Jare_Typograph
 * @subpackage 	Tof
 */
class Jare_Typograph_Tof_Number extends Jare_Typograph_Tof
{
	/**
	 * Базовые параметры тофа
	 *
	 * @var array
	 */
	protected $_baseParam = array(
		'auto_times_x' => array(
			'_disable'		=> false,
			'function_link' => '_buildTimesx'),
		'numeric_sub' => array(
			'_disable'		=> false,
			'pattern' 		=> '/([a-zа-я0-9])\_([\d]{1,3})([^а-яa-z0-9]|$)/ieu',
			'replacement' 	=> '"\1" . $this->_buildTag($this->_buildTag("\2","small"),"sub") . "\3"'),
		'numeric_sup' => array(
			'_disable'		=> false,
			'pattern' 		=> '/([a-zа-я0-9])\^([\d]{1,3})([^а-яa-z0-9]|$)/ieu',
			'replacement' 	=> '"\1" . $this->_buildTag($this->_buildTag("\2","small"),"sup") . "\3"'),
		'simple_fraction' => array(
			'_disable'		=> true,
			'function_link' => '_buildSimpleFraction'),
		'math_chars' => array(
			'_disable'		=> false,
			'function_link' => '_buildMathChars'),
		);
	
	/**
	 * Преобразование простых дробей (1/2, 1/4 и 3/4) в HTML-коды
	 *
	 * @return 	void
	 */
	protected function _buildSimpleFraction()
	{
		$this->_text = preg_replace('/(\D)1\/(2|4)(\D)/', '\1&frac1\2\3', $this->_text);
		$this->_text = preg_replace('/(\D)3\/4(\D)/', '\1&frac34\2', $this->_text);
	}

	/**
	 * Расстановка &times; между числами
	 *
	 * @return 	void
	 */	
	protected function _buildTimesx()
	{
		$regExpMask = '/(\&times\;)?(\d+)(\040*)(x|х)(\040*)(\d+)/u';

		while(preg_match($regExpMask, $this->_text)) {
			$this->_text = preg_replace($regExpMask, '\1\2&times;\6', $this->_text);
		}
	}

	/**
	 * Расстановка простейших математических знаков
	 *
	 * @return 	void
	 */
	protected function _buildMathChars()
	{
		$this->_text = str_replace('!=', '&ne;', $this->_text);
		$this->_text = str_replace('<=', '&le;', $this->_text);
		$this->_text = str_replace('>=', '&ge;', $this->_text);
		$this->_text = str_replace('~=', '&cong;', $this->_text);
		$this->_text = str_replace('+-', '&plusmn;', $this->_text);
	}
}