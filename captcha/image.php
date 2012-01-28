<?php

	header("Content-type: image/jpeg");

	session_start();

// image config

	$code = rand(1000,9999);
	$color_r = rand(50, 170);
	$color_g = rand(50, 170);
	$color_b = rand(170, 250);

	$_SESSION["captcha_code"] = $code;

	$bg_image = "blank.jpg";
	$font = "./maturasc.ttf";

	$size = 26;
	$rotation = rand(-5,10);
	$pad_x = 10;
	$pad_y = 35;

// generate image

	$img_path	= $bg_image;
	$img_size	= getimagesize($img_path);

	$width  = $img_size[0];
	$height = $img_size[1];

	$img = ImageCreateFromJpeg($img_path);

	$fg = ImageColorAllocate($img, $color_r, $color_g, $color_b);

	ImageTTFText($img, $size, $rotation, $pad_x, $pad_y, $fg, $font, $code);

	$dots = $width*$height/2;
	for($i=0;$i<$dots;$i++)
		{
		$dc = ImageColorAllocate($img, $color_r, $color_g, $color_b);
		ImageSetPixel($img, rand(0,$width), rand(0,$height), $dc);
		}

	imagejpeg($img);


?>