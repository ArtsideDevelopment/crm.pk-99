<?php
/*   
* /libs/security.php 
* File of security functions 
* Файл фунций, обеспечивающих безопасность приложения.  
* @author ArtSide Dulebsky A. 05.07.2012    
* @copyright © 2012 ArtSide   
*/
function rec_replace_str($str, $substr, $substr_replace){
    if(substr_count(strtolower($str), $substr)>0){
	   //$str=substr_replace($str, $substr_replace, stripos($str, $substr), strlen($substr));
	   $str=str_ireplace($substr, $substr_replace, $str);
	   $str=rec_replace_str($str, $substr, $substr_replace);
	   return $str;
	}
	else{
	   return $str;
	}
}
/**   
* Connection and installation of chaeset of connection 
* Проверка формы на введение пользователем запрещенных  
*/
function check_form($str, $type=""){
    $error_log="";
    /*if(strripos($str, "select") || strripos($str, "union")){ // ищем опасные для нас слова
        $error="Оишибка в запросе: ".$str." ";
        $where=  debug_backtrace();
        $search = array("select", "union");
        $replace   = array("selеct", "uniоn");
        $str_security = str_ireplace($search, $replace, $str);
        addError("hacker_attack", $error, $where);
    }
    */

    if(strtolower($str)=="select"){
        $str=rec_replace_str($str, "select", "селект");
        $error_log.="Ошибка в запросе! \n";
        $error_log.="Строка запроса: ".$str." \n";
    }
    if(strtolower($str)=="union"){
        $str=rec_replace_str($str, "union", "юнион");

    } 
    if(strtolower($str)=="order"){
        $str=rec_replace_str($str, "order", "ордер");

    }
    if(strtolower($str)=="where"){
        $str=rec_replace_str($str, "where", "уэре");

    }
    if(strtolower($str)=="char"){
        $str=rec_replace_str($str, "char", "чар");

    }   
    if(strtolower($str)=="from"){
        $str=rec_replace_str($str, "from", "фром");

    }
    if(strtolower($str)=="input"){
        $str=rec_replace_str($str, "input", "инпут");

    }   
    if($error_log!=""){
        $error_log.="User_id: ".(isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '')." \n";
        $error_log.="Date: ".date("m.d.Y:H:i:s")." \n";
        $error_log.="----------------------------------\n";
        file_put_contents(AS_ROOT .'log/form.log', $error_log."\n\n", FILE_APPEND);
    }     
    if($type=="numb"){
        return htmlspecialchars(str_ireplace(',', '.', $str),  ENT_QUOTES);
    }
    else{
        return htmlspecialchars($str,  ENT_QUOTES); 
    }
}
function check_form_lite($str){
    if(strripos($str, "select") || strripos($str, "union")){
        addError("hacker_attack", $error, $where);
    }   
    return htmlspecialchars($str,  ENT_QUOTES);
}
/*
* Функция логирования ошибок и отправки уведомления администратору
* Function add error in log file and send notice to administratior
* @param string $type $
* @return string
*/ 
function addError($type, $error="", $where=""){        
    require_once(AS_ROOT .'libs/mail_func.php');
    $error_log="";  
    $user_id=check_form(isset($_COOKIE['user_lk_id']) ? $_COOKIE['user_lk_id'] : '');
    switch($type)  
    {          
        case 'hacker_attack':      
            $err_type='Попытка sql или xss атаки';              
        break;  
        case 'bd_error':
            $err_type='Ошибка при обращении к базе данных';
        break; 
        case 'delete':
            $err_type='Ошибка при удалении с сервера';
        break;
        case 'mail':
            $err_type='Ошибка при отправки e-mail письма';
        break;
        default:  
            $err_type='Не определено';    
        break;      
    }
    $error_log.="Error type: ".$err_type." \n";
    $error_log.="User_id: ".$user_id." \n";
    $error_log.="Date: ".date("m.d.Y:H:i:s")." \n";
    $error_log.="User ip:".GetRealIp()." \n";
    $error_log.="Error:".$error." \n";
   // $error_log.="Where: File -> ".$where['file'].", Line -> ".$where['line'].", Function -> ".$where['function'].",\n";
    
    $error_log.="----------------------------------\n";
    file_put_contents(AS_ROOT .'log/error.log', $error_log."\n\n", FILE_APPEND);
    $msg="
        <p><strong>Тип ошибки: ".$err_type."</strong></p>
        <p><strong>Пользователь: ".$user_id."</strong></p>
        <p><strong>Описание проблемы:</strong></p>
        <p>".$error."</p>
        <p><strong>Место проблемы:</strong></p>
        <p>Файл -> ".$where['file'].", Строка - > ".$where['line'].", Функция -> ".$where['function']."</p>
        ";
    $mail = new Mailer('exeption');
    $mail->sendExeption($msg);
}
/* 
* Функция получения настоящего ip адреса пользователя
* The function get the real ip address of user
* @param  
* @return string 
*/ 
function GetRealIp(){
    $ip="";
    if (!empty($_SERVER["HTTP_CLIENT_IP"])) 
    {
        $ip=$_SERVER["HTTP_CLIENT_IP"];
    }
    elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
    {
        $ip=$_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    else
    {
        $ip=$_SERVER["REMOTE_ADDR"];
    }
    return $ip;
}
/** 
* Функция контроля цулочисленных числовых значений 
* Function of Control int values 
* @param string $str
* @return  $string 
*/ 
function controlNums($num){
    if(ctype_digit(trim($num)))	
        return true;
    else    
        return false;	
}
/** 
* Функция контроля числовых значений с плавающей точкой 
* Function of Control decimal values 
* @param string $str
* @return  $string 
*/ 
function controlFloats($num){
    $num_replace=formatStrToNumber($num);
    /*$num_replace=  str_ireplace(',', '.', trim($num))*1;
    if(is_numeric($num_replace))        return TRUE;
    else            return FALSE;
    
    if(preg_match("|^[\d]*\.[\d]*$|", $num_replace))	
        return true;	
    else
        return false;	
    */
    if(is_numeric($num_replace))        return true;
    else            return false;
    
}