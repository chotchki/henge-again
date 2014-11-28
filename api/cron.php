<?php
//Regenerate all .albumInfo files

require_once dirname(__FILE__) . "photoFunctions.php";

$album_list = getSimpleAlbumList("/");

foreach($album_list as $album){
	$album_contents_raw = getAlbumInfo($album);
	
	$album_contents = json_decode($album_contents_raw);
	if($album_contents == null){
		continue;
	}
	
	print_r($album_contents);
}
?>