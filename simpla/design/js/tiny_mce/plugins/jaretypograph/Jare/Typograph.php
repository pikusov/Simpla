<?php
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
class Jare_Typograph
{
	/**
	 * Перечень названий тофов, идущих с дистрибутивом
	 *
	 * @var array
	 */
	protected $_baseTof = array('quote', 'dash', 'punctmark', 'number', 'space', 'etc');
	
	/**
	 * Массив из тофов, где каждой паре-ключ соответствует название тофа
	 * и его объект
	 *
	 * @var array
	 */
	protected $_tof = array();
	
	/**
	 * Конструктор
	 *
	 * @param 	string $text строка для типографирования
	 * @return 	void
	 */
	public function __construct($text)
	{
		$this->_text = $text;
		$this->_text = trim($this->_text);
	}
	
	/**
	 * Метод для быстрого типографирования текста, при котором не нужно
	 * делать настройки тофов, их базовых параметров и т.п.
	 *
	 * @param 	string $text строка для типографирования
	 * @return 	string
	 */
	public static function quickParse($text)
	{
		$typograph = new self($text);
		return $typograph->parse($typograph->getBaseTofsNames());
	}
	
	/**
	 * Возвращает массив из названий тофов, которые идут вместе с дистрибутивом
	 *
	 * @return 	array
	 */
	public function getBaseTofsNames()
	{
		return $this->_baseTof;
	}
	
	/**
	 * Добавление тофа в очередь на обработку текста
	 *
	 * @param 	string $name название тофа
	 * @param 	Jare_Typograph_Tof $object экземляр класса, унаследованного от 'Jare_Typograph_Tof'
	 * @throws  Jare_Typograph_Exception
	 * @return 	void
	 */
	public function setTof($name, $object)
	{
		$name = strtolower($name);
		
		if (!$object instanceof Jare_Typograph_Tof) {
			require_once 'Pride/Typograph/Exception.php';
    		throw new Pride_Typograph_Exception("Tof '$name' class must be extend Jare_Typograph_Tof");
		}
		
		$this->_tof[$name] = $object;
		$this->_tof[$name]->setStringToParse(&$this->_text);
	}
	
	/**
	 * Получение объекта тофа
	 * 
	 * Если тоф не был раннее добавлен и при этом он является базовым, экземляр его класса
	 * будет создан автоматически
	 *
	 * @param 	string $name
	 * @throws 	Jare_Typograph_Exception
	 * @return 	Jare_Typograph_Tof
	 */
	public function getTof($name)
	{
		$name = strtolower($name);
		
		if (!isset($this->_tof[$name])) {
			if (!in_array($name, $this->_baseTof)) {
				require_once 'Jare/Typograph/Exception.php';
				throw new Jare_Typograph_Exception('Incorrect name of tof');
			}
			
			$fileName = 'Jare/Typograph/Tof/' . ucfirst($name) . '.php';
			$className = 'Jare_Typograph_Tof_' . ucfirst($name);
			
			require_once $fileName;
			
			if (!class_exists($className, false)) {
    			require_once 'Jare/Typograph/Exception.php';
    			throw new Jare_Typograph_Exception('Class not exists');
    		}
    		
    		$this->setTof($name, new $className);
		}
		
		return $this->_tof[$name];
	}
	
	/**
	 * Типографирование текста
	 *
	 * @param 	mixed $tofs строка или массив из названий тофов, которые будут применены при типографирование текста
	 * @throws 	Jare_Typograph_Exception
	 * @return 	string
	 */
	public function parse($tofs)
	{
		if (is_string($tofs)) {
			$tofs = array($tofs);
		}
		
		if (!is_array($tofs)) {
			require_once 'Jare/Typograph/Exception.php';
    			throw new Jare_Typograph_Exception('Incorrect type of tof-variable - try set array or string');
		}

		if (!count($tofs)) {
			require_once 'Jare/Typograph/Exception.php';
    			throw new Jare_Typograph_Exception('You must set 1 or more tofs; your array is empty!');
		}
		
		require_once 'Jare/Typograph/Tool.php';
		Jare_Typograph_Tool::addCustomBlocks('<pre>', '</pre>');
		Jare_Typograph_Tool::addCustomBlocks('<script>', '</script>');
		Jare_Typograph_Tool::addCustomBlocks('<style>', '</style>');
		
		$this->_text = Jare_Typograph_Tool::safeCustomBlocks($this->_text, true);
		$this->_text = Jare_Typograph_Tool::safeTagChars($this->_text, true);
		$this->_text = Jare_Typograph_Tool::clearSpecialChars($this->_text, Jare_Typograph_Tool::CLEAR_MODE_UTF8_NATIVE | Jare_Typograph_Tool::CLEAR_MODE_HTML_MATTER);
		
		foreach ($tofs as $tofName) {
			$this->getTof($tofName)->parse();
		}
		
		$this->_text = Jare_Typograph_Tool::safeTagChars($this->_text, false);
		$this->_text = Jare_Typograph_Tool::safeCustomBlocks($this->_text, false);
		
		return $this->_text;
	}
}