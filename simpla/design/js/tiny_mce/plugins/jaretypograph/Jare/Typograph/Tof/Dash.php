<?php
/**
 * @see Jare_Typograph_Tof
 */
require_once 'Jare/Typograph/Tof.php';

/**
 * Jare_Typograph_Tof_Dash
 * 
 * @copyright  	Copyright (c) 2009 E.Muravjev Studio (http://emuravjev.ru)
 * @license    	http://emuravjev.ru/works/tg/eula/
 * @version 	2.0.0
 * @author 		Arthur Rusakov <arthur@emuravjev.ru>
 * @category    Jare
 * @package 	Jare_Typograph
 * @subpackage 	Tof
 */
class Jare_Typograph_Tof_Dash extends Jare_Typograph_Tof
{
	/**
	 * Базовые параметры тофа
	 *
	 * @var array
	 */
	protected $_baseParam = array(
		'mdash' => array(
			'_disable'		=> false,
			'pattern' 		=> '/([a-zа-я0-9]+|\,|\:|\)|\&raquo\;|\|\")(\040|\t)(\-|\&mdash\;)(\s|$|\<)/u', 
			'replacement' 	=> '\1&nbsp;&mdash;\4'),
		'mdash_2' => array(
			'_disable'		=> false,
			'pattern' 		=> '/(\n|\r|^|\>)(\-|\&mdash\;)(\t|\040)/',
			'replacement' 	=> '\1&mdash;&nbsp;'),
		'mdash_3' => array(
			'_disable'		=> false,
			'pattern' 		=> '/(\.|\!|\?|\&hellip\;)(\040|\t|\&nbsp\;)(\-|\&mdash\;)(\040|\t|\&nbsp\;)/',
			'replacement' 	=> '\1 &mdash;&nbsp;'),
		'years' => array(
			'_disable'		=> false,
			'pattern' 		=> '/(с|по|период|середины|начала|начало|конца|конец|половины|в|между)(\s+|\&nbsp\;)([\d]{4})(-)([\d]{4})(г|гг)?/eui',
			'replacement' 	=> '"\1\2" . $this->_buildYears("\3","\5","\4") . "\6"'),
		'iz_za_pod' => array(
			'_disable'		=> false,
			'pattern' 		=> '/(\s|\&nbsp\;|\>)(из)(\040|\t|\&nbsp\;)\-?(за|под)([\.\,\!\?\:\;]|\040|\&nbsp\;)/uie',
			'replacement' 	=> '("\1" == "&nbsp;" ? " " : "\1") . "\2-\4" . ("\5" == "&nbsp;"? " " : "\5")'),
		'to_libo_nibud' => array(
			'_disable'		=> false,
			'function_link'	=> '_buildToLiboNibud')
		);

	/**
	 * Расстановка короткого тире между годами
	 *
	 * @param 	string $start
	 * @param 	string $end
	 * @param 	string $sep
	 * @return 	string
	 */
	protected function _buildYears($start, $end, $sep)
	{
		$start = (int) $start;
		$end = (int) $end;
		
		return ($start >= $end) ? "$start$sep$end" : "$start&ndash;$end";
	}
	
	/**
	 * Расстановка дефиса перед -то, -либо, -нибудь
	 *
	 * @return 	void
	 */
	protected function _buildToLiboNibud()
	{
		$regExpMask = '/(\s|^|\&nbsp\;|\>)(кто|кем|когда|зачем|почему|как|что|чем|где|чего|кого)\-?(\040|\t|\&nbsp\;)\-?(то|либо|нибудь)([\.\,\!\?\;]|\040|\&nbsp\;|$)/ui';
		
		while( preg_match($regExpMask, $this->_text)) {
			$this->_text = preg_replace($regExpMask . 'e', '("\1" == "&nbsp;" ? " " : "\1") . "\2-\4" . ("\5" == "&nbsp;"? " " : "\5")', $this->_text);
		}
	}
}