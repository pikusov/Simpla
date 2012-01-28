<?php

// Bildbreite zurückgeben
function Image_GetWidth($img) {
	$image_infos = @getimagesize($img);
	return $image_infos[0];
}

// Bildhöhe zurückgeben
function Image_GetHeight($img) {
	$image_infos = @getimagesize($img);
	return $image_infos[1];
}

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

// Bild schärfen
function Image_Sharpen($img, $amount, $radius, $threshold) {
	if ($amount > 500) { $amount = 500; }
	$amount = $amount * 0.016;
	if ($radius > 50) { $radius = 50; }
	$radius = $radius * 2;
	if ($threshold > 255) { $threshold = 255; }

	$radius = abs(round($radius));
	if ($radius == 0) { return $img; imagedestroy($img); break; }

	$w = imagesx($img); $h = imagesy($img);
	$imgCanvas = imagecreatetruecolor($w, $h);
	$imgBlur = imagecreatetruecolor($w, $h);

	if (function_exists('imageconvolution')) {
		$matrix = array(
			array( 1, 2, 1 ),
			array( 2, 4, 2 ),
			array( 1, 2, 1 )
		);
		imagecopy($imgBlur, $img, 0, 0, 0, 0, $w, $h);
		imageconvolution($imgBlur, $matrix, 16, 0);
	}
	else {
		for ($i = 0; $i < $radius; $i++)    { 
			imagecopy($imgBlur, $img, 0, 0, 1, 0, $w - 1, $h);
			imagecopymerge($imgBlur, $img, 1, 0, 0, 0, $w, $h, 50);
			imagecopymerge($imgBlur, $img, 0, 0, 0, 0, $w, $h, 50);
			imagecopy($imgCanvas, $imgBlur, 0, 0, 0, 0, $w, $h); 

			imagecopymerge($imgBlur, $imgCanvas, 0, 0, 0, 1, $w, $h - 1, 33.33333 );
			imagecopymerge($imgBlur, $imgCanvas, 0, 1, 0, 0, $w, $h, 25);
		}
	}

	if($threshold>0) {
		for ($x = 0; $x < $w-1; $x++) {
			for ($y = 0; $y < $h; $y++) {

				$rgbOrig = ImageColorAt($img, $x, $y);
				$rOrig = (($rgbOrig >> 16) & 0xFF);
				$gOrig = (($rgbOrig >> 8) & 0xFF);
				$bOrig = ($rgbOrig & 0xFF);

				$rgbBlur = ImageColorAt($imgBlur, $x, $y);

				$rBlur = (($rgbBlur >> 16) & 0xFF);
				$gBlur = (($rgbBlur >> 8) & 0xFF);
				$bBlur = ($rgbBlur & 0xFF);

				$rNew = (abs($rOrig - $rBlur) >= $threshold)
					? max(0, min(255, ($amount * ($rOrig - $rBlur)) + $rOrig))
					: $rOrig;
				$gNew = (abs($gOrig - $gBlur) >= $threshold)
					? max(0, min(255, ($amount * ($gOrig - $gBlur)) + $gOrig))
					: $gOrig;
				$bNew = (abs($bOrig - $bBlur) >= $threshold)
					? max(0, min(255, ($amount * ($bOrig - $bBlur)) + $bOrig))
					: $bOrig;

				if (($rOrig != $rNew) || ($gOrig != $gNew) || ($bOrig != $bNew)) {
					$pixCol = ImageColorAllocate($img, $rNew, $gNew, $bNew);
					ImageSetPixel($img, $x, $y, $pixCol);
				}
			}
		}
	}
	else {
		for ($x = 0; $x < $w; $x++) {
			for ($y = 0; $y < $h; $y++) {
				$rgbOrig = ImageColorAt($img, $x, $y);
				$rOrig = (($rgbOrig >> 16) & 0xFF);
				$gOrig = (($rgbOrig >> 8) & 0xFF);
				$bOrig = ($rgbOrig & 0xFF);

				$rgbBlur = ImageColorAt($imgBlur, $x, $y);

				$rBlur = (($rgbBlur >> 16) & 0xFF);
				$gBlur = (($rgbBlur >> 8) & 0xFF);
				$bBlur = ($rgbBlur & 0xFF);

				$rNew = ($amount * ($rOrig - $rBlur)) + $rOrig;
				
				if($rNew > 255) { $rNew = 255; }
				else if($rNew < 0) { $rNew = 0; }
				
				$gNew = ($amount * ($gOrig - $gBlur)) + $gOrig; 
				
				if($gNew > 255) {$gNew = 255;}
				else if($gNew < 0) { $gNew = 0; }
				
				$bNew = ($amount * ($bOrig - $bBlur)) + $bOrig; 

				if( $bNew > 255) { $bNew = 255; }
				else if ( $bNew < 0 ) { $bNew = 0; }

				$rgbNew = ($rNew << 16) + ($gNew <<8) + $bNew; 
				ImageSetPixel($img, $x, $y, $rgbNew); 
			}
		}
	}
	imagedestroy($imgCanvas);
	imagedestroy($imgBlur);

	return $img;
}

