<?php
/*   
* /core/autoload.php 
* File to auto load the classes
* Файл для автозагрузки классов 
* @author ArtSide Dulebsky A. 07.06.2015    
* @copyright © 2015 ArtSide   
*/
/**   
* Register function for __autoload()
* Регистрация функции в качестве реализации метода __autoload()  
*/
spl_autoload_register('autoloadClass');
function autoloadClass ($className) {
    $map = array(
        'DB' => AS_ROOT . 'libs/classes/DB.class.php',        
        'Mailer' => AS_ROOT . 'libs/classes/Mailer.class.php',
        'UserRegistration' => AS_ROOT . 'libs/classes/UserRegistration.class.php',
        'Users' => AS_ROOT . 'libs/classes/Users.class.php',
        'Page' => AS_ROOT . 'libs/classes/Page.class.php',
        'Tree' => AS_ROOT . 'libs/classes/Tree.class.php',
        'AdminUser' => AS_ROOT . 'libs/classes/AdminUser.class.php',
        'Router' => AS_ROOT . 'libs/classes/Router.class.php', 
        'Enum' => AS_ROOT . 'libs/classes/enums/Enum.class.php',
        'RequestStatus' => AS_ROOT . 'libs/classes/enums/RequestStatus.class.php',
        'ReportsFormat' => AS_ROOT . 'libs/classes/enums/ReportsFormat.class.php',
        'ExceptionFiles' => AS_ROOT . 'libs/classes/ExceptionFiles.class.php',
        'ExceptionDataBase' => AS_ROOT . 'libs/classes/ExceptionDataBase.class.php', 
        'Enum' => AS_ROOT . 'libs/classes/enums/Enum.class.php',
        'ProductStatus' => AS_ROOT . 'libs/classes/enums/ProductStatus.class.php',
        'xajax' => AS_ROOT . 'libs/xajax/xajax_core/xajax.inc.php',
        'PHPExcel' => AS_ROOT . 'libs/classes/PHPExcel.class.php'
    );
    include $map[$className];
}
