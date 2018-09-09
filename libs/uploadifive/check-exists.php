<?php
/*
UploadiFive
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
*/

// Define a destination
$targetFolder = '/uploads/'; // Relative to the root and should match the upload folder in the uploader script
$folder=$_POST['folder'];
if (file_exists($_SERVER['DOCUMENT_ROOT'] . $targetFolder . $folder . $_FILES['Filedata']['name'])) {
	echo 1;
} else {
	echo 0;
}