<?php
/*   
* /libs/mysqli.php 
* File of MySql functions 
* Файл работы с базой данных 
* @author ArtSide Dulebsky A. 15.08.2012    
* @copyright © 2012 ArtSide   
*/
/**   
* Connection and installation of chaeset of connection 
* Подключение и установка кодировок соединения  
*/
/*
$mysqli = new mysqli(AS_DBSERVER, AS_DBUSER, AS_DBPASSWORD, AS_DATABASE);
if ($mysqli->connect_errno) {  
    throw new ExceptionDataBase("Не удалось подключиться к базе данных");
}
$mysqli->query('SET NAMES utf8');          
$mysqli->query('SET CHARACTER SET utf8');  
$mysqli->query('SET COLLATION_CONNECTION="utf8_general_ci"');
*/
class DB{ 
    //const HOST = "localhost";
    const HOST = "localhost";
    const USER = "u0096_artside";
    const PASS = "ghV8k16#";
    private static $_database;

    public static $mysqli;
    public $sql;

    function __construct($database, $host=null, $user=null, $pass=null) {        
    }
    public static function mysqliConnect($database){
        if (!empty($database)) self::$_database = $database;
        self::$mysqli = new mysqli(self::HOST,  self::USER,  self::PASS, self::$_database);
        if (!self::$mysqli) {
            throw new Exception("Не возможно подключиться к базе данных");
        }
        self::$mysqli->query('SET NAMES utf8');          
        self::$mysqli->query('SET CHARACTER SET utf8');  
        self::$mysqli->query('SET COLLATION_CONNECTION="utf8_general_ci"');
    }
    public static function mysqliSelectDB($database){
        if (!empty($database)) self::$_database = $database;
        if ( !self::$mysqli ){ 
            self::$mysqli = self::mysqliConnect($database);
        }
        self::$mysqli->select_db(self::$_database);
    }
    public static function mysqliQuery($database, $sql) {
        if ( !self::$mysqli ){
            self::$_database = $database;
            self::mysqliConnect(self::$_database);
        }
        elseif(!(self::$_database===$database)){
            self::$_database = $database;
            self::mysqliSelectDB(self::$_database);
        }        
        $result = self::$mysqli->query($sql);
        if ($result === false) {
            throw new ExceptionDataBase("Ошибка в запросе к базе данных: ".self::$mysqli->error."<br/>\n Запрос:".$sql, 1);            
        }
        //$mail = new Mailer('info','dulebsky@mail.ru');
        //$mail->sendMail('Запрос к БД', $sql);
        return $result;        
    }
    public static function mysqliBegin($database) {
        if ( !self::$mysqli ){
            self::$_database = $database;
            self::mysqliConnect(self::$_database);
        }
        elseif(!(self::$_database===$database)){
            self::$_database = $database;
            self::mysqliSelectDB(self::$_database);
        }        
        $result = self::$mysqli->autocommit(FALSE);
        if ($result === false) {
            throw new ExceptionDataBase("Ошибка в запросе к базе данных: ".self::$mysqli->error."<br/>\n Запрос:".$sql, 1);            
        }
        return $result;        
    }
    public static function mysqliCommit() {        
        self::$mysqli->commit();
     
    }
    public static function mysqliRollback() {   
        self::$mysqli->rollback();
      
    }
    /** 
    * Функция получения массива данных из определенной таблицы
    * function get data array from table
    * @param string $table - таблица
    * @param int $table_id - id строки
    * @return array $table_arr 
    */ 
    public static function getTableArray($database, $table, $table_id=0, $pole_name=""){
        $table_arr=array();
        $query="*";
        if(strlen(trim($pole_name))>0){
            $query=$pole_name;
        }
        if($table_id*1>0){
            try{
                $res = self::mysqliQuery($database,"
                        SELECT 
                            ".check_form($query)."  
                        FROM 
                            `". AS_DBPREFIX .check_form($table)."` 
                        WHERE 
                            `id`='".check_form($table_id)."' "  
                        );
            }
            catch (ExceptionDataBase $edb){
                throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
            } 
            if($res->num_rows>0){
                $table_arr=  $res->fetch_assoc();
            }
        }
        else{
            try{
                $res = self::mysqliQuery($database,"SHOW COLUMNS   
                        FROM `". AS_DBPREFIX . $table."` "  
                        );
            }
            catch (ExceptionDataBase $edb){
                throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
            } 
            while ($row=  $res->fetch_array())
            {
                $table_arr[$row[0]]="";
            }        
        }
        return $table_arr;
    }
    /** 
    * Функция получения 2-х мерного массива всех данных из определенной таблицы
    * function get 2d data array from table
    * @param string $table - таблица
    * @param int $pole_name - название поля
    * @return array $table_arr 
    */ 
    public static function getTableDataArray($database, $table, $pole_name=""){
        $table_arr=array();        
        $table_arr[0]= "";
        try{
            $res = self::mysqliQuery($database,"
                    SELECT 
                        id, ".check_form($pole_name)."  
                    FROM 
                        `". AS_DBPREFIX .check_form($table)."` 
                    ");
        }
        catch (ExceptionDataBase $edb){
            throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
        } 
        if($res->num_rows>0){
            while($row = $res->fetch_array()){
                $table_arr[$row[0]]= $row[1] ;
            }
        }        
        return $table_arr;
    }
    /** 
    * Функция получения значения из связанной таблицы
    * function get value from linked table
    * @param string $table, int $id 
    * @return str $name
    */ 
    public static function getTableValue($database, $table, $pole, $id){
        $val="";
        try{
            $res = self::mysqliQuery($database,"
                SELECT 
                    `".check_form($pole)."`
                FROM 
                    `". AS_DBPREFIX."".check_form($table)."`               
                WHERE 
                    `id`='".check_form($id)."'"  
            ); 
        }
        catch (ExceptionDataBase $edb){
            throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
        } 
        if($res->num_rows>0){
            $row=  $res->fetch_array();
            $val=$row[0];
        }    
        return $val;    
    }
    /** 
    * Функция получения id последнего добавленного элемента
    * function get id of last insert value
    */ 
    public static function getInsertId() {        
        return self::$mysqli->insert_id;
    }  
    /** 
    * Функция получения уведомлений по результатам работы с БД
    * function get DB success exeptions 
    */
    public static function GetSuccessExeption($type){
        // Вывод сообщения пользователям
        $notice_arr=array(
            "success"=>"
                <h3>Информация успешно сохранена</h3>
                <p>                   
                    Вы можете продолжить работу с системой
                <p>",            
            "add_user"=>"
                <h3>Сотрудник успешно добавлен</h3>
                <p>                    
                    Вы можете продолжить работу с системой
                </p>",
            "edit_user"=>"
                <h3>Сотрудник успешно отредактирован</h3>
                <p>                    
                    Вы можете продолжить работу с системой
                </p>",
            "delete_user"=>"
                <h3>Сотрудник успешно удален</h3>
                <p>                    
                    Вы можете продолжить работу с системой
                </p>"  
            );
        return $notice_arr[$type];
    }
}