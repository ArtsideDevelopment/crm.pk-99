<?php
/*
UploadiFive
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
*/

// Set the uplaod directory
$uploadDir = '/uploads/images/';

// Set the allowed file extensions
if(isset($_POST['file_type'])){
    $fileTypes=explode(",", str_replace(' ','',$_POST['file_type']));
}
else{
    $fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // Allowed file extensions
}
$verifyToken = md5('as_salt' . $_POST['timestamp']);
$folder=$_POST['folder'];
$img_preffix=$_POST['img_preffix'];
$main_width=(isset($_POST['main_width'])) ? $_POST['main_width'] : 0; // ширина основного изображения
$main_height=(isset($_POST['main_height'])) ? $_POST['main_height'] : 0; // высота основного изображения
$middle_width=(isset($_POST['middle_width'])) ? $_POST['middle_width'] : 0; // ширина среднего изображния
$thumb_width=(isset($_POST['thumb_width'])) ? $_POST['thumb_width'] : 0; // ширина превью изображния
//dbg($main_width);
if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
	$tempFile   = $_FILES['Filedata']['tmp_name'];
	$uploadDir  = $_SERVER['DOCUMENT_ROOT'] . $uploadDir. $folder;
	$targetFileTmp = $uploadDir . $_FILES['Filedata']['name'];
        // Validate the filetype
	$fileParts = pathinfo($_FILES['Filedata']['name']);
        // Итоговый файл
        $file_name=$img_preffix . rand(1, 100)."_".time().".".strtolower($fileParts['extension']);
        $file_name = getRandomFileName($uploadDir, $img_preffix, $fileParts['extension']);
        $fileDest=$uploadDir. $file_name;
        $fileDestMiddle=$uploadDir. "middle_".$file_name; 
        $fileDestThumb=$uploadDir. "thumb_".$file_name; 
	
	if (in_array(strtolower($fileParts['extension']), $fileTypes)) {
		// Save the file
		move_uploaded_file($tempFile, $targetFileTmp);                
                if($main_width>0){
                    img_resize_width($targetFileTmp, $fileDest, $main_width); // основное изображение
                }
                else {
                    if($main_height>0){
                        img_resize_height($targetFileTmp, $fileDest, $main_height); // основное изображение если задано уменьшение по высоте
                    }
                }
                if($middle_width>0){
                    img_resize_width($targetFileTmp, $fileDestMiddle, $middle_width); // среднее изображение
                }
                if($thumb_width>0){
                    img_resize_width($targetFileTmp, $fileDestThumb, $thumb_width); // превью изображение
                }           
                
                unlink($targetFileTmp);
		echo $file_name;

	} else {
		// The file type wasn't allowed return: error_file_type
		echo 'error_file_type';
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
function img_resize_height($src, $dest, $h)
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
  $w=($w_src/$h_src)*$h;
  // обрабатываем прозрачные изображения
  if($format=="png"){
     if($h_src<$h){
          copy($src, $dest);
      }
      else{
          $idest = imagecreatetruecolor($w, $h);
          //устанавливаем прозрачность
          //setTransparency($idest, $isrc); 
          /**
            Перед тем как произодить опрерации с новым ресурсом,
            установим некоторые опции
            imageAlphaBlending - устанавливает режим смешивания(режим
             смешивания недоступен для изображений с палитрой)
            по умолчанию для truecolor изображений - true, для изображений
             с палитрой - false
            true/false - включен/выключен

                    true - при накладывании одного изображения на другое
                    цвета пикселей нижележащего и накладываемого изображения смешиваются,
                    параметры смешивания определяются прозрачностью пикселя.

                    false - накладываемый пиксель заменяет исходный
            */
          imageAlphaBlending($idest, false);
          /*
            ImageSaveAlpha
            Сохранять или не сохранять информацию о прозрачности
            по умолчанию - false, а надо true
            */
          imageSaveAlpha($idest, true);
          imagecopyresampled($idest, $isrc, 0, 0, 0, 0, $w, $h, $w_src, $h_src);    
          imagepng($idest, $dest);
          imagedestroy($idest);
      }
  }
  else{
      if($h_src<$h){
          copy($src, $dest);
      }
      else{
          $idest = imagecreatetruecolor($w, $h);
          imagecopyresampled($idest, $isrc, 0, 0, 0, 0, $w, $h, $w_src, $h_src);
          imagejpeg($idest, $dest, $quality);
          imagedestroy($idest);
      }
  }  
  imagedestroy($isrc);
  return true;
}
/** 
* Функция получения уникальнго названия файла
* Function get random file name
* @param string $path - путь до файла
* @param string $img - название файла с расширением
* @param array $prefix_arr - массив с префиксами изображения
* @return int 
*/
function getRandomFileName($path="", $preffix="", $extension="")
{  
  $file_name = "";
  if(strlen(trim($path))>0 && strlen(trim($extension))>0){
      do{
          $file_name=$preffix . md5(microtime() . rand(0, 9999)).".".strtolower($extension);
          $file = $path . $file_name;
      } while (file_exists($file));
  }
  return $file_name;
}
?>