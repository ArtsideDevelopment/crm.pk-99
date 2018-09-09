<?php
/** 
* Variables file 
* Файл премнных
* @author Dulebsky A.  19.03.2014 
* @copyright © 2014 ArtSide 
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
* user _SESSIONS variables for chech authentication
* Переменные _SESSIONS пользователя для проверки аутентификации
*/ 
    //$user_arr = getUserArrByIdForLk(Users::getCookieUserId());
    $auth_user_fio= Users::getUserFIO();

/**   
* get PAGE instance  
* получаем экземпляр страницы  
*/
    $PAGE = Page::getInstance(Router::getUrlPath());

/** 
* main menu and sub menu
*/  
    $main_menu= $PAGE->getMainMenu(Router::getUrlPath());    
    //$lk_bread_crumbs = $PAGE->getBreadCrumbs();
    // Необработанные заявки
    $modal_dialog_content = "";
    /*
    $new_orders_number = getUserNewOrdersNumber(Users::getCookieUserId());
    if($new_orders_number>0){
        $modal_dialog_content = getAgentNewOrdersDialog(Users::getCookieUserId());
    }
    */    
/**   
* tpl variables   
* переменные шаблона  
*/  
define('AS_GENERAL_HEADER', AS_ROOT .'skins/tpl/for_all/header.tpl');
define('AS_GENERAL_FOOTER', AS_ROOT .'skins/tpl/for_all/footer.tpl');
