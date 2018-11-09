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
       $page_id = isset($_GET['page_id']) ? $_GET['page_id'] : 0;       
       include_once AS_ROOT .'libs/form_func.php';
       $CONTENT= DB::getTableArray(AS_DATABASE_SITE, "content", $page_id);
       $as_content_type = getSelectBlock(AS_DATABASE_SITE, "content_type", "name", "as_content_type_id", $CONTENT['as_content_type_id']);
       $as_select_parent = getParentSelect('content', $CONTENT['parent_id']);
       $left_menu_set = getCheckBoxSet('left_menu_set', $CONTENT['left_menu_set']); 
       $top_menu_set = getCheckBoxSet('top_menu_set', $CONTENT['top_menu_set']);
       $test='<p><a href="../uploads/test/test.jpg"><img src="../uploads/test/test.jpg?1534499008945" alt="" width="300"></a></p>';
       require_once(AS_ROOT .'libs/uploads_func.php');
       //$content = check_form(handleText($test));
       $preview_btn = getPreviewButton($CONTENT['url_path']);
   }
   else{
       Router::routeAccessDenied();
   }