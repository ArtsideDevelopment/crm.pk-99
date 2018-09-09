<?php
/*   
* libs/exeptions.php 
* File of extended Exeption classes  
* Файл расширенного класса исключений
* @author Dulebsky A. 05.09.2014   
* @copyright © 2014 ArtSide   
*/
/** 
* Функция для обработки глобальных исключений
* Function for gloabal exception handler
* @param Exception $exception
* @return 
*/ 
function globalExceptionHandler($exception) {
      $body="";
      $e=$exception;
      do {
            $body.="
                <p>--------".$e->getCode()."-----------</p> \n
                <p>".$e->getMessage()."</p> \n
                <p>File: ".$e->getFile()."</p> \n
                <p>Line: ".$e->getLine()."</p> \n
                <p>---------------------</p> \n
                    ";
        }
        while($e = $e->getPrevious());
        $mail = new Mailer('exeption');
        $mail->sendExeption($body);                
  }
set_exception_handler('globalExceptionHandler');