// Bilddatei verkleinern und speichern
function Image_Resize($file, $size, $jpg_quality) {
	$width = $size;
	$height = $size;

	// Neue Bildgröße und Typ ermitteln
	list($width_orig, $height_orig, $type) = @getimagesize($file);

	// Neue Bildgröße und Typ brechnen
	if ($width_orig > $width || $height_orig > $height) {
		$ratio_orig = $width_orig/$height_orig;

		if ($width/$height > $ratio_orig) {
		   $width = $height*$ratio_orig;
		} else {
		   $height = $width/$ratio_orig;
		}
	}
	else {
		$width = $width_orig;
		$height = $height_orig;
	}

	// Neues Bild erstellen
	$image_p = imagecreatetruecolor($width, $height);

	switch($type) {
		case 1:
			if (ImageTypes() & IMG_GIF) {

				// Bilddatei laden
				$image = imagecreatefromgif($file);

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

				// Bild schärfen
				$image_p = Image_Sharpen($image_p, 80, 0.5, 3);

				// Bilddatei speichern
				@imagegif($image_p, $file);
			}
			else {
				//
			}
			break;

		case 2:
			if (ImageTypes() & IMG_JPG) {

				// Bilddatei laden 
				$image = imagecreatefromjpeg($file);
				
				// Resample
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

				// Bild schärfen
				$image_p = Image_Sharpen($image_p, 80, 0.5, 3);

				// Bilddatei speichern
				@imagejpeg($image_p, $file, $jpg_quality);
			}
			else {
				//
			}
			break;

		case 3:
			if (ImageTypes() & IMG_PNG) {

				// Bilddatei laden
				$image = imagecreatefrompng($file);

				// Transparenz erhalten
				imagealphablending($image_p, false);
				$colorTransparent = imagecolorallocatealpha($image_p, 0, 0, 0, 127);
				imagefill($image_p, 0, 0, $colorTransparent);
				imagesavealpha($image_p, true);

				// Resample
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

				// Bild schärfen
				$image_p = Image_Sharpen($image_p, 80, 0.5, 3);

				// Bilddatei speichern
				@imagepng($image_p, $file);
			}
			else {
				//
			}
			break;

		default:
			//
			break;
	}

	// Speicher freigeben
	if (isset($image)) { imagedestroy($image); }
	if (isset($image_p)) { imagedestroy($image_p); }
}

