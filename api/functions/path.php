<?php

//Sanity Check all paths
function isSafePath($path){
	return ($path === realpath($path));
}

//Takes an item name and maps it to the real render/raw path
function getRealItemPath($path){
	global $raw_dir, $render_dir;

	$possible_raw_path = $raw_dir . "/" . $path;
	if((is_dir($possible_raw_path) || is_file($possible_raw_path)) && isSafePath($possible_raw_path)){
		return $possible_raw_path;
	}

	$possible_render_path = $render_dir . "/" . $path;
	if((is_dir($possible_render_path) || is_file($possible_render_path)) && isSafePath($possible_render_path)){
		return $possible_render_path;
	}

	return false;
}

//If private is in the path we will restrict it to the local network
function isPrivatePath($path){
	if(preg_match("/private/i", $path)){
		return true;
	}
	return false;
}

//This function depends on a properly setup nginx to add the proper header
function isLocalClient(){
	$headers = getallheaders();
	
	if($headers["X-IS-LOCAL"] == 1){
		return true;
	} else {
		return false;
	}
}

?>