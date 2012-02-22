<?php
/**
 * @see Jare_Typograph_Tof
 */
require_once 'Jare/Typograph/Tof.php';

/**
 * Jare_Typograph_Tof_Space
 * 
 * @copyright  	Copyright (c) 2009 E.Muravjev Studio (http://emuravjev.ru)
 * @license    	http://emuravjev.ru/works/tg/eula/
 * @version 	2.0.0
 * @author 		Arthur Rusakov <arthur@emuravjev.ru>
 * @category    Jare
 * @package 	Jare_Typograph
 * @subpackage 	Tof
 */
class Jare_Typograph_Tof_Space extends Jare_Typograph_Tof
{
	/**
	 * Базовые параметры тофа
	 *
	 * @var array
	 */
	protected $_baseParam = array(
		'nobr_abbreviation' => array(
			'_disable'		=> false,
			'pattern' 		=> '/(\s+|^|\>)(\d+)(\040|\t)*(dpi|lpi)([\s\;\.\?\!\:\(]|$)/i', 
			'replacement' 	=> '\1\2&nbsp;\4\5'),
		'nobr_acronym' => array(
			'_disable'		=> false,
			'pattern' 		=> '/(\s|^|\>)(гл|стр|рис|ил)\.(\040|\t)*(\d+)(\s|\.|\,|\?|\!|$)/iu', 
			'replacement' 	=> '\1\2.&nbsp;\4\5'),		
		'nobr_before_unit' => array(
			'_disable'		=> false,
			'pattern' 		=> '/(\s|^|\>)(\d+)(м|мм|см|км|гм|km|dm|cm|mm)(\s|\.|\!|\?|\,|$)/iu', 
			'replacement' 	=> '\1\2&nbsp;\3\4'),				
		'remove_space_before_punctuationmarks' => array(
			'_disable'		=> false,
			'pattern' 		=> '/(\040|\t|\&nbsp\;)([\,\:\.])(\s+)/', 
			'replacement' 	=> '\2\3'),			
		'autospace_after_comma' => array(
			'_disable'		=> true,
			'pattern' 		=> '/(\040|\t|\&nbsp\;)?\,([а-яa-z0-9])/iu', 
			'replacement' 	=> ', \2'),	
		'autospace_after_pmarks' => array(
			'_disable'		=> false,
			'pattern' 		=> '/(\040|\t|\&nbsp\;)([a-zа-я0-9]+)(\040|\t|\&nbsp\;)?(\:|\)|\,|\.|\&hellip\;|(?:\!|\?)+)([а-яa-z])/iu', 
			'replacement' 	=> '\1\2\4 \5'),	
		'super_nbsp' => array(
			'_disable'		=> false,
			'pattern' 		=> '/(\s|^|\&laquo\;|\>|\(|\&mdash\;\&nbsp\;)([a-zа-я]{1,2}\s+)([a-zа-я]{1,2}\s+)?([a-zа-я0-9\-]{2,})/ieu', 
			'replacement' 	=> '"\1" . trim("\2") . "&nbsp;" . ("\3" ? trim("\3") . "&nbsp;" : "") . "\4"'),
		'many_spaces_to_one' => array(
			'_disable'		=> false,
			'pattern' 		=> '/(\040|\t)+/', 
			'replacement' 	=> ' '),
		'clear_percent' => array(
			'_disable'		=> false,
			'pattern' 		=> '/(\d+)([\t\040]+)\%/', 
			'replacement' 	=> '\1%'),
		'nbsp_before_open_quote' => array(
			'_disable'		=> false,
			'pattern' 		=> '/(^|\040|\t|>)([a-zа-я]{1,2})\040(\&laquo\;|\&bdquo\;)/u', 
			'replacement' 	=> '\1\2&nbsp;\3'),
		'nbsp_before_particle' => array(
			'_disable'		=> false,
			'pattern' 		=> '/(\040|\t)+(ли|бы|б|же|ж)(\&nbsp\;|\.|\,|\:|\;|\&hellip\;|\s)/iue', 
			'replacement' 	=> '"&nbsp;\2" . ("\3" == "&nbsp;" ? " " : "\3")'),	
		'ps_pps' => array(
			'_disable'		=> false,
			'pattern' 		=> '/(^|\040|\t|\>|\r|\n)(p\.\040?)(p\.\040?)?(s\.)/ie',
			'replacement' 	=> '"\1" . trim("\2") . "&thinsp;" . ("\3" ? trim("\3") . "&thinsp;" : "") . "\4"'),	
		);
}