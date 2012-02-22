<?php

// Löschen
if (isset($_GET["action"]) && $_GET["action"] == "delete") {

	// Datei löschen
	if (isset($_GET["file"])) { @unlink($IMAGE_PATH.$_GET["file"]); }

	// Verzeichnis löschen
	else if (isset($_GET["folder"])) { DeleteFolder($IMAGE_PATH.$_GET["folder"]); }
}

// Umbenennen
else if (isset($_GET["action"]) && $_GET["action"] == "rename") {

	// Datei umbenennen
	if (isset($_GET["file"])) {

		// Dateinamen formatieren
		$_GET["name"] = FormatFileName($_GET["name"]); 

		// Umbenennen
		@rename($IMAGE_PATH.$_GET["file"], $IMAGE_PATH.$_GET["name"]);
	}

	// Verzeichnis umbenennen
	else if (isset($_GET["folder"])) {

		// Verzeichnisnamen formatieren
		$_GET["name"] = FormatFolderName($_GET["name"]);

		// Umbenennen
		@rename($IMAGE_PATH.$_GET["folder"], $IMAGE_PATH.$_GET["name"]);
	}
}

// Bild drehen
else if (isset($_GET["action"]) && $_GET["action"] == "rotate") { Image_Rotate($IMAGE_PATH.$_GET["file"], $_GET["degrees"], $SESSION["jpg_quality"]); }

// Neues Verzeichnis erstellen
else if (isset($_GET["action"]) && $_GET["action"] == "newfolder") {

	// Verzeichnisnamen formatieren
	$_GET["name"] = FormatFolderName($_GET["name"]);

	// Verzeichnis erstellen
	@mkdir($IMAGE_PATH.$_GET["name"], $CONFIG["chmod_folder"]);
}

?>