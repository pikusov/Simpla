<?php
/**
 * @see Jare_Typograph_Tof
 */
require_once 'Jare/Typograph/Tof.php';

/**
 * Jare_Typograph_Tof_Punctmark
 * 
 * @copyright  	Copyright (c) 2009 E.Muravjev Studio (http://emuravjev.ru)
 * @license    	http://emuravjev.ru/works/tg/eula/
 * @version 	2.0.0
 * @author 		Arthur Rusakov <arthur@emuravjev.ru>
 * @category    Jare
 * @package 	Jare_Typograph
 * @subpackage 	Tof
 */
class Jare_Typograph_Tof_Punctmark extends Jare_Typograph_Tof
{
	/**
	 * Базовые параметры тофа
	 *
	 * @var array
	 */
	protected $_baseParam = array( 
	 	'auto_comma' => array(
	 		'_disable'		=> false,
	 		'pattern' 		=> '/([a-zа-я])(\s|&nbsp;)(но|а)(\s|&nbsp;)/iu',
	 		'replacement' 	=> '\1,\2\3\4'), 
		'punctuation_marks_limit' => array(
			'_disable'		=> false,
			'pattern' 		=> '/([\!\.\?]){4,}/', 
			'replacement' 	=> '\1\1\1'), 	
		'punctuation_marks_base_limit' => array(
			'_disable'		=> false,
			'pattern' 		=> '/([\,]|[\:]|[\;]]){2,}/',
			'replacement' 	=> '\1'),
		'hellip' => array(
			'_disable'		=> false,
			'function_link' => '_buildHellipTags'),
		'eng_apostrophe' => array(
			'_disable'		=> false,
			'pattern' 		=> '/(\s|^|\>)([a-z]{2,})\'([a-z]+)/i',
			'replacement' 	=> '\1\2&rsquo;\3'),
		'fix_pmarks' => array(
			'_disable'		=> false,
			'pattern' 		=> '/([a-zа-я0-9])(\!|\.|\?){2}(\s|$|\<)/i',
			'replacement' 	=> '\1\2\3'),
		'fix_brackets' => array(
			'_disable'		=> false,
			'function_link' => '_fixBrackets'),
		);
	
	/**
	 * Расстановка многоточия вместо трех и двух точек
	 *
	 * @return 	void
	 */
	protected function _buildHellipTags()
	{
		$this->_text = str_replace(array('...', '..'), '&hellip;', $this->_text);
	}
	
	/**
	 * Удаление лишних пробелов внутри скобок
	 *
	 * @return 	void
	 */
	protected function _fixBrackets()
	{
		$this->_text = preg_replace('/(\()(\040|\t)+/', '\1', $this->_text);
		$this->_text = preg_replace('/(\040|\t)+(\))/', '\2', $this->_text);
	}
}