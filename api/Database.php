<?php

/**
 * Класс для доступа к базе данных
 *
 * @copyright 	2011 Denis Pikusov
 * @link 		http://simplacms.ru
 * @author 		Denis Pikusov
 *
 */

require_once('Simpla.php');

class Database extends Simpla
{
	private $link;
	private $res_id;
	public $queries = array();
	public $count_queries = 0;

	/**
	 * В конструкторе подключаем базу
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->connect();
	}

	/**
	 * В деструкторе отсоединяемся от базы
	 */
	public function __destruct()
	{
		$this->disconnect();
	}

	/**
	 * Подключение к базе данных
	 */
	public function connect()
	{
		// При повторном вызове возвращаем существующий линк
		if(!empty($this->link))
			return $this->link;
		
		// Иначе пытаемся подключиться
		if(!$this->link = mysql_connect($this->config->db_server, $this->config->db_user, $this->config->db_password))
		{
			trigger_error("Could not connect to the database. Check the config file.", E_USER_WARNING);
			return false;
		}
		if(!mysql_select_db($this->config->db_name, $this->link))
		{
			trigger_error("Could not select the database.", E_USER_WARNING);
			return false;
		}
		
		// Настраиваем соединение
		if($this->config->db_charset)
			mysql_query('SET NAMES '.$this->config->db_charset, $this->link);		
		if($this->config->db_sql_mode)		
			mysql_query('SET SESSION SQL_MODE = "'.$this->config->db_sql_mode.'"', $this->link);
		if($this->config->timezone)		
			mysql_query('SET SESSION time_zone = "'.$this->config->db_timezone.'"', $this->link);			
		
		return $this->link;
	}

	/**
	 * Закрываем подключение к базе данных
	 */
	public function disconnect()
	{
		if(!@mysql_close($this->link))
			return true;
		else
			return false;
	}
	

	/**
	 * Запрос к базе. Обазятелен первый аргумент - текст запроса.
	 * При указании других аргументов автоматически выполняется placehold() для запроса с подстановкой этих аргументов
	 */
	public function query()
	{
		if($this->config->debug)
			$time_start = microtime(true);
		
		$args = func_get_args();

		$q = call_user_func_array(array($this, 'placehold'), $args);
 		if($this->link)
		{
			$this->res_id = mysql_query($q, $this->link);
		}
		else
		{
			$error_msg = "Could not execute query to database, wrong database link. [$q]";
			trigger_error($error_msg, E_USER_WARNING);
			return false;
		}
		if(!$this->res_id)
		{
			$error_msg = mysql_error($this->link).' ['.$q.']';
			trigger_error($error_msg, E_USER_WARNING);
			return false;
		}
		if($this->config->debug)
		{
			$time_end = microtime(true);
			$exec_time = round(($time_end-$time_start)*1000, 0);
			$this->queries[$this->count_queries] = new stdClass();
			$this->queries[$this->count_queries]->exec_time = $exec_time;
			$this->queries[$this->count_queries]->sql = preg_replace('/[\s]{2,}/', ' ', $q);
			$this->count_queries++;
		}
		return $this->res_id;
	}
	
	
	/**
	 * Плейсхолдер для запросов. Пример работы: $query = $db->placehold('SELECT name FROM products WHERE id=?', $id);
	 */
	public function placehold()
	{
		$args = func_get_args();	
		$tmpl = array_shift($args);
		// Заменяем все __ на префикс, но только необрамленные кавычками
		$tmpl = preg_replace('/([^"\'0-9a-z_])__([a-z_]+[^"\'])/ui', "\$1".$this->config->db_prefix."\$2", $tmpl);
		if(!empty($args))
		{
			$result = $this->sql_placeholder_ex($tmpl, $args, $error); 
			if ($result === false)
			{ 
				$error = "Placeholder substitution error. Diagnostics: \"$error\""; 
				trigger_error($error, E_USER_WARNING); 
				return false; 
			} 
			return $result;
		}
		else
			return $tmpl;
	}
	

	/**
	 * Возвращает результаты запроса. Необязательный второй аргумент указывает какую колонку возвращать вместо всего массива колонок
	 */
	public function results($field = null)
	{
		$results = array();
		if(!$this->res_id)
		{
			trigger_error(mysql_error($this->link), E_USER_WARNING); 
			return false;
		}

		if($this->num_rows() == 0)
			return array();

		while($row = mysql_fetch_object($this->res_id))
		{
			if(!empty($field) && isset($row->$field))
				array_push($results, $row->$field);				
			else
				array_push($results, $row);
		}
		return $results;
	}

