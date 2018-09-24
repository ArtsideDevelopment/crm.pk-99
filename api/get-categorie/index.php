<?php
/**  
* We connect a configuration file  
* Подключаем конфигурационный файл  
*/  
    define('AS_KEY', true);
    header("Content-Type: application/json");
/**   
* Installation of a key of access to files   
* Установка ключа доступа к файлам   
*/ 
    define('AS_KEY', true);
/**  
* We connect a configuration file  
* Подключаем конфигурационный файл  
*/  
    define('AS_ROOT_CUR', str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']) .'/'); 
    include_once AS_ROOT_CUR.'config.php';
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
    
    $key=isset($_GET['key']) ? $_GET['key'] : '';
    if(strlen(trim($key))>0){
        include_once AS_ROOT .'libs/shop_func.php';
        $categories_array = getCategoriesArray();
        echo json_encode($categories_array);
    }
    