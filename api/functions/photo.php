<?php

require_once dirname(__FILE__) . "/../../settings.php";
require_once dirname(__FILE__) . "/path.php";

function isMovie($name){
	return preg_match("/(avi|mov|mp4)$/i", $name);
}

function isPicture($name){
	return preg_match("/(arw|cr2|jpg|jpeg|png|thm|tif|tiff)$/i", $name);
}

function getItemDateTime($path){
	if(!isSafePath($path)){
		return false;
	}
	
	if(isPicture($path)){
		exec('identify -format "%[EXIF:DateTime]" ' . escapeshellarg($path), $output, $return_code);

		if($return_code != 0 || !$output){
			return false;
		}

		return date_create_from_format('Y:n:d G:i:s', $output[0]);
	} elseif(isMovie($path)){
		exec('ffprobe -show_entries "format_tags=creation_time" -print_format compact=nk=1:p=0 -loglevel error ' . escapeshellarg($path), $output, $return_code);
		
		if($return_code != 0 || !$output){
			return false;
		}
		
		return date_create_from_format('Y-n-d G:i:s', $output[0]);
	} else {
		return false;
	}
}

function getItemSize($path){
	if(!isSafePath($path)){
		return false;
	}

	if(isPicture($path)){
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
	} elseif(isMovie($path)){
		exec('ffprobe -select_streams v:0 -show_entries stream=height,width -print_format compact=nk=1:p=0 -loglevel error ' . escapeshellarg($path), $output, $return_code);
		
		if($return_code != 0 || !$output){
			return false;
		}
		
		list($width, $height) = split("|", $output[0]);
		
		return array($width, $height);
	} else {
		return false;
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
		if(isPicture($source)){ //Convert pictures
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
		} elseif(isMovie($source)){ //Convert movies
			$cmd = "ffmpeg -loglevel error -i " . escapeshellarg($source) . ' -vf "thumbnail,scale="' . $width . ":" . $height . '" -frames:v 1 ' . escapeshellarg($thumb);
			$output = system($cmd, $status);
			if($status != 0){
				error_log("Failed to resize " . $cmd . " | " . $status . " | " . $output);
				return false;
			}
		} else {
			error_log("Unable to convert " . $source);
			return false;
		}
	}
	
	return $thumb;
}

?>