	/**
	 * Возвращает первый результат запроса. Необязательный второй аргумент указывает какую колонку возвращать вместо всего массива колонок
	 */
	public function result($field = null)
	{
		$result = array();
		if(!$this->res_id)
		{
			$this->error_msg = "Could not execute query to database, wrong result id";
			return 0;
		}
		$row = mysql_fetch_object($this->res_id);
		if(!empty($field) && isset($row->$field))
			return $row->$field;
		elseif(!empty($field) && !isset($row->$field))
			return false;
		else
			return $row;
	}

	/**
	 * Возвращает последний вставленный id
	 */
	public function insert_id()
	{
		return mysql_insert_id($this->link);
	}

	/**
	 * Возвращает количество выбранных строк
	 */
	public function num_rows()
	{
		return mysql_num_rows($this->res_id);
	}

	/**
	 * Возвращает количество затронутых строк
	 */
	public function affected_rows()
	{
		return mysql_affected_rows($this->link);
	}
	
	/**
	 * Компиляция плейсхолдера
	 */
	private function sql_compile_placeholder($tmpl)
	{ 
		$compiled = array(); 
		$p = 0;	 // текущая позиция в строке 
		$i = 0;	 // счетчик placeholder-ов 
		$has_named = false; 
		while(false !== ($start = $p = strpos($tmpl, "?", $p)))
		{ 
			// Определяем тип placeholder-а. 
			switch ($c = substr($tmpl, ++$p, 1))
			{ 
				case '%': case '@': case '#': 
					$type = $c; ++$p; break; 
				default: 
					$type = ''; break; 
			} 
			// Проверяем, именованный ли это placeholder: "?keyname" 
			if (preg_match('/^((?:[^\s[:punct:]]|_)+)/', substr($tmpl, $p), $pock))
			{ 
				$key = $pock[1]; 
				if ($type != '#')
					$has_named = true; 
				$p += strlen($key); 
			}
			else
			{ 
				$key = $i; 
				if ($type != '#')
					$i++; 
			} 
			// Сохранить запись о placeholder-е. 
			$compiled[] = array($key, $type, $start, $p - $start); 
		} 
		return array($compiled, $tmpl, $has_named); 
	} 

	/**
	 * Выполнение плейсхолдера
	 */
	private function sql_placeholder_ex($tmpl, $args, &$errormsg)
	{ 
		// Запрос уже разобран?.. Если нет, разбираем. 
		if (is_array($tmpl))
			$compiled = $tmpl; 
		else
			$compiled	 = $this->sql_compile_placeholder($tmpl); 
	
		list ($compiled, $tmpl, $has_named) = $compiled; 
	
		// Если есть хотя бы один именованный placeholder, используем 
		// первый аргумент в качестве ассоциативного массива. 
		if ($has_named)
			$args = @$args[0]; 
	
		// Выполняем все замены в цикле. 
		$p	 = 0;				// текущее положение в строке 
		$out = '';			// результирующая строка 
		$error = false; // были ошибки? 
	
		foreach ($compiled as $num=>$e)
		{ 
			list ($key, $type, $start, $length) = $e; 
	
			// Pre-string. 
			$out .= substr($tmpl, $p, $start - $p); 
			$p = $start + $length; 
	
			$repl = '';		// текст для замены текущего placeholder-а 
			$errmsg = ''; // сообщение об ошибке для этого placeholder-а 
			do { 
				// Это placeholder-константа? 
				if ($type === '#')
				{ 
					$repl = @constant($key); 
					if (NULL === $repl)	 
						$error = $errmsg = "UNKNOWN_CONSTANT_$key"; 
					break; 
				} 
				// Обрабатываем ошибку. 
				if (!isset($args[$key]))
				{ 
					$error = $errmsg = "UNKNOWN_PLACEHOLDER_$key"; 
					break; 
				} 
				// Вставляем значение в соответствии с типом placeholder-а. 
				$a = $args[$key]; 
				if ($type === '')
				{ 
					// Скалярный placeholder. 
					if (is_array($a))
					{ 
						$error = $errmsg = "NOT_A_SCALAR_PLACEHOLDER_$key"; 
						break; 
					} 
					$repl = is_int($a) || is_float($a) ? str_replace(',', '.', $a) : "'".addslashes($a)."'"; 
					break; 
				} 
				// Иначе это массив или список.
				if(is_object($a))
					$a = get_object_vars($a);
				
				if (!is_array($a))
				{ 
					$error = $errmsg = "NOT_AN_ARRAY_PLACEHOLDER_$key"; 
					break; 
				} 
				if ($type === '@')
				{ 
					// Это список. 
					foreach ($a as $v)
					{
						if(is_null($v))
							$r = "NULL";
						else
							$r = "'".@addslashes($v)."'";

						$repl .= ($repl===''? "" : ",").$r; 
					}
				}
				elseif ($type === '%')
				{ 
					// Это набор пар ключ=>значение. 
					$lerror = array(); 
					foreach ($a as $k=>$v)
					{ 
						if (!is_string($k))
							$lerror[$k] = "NOT_A_STRING_KEY_{$k}_FOR_PLACEHOLDER_$key"; 
						else 
							$k = preg_replace('/[^a-zA-Z0-9_]/', '_', $k); 

						if(is_null($v))
							$r = "=NULL";
						else
							$r = "='".@addslashes($v)."'";

						$repl .= ($repl===''? "" : ", ").$k.$r; 
					} 
					// Если была ошибка, составляем сообщение. 
					if (count($lerror))
					{ 
						$repl = ''; 
						foreach ($a as $k=>$v)
						{ 
							if (isset($lerror[$k]))
							{ 
								$repl .= ($repl===''? "" : ", ").$lerror[$k]; 
							}
							else
							{ 
								$k = preg_replace('/[^a-zA-Z0-9_-]/', '_', $k); 
								$repl .= ($repl===''? "" : ", ").$k."=?"; 
							} 
						} 
						$error = $errmsg = $repl; 
					} 
				} 
			} while (false); 
			if ($errmsg) $compiled[$num]['error'] = $errmsg; 
			if (!$error) $out .= $repl; 
		} 
		$out .= substr($tmpl, $p); 
	
		// Если возникла ошибка, переделываем результирующую строку 
		// в сообщение об ошибке (расставляем диагностические строки 
		// вместо ошибочных placeholder-ов). 
		if ($error)
		{ 
			$out = ''; 
			$p	 = 0; // текущая позиция 
			foreach ($compiled as $num=>$e)
			{ 
				list ($key, $type, $start, $length) = $e; 
				$out .= substr($tmpl, $p, $start - $p); 
				$p = $start + $length; 
				if (isset($e['error']))
				{ 
					$out .= $e['error']; 
				}
				else
				{ 
					$out .= substr($tmpl, $start, $length); 
				} 
			} 
			// Последняя часть строки. 
			$out .= substr($tmpl, $p); 
			$errormsg = $out; 
			return false; 
		}
		else
		{ 
			$errormsg = false; 
			return $out; 
		} 
	} 

