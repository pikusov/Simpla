<?php


chdir('..');
require_once('api/Simpla.php');

$filename = $_GET['file'];
$token = $_GET['token'];

$simpla = new Simpla();

if(!$simpla->config->check_token($filename, $token))
	exit('bad token');		

$resized_filename =  $simpla->image->resize($filename);

if(is_readable($resized_filename))
{
	header('Content-type: image');
	print file_get_contents($resized_filename);
}

