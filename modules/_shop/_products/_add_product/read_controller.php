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
       include_once AS_ROOT .'libs/form_func.php';
       $product_id = 0;
       $CONTENT= DB::getTableArray(AS_DATABASE_SITE, "products");
       $as_status = getSelectBlock(AS_DATABASE_SITE, "status", "name", "as_status_id", 1);
       $noindex_set = getCheckBoxSet('noindex_set'); 
       $button_link_show_set = getCheckBoxSet('button_link_show_set');
       // Переменная для безопасности работы uploadifive
       $timestamp = time();
       $token=md5('as_salt' . $timestamp);
       $img = "";
   }
   else{
       Router::routeAccessDenied();
   }