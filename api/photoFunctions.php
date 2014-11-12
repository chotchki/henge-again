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

function getAlbumInfo($album){
	global $photo_size, $thumb_dir;
	
	$item_list = getSimpleAlbumList($album);
	
	//Find the time of the newest file edit
	$item_list_max_mod = 0;
	foreach($item_list as $item){
		if(preg_match("/\/\..*?$/", $item)){
			continue;
		}
	
		$real_item = getRealItemPath($item);
	
		if(!$real_item){
			continue;
		}
	
		if(is_dir($real_item)){
			continue;
		}
	
		$item_mod = filemtime($real_item);
		if($item_mod > $item_list_max_mod){
			$item_list_max_mod = $item_mod;
		}
	}
	
	
	$cache_parent = $thumb_dir . '/' . $album;
	$cache = $cache_parent . '/' . '.albumInfo';
	if(file_exists($cache)){
		$cache_mod = filemtime($cache);
	
		if($cache_mod >= $item_list_max_mod){
			return file_get_contents($cache);
		}
	} elseif(!file_exists($cache_parent) && !mkdir($cache_parent, 0770, true)) {
		return false;
	}
	
	//If we got here, the cache needs to be created
	
	$items = array();
	foreach($item_list as $item){
		if(preg_match("/\/\..*?$/", $item)){
			continue;
		}
	
		$real_item = getRealItemPath($item);
	
		if(!$real_item){
			continue;
		}
	
		if(is_dir($real_item)){
			continue;
		}
	
		$is_picture = (preg_match("/\.(jpe?g|gif|png|arw|raw)$/i", $real_item) === 1);
	
		$item_datetime = getItemDateTime($real_item);
		list($item_width, $item_height) = getItemSize($real_item);
	
		$thumb_width = round(($item_width * $photo_size) / $item_height);
	
		$items[] = array(
				"name" => $item,
				"isPicture" => $is_picture,
				"dateTime" => date_format($item_datetime, DATE_ISO8601),
				"height" => $item_height,
				"width" => $item_width,
				"thumbHeight" => $photo_size,
				"thumbWidth" => $thumb_width
		);
	}
	
	//Build the final album object
	$album_details = array(
			"name" => $album,
			"items" => $items
	);
	
	$cache_contents = json_encode($album_details);
	
	//Populate the cache
	file_put_contents($cache, $cache_contents);
	
	return $cache_contents;
}

?>