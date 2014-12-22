<?php
//This method returns the specific item details from the album cache

require_once dirname(__FILE__) . "/functions/album.php";

$item = isset($_GET["item"]) ? $_GET["item"] : null;

if(!$item){
	http_response_code(409);
	die("You must pass an item in.");
}

$parent_album_name = getAlbumName($item);
if($parent_album_name === false){
	http_response_code(500);
	die("No album found");
}

$parent_album_info = json_decode(getAlbumInfo($parent_album_name), true);
if($parent_album_info === false){
	http_response_code(500);
	die("Unable to load album info");
}

$item_info = null;

foreach($parent_album_info["items"] as $sub_item){
	if($sub_item["name"] == $item){
		$item_info = $sub_item;
	}
}

if($item_info === null){
	http_response_code(500);
	die("Unable to load item info");
}

$item_info["album"] = $parent_album_name;
$item_info["rawName"] = getItemName($item);

$item_contents = json_encode($item_info);

header("Content-Type: application/json");
header("Content-Length: " . strlen($item_contents));
echo $item_contents;

?>
