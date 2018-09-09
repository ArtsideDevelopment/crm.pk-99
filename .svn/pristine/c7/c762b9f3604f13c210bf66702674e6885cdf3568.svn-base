<?php
// modules/_confirm_registration
/**  
* Controller  
* Контроллер  
* @author Dulebsky A. 26.11.2015   
* @copyright © 2015 ArtSide  
*/  
/////////////////////////////////////////////////////////  

/**  
* Generation of page of an error at access out of system  
* Генерация страницы ошибки при доступе вне системы  
*/  
    if(!defined('AS_KEY'))  
    {  
       Router::routeErrorPage404();
    }      
///////////////////////////////////////////////////////////  

/**  
* check user access 
* проверяем права доступа 
*/    
   require_once(AS_ROOT .'libs/users_func.php'); 
   $user_id=(isset($_GET['user'])) ? check_form($_GET['user']) : "";
   $hash=(isset($_GET['hash'])) ? check_form($_GET['hash']) : "";
   if(Users::checkUserRegistration($user_id, $hash)){   
       $user_mail = Users::getUserMail();
       $user_name = Users::getUserName();
   }
   else{
       Router::routeAccessDenied();
   }