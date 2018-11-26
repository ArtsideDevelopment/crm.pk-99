<?php
/** 
* Configuration file 
* Конфигурационный файл 
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
       header("HTTP/1.1 404 Not Found");        
       header('Location: /404.html');
    } 
     
/////////////////////////////////////////////////////////////// 
//                THE GENERAL OPTIONS 
//                  ОбЩИЕ НАСТРОЙКИ 
/////////////////////////////////////////////////////////////// 
// устанавливаем временную зону
    //date_default_timezone_set ("Europe/Moscow");
    date_default_timezone_set ("Etc/GMT-3");
/** 
* Includes mod rewrite 
* Включает модуль перенаправления  
*/ 
    define('AS_REWRITE', 'on');     
/**  
* Choice of language of a site  
* Выбор языка сайта  
*/   
    define('AS_LANGUAGE', 'ru'); 
     
/////////////////////////////////////////////////////////////// 
//                OPTIONS OF CONNECTION WITH A DB 
//                  НАСТРОЙКИ СОЕДИНЕНИЯ С БД 
///////////////////////////////////////////////////////////////     
     
   /** 
   * Database prefix. 
   * Префикс таблиц БД. 
   */    
   define('AS_DBPREFIX', 'as_'); 
 
  /** 
   * Database name. 
   * Название базы 
   */  
   define('AS_DATABASE', 'u0096264_crm_pk_99');
   define('AS_DATABASE_SITE', 'u0096264_pk_99');
     
/////////////////////////////////////////////////////////////// 
//                       NOT TO CHANGE 
//                        НЕ ИЗМЕНЯТЬ 
///////////////////////////////////////////////////////////////   

     
/** 
* Establishes a path to a script root for HTTP 
* Устанавливает путь до корневой директории скрипта 
* по протоколу HTTP 
*/  
    define('AS_HOST', 'http://'. $_SERVER['HTTP_HOST'] .'/'); 
/** 
* Establishes domain host without http://
* Устанавливает домен без http://
*/  
    define('AS_DOMAIN', trim($_SERVER['HTTP_HOST'], '/'));  
/** 
* Establishes site url with http://
* Устанавливает адрес сайта с http://
*/
    define('AS_SITE','http://pk-99.u0096264.plsk.regruhosting.ru/');    
/** 
* Establishes a physical path to a root directory of a script 
* Устанавливает физический путь до корневой директории скрипта 
*/  
    define('AS_ROOT', str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']) .'/'); 
/** 
* Establishes a company name 
* Устанавливает название кампании
*/  
    define('AS_COMPANY', 'ArtSide'); 
/** 
* Establishes a system name
* Устанавливает название системы
*/  
    define('AS_SYSTEM_NAME', 'CRM ArtSide'); 
    
    define('AS_EXCEL_FILES_ROOT', AS_ROOT.'uploads/excel/'); 
    
    define('AS_IMH_THUMB_PATH', 'uploads_thumbs/'); 
 
/** 
* Establishes const for category images  
* Устанавливает контсанты к изображениям категории
*/     
    define('AS_CATEGORY_IMG_WIDTH', 800);
    define('AS_CATEGORY_THUMB_IMG_WIDTH', 120);

/** 
* Establishes a img path 
* Устанавливает путь к изображениям
*/  
    define('AS_IMG_ROOT', AS_ROOT.'uploads/images/');
    
    define('AS_CATEGORY_IMG_ROOT', AS_IMG_ROOT.'categories/');
    
    define('AS_IMG_PATH', AS_HOST.'uploads/images/');
    
    define('AS_CATEGORY_IMG', AS_HOST.'uploads/images/categories/');
    
    define('AS_CATEGORY_IMG_THUMB', AS_HOST.'uploads/images/categories/thumb_');