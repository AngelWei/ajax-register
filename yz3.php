<?php
session_start();
header('Content-type: image/png');

$im = imagecreatetruecolor(44, 20);
$bgcolor = imagecolorallocate($im, 245, 245, 245);
imagefill($im, 0, 0, $bgcolor);

$auth = null;
srand((double)microtime()*10000000);
for ($i=0; $i < 4; $i++) { 
	$bgcolor = imagecolorallocate($im, rand(0, 255), rand(0, 255), rand(0, 255));
	$math = rand(0, 9);
	$auth .= $math;
	imagestring($im, 5, 2+$i*10, 2, $math, $bgcolor); 
}

for ($i=0; $i < 100; $i++) { 
	$bgcolor = imagecolorallocate($im, rand(0, 255), rand(0, 255), rand(0, 255));
	imagesetpixel($im, rand()%70, rand()%40, $bgcolor);
}

imagepng($im);
imagedestroy($im);

$_SESSION['code'] = $auth;

