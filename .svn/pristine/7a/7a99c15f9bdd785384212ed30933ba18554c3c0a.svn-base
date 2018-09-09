<?php
// modules/_novostroiki
/**  
* Controller  
* Контроллер  
* @author IT studio IRBIS-team  
* @copyright © 2009 IRBIS-team  
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
   $PAGE = Page::getInstance(Router::getUrlPath());
   if(Users::checkUserAccess($PAGE::getId())){     
       include_once AS_ROOT .'libs/pages_func.php';
       $lk_bread_crumbs = $PAGE->getBreadCrumbs();       
       $import_history=  "<h3>У Вас нет истории импорта</h3>";
       
       // Переменная для безопасности работы uploadifive
       $timestamp = time();
       $token=md5('as_salt' . $timestamp);
       
       //require_once(AS_ROOT .'libs/uploads_func.php');
       
        // Описание товара
        //$description = handleOutText($text);
        //dbg($description);
   }
   else{
       Router::routeAccessDenied();
   }