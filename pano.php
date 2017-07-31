<?php

list($cmd, $path) = $argv;

if (!$path) die("usage: php pano.php path/to/file\n");

$pi = pi();
$halfPi = $pi/2;
$twoPi = $pi*2;

$hfov = 180;
$vfov = 35;
$sw = 6000;
$sh = 2*tan($vfov*$pi/360)*w/$twoPi;
$w = round($sw*360/$hfov);
$h = $w/2;
$cl = ($w-$sw)/2;
$ct = ($h/2) * ($halfPi - atan($sh*$pi/$w)) / $halfPi;
$cw = $sw;
$ch = $h*2*atan(($sh/2)/($w/$twoPi))/$pi;

$cmd = "exiftool -ProjectionType=cylindrical";

foreach ([
	'FullPanoWidthPixels' => $w,
	'FullPanoHeightPixels' => $h,
	'CroppedAreaLeftPixels' => $cl,
	'CroppedAreaTopPixels' => $ct,
	'CroppedAreaImageWidthPixels' => $cw,
	'CroppedAreaImageHeightPixels' => $ch,
] as $attr => $value) {
	$cmd .= " -$attr=".round($value);
}

$cmd .= " $path";

echo "$cmd\n";