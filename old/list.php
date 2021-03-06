<?php

require "settings.php";

$album = $_GET["album"];

$raw_items = array();
if(!isset($album)){
  $raw_items = getSimpleAlbumList("/");
  rsort($raw_items, SORT_NATURAL | SORT_FLAG_CASE);
} else {
  $raw_items = getSimpleAlbumList($album);
}

$items = array();
foreach($raw_items as $raw_item){
  if(preg_match("/\/\..*?$/", $raw_item)){
    continue;
  }

  $real_raw_item = getRealItemPath($raw_item);
  if(!$real_raw_item){
    continue;
  }

  $dir = is_dir($real_raw_item);
  $picture = (preg_match("/\.(jpe?g|gif|png|arw|raw)$/i", $real_raw_item) === 1);  
 
  $thumb_url = "#";
  if($dir){
    $dir_contents = scandir($real_raw_item);
    foreach($dir_contents as $dir_content){
      if(preg_match("/\.(jpe?g|gif|png|arw|raw)$/i", $dir_content) === 1){
         $thumb_url = "thumbs.php?name=" . urlencode($raw_item) . "&width=150&height=150";
         break;
      }
    }
  } else {
    $thumb_url = "thumbs.php?name=" . urlencode($raw_item) . "&width=150&height=150";
  }

  if(isset($album)){
    $name = $album . "/" . $raw_item;
  } else {
  	$name = $raw_item;
  }
  
  $items[] = array(
    "name" => $name,
    "dir" => $dir,
    "picture" => $picture,
    "thumb" => $thumb_url
  );
} 

echo json_encode($items);	
?>
