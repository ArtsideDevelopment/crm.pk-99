<?php
/*   
* libs/uploads_func.php 
* File of uploads functions
* Файл функций формы
* @author ArtSide 13.04.2018  
* @copyright © 2018 ArtSide   
*/
/** 
* Функция обработки внешнего текста
* function handle out text
* @param string $text
* @return string $text_handled 
*/ 
function handleOutText($text_out, $folder, $url="", $url_old=""){    
    $text_handled = "";
    //$text_out = str_replace('""', '"', $text_out);
    $text_out = htmlspecialchars_decode($text_out);
    $img_count = substr_count($text_out, 'img');
    $links_array = findOutImgLinks($text_out);
    //dbg ($links_array);
    $img_array = findOutImages($links_array, $img_count, $url, $url_old); 
    //dbg($img_array);
    $img_transfer_arr = uploadOutImages($img_array, $folder);
    //dbg($img_transfer_arr);
    $text_handled=$text_out;
    foreach ($img_transfer_arr as $img) {
        foreach ($img as $old_img => $new_img) {
            $text_handled = str_replace($old_img, $new_img, $text_handled);
        }
    }
    $search = array(
        'highslide',
        'return hs.expand(this)',
        '../../',
        '../'
    );
    $replace= array(
        'pk-gallery',
        '',
        '/',
        '/'
    );
    return str_replace($search, $replace, $text_handled); 
    //return $text_handled; 
    //return str_replace('../uploads/content/transfer/', AS_HOST.'uploads/content/transfer/', $text_handled);
    
}
/** 
* Функция поиска ссылок с изображениями
* function find links with images
* @param string $text
* @return string $text_handled 
*/ 
function findOutImgLinks($text_out){
    //$text_out = mb_convert_encoding($text_out, "UTF-8");
    //$text_out = mb_convert_encoding($text_out, 'HTML-ENTITIES', "UTF-8");    
    //dbg($text_out);
    preg_match_all('/<a.*img.*<\/a>/', (string)$text_out, $links_array);    
    return $links_array;
}
/** 
* Функция поиска всех изображений в тексте
* function handle out text
* @param string $text
* @return string $text_handled 
*/ 
function findOutImages($links_array, $img_count, $url="", $url_old=""){    
    $img_array = array();    
    $i=0;
    foreach($links_array[0] as $link_tag)
    {
        //dbg($img_tag);
        $img_array_tmp = array('thumb'=>'','big'=>'');
        preg_match_all('/src=("[^"]*")/', (string)$link_tag, $img_src);
        preg_match_all('/href=("[^"]*[.png|.jpg|.gif]")/', (string)$link_tag, $img_href);      
        if(isset($img_src[1][0])){
            $img_array_tmp['thumb'] = str_replace('..','',(string)$img_src[1][0]);
        }
        if(isset($img_href[1][0])){
            $img_array_tmp['big'] = str_replace('..','',(string)$img_href[1][0]);
        }
        //dbg($img_src);
        //dbg($img_href);
        $img_array[$i] = $img_array_tmp;
        $i++;
    }    
    if($img_count>$i){
        $count = $img_count - $i;
        try{ 
            $res = DB::mysqliQuery(AS_DATABASE_SITE,"
                     INSERT INTO   
                        `". AS_DBPREFIX ."img_log`
                     SET
                        `url`='".$url."',
                        `url_old`='".$url_old."',
                        `count`=".$count.", 
                        `type`='shop',
                        `as_catalog_id`='355'
                    ");
        } catch (ExceptionDataBase $edb) {
            throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
        }
    }
    return $img_array;
}
function findOutImages2($text_out){    
    $img_array = array();
    preg_match_all('/<img[^>]+>/', $text_out, $img_array); 
    $img = array();
    foreach($img_array[0] as $img_tag)
    {
        //dbg($img_tag);
        preg_match_all('/src=("[^"]*")/', (string)$img_tag, $img[(string)$img_tag]);
        preg_match_all('/src:("[^"]*")/', (string)$img_tag, $img_2[(string)$img_tag]);
    }    
    $img_src_arr = array();
    foreach($img as $img_tag_s => $img_src){
        //dbg($img_src[1]);
        $img_src_arr[$img_tag_s]=$img_src[1][0];
    }
    //dbg($img_src_arr);
    //uploadOutImages($img_src_arr);
    return $img_src_arr;
}
/** 
* Функция поиска скачивания изображения с удаленного сервера
* function upload out images
* @param array $text
* @return string $text_handled 
*/ 
function uploadOutImages($img_src_arr, $folder){ 
    $transfer_img_arr = array();
    $i=0;
    foreach($img_src_arr as $img_src){
        //dbg($img_src);
        $array_tmp = array();
        if(strlen(trim($img_src['big']))>0){
            $array_tmp = array();
            $img_src_big_clear = trim(trim((string)$img_src['big'],'"'), '/');
            $new_img_src_big = uploadOutImagesCurl($img_src_big_clear, $folder);
            $array_tmp[$img_src_big_clear]=$new_img_src_big;
            $transfer_img_arr[$i] = $array_tmp;
            $i++;
        }
        if(strlen(trim($img_src['thumb']))>0){
            $array_tmp = array();
            $img_src_thumb_clear = trim(trim((string)$img_src['thumb'],'"'), '/');
            $new_img_src_thumb = uploadOutImagesCurl($img_src_thumb_clear, $folder, 'thumb_');
            $array_tmp[$img_src_thumb_clear]=$new_img_src_thumb;
            $transfer_img_arr[$i] = $array_tmp;
            $i++;
        } 
    }
    return $transfer_img_arr;
}
/** 
* Функция функция скачивания изображения curl 
* function curl function for upload out images
* @param array $text
* @return string $text_handled 
*/ 
function uploadOutImagesCurl($img_src_clear, $folder='', $prefix=''){  
    $new_img="";
    $img_path="http://pk-99.ru/";
    $dest_path="uploads/images/".trim($folder, '/').'/';
    $dest_folder =AS_ROOT.$dest_path;
    
    $img_url = $img_path.$img_src_clear;
    $Headers = @get_headers($img_url); 
    //dbg($Headers[0]);
    //dbg($img_url);
    if(preg_match("|200|", $Headers[0])) {            
        $ch = curl_init($img_url);  
        curl_setopt($ch, CURLOPT_HEADER, 0);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1); 
        if(curl_exec($ch) === false)
        {
            echo 'Ошибка curl: ' . curl_error($ch);
        }
        else{
            $fileParts = pathinfo($img_src_clear); 
            if(isset($fileParts['extension'])){
                $img_extension = $fileParts['extension'];
                $img_name = imgToTranslit($fileParts['filename']).".".strtolower($img_extension);  
            }
            else{
                $img_name = imgToTranslit($fileParts['filename']);
            }           
            $out = curl_exec($ch);  
            $image_sv = $dest_folder.$prefix.$img_name;
            $new_img = $dest_path.$prefix.$img_name;
            $img_sc = file_put_contents($image_sv, $out);
        }              
        curl_close($ch);
    }
    return $new_img;
}
/** 
* Функция получения лога загрузки изображения
* function get img log
* @param 
* @return string 
*/ 
function getImgLog(){
    $img_log="";
    try{        
        $res = DB::mysqliQuery(AS_DATABASE_SITE,"
            SELECT *   
            FROM `". AS_DBPREFIX ."img_log`"  
                );        
    }
    catch (ExceptionDataBase $edb){
        throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
    }    
    if($res->num_rows){
        $img_log="
            <table width='100%' border='0' cellspacing='0' cellpadding='0' class='dataTables'>
            <thead>
                <tr class='tr_header'>
                    <th>id</th>
                    <th width='200px'>Новый url</th>
                    <th width='200px'>Старый url</th>            
                    <th>Количество изображений</th>
                    <th>Тип</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>";
        while($row = $res->fetch_assoc()){   
            $img_log.="
            <tr>        
                <td align='center'>".$row['id']."</td>         
                <td align='left'>
                    <a href='".AS_SITE.$row['url']."' target='_blank'>".$row['url']."</a>                    
                </td>
                <td align='left'><a href='".$row['url_old']."' target='_blank'>".$row['url_old']."</a></td> 
                <td align='center'>".$row['count']."</td> 
                <td align='center'> ".$row['type']."</td> 
                <td align='center'>                    
                    <a href='javascript:void(null);' onclick='xajax_Delete_Img_Log(".$row['id']."); return false;' class='btn btn-danger'><i class='icon-trash'></i></a>                    
                </td>
            </tr>";
        }
        $img_log.="
            </tbody>
        </table>";
    }  
    return $img_log;
}
/** 
* Функция получения лога загрузки изображения
* function get img log
* @param 
* @return string 
*/ 
function getImgLogStat($type){
    $stat=0;
    try{        
        $res = DB::mysqliQuery(AS_DATABASE_SITE,"
            SELECT COUNT(*) as stat  
            FROM 
                `". AS_DBPREFIX ."img_log`
            WHERE 
                `type`='".$type."'
            ");        
    }
    catch (ExceptionDataBase $edb){
        throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
    }    
    if($res->num_rows){
        $row=  $res->fetch_array();
        $stat=$row[0];
    }  
    return $stat;
}
/** 
* Функция перевода строки в формат url
* Function format string to url
* @param string $str
* @return string 
*/ 
function imgToTranslit($str){
    //$str = (string) $str; // преобразуем в строковое значение
    //$str = strip_tags($str); // убираем HTML-теги
    //$str = str_replace(array("\n", "\r"), " ", $str); // убираем перевод каретки
    //$str = preg_replace("/\s+/", ' ', $str); // удаляем повторяющие пробелы
    $str = urldecode($str);
    $str = trim($str); // убираем пробелы в начале и конце строки
    $str = trim($str,'.'); // убираем точки в начале и конце строки
    $str = strtolower($str);
    //$str = function_exists('mb_strtolower') ? mb_strtolower($str) : strtolower($str); // переводим строку в нижний регистр (иногда надо задать локаль)
    $str = strtr($str, array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sh',
        'ь' => '',  'ы' => 'y',   'ъ' => '',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
        'А' => 'a',   'Б' => 'b',   'В' => 'v',
        'Г' => 'g',   'Д' => 'd',   'Е' => 'e',
        'Ё' => 'e',   'Ж' => 'zh',  'З' => 'z',
        'И' => 'i',   'Й' => 'y',   'К' => 'k',
        'Л' => 'l',   'М' => 'm',   'Н' => 'n',
        'О' => 'o',   'П' => 'p',   'Р' => 'r',
        'С' => 's',   'Т' => 't',   'У' => 'u',
        'Ф' => 'f',   'Х' => 'h',   'Ц' => 'c',
        'Ч' => 'ch',  'Ш' => 'sh',  'Щ' => 'sh',
        'Ь' => '',  'Ы' => 'y',   'Ъ' => '',
        'Э' => 'e',   'Ю' => 'yu',  'Я' => 'ya', '.' => '_'
    ));
    $str = str_replace(" ", "-", $str); // заменяем пробелы знаком минус 
    $str = preg_replace('~[^-a-z0-9_]+~u', '', $str); // очищаем строку от недопустимых символов       
    return $str;
}
/** 
* Функция обработки изображения
* function handle out text
* @param string $text
* @return string $text_handled 
*/ 
function handleText($text){
    //dbg($text);    
    $text_handled = "";
    $text_handled = htmlspecialchars_decode($text);
    $links_array = findOutImgLinks($text_handled);
    $result_array = findImages($links_array); 
    $img_array = $result_array['img'];
    $link_replace_array = $result_array['link_replace'];  
    
    if(!empty($img_array)){
        $i=0;
        $img_replace_arr = array();
        foreach ($img_array as $img_src_array) {
            $array_tmp = array();
            if(strlen(trim($img_src_array['width']))>0 && strlen(trim($img_src_array['src']))>0){
                $fileParts = pathinfo($img_src_array['src']);
                $parsed_img = parse_url($fileParts['basename']);
                $img_src_basename = $parsed_img['path'];
                $img_src= trim($fileParts['dirname'],'"/')."/".$img_src_basename;                
                $img_src_path = trim(AS_ROOT.$img_src,'"');
                if(strpos($fileParts['dirname'], 'uploads_thumbs')>0){
                    // Изображение обрабатывается повторно
                    $img_thumb = $img_src;
                    $img_thumb_path = $img_src_path;
                }
                else{
                    $img_thumb = AS_IMH_THUMB_PATH."thumb_".uniqid()."_".$img_src_basename;
                    $img_thumb_path = AS_ROOT.$img_thumb;
                    if(file_exists($img_thumb)){
                        throw new ExceptionFiles("Файл уже существует: ".$img_thumb);
                    }
                    imgResizeWidth($img_src_path, $img_thumb_path, $img_src_array['width']*1);
                    $array_tmp[$img_src]=$img_thumb;
                    $img_replace_arr[$i] = $array_tmp;
                    $i++;
                }
                //dbg($img_replace_arr);                
                                
            }
        }    
        $text_handled = createGallery($text_handled, $link_replace_array, $img_replace_arr);
    }
    $search = array(        
        '../../',
        '../'
    );
    $replace_host= array(        
       '/',
        '/'
    );    
    //dbg($text_handled);
    return str_replace($search, $replace_host, $text_handled);
    
}
/** 
* Функция поиска всех изображений в тексте
* function handle out text
* @param string $text
* @return string $text_handled 
*/ 
function findImages($links_array){    
    $img_array = array(); 
    $a_array = array();
    $a_array_replace = array();
    $result_array = array('img'=>'','link_replace'=>'');
    $i=0;
    foreach($links_array[0] as $link_tag)
    {
        $img_array_tmp = array('src'=>'','width'=>'','class'=>'');
        preg_match_all('/src=("[^"]*")/', $link_tag, $img_src);
        preg_match_all('/width=("[^"]*")/', $link_tag, $img_width);
        preg_match_all('/class=("[^"]*")/', $link_tag, $a_class);    
        if(isset($img_src[1][0])){
            $img_array_tmp['src'] = str_replace('..','',trim($img_src[1][0],'"'));
        }
        if(isset($img_width[1][0])){
            $img_array_tmp['width'] = str_replace('..','',trim($img_width[1][0],'"'));
        }
        if(isset($a_class[1][0])){
            $img_array_tmp['class'] = str_replace('..','',trim($a_class[1][0],'"'));
        }
        //dbg($img_src);
        //dbg($img_href);
        if($img_array_tmp['class']!=='pk-gallery'){
            $img_array[$i] = $img_array_tmp;  
            $a_array_replace[trim($link_tag,'"')]=str_replace('<a','<a class="pk-gallery"',trim($link_tag,'"'));
            $a_array[$i] = $a_array_replace;
            $i++;
        }
    }   
    if(!empty($img_array)){
        $result_array['img'] = $img_array;
        $result_array['link_replace'] = $a_array;
    }
    return $result_array;
}
/** 
* Функция создания галлереи из изображений
* function create gallery
* @param string $links_array
* @return string $text_handled 
*/ 
function createGallery($text, $link_replace_array, $img_replace_arr){  
    $text_handled = "";
    foreach ($link_replace_array as $link) {
        foreach ($link as $old_link=> $new_link) {
            $text_handled = str_replace($old_link, $new_link, $text);
        }
    } 
    foreach ($img_replace_arr as $img) {
        foreach ($img as $old_img => $new_img) {
            $text_handled = str_replace('src="../'.$old_img.'"', 'src="../'.$new_img.'"', $text_handled);
        }
    }   
    return $text_handled;
}
/** 
* Функция пропорционального изменения размера
* function resize img
* @param string $text
* @return string $text_handled 
*/ 
function imgResizeWidth($src, $dest, $w)
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
  if($w_src<=$w){
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