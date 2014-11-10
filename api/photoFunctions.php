<?php

require_once 'functions.php';

function getItemDateTime($path){
	if(!isSafePath($path)){
		return false;
	}

	exec('identify -format "%[EXIF:DateTime]" ' . escapeshellarg($path), $output, $return_code);

	if($return_code != 0 || !$output){
		return false;
	}

	return date_create_from_format('Y:n:d G:i:s', $output[0]);
}

function getItemSize($path){
	if(!isSafePath($path)){
		return false;
	}
	
	exec('identify -format "%Wx%Hx%[exif:orientation]" ' . escapeshellarg($path), $output, $return_code);
	
	if($return_code != 0 || !$output){
		return false;
	}
	
	list($width, $height, $orient) = split("x", $output[0]);
	
	switch($orient){
		case 1:
		case 3:
			return array($width, $height);
		case 6:
		case 8:
			return array($height, $width);
		default:
			return array($width, $height);
	}
}

?>