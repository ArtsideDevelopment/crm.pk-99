<?php
/*   
* libs/classes/Router.class.php 
* File of the Router class  
* Файл класса Маршрутизации 
* @author Dulebsky A. 12.06.2015   
* @copyright © 2015 ArtSide   
*/
/** 
* Класс для маршрутизации приложения
* Class for routing application
* @param  
*/ 
class Router{
    const ERROR_CONTROLLER_ROUTER = 'modules/_error/router.php';
    const DEFAULT_CONTROLLER = '_content';
    static private $_module='modules';
    static private $_url_path;
    static private $_controller = '_main';
    static private $_ROUTE = array( 
        'controller' => '',
        'action'   => '', 
        'id'    => 0, 
        'num'   => 0,
    );
    /** 
    * Конструктор класса
    * Class construct
    * @param 
    * @return boolean 
    */ 
    function __construct(){
        
    }
    /** 
    * Функция записи кукисов пользователя
    * Functio set user cookies
    * @param $module - модуль, если маршрутизация происходит вручную
    * @param $controller - контроллер, если маршрутизация происходит вручную
    * @return boolean 
    */ 
    static public function startRoute($module=NULL, $controller=NULL) 
    { 
        //dbg($_GET['route']);
        if(!empty($module) && !empty($controller)){
            self::$_module = $module;
            self::$_controller = "_".trim(str_replace('-', '_', $controller),'_');
        }
        else{            
            if(!empty($_GET['route'])){
                self::setUrlPath();
                $route = explode('/', trim($_GET['route'], '/'));
                if($route[0]==='admin'){
                    self::$_module=$route[0];
                    if(!empty($route[1])) {
                        self::$_controller = "_".trim(str_replace('-', '_', $route[1]),'_');
                    }
                    $i = 2;
                    foreach(self::$_ROUTE as $var => $val) 
                    { 
                        if(!empty($route[$i])) 
                            self::$_ROUTE[$var] = $route[$i];
                        ++$i;    
                    } 
                }
                else{
                    if(!empty($route[0])) {
                        
                        $i = 0;
                        $controller_tmp = "";
                        foreach(self::$_ROUTE as $var => $val) 
                        {                             
                            if(!empty($route[$i])) {
                                // Проверяем, существует ли каталог с роутером
                                $controller_tmp.= "/"."_".trim(str_replace('-', '_', $route[$i]),'_');
                                if (is_dir(self::$_module.$controller_tmp)) {
                                    self::$_controller = $controller_tmp;
                                }
                                elseif($i===0){
                                    self::$_controller = self::DEFAULT_CONTROLLER;
                                }
                                self::$_ROUTE[$var] = $route[$i];
                            }                                
                            ++$i;    
                        }
                    }                    
                }
            }            
        }
        $content = "";
        try {
            ob_start();
            include self::getControllerRouter();
            $content = ob_get_contents();
            ob_end_clean();
        } catch (ExceptionFiles $ef) {
            $ef->HandleExeption();
            self::routeErrorPage404();
        } 
        //include AS_ROOT .'skins/tpl/'.self::$_controller.'/index.tpl';
        return $content;
    }    
    /** 
    * Функция подключает необходимый контроллер
    * Functio get controller
    * @param 
    * @return boolean 
    */ 
    static public function getControllerRouter() 
    { 
        $controller_router_file = "";
        $controller_router="";
        if(strlen(trim(self::$_module))>0){
            $controller_router .= self::$_module."/";
        }
        if(strlen(trim(self::$_controller))>0){
            $controller_router .= self::$_controller."/";
        }        
        $controller_router .="router.php";
        $controller_router_file = AS_ROOT.strtolower($controller_router);
        if(file_exists($controller_router_file)){
            return $controller_router_file;
        }
        else{
            //self::routeErrorPage404();
            throw new ExceptionFiles("Файл контроллера не найден: ".$controller_router_file);
        }        
    }    
    /** 
    * Функция подключает название контроллера
    * Functio get controller name
    * @param 
    * @return boolean 
    */ 
    static public function getController() 
    {         
        return self::$_controller;            
    }    
    /** 
    * Функция подключает необходимый контроллер
    * Functio get controller
    * @param 
    * @return boolean 
    */ 
    static public function getErrorControllerRouter() 
    { 
          $controller_router_file = AS_ROOT.self::ERROR_CONTROLLER_ROUTER;
          return $controller_router_file;
    }
    /** 
    * Функция получает url_path, щапрошенной страницы
    * Functio get page url_path
    * @param 
    * @return boolean 
    */ 
    static public function setUrlPath() 
    { 
        if(!empty($_GET['route']) && empty(self::$_url_path)){
            self::$_url_path=trim($_GET['route'], '/');
        }
    }   
    /** 
    * Функция получает url_path, щапрошенной страницы
    * Functio get page url_path
    * @param 
    * @return boolean 
    */ 
    static public function getUrlPath(){ 
        if(empty(self::$_url_path)){
            self::setUrlPath();
        }        
        return self::$_url_path;
    }   
    /** 
    * Функция получает action
    * Functio get action
    * @param 
    * @return boolean 
    */ 
    static public function getUrlController(){                 
        return self::$_ROUTE['controller'];
    }   
    /** 
    * Функция получает action
    * Functio get action
    * @param 
    * @return boolean 
    */ 
    static public function getAction(){                 
        return self::$_ROUTE['action'];
    }    
    /** 
    * Функция перенаправления на страницу 404
    * function route to 404 page
    * @param 
    * @return string 
    */ 
    static public function routeAccessDenied(){ 
        header('HTTP/1.1 404 Not Found');
        //header("Status: 404 Not Found");
        header('Location:'.AS_HOST.'access_denied.html');
        exit();
    }   
    /** 
    * Функция перенаправления на страницу 404
    * function route to 404 page
    * @param 
    * @return string 
    */ 
    static public function routeErrorPage404(){ 
        header('HTTP/1.1 404 Not Found');
        //header("Status: 404 Not Found");
        header('Location:'.AS_HOST.'404.html');
        exit();
    }   
    /**  
    * Function of Redirections  
    * Функция перенаправления  
    */       
    static public function reDirect()  
    {   
        $host = AS_HOST;  
        $url_path = self::getUrlPath();       
        $host .=$url_path;
        header('location: '. $host);  
        exit(); // Останавливаем скрипт  
    }
}