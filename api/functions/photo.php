<?php

require_once dirname(__FILE__) . "/../../settings.php";
require_once dirname(__FILE__) . "/path.php";

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

function getThumbRealPath($name, $height, $width){
	global $thumb_dir;
	
	if(!is_numeric($height) || !is_numeric($width)) {
		error_log("height and width must be numeric");
		return false;
	}
	
	$source = getRealItemPath($name);
	if($source === false){
		error_log("source file does not exist " . $name);
		return false;
	}
	$source_mod = filemtime($source);
	
	$thumb = $thumb_dir . "/" . $name . "_" . $width . "x" . $height . ".jpeg";
	$thumb_exists = file_exists($thumb);
	if($thumb_exists){
		$thumb_mod = filemtime($thumb);
	} else {
		$thumb_parent = dirname($thumb);
		if(!file_exists($thumb_parent)){
			if(!mkdir($thumb_parent, 0770, true)){
				error_log("Unable to create the parent directory " . $thumb_parent);
				return false;
			}
		}
	}
	
	if($thumb_exists === false || $thumb_mod < $source_mod){
		$cmd = "convert -auto-orient " . escapeshellarg($source) . " " . escapeshellarg($thumb);
		$output = system($cmd, $status);
		if($status != 0){
			error_log("Failed to auto orient " . $cmd . " | " . $status . " | " . $output);
			return false;
		}
	
		$cmd = "convert -geometry " . "x" . $height . " " . escapeshellarg($thumb) . " " . escapeshellarg($thumb);
		$output = system($cmd, $status);
		if($status != 0){
			error_log("Failed to resize " . $cmd . " | " . $status . " | " . $output);
			return false;
		}
	}
	
	return $thumb;
}

?>