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
       $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : 0;
       $CONTENT= DB::getTableArray(AS_DATABASE_SITE, "catalog", $category_id);
       $as_select_parent = getParentSelect('catalog', $CONTENT['parent_id']);
       $as_status = getSelectBlock(AS_DATABASE_SITE, "status", "name", "as_status_id", $CONTENT['as_status_id']);
       $menu_hidden_set = getCheckBoxSet('menu_hidden_set', $CONTENT['menu_hidden_set']);
       $img = getCategoryImageInput('img', $CONTENT['img']);
       // Переменная для безопасности работы uploadifive
       $timestamp = time();
       $token=md5('as_salt' . $timestamp);
       $tranlit_class="no_tranlit";
       $preview_btn = getPreviewButton($CONTENT['url_path']);
       $form_name = 'EditCategory';
   }
   else{
       Router::routeAccessDenied();
   }