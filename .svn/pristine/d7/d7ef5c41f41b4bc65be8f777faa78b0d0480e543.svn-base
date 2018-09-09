<?php
/*   
* libs/classes/ExceptionDataBase.class.php 
* File of extended Exeption classes  
* Файл расширенного класса исключений
* @author Dulebsky A. 05.09.2014   
* @copyright © 2014 ArtSide   
*/
/** 
* Класс для обработки исключений базы данных
* Class db exeption
*/ 
class ExceptionDataBase extends Exception
{
    function HandleExeption($error_file="",$error_func=""){
        // отсылаем содержимое ошибки на email админа
        $e=$this;
        $body="
            <p>Ошибка была вызвана на странице: ".$_SERVER['REQUEST_URI']."</p>
            <p>Функцией: ".$error_file."->".$error_func."</p>
            <p>Подробности ошибки:</p>";
        do {
            $body.="
                <p>--------".$e->code."-----------</p> \n
                <p>".$e->message."</p> \n
                <p>File: ".$e->file."</p> \n
                <p>Line: ".$e->line."</p> \n
                <p>---------------------</p> \n
                    ";
        }
        while($e = $e->getPrevious());
        $mail = new Mailer('exeption');
        $mail->sendExeption($body);
        // логирование
        ouputLogFile("mysql.log", "Ошибка при работе с базой данных", $body);
    }
    function GetNoticeExeption($type){
        // Вывод сообщения пользователям
        $notice_arr=array(      
            "error"=>"                
                <div id='modal_dialog_notice'>                    
                    В настоящее время ведутся работы! Попробуйте позже!
                </div>",
            "save_error"=>"  
                <div id='modal_dialog_header'>Ошибка</div>
                <div id='modal_dialog_notice'>                    
                    В процессе сохранении информации произошла ошибка! Обратитесь к администратору системы
                </div>",
            "delete_error"=>"  
                <div id='modal_dialog_header'>Ошибка</div>
                <div id='modal_dialog_notice'>                    
                    В процессе удаления произошла ошибка! Обратитесь к администратору системы
                </div>"            
            );
        return $notice_arr[$type];
    }
}