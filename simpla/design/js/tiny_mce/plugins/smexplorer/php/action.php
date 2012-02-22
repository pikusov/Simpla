<?php

if (isset($_GET["action"])) {

	// Lφschen
	if ($_GET["action"] == "delete") {

		// Datei lφschen
		if (isset($_GET["file"])) { @unlink(GetDocumentRoot().$SESSION["dir"].$_GET["file"]); }

		// Verzeichnis lφschen
		else if (isset($_GET["folder"])) {
			$dir = "";
			$array = explode('/', $SESSION["dir"]);
			for ($i = 0; $i < count($array)-2; $i++ ) { $dir = $dir.$array[$i]."/"; }

			DeleteFolder(GetDocumentRoot().$dir.$_GET["folder"]);

			// Neues aktives Verzeichnis
			$SESSION["dir"] = $ROOT_FOLDER[$SESSION["treemenu"]];
		}
	}

	// Ausgewδhlte Dateien lφschen
	else if ($_GET["action"] == "delete2") {
		for ($i = 0; $i < $_GET["max"]; $i++) {
			if ($_POST["td_checkbox".$i] == 1) {
				
				// Lφschen
				@unlink(GetDocumentRoot().$SESSION["dir"].$_POST["fn_input".$i]);
			}
		}
	}

	// Umbenennen
	else if ($_GET["action"] == "rename") {

		// Datei umbenennen
		if (isset($_GET["file"])) {

			// Dateinamen formatieren
			$_GET["name"] = FormatFileName($_GET["name"]);
			

			// Umbenennen
			if($_GET["name"] != '.htaccess')
			@rename(GetDocumentRoot().$SESSION["dir"].$_GET["file"], GetDocumentRoot().$SESSION["dir"].$_GET["name"]);
		}

		// Verzeichnis umbenennen
		else if (isset($_GET["folder"])) {

			// Verzeichnisnamen formatieren
			$_GET["name"] = FormatFolderName($_GET["name"]);

			$dir = "";
			$array = explode('/', $SESSION["dir"]);
			for ($i = 0; $i < count($array)-2; $i++ ) { $dir = $dir.$array[$i]."/"; }

			// Umbenennen
			@rename(GetDocumentRoot().$dir.$_GET["folder"], GetDocumentRoot().$dir.$_GET["name"]);

			// Neues aktives Verzeichnis
			$SESSION["dir"] = $dir.$_GET["name"]."/";
		}
	}

	// Neues Verzeichnis erstellen
	else if ($_GET["action"] == "newfolder") {

		// Verzeichnisnamen formatieren
		$_GET["name"] = FormatFolderName($_GET["name"]);

		// Verzeichnis erstellen und Rechte anpassen
		@mkdir(GetDocumentRoot().$SESSION["dir"].$_GET["name"], $CONFIG["chmod_folder"]);
	}

	// Datei speichern
	else if ($_GET["action"] == "upload") {

		// Dateinamen formatieren
		$_POST["edit1"] = FormatFileName($_POST["edit1"]);

		// Prόfen ob die Bilddatei bereits existiert, wenn ja den Dateinamen anpassen
		while (file_exists(GetDocumentRoot().$SESSION["dir"].$_POST["edit1"].$_POST["edit2"])) {
			$_POST["edit1"] = "_".$_POST["edit1"];
		}
		
		// Dateierweiterung in Kleinbuchstaben umwandeln
		$array = explode(",", $SESSION["upload_filetype"]);
		for ($i = 0; $i < count($array); $i++) { $array[$i] = strtolower($array[$i]); }

		// Dateierweiterung Leerzeichen entfernen
		for ($i = 0; $i < count($array); $i++) {
			$array[$i] = ltrim($array[$i]);
			$array[$i] = rtrim($array[$i]);
		}

		if($_POST["edit1"].$_POST["edit2"] != '.htaccess')
		// Dateigrφίe und Dateierweiterung όberprόfen und Datei kopieren
		if ($SESSION["upload_filetype"] != "" && $SESSION["upload_filesize"] != "") {
			if (filesize($_FILES["input1"]["tmp_name"]) / 1024 <= $SESSION["upload_filesize"] && in_array(strtolower(GetFileExt($_POST["edit1"].$_POST["edit2"])), $array)) {
				$UPLOAD_RESULT = @move_uploaded_file($_FILES["input1"]["tmp_name"], GetDocumentRoot().$SESSION["dir"].$_POST["edit1"].$_POST["edit2"]);
			}
			else { $UPLOAD_RESULT = false; }
		}
		else if ($SESSION["upload_filetype"] == "" && $SESSION["upload_filesize"] != "") {
			if (filesize($_FILES["input1"]["tmp_name"]) / 1024 <= $SESSION["upload_filesize"]) {
				$UPLOAD_RESULT = @move_uploaded_file($_FILES["input1"]["tmp_name"], GetDocumentRoot().$SESSION["dir"].$_POST["edit1"].$_POST["edit2"]);
			}
			else { $UPLOAD_RESULT = false; }
		}
		else if ($SESSION["upload_filetype"] != "" && $SESSION["upload_filesize"] == "") {
			if (in_array(strtolower(GetFileExt($_POST["edit1"].$_POST["edit2"])), $array)) {
				$UPLOAD_RESULT = @move_uploaded_file($_FILES["input1"]["tmp_name"], GetDocumentRoot().$SESSION["dir"].$_POST["edit1"].$_POST["edit2"]);
			}
			else { $UPLOAD_RESULT = false; }
		}
		else if ($SESSION["upload_filetype"] == "" && $SESSION["upload_filesize"] == "") {
			$UPLOAD_RESULT = @move_uploaded_file($_FILES["input1"]["tmp_name"], GetDocumentRoot().$SESSION["dir"].$_POST["edit1"].$_POST["edit2"]);
		}

		// Dateirechte anpassen
		if ($UPLOAD_RESULT) {
			@chmod(GetDocumentRoot().$SESSION["dir"].$_POST["edit1"].$_POST["edit2"], $CONFIG["chmod_file"]);
		}
	}
}

?>