// Bilddatei drehen und speichern
function Image_Rotate($file, $degrees, $jpg_quality) {

	// Bildgröße und Type ermitteln
	list($width, $height, $type) = @getimagesize($file);

	// Neues Bild erstellen
	if ($degrees != 180) {
		$h = $width;
		$w = $height;
		$width = $w;
		$height = $h;
	}
	$image_p = imagecreatetruecolor($width, $height);

	switch($type) {
		case 1:
			if (ImageTypes() & IMG_GIF) {

				// Bilddatei laden
				$image = imagecreatefromgif($file);

				// Bild drehen
				$image = imagerotate($image, $degrees, -1);

				// Transparenz erhalten
				$trnprt_indx = imagecolortransparent($image);
				if ($trnprt_indx >= 0) {
					$trnprt_color = imagecolorsforindex($image, $trnprt_indx);
					$trnprt_indx = imagecolorallocate($image_p, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
					imagefill($image_p, 0, 0, $trnprt_indx);
					imagecolortransparent($image_p, $trnprt_indx);
				}

				// Bild kopieren
				imagecopy($image_p ,$image, 0, 0, 0, 0, $width, $height);

				// Bilddatei speichern
				@imagegif($image_p, $file);
			}
			else {
				//
			}
			break;

		case 2:
			if (ImageTypes() & IMG_JPG) {

				// Bilddatei laden 
				$image = imagecreatefromjpeg($file);
				
				// Bild drehen
				$image = imagerotate($image, $degrees, -1);

				// Bild kopieren
				imagecopy($image_p ,$image, 0, 0, 0, 0, $width, $height);

				// Bilddatei speichern
				@imagejpeg($image_p, $file, $jpg_quality);
			}
			else {
				//
			}
			break;

		case 3:
			if (ImageTypes() & IMG_PNG) {

				// Bilddatei laden
				$image = imagecreatefrompng($file);

				// Bild drehen
				$image = imagerotate($image, $degrees, -1);

				// Transparenz erhalten
				imagealphablending($image_p, false);
				$colorTransparent = imagecolorallocatealpha($image_p, 0, 0, 0, 127);
				imagefill($image_p, 0, 0, $colorTransparent);
				imagesavealpha($image_p, true);

				// Bild kopieren
				imagecopy($image_p ,$image, 0, 0, 0, 0, $width, $height);

				// Bilddatei speichern
				@imagepng($image_p, $file);
			}
			else {
				//
			}
			break;

		default:
			//
			break;
	}

	// Speicher freigeben
	if (isset($image)) { imagedestroy($image); }
	if (isset($image_p)) { imagedestroy($image_p); }
}

// Filter auf das Bild anwenden
// 1 = Graustufen
// 2 = Graustufen + Kontrast
// 3 = Sepia
function Image_Filter($file, $jpg_quality, $filter) {

	// Bildgröße und Type ermitteln
	list($width, $height, $type) = @getimagesize($file);

	// Neues Bild erstellen
	$image_p = imagecreatetruecolor($width, $height);

	switch($type) {
		case 1:
			if (ImageTypes() & IMG_GIF) {

				// Bilddatei laden
				$image = imagecreatefromgif($file);

				// Filter anwenden
				switch($filter) {
					case 1:
						@imagefilter($image, IMG_FILTER_GRAYSCALE);
						break;
					case 2:
						@imagefilter($image, IMG_FILTER_GRAYSCALE);
						@imagefilter($image, IMG_FILTER_CONTRAST, -5);
						break;
					case 3:
						@imagefilter($image, IMG_FILTER_GRAYSCALE);
						@imagefilter($image, IMG_FILTER_COLORIZE, 100, 50, 0);
						break;
				}

				// Transparenz erhalten
				$trnprt_indx = imagecolortransparent($image);
				if ($trnprt_indx >= 0) {
					$trnprt_color = imagecolorsforindex($image, $trnprt_indx);
					$trnprt_indx = imagecolorallocate($image_p, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
					imagefill($image_p, 0, 0, $trnprt_indx);
					imagecolortransparent($image_p, $trnprt_indx);
				}

				// Bild kopieren
				imagecopy($image_p ,$image, 0, 0, 0, 0, $width, $height);

				// Bilddatei speichern
				@imagegif($image_p, $file);
			}
			else {
				//
			}
			break;

		case 2:
			if (ImageTypes() & IMG_JPG) {

				// Bilddatei laden 
				$image = imagecreatefromjpeg($file);
				
				// Filter anwenden
				switch($filter) {
					case 1:
						@imagefilter($image, IMG_FILTER_GRAYSCALE);
						break;
					case 2:
						@imagefilter($image, IMG_FILTER_GRAYSCALE);
						@imagefilter($image, IMG_FILTER_CONTRAST, -5);
						break;
					case 3:
						@imagefilter($image, IMG_FILTER_GRAYSCALE);
						@imagefilter($image, IMG_FILTER_COLORIZE, 100, 50, 0);
						break;
				}

				// Bild kopieren
				imagecopy($image_p ,$image, 0, 0, 0, 0, $width, $height);

				// Bilddatei speichern
				@imagejpeg($image_p, $file, $jpg_quality);
			}
			else {
				//
			}
			break;

		case 3:
			if (ImageTypes() & IMG_PNG) {

				// Bilddatei laden
				$image = imagecreatefrompng($file);

				// Filter anwenden
				switch($filter) {
					case 1:
						@imagefilter($image, IMG_FILTER_GRAYSCALE);
						break;
					case 2:
						@imagefilter($image, IMG_FILTER_GRAYSCALE);
						@imagefilter($image, IMG_FILTER_CONTRAST, -5);
						break;
					case 3:
						@imagefilter($image, IMG_FILTER_GRAYSCALE);
						@imagefilter($image, IMG_FILTER_COLORIZE, 100, 50, 0);
						break;
				}

				// Transparenz erhalten
				imagealphablending($image_p, false);
				$colorTransparent = imagecolorallocatealpha($image_p, 0, 0, 0, 127);
				imagefill($image_p, 0, 0, $colorTransparent);
				imagesavealpha($image_p, true);

				// Bild kopieren
				imagecopy($image_p ,$image, 0, 0, 0, 0, $width, $height);

				// Bilddatei speichern
				@imagepng($image_p, $file);
			}
			else {
				//
			}
			break;

		default:
			//
			break;
	}

	// Speicher freigeben
	if (isset($image)) { imagedestroy($image); }
	if (isset($image_p)) { imagedestroy($image_p); }
}

?>