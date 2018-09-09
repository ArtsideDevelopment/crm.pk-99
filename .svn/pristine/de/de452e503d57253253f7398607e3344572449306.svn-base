<?php
/*
UploadiFive
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
*/

// Set the uplaod directory
$uploadDir = '/uploads/';

// Set the allowed file extensions
$fileTypes = array('xls', 'xlsx', 'jpg', 'jpeg', 'gif', 'png', 'pdf', 'docx', 'doc'); // Allowed file extensions
$verifyToken = md5('as_salt' . $_POST['timestamp']);
$folder=$_POST['folder'];
$preffix=$_POST['preffix'];
if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
	$tempFile   = $_FILES['Filedata']['tmp_name'];
	$uploadDir  = $_SERVER['DOCUMENT_ROOT'] . $uploadDir. $folder;
	$targetFileTmp = $uploadDir . $_FILES['Filedata']['name'];
        // Validate the filetype
	$fileParts = pathinfo($_FILES['Filedata']['name']);
        // Итоговый файл
        $file_name=$preffix . uniqid() .".".strtolower($fileParts['extension']);
        $fileDest=$uploadDir. $file_name;
	
	if (in_array(strtolower($fileParts['extension']), $fileTypes)) {
		// Save the file
		move_uploaded_file($tempFile, $targetFileTmp);
                copy($targetFileTmp, $fileDest);                   
                unlink($targetFileTmp);
		echo $file_name;

	} else {
		// The file type wasn't allowed
		echo 'Invalid file type.';
	}
}
else{
    echo 'Access error';
}