<?php

function ShowSubFolders($dir_root, $dir, $depth, $treemenu) {
	global $SESSION;
	global $GET2;

	if ($depth >= 1) { $folders = GetFolders($dir, explode(",", $SESSION["hidden_subfolder"])); }
	else { $folders = GetFolders($dir, explode(",", $SESSION["hidden_folder"])); }

	if (count($folders) == 0) { return; }
	
	if ($depth >= 1) { echo "<div class=\"sub_tree_menu\"><ul>"; }
	else { echo "<div><ul>"; }

	for ($i = 0; $i < count($folders); $i++) {

		if ($SESSION["dir"] == $dir.$folders[$i]."/") {
			echo "<li><a id=\"active\" href=\"javascript:;\">";
			$SESSION["folder"] = $folders[$i];
		}
		else { echo "<li><a href=\"javascript:;\" onclick=\"SMExplorer_OpenFolder('".bin2hex(RC4("id=1&treemenu=".$treemenu."&dir=".$dir.$folders[$i]."/&".$GET2))."'); if (window.event){ window.event.returnValue = false; }\">"; }

		echo "<img style=\"margin:0px; margin-left:4px;\" src=\"img/icon_tree_16x16.png\" border=\"0\" /><img src=\"img/icon_folder_16x16.png\" border=\"0\" />".$folders[$i];
		if ($SESSION["show_chmod"] == 1) { echo "<span style=\"margin-left:3px; font-size:7pt; color:#c4d3f6; font-weight:normal;\">[".GetChmod($dir_root)."]</span>"; }
		echo "</a></li>";

		// Unterordner anzeigen
		ShowSubFolders($dir_root, $dir.$folders[$i]."/", $depth+1, $treemenu);
	}

	echo "</ul></div>";
}

// Root-Ordner anzeigen
for ($i = 0; $i < count($ROOT_FOLDER); $i++) {
	if ($i > 0) { echo "<div class=\"splitter_horizontal\"></div>"; }

	if (@file_exists(GetDocumentRoot().$ROOT_FOLDER[$i])) {
		echo "<div class=\"tree_menu\"><ul>";
		echo "<li><a href=\"javascript:;\" onclick=\"SMExplorer_OpenFolder('".bin2hex(RC4("id=1&treemenu=".$i."&dir=".$ROOT_FOLDER[$i]."&".$GET2))."'); if (window.event){ window.event.returnValue = false; }\"><img src=\"img/icon_folder_16x16.png\" border=\"0\" />";
		if ($ROOT_FOLDER[$i] == $SESSION["dir"]) { echo "<b>".basename($ROOT_FOLDER[$i])."</b>"; } else { echo basename($ROOT_FOLDER[$i]); }
		if ($SESSION["show_chmod"] == 1) { echo "<span style=\"margin-left:3px; font-size:7pt; color:#c4d3f6; font-weight:normal;\">[".GetChmod($ROOT_FOLDER[$i])."]</span>"; }
		echo "</a></li>";

		// Unterordner anzeigen
		ShowSubFolders($ROOT_FOLDER[$i], $ROOT_FOLDER[$i], 0, $i);

		echo "</ul></div>";
	}
	else {
		echo "<div class=\"tree_menu\"><ul>";
		echo "<li><a style=\"color:#d21034;\" href=\"javascript:;\"><img src=\"img/icon_folder_16x16.png\" border=\"0\" /><b>".basename($ROOT_FOLDER[$i])."</b></a></li>";
		echo "</ul></div>";
	}
}

?>