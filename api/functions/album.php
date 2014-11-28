<?php

require_once dirname(__FILE__) . "/../../settings.php";
require_once dirname(__FILE__) . "/path.php";
require_once dirname(__FILE__) . "/photo.php";

function getListOfAlbums(){
	global $raw_dir, $render_dir;
	
	$raw_dir_list = scandir($raw_dir);
	$render_dir_list = scandir($render_dir);
	
	$contents_raw = array_unique(array_merge($raw_dir_list, $render_dir_list));
	
	$contents = preg_grep("/^\\./",$contents_raw,PREG_GREP_INVERT);
	rsort($contents, SORT_NATURAL | SORT_FLAG_CASE);
	
	return $contents;
}

function getContentsOfAlbum($album){
	global $raw_dir, $render_dir;
	
	$raw_dir_path = $raw_dir . "/" . $album;
	$render_dir_path = $render_dir . "/" . $album;
	
	if(is_dir($render_dir_path) && isSafePath($render_dir_path)){
		$contents_raw = scandir($render_dir_path);
	} elseif(is_dir($raw_dir_path) && isSafePath($raw_dir_path)){
		$contents_raw = scandir($raw_dir_path);
	} else {
		return false;
	}
	
	$contents = preg_grep("/^\\./",$contents_raw,PREG_GREP_INVERT);
	sort($contents, SORT_NATURAL | SORT_FLAG_CASE);
	
	array_walk($contents, function(&$value, $key) use ($album) {
		$value = $album . '/' . $value;
	});
	
	return $contents;
}

function getAlbumInfo($album){
	global $photo_size, $thumb_dir;

	$item_list = getContentsOfAlbum($album);
	if($item_list === false){
		return false;
	}

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
