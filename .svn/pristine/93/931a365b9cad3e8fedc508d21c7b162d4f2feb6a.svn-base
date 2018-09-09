<?php
/*   
* libs/classes/ExceptionFiles.class.php 
* File of extended Exeption classes  
* Файл расширенного класса исключений
* @author Dulebsky A. 13.06.2015   
* @copyright © 2015 ArtSide   
*/
/** 
* Класс для обработки исключений связанных с файлами
* Class files exeption
*/ 
class ExceptionFiles extends Exception
{
    function HandleExeption(){
        $e=$this;
        $body="
            <p>Ошибка при работе с файлами</p>
            <p>Ошибка была вызвана на странице: ".$_SERVER['REQUEST_URI']."</p>
            <p>Подробности ошибки:</p>";
        do {
            $body.="
                <p>--------".$e->code."-----------</p> \n
                <p>".$e->message."</p> \n
                <p>File: ".$e->file."</p> \n
                <p>Line: ".$e->line."</p> \n
                <p>Trace: ".$e->getTraceAsString()."</p> \n
                <p>---------------------</p> \n
                    ";
        }
        while($e = $e->getPrevious());
        $mail = new Mailer('exeption');
        $mail->sendExeption($body);
    }
    function GetFileNoticeExeption($type){
        // Вывод сообщения пользователям
        $notice_arr=array(            
            "del_error"=>"
                <div id='modal_dialog_header'>Ошибка удаления изображения</div>
                <div id='modal_dialog_notice'>В процессе удаления изображения возникла ошибка! Обратитесь к администратору сайта</div>",
            "empty_file"=>"Передан пустой файл"
            );
        return $notice_arr[$type];
    }
}