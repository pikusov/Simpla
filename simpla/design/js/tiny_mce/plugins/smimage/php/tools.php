<?php

include("config.php");

// Server Root-Pfad zurückgeben
function GetDocumentRoot() {
	global $SESSION;

	if ($SESSION["document_root"] != "") {
		$s = $SESSION["document_root"];
		if ($s[strlen($s)-1] == "/") { $s = substr($s, 0, -1); }
		return $s;
	}

	if (isset($_SERVER["DOCUMENT_ROOT"])) { return $_SERVER["DOCUMENT_ROOT"]; }
	else if (isset($_SERVER["APPL_PHYSICAL_PATH"])) {
		$s = $_SERVER["APPL_PHYSICAL_PATH"];
		$s = str_replace('\\', '/', $_SERVER["APPL_PHYSICAL_PATH"]);
		if ($s[strlen($s)-1] == "/") { $s = substr($s, 0, -1); }
		return $s;
	}
}

// Datei-Erweiterung zurückgeben
function GetFileExt($file) {
	$pfad_info = @pathinfo($file);
	return $pfad_info['extension'];
}

// Datei-Erweiterung prüfen
function IsFileExt($file, $ext) {
	if (GetFileExt(strtolower($file)) == strtolower($ext)) { return true; }
	else { return false; }
}

// Verzeichnis lesen und alle Dateien ermitteln
function GetFiles($dir, $orderby) {
	$files = array();

	if ($dh = @opendir($dir)) {
		while($file = readdir($dh)) {
			if (!preg_match("/^\.+$/", $file)) {
				if (is_file($dir.$file) && (IsFileExt($file, "jpg") || IsFileExt($file, "jpeg") || IsFileExt($file, "gif") || IsFileExt($file, "png"))) {
					$files[0][] = $file;
					$files[1][] = filemtime($dir.$file);
					$files[2][] = filesize($dir.$file);
					$files[3][] = Image_GetWidth($dir.$file);
				}
			}
		}
		closedir($dh);
	}

	switch ($orderby) {
		case "0":
			@array_multisort($files[1], SORT_NUMERIC, SORT_DESC, $files[0], SORT_STRING, SORT_DESC);
			break;
		case "1":
			@array_multisort($files[0], SORT_STRING, SORT_ASC);
			break;
		case "2":
			@array_multisort($files[0], SORT_STRING, SORT_DESC);
			break;
		case "3":
			@array_multisort($files[2], SORT_NUMERIC, SORT_ASC, $files[0], SORT_STRING, SORT_DESC);
			break;
		case "4":
			@array_multisort($files[2], SORT_NUMERIC, SORT_DESC, $files[0], SORT_STRING, SORT_DESC);
			break;
		case "5":
			@array_multisort($files[3], SORT_NUMERIC, SORT_ASC, $files[0], SORT_STRING, SORT_DESC);
			break;
		case "6":
			@array_multisort($files[3], SORT_NUMERIC, SORT_DESC, $files[0], SORT_STRING, SORT_DESC);
			break;
		case "7":
			@array_multisort($files[1], SORT_NUMERIC, SORT_ASC, $files[0], SORT_STRING, SORT_DESC);
			break;
		case "8":
			@array_multisort($files[1], SORT_NUMERIC, SORT_DESC, $files[0], SORT_STRING, SORT_DESC);
			break;
	}

	// Server-Cache löschen
	clearstatcache();

	// Datei-Array zurückgeben
	return $files[0];
}

// Verzeichnis lesen und alle Ordner ermitteln
function GetFolders($dir) {
	$folders = array();

	if ($dh = @opendir($dir)) {
		while($file = readdir($dh)) {
			if (!preg_match("/^\.+$/", $file)) {
				if (is_dir($dir.$file)) { $folders[] = $file; }
			}
		}
		closedir($dh);
	}

	@sort($folders, SORT_STRING);

	// Server-Cache löschen
	clearstatcache();

	// Ordner-Array zurückgeben
	return $folders;
}

