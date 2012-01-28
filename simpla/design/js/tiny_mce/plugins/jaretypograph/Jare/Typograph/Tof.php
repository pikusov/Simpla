<?php
/**
 * Класс-обертка для работы с параметрами тофа
 * 
 * @see Jare_Typograph_Param
 */
require_once 'Jare/Typograph/Param.php';

/**
 * Jare_Typograph
 *
 * @copyright  	Copyright (c) 2009 E.Muravjev Studio (http://emuravjev.ru)
 * @license    	http://emuravjev.ru/works/tg/eula/
 * @version 	2.0.0
 * @author 		Arthur Rusakov <arthur@emuravjev.ru>
 * @category    Jare
 * @package 	Jare_Typograph
 */
abstract class Jare_Typograph_Tof
{
	/**
	 * Отключение обработки текста тофом
	 *
	 * @var bool
	 */
	protected $_disableParsing = false;
	
	/**
	 * Текст для типографирования
	 *
	 * @var string
	 */
	protected $_text = '';
	
	/**
	 * Базовые параметры тофа
	 *
	 * @var array
	 */
	protected $_baseParam = array();
	
	/**
	 * Установка базового параметра
	 *
	 * @param 	string $name
	 * @param 	Jare_Typograph_Param $param
	 * @return 	Jare_Typograph_Tof
	 */
	public function setBaseParam($name, Jare_Typograph_Param $param)
	{
		$this->_baseParam[$name] = $param->getOptions();
		return $this;
	}
	
	/**
	 * Получение экземпляра класса базового параметра
	 *
	 * @param 	string $name
	 * @throws 	Jare_Typograph_Exception
	 * @return 	Jare_Typograph_Param
	 */
	public function getBaseParam($name)
	{
		if(!isset($this->_baseParam[$name])) {
			require_once 'Jare/Typograph/Exception.php';
			throw new Jare_Typograph_Exception("Incorrect base parameter name");
		}
		
		$param = new Jare_Typograph_Param($this->_baseParam[$name]);
		return $param;
	}
	
	/**
	 * Установка текста для типографирования
	 *
	 * @param 	string $text
	 * @return 	void
	 */
	public function setStringToParse($text)
	{
		$this->_text = &$text;
	}
	
	/**
	 * Отключение типографирования текста данным тофом
	 *
	 * @param 	bool $status
	 * @return 	Jare_Typograph_Tof
	 */
	public function disableParsing($status)
	{
		$this->_disableParsing = (bool) $status;
		return $this;
	}
	
	/**
	 * Возврат статуса для типографирования данным тофом
	 *
	 * @return 	bool
	 */
	public function isDisabledParsing()
	{
		return $this->_disableParsing;
	}
	
	/**
	 * Отключение базовых параметров тофа
	 *
	 * @param 	mixed $name массив или строка из названий параметров, которые необходимо отключить
	 * @return 	Jare_Typograph_Tof
	 */
	public function disableBaseParam($name)
	{
		if (!is_array($this->_baseParam) || !count($this->_baseParam)) {
			require_once 'Jare/Typograph/Exception.php';
			throw new Jare_Typograph_Exception("This tof dosn't have base parameters");
		}
		
		if (is_string($name)) {
			$name = array($name);
		}
		
		if (!is_array($name)) {
			require_once 'Jare/Typograph/Exception.php';
			throw new Jare_Typograph_Exception("Incorrect var type");
		}

		foreach ($name as $accessKey) {
			if (!isset($this->_baseParam[$accessKey])) {
				require_once 'Jare/Typograph/Exception.php';
				throw new Jare_Typograph_Exception("Incorrect name of base param - '$accessKey'");
			} else {
				$this->_baseParam[$accessKey][Jare_Typograph_Param::KEY_DISABLE_USER] = true;
			}
		}
		
		return $this;
	}
	
	/**
	 * Стандартное типографирование текста тофом
	 *
	 * @throws 	Jare_Typograph_Exception
	 * @return 	string
	 */
	public function parse()
	{
		$this->_preParse();
		
		if (true === $this->_disableParsing) {
			return $this->_text;
		}
		
		if (is_array($this->_baseParam) || count($this->_baseParam)) {
			foreach ($this->_baseParam as $accessKey => $param) {
				$ignoreParsing = null;
				
				// Типографирование параметром отключено или включено пользователем
				if (isset($param[Jare_Typograph_Param::KEY_DISABLE_USER])) {
					$ignoreParsing = (bool) $param[Jare_Typograph_Param::KEY_DISABLE_USER];
				}
				
				if (null === $ignoreParsing) {
					// Параметр отключен по умолчанию...
					if (isset($param[Jare_Typograph_Param::KEY_DISABLE_DEFAULT])) {
						$ignoreParsing = $param[Jare_Typograph_Param::KEY_DISABLE_DEFAULT];
					}
				}
				
				if ($ignoreParsing) {
					continue;
				}
				
				// Ссылка на метод класса с правилами типографирования
				if (!empty($param[Jare_Typograph_Param::KEY_FUNCTION_LINK])) {
					$methodName = $param[Jare_Typograph_Param::KEY_FUNCTION_LINK];
					
					if (method_exists($this, $methodName)) {
						$this->$methodName();
						continue;
					} else {
						require_once 'Jare/Typograph/Exception.php';
						throw new Jare_Typograph_Exception("Incorrect method name - '$methodName'");
					}
				}
				
				// Классическое типографирование регулярными выражениями
				$this->_text = preg_replace($param[Jare_Typograph_Param::KEY_PARSE_PATTERN], $param[Jare_Typograph_Param::KEY_PARSE_REPLACE], $this->_text);
			}
		}
		
		$this->_postParse();
		
		return $this->_text;
	}
	
	/**
	 * Метод, который вызывается перед стандартным типографированием текста тофом
	 *
	 * @return 	void
	 */
	protected function _preParse()
	{
	}
	
	/**
	 * Метод, который вызывается после стандартным типографированием текста тофом
	 *
	 * @return 	void
	 */
	protected function _postParse()
	{
	}
	
	/**
	 * Создание защищенного тега с содержимым
	 *
	 * @see 	Jare_Typograph_Tool::buildSafeTag
	 * @param 	string $content
	 * @param 	string $tag
	 * @param 	array $attribute
	 * @return 	string
	 */
	protected function _buildTag($content, $tag = 'span', $attribute = array())
	{
		require_once 'Jare/Typograph/Tool.php';
		$html = Jare_Typograph_Tool::buildSafedTag($content, $tag, $attribute);
		
		return $html;
	}
}