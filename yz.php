<?php
$height = 50;
$width = 150;

if (isset($_GET['height'])) {
	$height = $_GET['height'];
}
if (isset($_GET['width'])) {
	$width = $_GET['width'];
}

function setcolor($im)
{
	$fillcolor = imagecolorallocate($im, mt_rand(0, 120), mt_rand(0, 120), mt_rand(0, 120));
	return $fillcolor;
}
function textcolor($im)
{
	$textcolor = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
	return $textcolor;
}

$im = imagecreate($width, $height);

imagefill($im, 0, 0, setcolor($im));
for ($i=0; $i < 5; $i++) { 
	imageline($im, mt_rand(0, $width), mt_rand(0, $height), mt_rand(0, $width), mt_rand(0, $height), textcolor($im));	
}
for ($i=0; $i < 5; $i++) { 
	imagearc($im, mt_rand(-$width, 2 * $width), mt_rand(-$height, 2 * $height), $width, $height, mt_rand(0, 360), mt_rand(0, 360), textcolor($im));
}
for ($i=0; $i < 30; $i++) { 
	imagesetpixel($im, mt_rand(0, $width), mt_rand(0, $height), textcolor($im));
}

$selectedCode = '0123456789zxcvbnmasdfghjklqwertyuiopZXCVBNMASDFGHJKLQWERTYUIOP';
$length = strlen($selectedCode);
$code = '';

for ($i=0; $i < 4; $i++) { 
	$code .= $selectedCode[mt_rand(0, $length - 1)]; 
}

$x = 10;
for ($i=0; $i < 4; $i++) { 
imagettftext($im, $height/2, mt_rand(-15, 15), $x, $height/4*3, textcolor($im), '/usr/share/fonts/truetype/ubuntu/Ubuntu-B.ttf', $code[$i]);
	$x += ($width-10)/4;
}

session_start();
$_SESSION['code'] = $code;
header('Content-type: image/png');
imagepng($im);
imagedestroy($im);

