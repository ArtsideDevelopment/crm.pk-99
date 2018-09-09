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
   if(Users::checkUserAccess($PAGE::getId() )){
       include_once AS_ROOT .'libs/form_func.php';
       $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : 0;
       $user_arr= DB::getTableArray(AS_DATABASE, "lk_users", $user_id);       
       $user_parent_select= getUserChildSelect(Users::getCookieUserId(), $user_arr['parent_id']);
       $user_type_select = getSelectBlock(AS_DATABASE, 'lk_users_type', 'name', 'as_lk_users_type_id', $user_arr['as_lk_users_type_id']);
   }
   else{
       Router::routeAccessDenied();
   }
   