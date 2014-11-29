<?php
//Regenerate all .albumInfo files

require_once dirname(__FILE__) . "/functions/album.php";
require_once dirname(__FILE__) . "/functions/photo.php";

$album_list = getListOfAlbums();

foreach($album_list as $album){
	$album_contents_raw = getAlbumInfo($album);
	
	$album_contents = json_decode($album_contents_raw, true);
	if($album_contents == null){
		continue;
	}
	
	foreach($album_contents["items"] as $item){
		getThumbRealPath($item["name"], 150, 225);
		getThumbRealPath($item["name"], 300, 450);
		getThumbRealPath($item["name"], 600, 900);
	}
}
?>