<?php
/*   
* index.php 
* main application entry
* главная точка входа
* @author Dulebsky A. 19.03.2014   
* @copyright © 2014 ArtSide   
*/
/**   
* We establish the charset and level of errors   
* Устанавливаем кодировку и уровень ошибок   
*/
    header("Content-Type: text/html; charset=utf-8"); 
    ini_set('display_errors',1);
    error_reporting(E_ALL);   
/**    
* Debug    
* Дебаггер   
* @TODO To clean in release   
*/   
    define('AS_TRACE', true);      
    include_once './debug.php';    
/**   
* Installation of a key of access to files   
* Установка ключа доступа к файлам   
*/ 
    define('AS_KEY', true);
/**  
* We connect a configuration file  
* Подключаем конфигурационный файл  
*/  
    include_once './config.php';
/**   
* We connect exeptions file     
* Подключаем файл исключений
*/      
    include_once AS_ROOT .'libs/exceptions.php';
/**  
* We connect a file of sequriy functions  
* Подключаем файл функции безопасности
*/      
    include_once AS_ROOT .'libs/security.php'; 
/**  
* We connect a file of the general functions  
* Подключаем файл общих функций  
*/    
    include_once AS_ROOT .'libs/default.php';
/**  
* We connect a file of autoload function 
* Подключаем файл с автооматической загрузкой классов
*/      
    include_once AS_ROOT .'libs/autoload.php'; 
if(Page::checkAccessWithoutPassword(Router::getUrlPath())){
    /**   
    * get PAGE instance  
    * получаем экземпляр страницы  
    */
    $PAGE = Page::getInstance(Router::getUrlPath());
    /**   
    * We connect a file of the xajax lib   
    * Подключаем файл xajax библиотеки  
    */        
    $xajax = new xajax();	
    require_once(AS_ROOT .'libs/xajax/xajax_access_func_inc.php');
    $xajax->processRequest();
    $xajax->configure('javascript URI', AS_HOST.'libs/xajax');
    /**
     * We connect rouer of page
     * Подключаем маршрутизатор страницы
     */    
    $content = Router::startRoute();
    include AS_ROOT .'skins/tpl/'.$PAGE::getMainTpl().'/index.tpl';
}
elseif(Users::checkUserAut()){  
    /**
     * We connect rouer of page
     * Подключаем маршрутизатор страницы
     */ 
    $content = Router::startRoute();
    
    /**  
    * We connect a file of initialization of variables  
    * Подключаем файл инициализации переменных  
    */     
    include AS_ROOT .'libs/variables.php';     
    /**   
    * We connect a file of the xajax lib   
    * Подключаем файл xajax библиотеки  
    */        
    $xajax = new xajax();
    require_once(AS_ROOT .'libs/xajax/xajax_for_all_func_inc.php');
    switch(Router::getUrlController())  
    {        
        case 'users':
            require_once(AS_ROOT .'libs/xajax/xajax_users_func_inc.php');
        break;
        case 'pages':
            require_once(AS_ROOT .'libs/xajax/xajax_pages_func_inc.php');       
        break; 
        case 'shop':
            require_once(AS_ROOT .'libs/xajax/xajax_shop_func_inc.php'); 
            require_once(AS_ROOT .'libs/xajax/xajax_products_actions_func_inc.php'); 
        break;
        default :
        break;
    } 
    $xajax->processRequest();
    $xajax->configure('javascript URI', AS_HOST.'libs/xajax');
    include AS_ROOT .'skins/tpl/'.$PAGE::getMainTpl().'/index.tpl';
} 
else{
    /**   
    * We connect a file of the xajax lib   
    * Подключаем файл xajax библиотеки  
    */        
    $xajax = new xajax();	
    require_once(AS_ROOT .'libs/xajax/xajax_for_all_func_inc.php');
    $xajax->processRequest();
    $xajax->configure('javascript URI', AS_HOST.'libs/xajax');
    /**   
    * We include buffering   
    * Включаем буферизацию   
    */  
    $content = Router::startRoute('modules','sequrity');
    include AS_ROOT .'skins/tpl/sequrity/index.tpl';
}