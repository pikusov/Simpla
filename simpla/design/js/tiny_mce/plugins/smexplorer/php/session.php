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
$SESSION["dir_root"] = $CONFIG["directory"];
$SESSION["dir"] = $CONFIG["directory"];
$SESSION["server"] = $CONFIG["server"];
$SESSION["show_upload"] = $CONFIG["show_upload"];
$SESSION["orderby"] = $CONFIG["orderby"];
$SESSION["show_folder_menu"] = $CONFIG["show_folder_menu"];
$SESSION["show_file_menu"] = $CONFIG["show_file_menu"];
$SESSION["link_target"] = $CONFIG["link_target"];
$SESSION["hidden_folder"] = $CONFIG["hidden_folder"];
$SESSION["hidden_subfolder"] = $CONFIG["hidden_subfolder"];
$SESSION["hidden_filetype"] = $CONFIG["hidden_filetype"];
$SESSION["show_chmod"] = $CONFIG["show_chmod"];
$SESSION["upload_filetype"] = $CONFIG["upload_filetype"];
$SESSION["upload_filesize"] = $CONFIG["upload_filesize"];
$SESSION["check_session_variable"] = $CONFIG["check_session_variable"];
$SESSION["document_root"] = $CONFIG["document_root"];
$SESSION["treemenu"] = "0";

// Query auswerten
if (isset($QUERY["id"])) { $SESSION["id"] = $QUERY["id"]; }
if (isset($QUERY["dir_root"]) && $QUERY["dir_root"] != "") {
	$SESSION["dir_root"] = $QUERY["dir_root"];

	// Verzeichnispfad überprüfen
	$a = explode(",", $SESSION["dir_root"]);
	for ($i = 0; $i < count($a); $i++) {
		if ($a[$i][0] != "/") { $a[$i] = "/".$a[$i]; }
		if ($a[$i] != "" && $a[$i][strlen($a[$i])-1] != "/") { $a[$i] = $a[$i]."/"; }
	}
	$SESSION["dir_root"] = implode(",", $a);

	$SESSION["dir"] = $a[0];
}
if (isset($QUERY["dir"])) { $SESSION["dir"] = $QUERY["dir"]; }
if (isset($QUERY["server"]) && $QUERY["server"] != "") {

	// Serverpfad überprüfen
	if ($QUERY["server"] != "" && $QUERY["server"][strlen($QUERY["server"])-1] == "/") { $QUERY["server"] = substr($QUERY["server"], 0, -1); }

	$SESSION["server"] = $QUERY["server"];
}
if (isset($QUERY["show_upload"]) && $QUERY["show_upload"] != "") {
	$SESSION["show_upload"] = $QUERY["show_upload"];
}
if (isset($QUERY["orderby"]) && $QUERY["orderby"] != "") {
	$SESSION["orderby"] = $QUERY["orderby"];
}
if (isset($QUERY["show_folder_menu"]) && $QUERY["show_folder_menu"] != "") {
	$SESSION["show_folder_menu"] = $QUERY["show_folder_menu"];
}
if (isset($QUERY["show_file_menu"]) && $QUERY["show_file_menu"] != "") {
	$SESSION["show_file_menu"] = $QUERY["show_file_menu"];
}
if (isset($QUERY["link_target"]) && $QUERY["link_target"] != "") {
	$SESSION["link_target"] = $QUERY["link_target"];
}
if (isset($QUERY["hidden_folder"]) && $QUERY["hidden_folder"] != "") {
	$SESSION["hidden_folder"] = $QUERY["hidden_folder"];
}
if (isset($QUERY["hidden_subfolder"]) && $QUERY["hidden_subfolder"] != "") {
	$SESSION["hidden_subfolder"] = $QUERY["hidden_subfolder"]; 
}
if (isset($QUERY["hidden_filetype"]) && $QUERY["hidden_filetype"] != "") {
	$SESSION["hidden_filetype"] = $QUERY["hidden_filetype"];

	// Dateityp überprüfen
	if ($SESSION["hidden_filetype"] == "") { $SESSION["hidden_filetype"] = "."; }
}
if (isset($QUERY["show_chmod"]) && $QUERY["show_chmod"] != "") {
	$SESSION["show_chmod"] = $QUERY["show_chmod"];
}
if (isset($QUERY["upload_filetype"]) && $QUERY["upload_filetype"] != "") {
	$SESSION["upload_filetype"] = $QUERY["upload_filetype"];
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
if (isset($QUERY["treemenu"]) && $QUERY["treemenu"] != "") {
	$SESSION["treemenu"] = $QUERY["treemenu"];
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

// Query-Zeichenkette 1
$GET = "dir_root=".$SESSION["dir_root"]
	."&dir=".$SESSION["dir"]
	."&server=".$SESSION["server"]
	."&show_upload=".$SESSION["show_upload"]
	."&orderby=".$SESSION["orderby"]
	."&show_folder_menu=".$SESSION["show_folder_menu"]
	."&show_file_menu=".$SESSION["show_file_menu"]
	."&link_target=".$SESSION["link_target"]
	."&hidden_folder=".$SESSION["hidden_folder"]
	."&hidden_subfolder=".$SESSION["hidden_subfolder"]
	."&hidden_filetype=".$SESSION["hidden_filetype"]
	."&show_chmod=".$SESSION["show_chmod"]
	."&upload_filetype=".$SESSION["upload_filetype"]
	."&upload_filesize=".$SESSION["upload_filesize"]
	."&check_session_variable=".$SESSION["check_session_variable"]
	."&document_root=".$SESSION["document_root"]
	."&treemenu=".$SESSION["treemenu"];

// Query-Zeichenkette 2
$GET2 = "dir_root=".$SESSION["dir_root"]
	."&server=".$SESSION["server"]
	."&show_upload=".$SESSION["show_upload"]
	."&orderby=".$SESSION["orderby"]
	."&show_folder_menu=".$SESSION["show_folder_menu"]
	."&show_file_menu=".$SESSION["show_file_menu"]
	."&link_target=".$SESSION["link_target"]
	."&hidden_folder=".$SESSION["hidden_folder"]
	."&hidden_subfolder=".$SESSION["hidden_subfolder"]
	."&hidden_filetype=".$SESSION["hidden_filetype"]
	."&show_chmod=".$SESSION["show_chmod"]
	."&upload_filetype=".$SESSION["upload_filetype"]
	."&upload_filesize=".$SESSION["upload_filesize"]
	."&check_session_variable=".$SESSION["check_session_variable"]
	."&document_root=".$SESSION["document_root"];

// Query-Zeichenkette 3
$GET3 = "dir_root=".$SESSION["dir_root"]
	."&dir=".$SESSION["dir"]
	."&server=".$SESSION["server"]
	."&show_upload=".$SESSION["show_upload"]
	."&show_folder_menu=".$SESSION["show_folder_menu"]
	."&show_file_menu=".$SESSION["show_file_menu"]
	."&link_target=".$SESSION["link_target"]
	."&hidden_folder=".$SESSION["hidden_folder"]
	."&hidden_subfolder=".$SESSION["hidden_subfolder"]
	."&hidden_filetype=".$SESSION["hidden_filetype"]
	."&show_chmod=".$SESSION["show_chmod"]
	."&upload_filetype=".$SESSION["upload_filetype"]
	."&upload_filesize=".$SESSION["upload_filesize"]
	."&check_session_variable=".$SESSION["check_session_variable"]
	."&document_root=".$SESSION["document_root"]
	."&treemenu=".$SESSION["treemenu"];

?>