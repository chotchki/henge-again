<?php
$parent = "/srv/samba/share/pictures/organized_photos";
$thumb_dir = "/usr/share/nginx/html/photos/thumbs"; 

$name = $_GET["name"];

$height = $_GET["height"];
$width = $_GET["width"];

if(preg_match("/\.\./", $name)) {
  http_response_code(500);
  die("Bad Item Name");
}

if(!is_numeric($height)){
  http_response_code(500);
  die("Bad Height " . $height);
}

if(!is_numeric($width)){
  http_response_code(500);
  die("Bad Width " . $width);
}

$source = $parent . "/" . $name;
$source_exists = file_exists($source);
if($source_exists){
  $source_mod = filemtime($source);
}

$thumb = $thumb_dir . "/" . $name . "_" . $width . "x" . $height . ".jpeg";
$thumb_exists = file_exists($thumb);
if($thumb_exists){
  $thumb_mod = filemtime($thumb);
} else {
  $thumb_parent = dirname($thumb);
  if(!file_exists($thumb_parent)){
    if(!mkdir($thumb_parent, 0770, true)){
      http_response_code(500);
      die("Unable to resize");
    }
  }
}

if(!$source_exists){
  http_response_code(500);
  die("No such image");
}

if($thumb_exists == false || $thumb_mod < $source_mod){
  $cmd = "convert -auto-orient " . escapeshellarg($source) . " " . escapeshellarg($thumb);
  $output = system($cmd, $status);
  if($status != 0){
  	http_response_code(500);
  	die("Failed to auto orient " . $cmd . " | " . $status . " | " . $output);
  }
  
  $cmd = "convert -geometry " . "x" . $height . " " . escapeshellarg($thumb) . " " . escapeshellarg($thumb);
  $output = system($cmd, $status);
  if($status != 0){
    http_response_code(500);
    die("Failed to resize " . $cmd . " | " . $status . " | " . $output);
  }
}

header("Content-Type: image/jpeg");
header("Content-Length: " . filesize($thumb));
readfile($thumb);

?>
