<?php
/*   
* libs/classes/User.class.php 
* File of the user class  
* Файл класса пользователя 
* @author Dulebsky A. 07.06.2015   
* @copyright © 2015 ArtSide   
*/
/** 
* Класс для отправки e-mail письма с задаваемыми параметрами
* Class for send e-mail with some parameters 
* @param string $title, string $str_body, array $mail
* @return boolean 
*/ 
class Users{
    static private $_user_fam;
    static private $_user_name;
    static private $_user_type_id;
    static private $_user_mail;
    static private $_cookie_domain = AS_DOMAIN;
    static private $cookie_user_id=0;
    static private $cookie_user_temp_id=0; 
    static private $_users_array = array();
    private static $instance;
    
    
    /** 
    * Конструктор класса
    * Class construct
    * @param 
    * @return boolean 
    */ 
    private function __construct(){
        
    }
        /** 
    * Функция записи кукисов пользователя
    * Functio set user cookies
    * @param 
    * @return boolean 
    */ 
    static public function setUserCookies($user_id, $temp_id="") 
    { 
        if($user_id){ 
            self::$cookie_user_id = $user_id; 
            setcookie ("user_id", self::$cookie_user_id, time()+60*60*24, "/", AS_DOMAIN);            
        }
        if($temp_id){
            self::$cookie_user_temp_id = $temp_id;    
            setcookie ("temp_id", self::$cookie_user_temp_id, time()+60*60*24, "/", AS_DOMAIN);
        } 
    } 
    /** 
    * Функция получения кукисов пользователя
    * Functio get user cookies
    * @param 
    * @return boolean 
    */ 
    static private function getCookies() 
    { 
        self::$cookie_user_id = check_form(isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : ''); 
        self::$cookie_user_temp_id =  check_form(isset($_COOKIE['temp_id']) ? $_COOKIE['temp_id'] : '');
    } 
    /** 
    * Функция получения $cookie_user_id
    * Functio get $cookie_user_id
    * @param 
    * @return boolean 
    */ 
    static public function getCookieUserId() 
    { 
        if(!self::$cookie_user_id) self::getCookies();
        return self::$cookie_user_id;
    } 
    /** 
    * Функция получения $cookie_user_id
    * Functio get $cookie_user_id
    * @param 
    * @return boolean 
    */ 
    static function getCookieUserTempId() 
    { 
        if(!self::$cookie_user_temp_id) self::getCookies();
        return self::$cookie_user_temp_id;        
    } 
    /** 
    * Функция инициализации переменных пользователя
    * Functio set user var's
    * @param 
    * @return boolean 
    */ 
    static public function setUserInfo($user_info=  array() ){
        if(isset($user_info['name'])) self::$_user_name = $user_info['name'];
        if(isset($user_info['fam'])) self::$_user_fam = $user_info['fam'];
        if(isset($user_info['as_lk_users_type_id'])) self::$_user_type_id = $user_info['as_lk_users_type_id'];
        if(isset($user_info['mail'])) self::$_user_mail = $user_info['mail'];
    }
    /** 
    * Функция получения информации о пользователе
    * Functio get user info
    * @param 
    * @return boolean 
    */ 
    static public function getUserInfo($user_info=  array() ){
        if(!self::$cookie_user_id) self::getCookies();  
        $user_arr = DB::getTableArray(AS_DATABASE,'lk_users', self::$cookie_user_id, '`as_lk_users_type_id`,`name`, `fam`, `mail`');
        if(!empty($user_arr)){
            self::$_user_fam = $user_arr['fam'];
            self::$_user_name = $user_arr['name'];
            self::$_user_type_id = $user_arr['as_lk_users_type_id'];
            self::$_user_mail = $user_arr['mail'];
        }
        return $user_arr;
    }
    /** 
    * Функция получения типа пользователя
    * Functio get user type
    * @param 
    * @return boolean 
    */ 
    static function getUserType() 
    { 
        if(!self::$cookie_user_id) self::getCookies();        
        if(!self::$_user_type_id){
            $user_arr = self::getUserInfo();   
        }
        return self::$_user_type_id;        
    }     
    /** 
    * Функция получения e-mail адреса пользователя
    * Functio get user mail
    * @param 
    * @return boolean 
    */ 
    static public function getUserMail(){
        if(!self::$cookie_user_id) self::getCookies();
        if(!self::$_user_mail){
            $user_arr = self::getUserInfo();
        }
        return self::$_user_mail;
    }
    /** 
    * Функция получения e-mail адреса пользователя
    * Functio get user mail
    * @param 
    * @return boolean 
    */ 
    static public function getUserName(){
        if(!self::$cookie_user_id) self::getCookies();
        if(!self::$_user_name){
            $user_arr = self::getUserInfo();
        }
        return self::$_user_name;
    }
    /** 
    * Функция получения $cookie_user_id
    * Functio get $cookie_user_id
    * @param 
    * @return boolean 
    */ 
    static public function getUserFIO() 
    { 
        $user_fio="";
        if(!self::$cookie_user_id) self::getCookies();       
        if(!self::$_user_fam || !self::$_user_name){
            $user_arr = self::getUserInfo();          
        }
        $user_fio=self::$_user_fam." ".self::$_user_name;     
        return $user_fio;
    } 
    /** 
    * Функция получения ФИО по id пользователю
    * Functio get FIO by id
    * @param 
    * @return boolean 
    */ 
    static public function getUserFIOById($user_id=0) 
    { 
        $user_fio="";      
        if($user_id*1>0){
            $user_info = DB::getTableArray(AS_DATABASE,'lk_users', $user_id, '`fam`, `name`, `patronymic`'); 
            if(!empty($user_info)){
                $user_fio=$user_info['fam']." ".$user_info['name']." ".$user_info['patronymic']; 
            }
        }        
        return $user_fio;
    } 
    /** 
    * Функция получения масиива пользователей
    * Functio get user array
    * @param 
    * @return boolean 
    */ 
    static public function getUserArray() 
    { 
        if(empty(self::$_users_array)){
            $users_array=array();
            try{
                $res = DB::mysqliQuery(AS_DATABASE,"
                    SELECT 
                        `id`, `name`, `fam`, `patronymic`
                    FROM 
                        `". AS_DBPREFIX."lk_users` 
                ");            
                if($res->num_rows>0){
                    while ($row=  $res->fetch_assoc()){
                        $users_array[$row['id']]=$row['fam']." ".$row['name']." ".$row['patronymic'];
                    }
                }                
            }
            catch (ExceptionDataBase $edb){
                throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
            }  
            self::$_users_array = $users_array;
        }
        return self::$_users_array;
    } 
    /** 
    * Функция очистки кукисов пользователя
    * Functio clear user cookies
    * @param 
    * @return boolean 
    */ 
   static function clearCookies() 
    { 
        self::$cookie_user_id = 0; 
        self::$cookie_user_temp_id =  0;
        setcookie ("user_id", "", time()-3600, "/", AS_DOMAIN);
        setcookie ("temp_id", "", time()-3600, "/", AS_DOMAIN);
    }
    /* 
    * Функция получения настоящего ip адреса пользователя
    * The function get the real ip address of user
    * @param  
    * @return string 
    */ 
    static function getUserIp(){
        $ip="";
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) 
        {
            $ip=$_SERVER["HTTP_CLIENT_IP"];
        }
        elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
        {
            $ip=$_SERVER["HTTP_X_FORWARDED_FOR"];
        }
            else
        {
            $ip=$_SERVER["REMOTE_ADDR"];
        }
        return $ip;
    }
    /*
    * Function for authorization  
    * Функция авторизации пользователя
    * @param  
    * @return bool 
    */ 
    static function authorizationUser($login, $password){
        if(isset($login) && isset($password)){
            // соль
            $salt="as_salt";
            $login = (isset($login)) ? check_form($login) : '';
            $password = (isset($password)) ? check_form($password) : '';
            $auth_error="";
            try{
                $res = DB::mysqliQuery(AS_DATABASE,"
                    SELECT 
                        `id`,`password`, `name`, `fam`, `as_lk_users_type_id`, `mail`   
                    FROM 
                        `". AS_DBPREFIX."lk_users` 
                    WHERE `login`='".$login."'  
                ");            
                if($res->num_rows>0){
                    $row=  $res->fetch_assoc();                     
                    if ($row['password'] == md5(md5(trim($password)).$salt)){             
                        $tmp_id=time();
                        $res_insert = DB::mysqliQuery(AS_DATABASE,"
                            UPDATE 
                                `". AS_DBPREFIX."lk_users`
                                SET `temp_id`='".$tmp_id."', `user_ip`='".self::getUserIp()."'
                                WHERE `login`='".$login."'  
                            ");   
                        self::setUserInfo($row); 
                        self::setUserCookies($row['id'], $tmp_id);  
                        Router::reDirect();
                    }
                    else{
                        if(strlen(trim($login))!=0 || strlen(trim($password))!=0 ){
                            $auth_error="Не верный логин или пароль";
                        }
                    }
                } 
                else{
                    if(strlen(trim($login))>0)
                        $auth_error="Пользователя с таким адресом e-mail не существует";
                }
            }
            catch (ExceptionDataBase $edb){
                throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
            }
        }        
        return $auth_error;
    }
    /*
    * Function checks the authorization  
    * Функция проверки авторизации 
    * @param  
    * @return bool 
    */ 
    static function checkUserAut(){
        $user_ip = self::getUserIp();
        self::getCookies();
        if(self::$cookie_user_id>0 && self::$cookie_user_temp_id>0){
            try{
                $res = DB::mysqliQuery(AS_DATABASE,"
                    SELECT 
                        `temp_id`, `user_ip`, `name`, `fam`, `as_lk_users_type_id`, `mail`
                    FROM 
                        `".AS_DBPREFIX."lk_users`
                    WHERE 
                        `id`='".self::$cookie_user_id."' AND `active`=1
                    LIMIT 1 "  
                        );
            }
            catch (ExceptionDataBase $edb){
                throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
            }
            if($res->num_rows>0){
                $row=  $res->fetch_assoc(); 
                if($row['temp_id'] == self::$cookie_user_temp_id && $row['user_ip']==$user_ip){ 
                    self::setUserInfo($row);
                    return true;            
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }        
        }
        else{
            return false;
        }
    }   
    /*
    * Function check user registration
    * Функция проверки регистрации пользователя 
    * @param  
    * @return bool 
    */ 
    static function checkUserRegistration($user_id, $hash){
        $user_arr = DB::getTableArray(AS_DATABASE,'lk_users', $user_id, '`hash`,`name`, `fam`, `mail`');
        if(!empty($user_arr)){
            if($user_arr['hash']==$hash){
                self::setUserInfo($user_arr);
                self::setUserCookies($user_id);
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }     
    /*
    * Function check the page user access   
    * Функция проверки доступа пользователя к странице
    * @param  
    * @return bool 
    */ 
    static function checkUserAccess($content_id=0){        
        $res= DB::mysqliQuery(AS_DATABASE,"
                SELECT 
                    `id`             
                FROM
                    ". AS_DBPREFIX ."access
                WHERE 
                    as_lk_users_type_id='".  check_form(self::getUserType())."' AND as_content_id=".check_form($content_id)." " 
        );      
        if($res->num_rows>0)        return TRUE;
        else        return FALSE ;
    }  

}