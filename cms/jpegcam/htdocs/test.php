<?php

/* JPEGCam Test Script */
/* Receives JPEG webcam submission and saves to local file. */
/* Make sure your directory has permission to write files as your web server user! */
$id=$_GET["id"];
$filename = $id . '.jpg';
//$filemtime = filemtime($filename);
$filemtime=time();
if(file_exists('jpegcam/htdocs/' .$filename)){
unlink('jpegcam/htdocs/' .$filename);
}

$result = file_put_contents( $filename, file_get_contents('php://input') );
if (!$result) {
	print "ERROR: Failed to write data to $filename, check permissions\n";
	exit();
}

$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $filename."?".$filemtime;
print "$url\n";



?>
