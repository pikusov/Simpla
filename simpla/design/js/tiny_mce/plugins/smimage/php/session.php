<?php

// Initialisierung
$SESSION = array();
$QUERY = array();

// Query-Zeichenkette entschlüsseln
if (isset($_GET["get"])) {
	parse_str(RC4(@pack("H*", $_GET["get"])), $QUERY);
}
else {
	include("error.php");
	die;
}

// Query-Zeichenkette auf Vollständigkeit überprüfen
if (!isset($QUERY["id"]) || !isset($QUERY["check_session_variable"])) {
	include("error.php");
	die;
}

// Verzeichnispfad überprüfen
if ($CONFIG["directory"] != "" && $CONFIG["directory"][0] != "/") { $CONFIG["directory"] = "/".$CONFIG["directory"]; }
if ($CONFIG["directory"] != "" && $CONFIG["directory"][strlen($CONFIG["directory"])-1] != "/") { $CONFIG["directory"] = $CONFIG["directory"]."/"; }

// Serverpfad überprüfen
if ($CONFIG["server"] != "" && $CONFIG["server"][strlen($CONFIG["server"])-1] == "/") { $CONFIG["server"] = substr($CONFIG["server"], 0, -1); }

// Initialisierung
$SESSION["id"] = "1";
$SESSION["back"] = "0";
$SESSION["page"] = "0";
$SESSION["dir_root"] = $CONFIG["directory"];
$SESSION["dir"] = $CONFIG["directory"];
$SESSION["server"] = $CONFIG["server"];
$SESSION["thumbnail_size"] = $CONFIG["thumbnail_size"];
$SESSION["jpg_quality"] = $CONFIG["jpg_quality"];
$SESSION["show_thumbnail"] = $CONFIG["show_thumbnail"];
$SESSION["orderby"] = $CONFIG["orderby"];
$SESSION["show_upload"] = $CONFIG["show_upload"];
$SESSION["show_image_menu"] = $CONFIG["show_image_menu"];
$SESSION["show_folder_menu"] = $CONFIG["show_folder_menu"];
$SESSION["show_newfolder"] = $CONFIG["show_newfolder"];
$SESSION["thumbnails_perpage"] = $CONFIG["thumbnails_perpage"];
$SESSION["upload_filesize"] = $CONFIG["upload_filesize"];
$SESSION["check_session_variable"] = $CONFIG["check_session_variable"];
$SESSION["document_root"] = $CONFIG["document_root"];

// Query auswerten
if (isset($QUERY["id"])) { $SESSION["id"] = $QUERY["id"]; }
if (isset($QUERY["back"])) { $SESSION["back"] = $QUERY["back"]; }
if (isset($QUERY["page"])) { $SESSION["page"] = $QUERY["page"]; }
if (isset($QUERY["dir_root"]) && $QUERY["dir_root"] != "") {
	$SESSION["dir_root"] = $QUERY["dir_root"];
	
	// Verzeichnispfad überprüfen
	if ($SESSION["dir_root"] != "" && $SESSION["dir_root"][0] != "/") { $SESSION["dir_root"] = "/".$SESSION["dir_root"]; }
	if ($SESSION["dir_root"] != "" && $SESSION["dir_root"][strlen($SESSION["dir_root"])-1] != "/") { $SESSION["dir_root"] = $SESSION["dir_root"]."/"; }
	
	$SESSION["dir"] = $SESSION["dir_root"];
}
if (isset($QUERY["dir"])) { $SESSION["dir"] = $QUERY["dir"]; }
if (isset($QUERY["server"]) && $QUERY["server"] != "") {

	// Serverpfad überprüfen
	if ($QUERY["server"] != "" && $QUERY["server"][strlen($QUERY["server"])-1] == "/") { $QUERY["server"] = substr($QUERY["server"], 0, -1); }

	$SESSION["server"] = $QUERY["server"];
}
if (isset($QUERY["thumbnail_size"]) && $QUERY["thumbnail_size"] != "") {
	$SESSION["thumbnail_size"] = $QUERY["thumbnail_size"];
}
if (isset($QUERY["jpg_quality"])  && $QUERY["jpg_quality"] != "") {
	$SESSION["jpg_quality"] = $QUERY["jpg_quality"];
}
if (isset($QUERY["show_thumbnail"])  && $QUERY["show_thumbnail"] != "") {
	$SESSION["show_thumbnail"] = $QUERY["show_thumbnail"];
}
if (isset($QUERY["orderby"])  && $QUERY["orderby"] != "") {
	$SESSION["orderby"] = $QUERY["orderby"];
}
if (isset($QUERY["show_upload"]) && $QUERY["show_upload"] != "") {
	$SESSION["show_upload"] = $QUERY["show_upload"];
}
if (isset($QUERY["show_image_menu"]) && $QUERY["show_image_menu"] != "") {
	$SESSION["show_image_menu"] = $QUERY["show_image_menu"];
}
if (isset($QUERY["show_folder_menu"]) && $QUERY["show_folder_menu"] != "") {
	$SESSION["show_folder_menu"] = $QUERY["show_folder_menu"];
}
if (isset($QUERY["show_newfolder"]) && $QUERY["show_newfolder"] != "") {
	$SESSION["show_newfolder"] = $QUERY["show_newfolder"];
}
if (isset($QUERY["thumbnails_perpage"]) && $QUERY["thumbnails_perpage"] != "") {
	$SESSION["thumbnails_perpage"] = $QUERY["thumbnails_perpage"];
}
if (isset($QUERY["upload_filesize"]) && $QUERY["upload_filesize"] != "") {
	$SESSION["upload_filesize"] = $QUERY["upload_filesize"];
}
if (isset($QUERY["check_session_variable"]) && $QUERY["check_session_variable"] != "") {
	$SESSION["check_session_variable"] = $QUERY["check_session_variable"];
}
if (isset($QUERY["document_root"]) && $QUERY["document_root"] != "") {
	$SESSION["document_root"] = $QUERY["document_root"];
}

