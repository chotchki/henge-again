<?php
//This method returns the album details of the NEXT album after the one passed in.

require_once "functions.php";
require_once "photoFunctions.php";

$album = $_GET["current"];

$album_list = getSimpleAlbumList("/");
rsort($album_list, SORT_NATURAL | SORT_FLAG_CASE);

if(!isset($album)){
	$selected_album = $album_list[0];
} else {
	$selected_album_key = array_search($album, $album_list);
	if($selected_album_key === false || (count($album_list) - 1)  < ($selected_album_key + 1)){
		http_response_code(404);
		die("Album Not Found");
	} else {
		$selected_album = $album_list[$selected_album_key + 1];
	}
}

//Now that we have an album, get its information... hopefully cached

$item_list = getSimpleAlbumList($selected_album);

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


$cache_parent = $thumb_dir . '/' . $selected_album;
$cache = $cache_parent . '/' . '.albumInfo';
if(file_exists($cache)){
	$cache_mod = filemtime($cache);
	
	if($cache_mod >= $item_list_max_mod){
		header("Content-Type: application/json");
		header("Content-Length: " . filesize($cache));
		readfile($cache);
		return;
	}
} elseif(!file_exists($cache_parent) && !mkdir($cache_parent, 0770, true)) {
	http_response_code(500);
	die("Unable to cache album info");
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
	"name" => $selected_album,
	"items" => $items
);

$cache_contents = json_encode($album_details);

//Populate the cache
file_put_contents($cache, $cache_contents);

header("Content-Type: application/json");
header("Content-Length: " . strlen($cache_contents));
echo $cache_contents;

?>
