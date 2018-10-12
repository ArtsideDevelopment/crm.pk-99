<?php
/*   
* libs/translit_func.php 
* File of the translit functions  
* Файл функций перевода в транслит 
* @author Dulebsky A. 23.05.2018   
* @copyright © 2018 ArtSide   
*/

/** 
* Функция перевода строки в формат url
* Function format string to url
* @param string $str
* @return string 
*/ 
function strToUrl($str){
    //$str = (string) $str; // преобразуем в строковое значение
    //$str = strip_tags($str); // убираем HTML-теги
    //$str = str_replace(array("\n", "\r"), " ", $str); // убираем перевод каретки
    //$str = preg_replace("/\s+/", ' ', $str); // удаляем повторяющие пробелы
    $str = trim($str); // убираем пробелы в начале и конце строки
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
        'Э' => 'e',   'Ю' => 'yu',  'Я' => 'ya',
        '>' => '',
    ));
    $str = str_replace(" ", "-", $str); // заменяем пробелы знаком минус 
    $str = str_replace(array("'",'"'), "", $str); // заменяем ковычки 
    $str = preg_replace('~[^-a-z0-9_]+~u', '', $str); // очищаем строку от недопустимых символов 
    $str = preg_replace('/\-{2,}/', '', $str); // очищаем строку от лишних знаков -
    $str = trim($str, '-');
    return $str;
}