// Session-Variable überprüfen
if ($SESSION["check_session_variable"] != "") {

	// Session Starten
	session_start();

	// Session-Variable überprüfen
	if (!isset($_SESSION[$SESSION["check_session_variable"]])) {
		include("error.php");
		die;
	}
}

// Eine Verzeichnisebene höher anzeigen
if (isset($_GET["action"]) && $_GET["action"] == "back") {
	$array = explode ("/", $SESSION["dir"]);
	
	$SESSION["dir"] = "";
	for ($i = 0; $i < count($array)-2; $i++ ) {
		$SESSION["dir"] = $SESSION["dir"].$array[$i]."/";
	}

	if ($SESSION["dir_root"] == $SESSION["dir"]) { $SESSION["back"] = 0; }
}

// Query-Zeichenkette 1
$GET = "dir_root=".$SESSION["dir_root"]
	."&dir=".$SESSION["dir"]
	."&server=".$SESSION["server"]
	."&thumbnail_size=".$SESSION["thumbnail_size"]
	."&show_thumbnail=".$SESSION["show_thumbnail"]
	."&jpg_quality=".$SESSION["jpg_quality"]
	."&back=".$SESSION["back"]
	."&orderby=".$SESSION["orderby"]
	."&show_upload=".$SESSION["show_upload"]
	."&show_image_menu=".$SESSION["show_image_menu"]
	."&show_folder_menu=".$SESSION["show_folder_menu"]
	."&show_newfolder=".$SESSION["show_newfolder"]
	."&thumbnails_perpage=".$SESSION["thumbnails_perpage"]
	."&upload_filesize=".$SESSION["upload_filesize"]
	."&check_session_variable=".$SESSION["check_session_variable"]
	."&document_root=".$SESSION["document_root"];

// Query-Zeichenkette 2
$GET2 = "dir_root=".$SESSION["dir_root"]
	."&server=".$SESSION["server"]
	."&thumbnail_size=".$SESSION["thumbnail_size"]
	."&show_thumbnail=".$SESSION["show_thumbnail"]
	."&jpg_quality=".$SESSION["jpg_quality"]
	."&orderby=".$SESSION["orderby"]
	."&show_upload=".$SESSION["show_upload"]
	."&show_image_menu=".$SESSION["show_image_menu"]
	."&show_folder_menu=".$SESSION["show_folder_menu"]
	."&show_newfolder=".$SESSION["show_newfolder"]
	."&thumbnails_perpage=".$SESSION["thumbnails_perpage"]
	."&upload_filesize=".$SESSION["upload_filesize"]
	."&check_session_variable=".$SESSION["check_session_variable"]
	."&document_root=".$SESSION["document_root"];

// Query-Zeichenkette 3
$GET3 = "dir_root=".$SESSION["dir_root"]
	."&dir=".$SESSION["dir"]
	."&server=".$SESSION["server"]
	."&thumbnail_size=".$SESSION["thumbnail_size"]
	."&show_thumbnail=".$SESSION["show_thumbnail"]
	."&jpg_quality=".$SESSION["jpg_quality"]
	."&back=".$SESSION["back"]
	."&show_upload=".$SESSION["show_upload"]
	."&show_image_menu=".$SESSION["show_image_menu"]
	."&show_folder_menu=".$SESSION["show_folder_menu"]
	."&show_newfolder=".$SESSION["show_newfolder"]
	."&thumbnails_perpage=".$SESSION["thumbnails_perpage"]
	."&upload_filesize=".$SESSION["upload_filesize"]
	."&check_session_variable=".$SESSION["check_session_variable"]
	."&document_root=".$SESSION["document_root"];

?>