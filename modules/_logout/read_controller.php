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
   /*if(checkUserAccess($COOKIE_LK_USER_ID, $PAGE['id'])){
       include_once AS_ROOT .'libs/users_func.php';
       $user_type = getUserInfo("`type`","id",$COOKIE_LK_USER_ID);
       switch($user_type['type'])  
        {          
            case 'commercial_agent':                      
                 $PAGE_TITLE = "Агентство недвижимости \"Мой город\"";
            break;             
            default:  
                include_once AS_ROOT .'libs/pervichka_func.php'; 
                include_once AS_ROOT .'libs/news_func.php'; 
                $objects_table=  getPervichkaObjectsTable();
                $complex_stat=getStatistic("complex");
                $flat_stat=getStatistic("complex_flats");
                $news=getNews(2);
            break;      
        }       
   }
   else{
       routeAccessDenied();
   }
    * 
    */
   
    