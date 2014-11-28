<?php

require_once dirname(__FILE__) . "/functions/photo.php";

$name = $_GET["name"];
$height = $_GET["height"];
$width = $_GET["width"];

$thumb = getThumbRealPath($name, $height, $width);

if($thumb === false){
	http_response_code(500);
	die("Unable to produce thumb");
}

header("Content-Type: image/jpeg");
header("Content-Length: " . filesize($thumb));
readfile($thumb);

?>
