<?php
/*   
* libs/default.php 
* File of the general functions  
* Файл общих функций  
* @author Dulebsky A. 21.03.2014   
* @copyright © 2014 ArtSide   
*/
/** 
* Функция перевода даты из азиатского формата в прописной 
* Translation function of date from the Asian format in the string 
* @param string $date, boolean $format 
* @return string 
*/ 
function formatDate($date, $time_bool = FALSE)  
{     
    $date_str="";
    if($date=="0000-00-00 00:00:00"){
        $date_str="--";
    }
    else{
        if(strlen(trim($date))>0){
            $day  = substr($date, 8, 2);          
            $mnt  = substr($date, 5, 2);         
            $year = substr($date, 0, 4);  
            $date_str = $day .'.'. $mnt .'.'. $year;                 
        }  
        if($time_bool){
            $date_str.= " ". substr($date, 11, 8); 
        }
    }
    return $date_str;
}
function formatDatePlusPeriod($date, $days)  
{     
    $tomorrow_date="";    
    if(strlen(trim($date))>0){
        $day  = substr($date, 8, 2);          
        $mnt  = substr($date, 5, 2);         
        $year = substr($date, 0, 4); 
        $tomorrow_date = date("d.m.Y", mktime(0, 0, 0, $mnt*1 , $day*1+$days, $year*1));        
    }  

    return $tomorrow_date;
}
/** 
* Функция перевода даты в формат mysql
* Function for translation date to mysql format
* @param string $date
* @return string 
*/ 
function formatDateToMysql($date, $time="12:00:00")  
{  

    if(strlen(trim($date))>0){
        $date_arr = explode(".", $date);
        $day  = $date_arr[0]; 
        $mnt  = $date_arr[1];
        $year = $date_arr[2];
    }
    else{
        $year="0000";
        $mnt="00";
        $day="00";
    }
   
    return $year .'-'. $mnt .'-'. $day." ".$time;  
}
/**  
* Function output to file
* Функция вывода в файл
*/  
function ouputLogFile($file, $file_header, $file_info){
    $log_header=date("Y-m-d H:i:s")." ".$file_header." \n";
    $log_body= strip_tags($file_info) . "\n\n";
    file_put_contents(AS_ROOT .'log/'.$file, $log_header . $log_body, FILE_APPEND);
}

/** 
* Функция перевода строки в числовой формат
* Function format string to number
* @param string $date
* @return string 
*/ 
function formatStrToNumber($numb){
    return str_ireplace(' ', '', str_ireplace(',', '.', $numb));
}