	public function dump($filename)
	{
		$h = fopen($filename, 'w');
		$q = $this->placehold("SHOW FULL TABLES LIKE '__%';");		
		$result = mysql_query($q, $this->link);
		while($row = mysql_fetch_row($result))
		{
			if($row[1] == 'BASE TABLE')
				$this->dump_table($row[0], $h);
		}
	    fclose($h);
	}
	
	function restore($filename)
	{
		$templine = '';
		$h = fopen($filename, 'r');
	
		// Loop through each line
		if($h)
		{
			while(!feof($h))
			{
				$line = fgets($h);
				// Only continue if it's not a comment
				if (substr($line, 0, 2) != '--' && $line != '')
				{
					// Add this line to the current segment
					$templine .= $line;
					// If it has a semicolon at the end, it's the end of the query
					if (substr(trim($line), -1, 1) == ';')
					{
						// Perform the query
						mysql_query($templine, $this->link) or print('Error performing query \'<b>' . $templine . '</b>\': ' . mysql_error() . '<br /><br />');
						// Reset temp variable to empty
						$templine = '';
					}
				}
			}
		}
		fclose($h);
	}
	
	
	private function dump_table($table, $h)
	{
		$sql = "SELECT * FROM `$table`;";
		$result = mysql_query($sql, $this->link);
		if($result)
		{
			fwrite($h, "/* Data for table $table */\n");
			fwrite($h, "TRUNCATE TABLE `$table`;\n");
			
			$num_rows = mysql_num_rows($result);
			$num_fields = mysql_num_fields($result);
	
			if($num_rows > 0)
			{
				$field_type=array();
				$field_name = array();
				$i=0;
				while( $i < $num_fields)
				{
					$meta= mysql_fetch_field($result, $i);
					array_push($field_type, $meta->type);
					array_push($field_name, $meta->name);
					$i++;
				}
				$fields = implode('`, `', $field_name);
				fwrite($h,  "INSERT INTO `$table` (`$fields`) VALUES\n");
				$index=0;
				while( $row= mysql_fetch_row($result))
				{
					fwrite($h, "(");
					for( $i=0; $i < $num_fields; $i++)
					{
						if( is_null( $row[$i]))
							fwrite($h, "null");
						else
						{
							switch( $field_type[$i])
							{
								case 'int':
									fwrite($h,  $row[$i]);
									break;
								case 'string':
								case 'blob' :
								default:
									fwrite($h, "'".mysql_real_escape_string($row[$i])."'");
	
							}
						}
						if( $i < $num_fields-1)
							fwrite($h,  ",");
					}
					fwrite($h, ")");
	
					if( $index < $num_rows-1)
						fwrite($h,  ",");
					else
						fwrite($h, ";");
					fwrite($h, "\n");
	
					$index++;
				}
			}
		}
		mysql_free_result($result);
		fwrite($h, "\n");
	}
}