// Verzeichnis rekursiv löschen
// Rückgabewerte:
//  0 - O.K.
// -1 - Kein Verzeichnis
// -2 - Fehler beim Löschen
// -3 - Ein Eintrag eines Verzeichnisses war keine Datei und kein Verzeichnis und kein Link
function DeleteFolder($path) {

	// Auf Verzeichnis testen
	if (!is_dir($path)) { return -1; }

	// Verzeichnis öffnen
	$dir = @opendir($path);

	// Fehler?
	if (!$dir) { return -2; }

	while (($entry = @readdir($dir)) != false) {

		if ($entry == '.' || $entry == '..') continue;

		if (is_dir($path.'/'.$entry)) {
			$res = DeleteFolder($path.'/'.$entry);

			// Fehler ?
			if ($res == -1) {
				@closedir($dir);
				return -2;
			}
			else if ($res == -2) {
				@closedir($dir);
				return -2;
			}
			else if ($res == -3) {
				@closedir($dir);
				return -3;
			}
			else if ($res != 0) {
				@closedir($dir);
				return -2;
			}
		}
		else if (is_file($path.'/'.$entry) || is_link($path.'/'.$entry)) {

			// Datei löschen
			$res = @unlink($path.'/'.$entry);

			// Fehler?
			if (!$res) {
				@closedir($dir);
				return -2;
			}
		}
		else {
			@closedir($dir);
			return -3;
		}
	}

	// Verzeichnis schliessen
	@closedir($dir);

	// Verzeichnis löschen
	$res = @rmdir($path);

	// Fehler?
	if (!$res) { return -2; }

	return 0;
}

// Datumsformat zurückgeben
function GetDateFormat() {
	$lang = $_SERVER["HTTP_ACCEPT_LANGUAGE"];
	$curlang = substr($lang, 0, 2);

	if (isset($lang)) {
		if ($curlang == "en") { return "Y-m-d"; }
		elseif ($curlang == "de" || $curlang == "nl") { return "d.m.Y"; }
		else { return "Y-m-d"; }
	}

	else { return "Y-m-d"; }
}

// Dateinamen richtig formatieren und zurückgeben
function FormatFileName($name) {

	// Leerzeichen entfernen
	$name = ltrim($name);
	$name = rtrim($name);

	// Umlaute ersetzen
	$name = str_replace(array('ä','ö','ü','ß','Ä','Ö','Ü'), array('ae','oe','ue','ss','Ae','Oe','Ue'), $name); 
	
	// Zeichen ersetzen
	$name = str_replace(" ", "_", $name);
	$name = preg_replace('/[^a-z0-9_\.\-]/i', '', $name);

	return $name;
}

// Verzeichnisnamen richtig formatieren und zurückgeben
function FormatFolderName($name) {

	// Leerzeichen entfernen
	$name = ltrim($name);
	$name = rtrim($name);

	// Umlaute ersetzen
	$name = str_replace(array('ä','ö','ü','ß','Ä','Ö','Ü'), array('ae','oe','ue','ss','Ae','Oe','Ue'), $name); 
	
	// Zeichen ersetzen
	$name = str_replace(" ", "_", $name);
	$name = preg_replace('/[^a-z0-9_\-]/i', '', $name);

	return $name;
}

// Aktuellen Verzeichnispfad zurückgeben
function GetCurrentPath($dir_root, $dir) {
	$a = explode ('/', $dir_root);
	$s = $a[count($a)-2];
	unset($a);
	echo "/".$s."/".@str_replace($dir_root,"" , $dir);
}

// RC4 Verschlüsselung
function RC4($data) {
	$s = array();
	$key = 'f62Z4Dpv7RpBCY3MJcrOcV7nwySM7k7XijkFeCFMVnTdaa9RyXcLZl81CxkK2TGgZnWbXGvQ6nyOs2lSLJIH2ahxf0FDSgQbykByzpSL62EKluUzfWmHarf4qPYUtNUi';
	
	for ($i = 0; $i < 256; $i++) { $s[$i] = $i; }

	$j = 0;
	$x;

	for ($i = 0; $i < 256; $i++) {
		$j = ($j + $s[$i] + ord($key[$i % strlen($key)])) % 256;
		$x = $s[$i];
		$s[$i] = $s[$j];
		$s[$j] = $x;
	}
	
	$i = 0;
	$j = 0;
	$ct = '';
	$y;
	
	for ($y = 0; $y < strlen($data); $y++) {
		$i = ($i + 1) % 256;
		$j = ($j + $s[$i]) % 256;
		$x = $s[$i];
		$s[$i] = $s[$j];
		$s[$j] = $x;
		$ct .= $data[$y] ^ chr($s[($s[$i] + $s[$j]) % 256]);
	}
	
	return $ct;
}

// PHP-Version zurückgeben
function GetPHPVersion_Major() {
	$v = phpversion();
	$version = Array();

	foreach(explode('.', $v) as $bit) {
		if(is_numeric($bit)) { $version[] = $bit; }
	}

	return $version[0];
}

// PHP-Ini "safe_mode" zurückgeben
function GetPHPIni_SafeMode() {
	if(ini_get('safe_mode')) { return(true); } else { return(false); }
}

?>