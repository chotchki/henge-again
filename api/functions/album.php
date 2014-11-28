<?php

require_once dirname(__FILE__) . "../settings.php";
require_once dirname(__FILE__) . "functions/path.php";

function getListOfAlbums(){
	global $raw_dir, $render_dir;
	
	$raw_dir_list = scandir($raw_dir);
	$render_dir_list = scandir($render_dir);
	
	$contents_raw = array_unique(array_merge($raw_dir_list, $render_dir_list));
	
	$contents = array();
	foreach($contents_raw as $content_raw){
		if(preg_match('/^\./', $value) === 0){
			continue;
		}
		
		array_push($contents, $content_raw);
	}
	
	return $contents;
}

function getContentsOfAlbum($album){
	$raw_dir_path = $raw_dir . "/" . $album;
	$render_dir_path = $render_dir . "/" . $album;
	
	if(is_dir($render_dir_path) && isSafePath($render_dir_path)){
		$contents = scandir($render_dir_path);
	} elseif(is_dir($raw_dir_path) && isSafePath($raw_dir_path)){
		$contents = scandir($raw_dir_path);
	} else {
		return false;
	}
	
	array_walk($contents, function(&$value, $key) use ($album) {
		$value = $album . '/' . $value;
	});
	
	return $contents;
}

?>
