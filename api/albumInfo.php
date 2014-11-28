<?php
//This method returns the album details of the NEXT album after the one passed in.

require_once dirname(__FILE__) . "/functions/album.php";

$album = isset($_GET["album"]) ? $_GET["album"] : null;

$next = isset($_GET["next"]) ? true : false; //If set, return the next album NOT the asked for one
$previous = isset($_GET["previous"]) ? true : false; //If set, return all the albums up to the asked for one

if($next && $previous){
	http_response_code(409);
	die("Only one modifier allowed.");
}

//All the albums to return
$selected_albums = array();

$album_list = getListOfAlbums();

if(!isset($album)){
	array_push($selected_albums, $album_list[0]);
} elseif(!$next && !$previous){
	array_push($selected_albums, $album);
} elseif($next){
	$selected_album_key = array_search($album, $album_list);
	if($selected_album_key === false || (count($album_list) - 1)  < ($selected_album_key + 1)){
		http_response_code(404);
		die("Album Not Found");
	} else {
		array_push($selected_albums, $album_list[$selected_album_key + 1]);
	}
} else {
	$selected_album_key = array_search($album, $album_list);
	if($selected_album_key === false){
		http_response_code(404);
		die("Album Not Found");
	} else {
		array_push($selected_albums, array_slice($album_list, 0, $selected_album_key));
	}
}

$albums = array();
foreach($selected_albums as $selected_album){
	$album_info = json_decode(getAlbumInfo($selected_album));
	if($album_info === false){
		http_response_code(500);
		die("Unable to load album info");
	}
	array_push($albums, $album_info);
}

$album_contents = json_encode($albums);

header("Content-Type: application/json");
header("Content-Length: " . strlen($album_contents));
echo $album_contents;

?>
