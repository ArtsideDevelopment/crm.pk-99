<?php
/*
UploadiFive
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
*/

// Set the uplaod directory
$uploadDir = '/uploads/';

// Set the allowed file extensions
$fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // Allowed file extensions

$folder=$_POST['folder'];
$img_preffix=$_POST['img_preffix'];
$main_width=$_POST['main_width']; // ширина основного изображения

if (!empty($_FILES)) {
	$tempFile   = $_FILES['Filedata']['tmp_name'];
	$uploadDir  = $_SERVER['DOCUMENT_ROOT'] . $uploadDir. $folder;
	$targetFileTmp = $uploadDir . $_FILES['Filedata']['name'];
        // Validate the filetype
	$fileParts = pathinfo($_FILES['Filedata']['name']);
        // Итоговый файл
        $file_name=$img_preffix . rand(1, 100)."_".time().".".strtolower($fileParts['extension']);
        $fileDest=$uploadDir. $file_name; 
        
	if (in_array(strtolower($fileParts['extension']), $fileTypes)) {
		// Save the file
		move_uploaded_file($tempFile, $targetFileTmp);
                img_resize_width($targetFileTmp, $fileDest, $main_width); // основное изображение                         
                unlink($targetFileTmp);
		echo $file_name;

	} else {
		// The file type wasn't allowed
		echo 'Invalid file type.';
	}
}
function img_resize($src, $dest,$w,$h)
{  
  $rgb=0xFFFFFF; 
  $quality=100;
  if (!file_exists($src)) return false;
  // Определяем исходный формат по MIME-информации, предоставленной
  // функцией getimagesize, и выбираем соответствующую формату
  // imagecreatefrom-функцию.
  $size = getimagesize($src);
  $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
  $icfunc = "imagecreatefrom" . $format;
  if (!function_exists($icfunc)) return false;
  $isrc = $icfunc($src);
  $w_src = imagesx($isrc); 
  $h_src = imagesy($isrc);
  $idest = imagecreatetruecolor($w, $h);
  if($h_src/$w_src>1.5){
     imagecopyresampled($idest, $isrc, 0, 0,  0, round(($h_src-1.5*$w_src)/2), $w, $h, $w_src , $w_src*1.5); 
  }
  else{
     imagecopyresampled($idest, $isrc, 0, 0, round(($w_src-$h_src/1.5)/2), 0, $w, $h, $h_src/1.5, $h_src );
 }
  imagejpeg($idest, $dest, $quality);
  imagedestroy($isrc);
  imagedestroy($idest);
  return true;
}
function img_resize_width($src, $dest, $w)
{  
  $rgb=0xFFFFFF; 
  $quality=100;
  if (!file_exists($src)) return false;

  // Определяем исходный формат по MIME-информации, предоставленной
  // функцией getimagesize, и выбираем соответствующую формату
  // imagecreatefrom-функцию.
  $size = getimagesize($src);
  $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
  $icfunc = "imagecreatefrom" . $format;
  if (!function_exists($icfunc)) return false;
  $isrc = $icfunc($src);
  $w_src = imagesx($isrc); 
  $h_src = imagesy($isrc);
  $h=$h_src/$w_src*$w;
  if($w_src<$w){
      imagejpeg($isrc, $dest, $quality);
  }
  else{
    $idest = imagecreatetruecolor($w, $h);
    imagecopyresampled($idest, $isrc, 0, 0, 0, 0, $w, $h, $w_src, $h_src);
    imagejpeg($idest, $dest, $quality);
    imagedestroy($idest);
  }
  imagedestroy($isrc);
  return true;
}
?>