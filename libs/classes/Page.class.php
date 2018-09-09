<?php
/*   
* libs/classes/Page.class.php 
* File of the Page class  
* Файл класса для работы со страницей 
* @author Dulebsky A. 15.06.2015   
* @copyright © 2015 ArtSide   
*/
class Page{    
    private static $_title;
    private static $_content;
    private static $_main_tpl;
    private static $_canonical_url='url';
    private static $_sub_menu_arr=array();
    private static $instance;
    private static $instance_url_path;
    private static $_page_arr=array();
    private static $_access_without_password_set=0;


    /** 
    * Конструктор класса
    * Class construct
    * @param 
    * @return boolean 
    */ 
    private function __construct($url_path){
        $query ="";
        try{
            if(empty($url_path)){
                $query = "`default_set`=1";                
            }
            else{
                $query = "`url_path`='".check_form($url_path)."'";
            }
            $res = DB::mysqliQuery(AS_DATABASE,"
                SELECT *   
                FROM 
                    `". AS_DBPREFIX."content` 
                WHERE 
                    ".$query." 
            "); 
        }
        catch (ExceptionDataBase $edb){
            throw new ExceptionDataBase("Ошибка в стеке запросов к базе данных",2, $edb);
        }
        if($res->num_rows==1){
            $row = $res->fetch_assoc();
            self::$instance_url_path = $url_path;
            self::$_page_arr = $row;
            self::$_title = $row['title'];
            self::$_main_tpl = $row['main_tpl'];
            //self::$_content = $row['content'];
            self::$_access_without_password_set = $row['access_without_password_set'];
        }
        else{
            Router::routeErrorPage404();
        }
    }  
    public static function getInstance($url_path){
        if ( empty(self::$instance) || self::$instance_url_path!=$url_path){
            self::$instance = new Page($url_path);
        }
        return self::$instance;
    }
    /** 
    * Функция проверки доступа к странице без пароля
    * Functio check page access without password
    * @param 
    * @return boolean 
    */ 
    static public function checkAccessWithoutPassword($url_path){                
        if ( empty(self::$instance) || self::$instance_url_path!=$url_path){
            self::$instance = new Page($url_path);
        }
        return self::$_access_without_password_set;
    }
    /** 
    * Функция устанавливает title страницы
    * Functio set page title
    * @param 
    * @return boolean 
    */ 
    static public function setTitle($title){                
        self::$_title = $title;
    } 
    /** 
    * Функция получает title страницы
    * Functio get page title
    * @param 
    * @return boolean 
    */ 
    public function getTitle(){                
        return self::$_title;
    }  
    /** 
    * Функция получает контетнта страницы
    * Functio get page content
    * @param 
    * @return boolean 
    */ 
    public function getContent(){                
        return self::output_decode(self::$_content);
    }    
    /** 
    * Функция получает main_tpl страницы
    * Functio get main_tpl page
    * @param 
    * @return boolean 
    */ 
    public function getMainTpl(){                
        return self::$_main_tpl;
    }
    /** 
    * Функция получает массив с данными о странице
    * Functio get page data array
    * @param 
    * @return boolean 
    */ 
    public function getPageArr(){                
        return self::$_page_arr;
    }   
    /** 
    * Функция получает шаблон страницы
    * Functio get page tpl
    * @param 
    * @return boolean 
    */ 
    public function getId(){      
        if(!empty(self::$_page_arr)){
            return self::$_page_arr['id'];
        }
        else{
            self::$instance = new Page($url_path);
            return self::$_page_arr['id'];
        }        
    }  
    /** 
    * Функция получает canonical url страницы
    * Functio get page canonical url
    * @param 
    * @return boolean 
    */ 
    static public function getCanonicalUrl(){                
        return self::$_canonical_url;
    } 
    /* 
    * Функция создания меню 
    * Function to create menu  
    * @param string $url_path
    * @return string 
    */ 
    public function getMainMenu($url_path=""){
        $mainmenu="";
        $url_path_arr=  explode("/", trim($url_path,"/"));
        $user_type_id= Users::getUserType();
        //Получаем из базы данных все корневые страницы контента
        try{      
            $res = DB::mysqliQuery(AS_DATABASE,"
                        SELECT 
                            ". AS_DBPREFIX ."content.id,
                            ". AS_DBPREFIX ."content.url_path,
                            ". AS_DBPREFIX ."content.menu_icon,
                            ". AS_DBPREFIX ."content.menu_text
                        FROM 
                            ". AS_DBPREFIX ."access
                                 join
                            ". AS_DBPREFIX ."content 
                                on
                            ". AS_DBPREFIX ."access.as_content_id=". AS_DBPREFIX ."content.id 
                        WHERE 
                            ". AS_DBPREFIX ."access.as_lk_users_type_id='".$user_type_id."'  AND 
                            ". AS_DBPREFIX ."content.show_in_menu_set=1 
                        ORDER BY `hierarchy`"                      
            );  
        }
        catch (ExceptionDataBase $edb){
            throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
        }
        if($res->num_rows > 0){ 
            $mainmenu.="<ul>";
            while($row = $res->fetch_assoc())
            {  
                $submenu = self::getSubMenu($row['id'], $url_path);
                $submenu_trigger='';
                if(strlen(trim($submenu))>0){
                    $submenu_trigger='class="submenu_trigger"';
                }
                if($url_path_arr[0]===$row['url_path']){
                    $mainmenu.='
                        <li class="current_section" title="'.$row['menu_text'].'" '.$submenu_trigger.'>
                            <a href="/'.$row['url_path'].'">
                                <span class="menu_icon"><i class="material-icons">'.$row['menu_icon'].'</i></span>
                                <span class="menu_title">'.$row['menu_text'].'</span>
                            </a>
                            '.$submenu.'
                        </li>
                        ';                       
                }
                else{
                    $mainmenu.='
                        <li title="'.$row['menu_text'].'" '.$submenu_trigger.'>
                            <a href="/'.$row['url_path'].'">
                                <span class="menu_icon"><i class="material-icons">'.$row['menu_icon'].'</i></span>
                                <span class="menu_title">'.$row['menu_text'].'</span>
                            </a>
                            '.$submenu.'
                        </li>';                    
                }

            }
            $mainmenu.="</ul>";
        } 
        return $mainmenu;        
    }
    /* 
    * Функция создания под меню админки
    * Function to create sub menu  
    * @param int $parent_id
    * @return string 
    */ 
    public static function getSubMenu($parent_id=0, $url_path=""){
        $submenu=""; 
        $url_path = trim($url_path,"/");
        $url_path_arr=  explode("/", trim($url_path,"/"));
        $user_type=  Users::getUserType();
        //Получаем из базы данных все корневые страницы контента 
        try{    
            $res = DB::mysqliQuery(AS_DATABASE,"
                    SELECT 
                        ". AS_DBPREFIX ."content.url_path,
                        ". AS_DBPREFIX ."content.menu_text
                    FROM 
                        ". AS_DBPREFIX ."access
                             join
                        ". AS_DBPREFIX ."content 
                            on
                        ". AS_DBPREFIX ."access.as_content_id=". AS_DBPREFIX ."content.id 
                    WHERE  
                        ". AS_DBPREFIX ."access.as_lk_users_type_id='".$user_type."'  AND 
                        ". AS_DBPREFIX ."content.show_in_submenu_set=1 AND 
                        ". AS_DBPREFIX ."content.parent_id=".check_form($parent_id)."
                    ORDER BY `hierarchy`"                      
            );  
        }
        catch (ExceptionDataBase $edb){
            throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
        }
        if($res->num_rows > 0){
            $submenu.="<ul>";
            while($row = $res->fetch_assoc())
            {  
                if($url_path===$row['url_path']){
                    $submenu.='<li class="act_item"><a href="/'.$row['url_path'].'">'.$row['menu_text'].'</a></li>';                         
                }
                else{
                    $submenu.='<li><a href="/'.$row['url_path'].'">'.$row['menu_text'].'</a></li>';
                }

            }
            $submenu.="</ul>";
        } 
        return $submenu;
    }
    /* 
    * Функция получения id по url адресу страницы
    * Function get page id by url
    * @param string $url_path
    * @return string 
    */ 
    public function getIdByUrl($url_path=""){
        $id=0;   
        try{  
            $res = DB::mysqliQuery(AS_DATABASE,"
                    SELECT 
                        `id`
                    FROM                     
                        ". AS_DBPREFIX ."content                     
                    WHERE 
                        url_path='".$url_path."' 
                    "                      
            );
        }
        catch (ExceptionDataBase $edb){
            throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
        }
        if($res->num_rows>0){
            $row=  $res->fetch_array();
            $id=$row[0];
        }
        return $id;
    }
    /* 
    * Функция создания хлебных крошек для текущей страницы
    * Function to create bread crumbs to current page
    * @param 
    * @return string $bread_crumbs
    */ 
    public function getBreadCrumbs(){
        $bread_crumbs="<span>".  self::$_page_arr['menu_text']."</span>"; 
        $bread_crumbs= self::getBreadCrumbsRecursion(self::$_page_arr['parent_id'], self::$_page_arr['url_path'], self::$_page_arr['menu_text']).$bread_crumbs;   
        return $bread_crumbs;
    }
    /* 
    * Рекурсивная Функция создания хлебных крошек для текущей страницы
    * Recursion Function to create bread crumbs to current page
    * @param string $parent_id string $url_path string $menu_text
    * @return string $bread_crumbs
    */ 
    public function getBreadCrumbsRecursion($parent_id){ // рекурсивная фугкция         
        if($parent_id==0){     
            $bread_crumbs="<a href='/'>Главная</a><i class='icon-arrow-right'></i>";
            return $bread_crumbs;
        }
        else{
            //Получаем родителя страницы  
            $parent_info = DB::getTableArray(AS_DATABASE,'content', $parent_id, '`parent_id`, `url_path`, `menu_text`');
            $bread_crumbs="<a href='/".$parent_info['url_path']."'>".$parent_info['menu_text']."</a><i class='icon-arrow-right'></i>";
            $bread_crumbs=  self::getBreadCrumbsRecursion($parent_info['parent_id']).$bread_crumbs;
            return $bread_crumbs;       
        }    
    }
    /**  
    * Function of processing of variables for a conclusion in a stream  
    * Функция обработки переменных для вывода в поток   
    */                                                      
    public static function output_decode($data)     
    {     
        if(is_array($data))  // Если данные - массив, вызываем эту же функцию.           
            $data = array_map("output_decode", $data);   
        else  // Если нет, обрабатываем  htmlspecialchars()             
            $data = htmlspecialchars_decode($data);                               
        return $data;  
    }
}