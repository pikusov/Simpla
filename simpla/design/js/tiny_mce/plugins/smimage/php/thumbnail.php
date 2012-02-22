<?php

include("tools.php");

function SendEmptyImage() {

	// Content type
	header("Content-type: image/gif");

	// Output
	imagegif(imagecreatefromgif("../img/icon_image_32x32.gif"));
}

// Neue Bildgröße brechnen
function GetNewImageSize($file, $size) {
	$a = array();
	$a["width"] = $size;
	$a["height"] = $size;

	if (list($width_orig, $height_orig, $image_type) = getimagesize($file)) {
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

// Neue Bildgröße brechnen
$a = array();
$a = GetNewImageSize(GetDocumentRoot().$_GET["src"], $_GET["size"]);
$width = $a["width"];
$height = $a["height"];
unset($a);

// Originale Bildgröße und Bilddateityp ermitteln
if (!list($width_orig, $height_orig, $image_type) = getimagesize(GetDocumentRoot().$_GET["src"])) {
	SendEmptyImage();
	exit;
}

// Neues Bild erstellen
if (!$image_p = imagecreatetruecolor($width, $height)) {
	SendEmptyImage();
	exit;
}

// GIF-, JPG- und PNG-Bildformat
switch($image_type) {
	case 1:
		if (ImageTypes() & IMG_GIF) {

			// Content type
			header("Content-type: image/gif");

			// Bilddatei laden
			if ($image = imagecreatefromgif(GetDocumentRoot().$_GET["src"])) {

				// Transparenz erhalten
				$trnprt_indx = imagecolortransparent($image);
				if ($trnprt_indx >= 0) {
					$trnprt_color = @imagecolorsforindex($image, $trnprt_indx);
					$trnprt_indx = @imagecolorallocate($image_p, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
					imagefill($image_p, 0, 0, $trnprt_indx);
					imagecolortransparent($image_p, $trnprt_indx);
				}

				// Resample
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

				// Output
				imagegif($image_p);
			}
			else { SendEmptyImage(); }
		}
		else {
			SendEmptyImage();
		}
		break;

	case 2:
		if (ImageTypes() & IMG_JPG) {

			// Content type
			header("Content-type: image/jpeg");

			// Bilddatei laden 
			if ($image = imagecreatefromjpeg(GetDocumentRoot().$_GET["src"])) {

				// Resample
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
					
				// Output
				imagejpeg($image_p, null, $_GET["jpg_quality"]);
			}
			else { SendEmptyImage(); }
			
		}
		else {
			SendEmptyImage();
		}
		break;

	case 3:
		if (ImageTypes() & IMG_PNG) {

			// Content type
			header("Content-type: image/png");

			// Bilddatei laden
			if ($image = imagecreatefrompng(GetDocumentRoot().$_GET["src"])) {

				// Transparenz erhalten
				imagealphablending($image_p, false);
				$colorTransparent = imagecolorallocatealpha($image_p, 0, 0, 0, 127);
				imagefill($image_p, 0, 0, $colorTransparent);
				imagesavealpha($image_p, true);

				// Resample 
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

				// Output
				imagepng($image_p);
			}
			else { SendEmptyImage(); }
			
		}
		else {
			SendEmptyImage();
		}
		break;

	default:
		SendEmptyImage();
		break;
}

// Speicher freigeben
if (isset($image)) { imagedestroy($image); }
if (isset($image_p)) { imagedestroy($image_p); }

?>