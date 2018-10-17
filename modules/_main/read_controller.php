<?php
// modules/_main
/**  
* Controller  
* Контроллер  
* @author Dulebsky A. 15.12.2015   
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
    $PAGE = Page::getInstance(Router::getUrlPath());
    include_once AS_ROOT .'libs/dashboard_func.php';
    //$dashboard = getDashboard($PAGE::getId(), Users::getUserType(), Users::getCookieUserId());
    require_once(AS_ROOT .'libs/uploads_func.php');
    $log_table = getImgLog();
    $stat_category = getImgLogStat('catalog');
    $stat_product = getImgLogStat('shop');
    $stat_content = getImgLogStat('content');
    
   
    