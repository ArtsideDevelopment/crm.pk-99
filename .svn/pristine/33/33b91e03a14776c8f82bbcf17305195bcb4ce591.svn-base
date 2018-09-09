<?php
// admin/_sequrity/read_controller.php
/**  
* Controller. Protection file for authorization
* Контроллер. Файл защиты для авторизации 
* @author Dulebsky A. 07.06.2015 
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
///////////////////////////////////////////////////////////////
    $login = (isset($_POST['login'])) ? check_form($_POST['login']) : '';
    $password = (isset($_POST['pass'])) ? check_form($_POST['pass']) : '';
    //dbg($login);
    $auth_error = Users::authorizationUser($login, $password);