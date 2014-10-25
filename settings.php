<?php
$raw_dir = "/srv/samba/share/pictures/raw_photos";
$render_dir = "/srv/samba/share/pictures/organized_photos";

$thumb_dir = "/usr/share/nginx/html/photos/thumbs";

$thumb_sizes = array(
  "album" => "300x",
  "album2x" => "600x",
  "photo" => "200x",
  "photo2x" => "400x"
);

//Paths with two periods in them are not allowed
function isSafePath($path){
  if(preg_match('/\.\./', $path)){
    return false;
  }
  return true;
}

//If private is in the path we will restrict it to the local network
function isPrivatePath($path){
  if(preg_match("/private/i", $path)){
    return true;
  }
  return false;
}

//Find the album name if possible
function getAlbumName($path){
  if(preg_match("/(.*)\/(.*?)/", $path, $match)){
    return $match[1];
  }

  return null;
}

//Takes an item name and maps it to the real render/raw path
function getRealItemPath($path){
  global $raw_dir, $render_dir;

  if(!isSafePath($path)){
    return null;
  }

  $album_name = getAlbumName($path);

  if($album_name == null){
    $possible_render_path = $render_dir . "/" . $path;
    if(is_dir($possible_render_path) || is_file($possible_render_path)){
      return $possible_render_path;
    }

    $possible_raw_path = $raw_dir . "/" . $path;
    if(is_dir($possible_raw_path) || is_file($possible_raw_path)){
      return $possible_raw_path;
    }

    return null;
  }

  $possible_render_album_path = $render_dir . "/" . $album_name;
  if(is_dir($possible_render_album_path)){
    $possible_render_path = $render_dir . "/" . $path;
    if(is_file($possible_render_path)){
      return $possible_render_path;
    }
    return null;
  }

  $possible_raw_album_path = $raw_dir . "/" . $album_name;
  if(is_dir($possible_raw_album_path)){
    $possible_raw_path = $raw_dir . "/" . $path;
    if(is_file($possible_raw_path)){
      return $possible_raw_path;
    }
    return null;
  }

  return null;
}

function getSimpleAlbumList($album='/'){
  global $raw_dir, $render_dir;

  if(!isSafePath($album)){
    return array();
  }

  if($album == '/'){
    $raw_dir_list = scandir($raw_dir);
    $render_dir_list = scandir($render_dir);

    return array_unique(array_merge($raw_dir_list, $render_dir_list));
  }
  $raw_dir_path = $raw_dir . "/" . $album;
  $render_dir_path = $render_dir . "/" . $album;

  if(is_dir($render_dir_path)){
    return scandir($render_dir_path);
  } elseif(is_dir($raw_dir_path)){
    return scandir($raw_dir_path);
  } else {
    return array();
  }
}

?>
