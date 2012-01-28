<?php

// Neue Bildgröße brechnen
function GetNewImageSize($file, $size) {
	$a = array();
	$a["width"] = $size;
	$a["height"] = $size;

	if (list($width_orig, $height_orig, $image_type) = getimagesize(GetDocumentRoot().$file)) {
		if ($height_orig > $size || $width_orig > $size) {
			if ($height_orig >= $width_orig) {
				$ratio_orig =  $height_orig / $width_orig;
				$a["width"] = round($size / $ratio_orig);
			}
			else if ($width_orig >= $height_orig) {
				$ratio_orig = $width_orig / $height_orig;
				$a["height"] = round($size / $ratio_orig);
			}
		}
		else {
			$a["width"] = $width_orig;
			$a["height"] = $height_orig;
		}
	}

	return $a;
}

?>