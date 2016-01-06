<?php

require_once('../api/Simpla.php');

$filename = $_GET['file'];
$token = $_GET['token'];

$simpla = new Simpla();


if(!$simpla->config->check_token($filename, $token))
{
	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
	exit('bad token');
}

$resized_filename = $simpla->image->resize($filename);

if(is_readable($resized_filename))
{
	if (function_exists('exif_imagetype')) {
		$image_type = exif_imagetype( $resized_filename );
	} else {
		$image_type = getimagesize( $resized_filename );
		$image_type = ( isset($image_type[2]) ) ? $image_type[2] : NULL;
	}

	if( is_null($image_type) )
		$image_mime = 'image';
	else
		$image_mime = image_type_to_mime_type($image_type);

	header("Content-type: ".$image_mime);
	print file_get_contents($resized_filename);
	exit;
}

