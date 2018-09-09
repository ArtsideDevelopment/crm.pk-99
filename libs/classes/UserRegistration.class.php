<?php
/*   
* libs/classes/Mailer.class.php 
* File of the mail class  
* Файл класса для отправки e-mail сообщений  
* @author Dulebsky A. 07.06.2015   
* @copyright © 2015 ArtSide   
*/
/** 
* Класс для отправки e-mail письма с задаваемыми параметрами
* Class for send e-mail with some parameters 
* @param string $title, string $str_body, array $mail
* @return boolean 
*/ 
class UserRegistration extends Mailer{
    
    /** 
    * Функция для подтверждения регистрации пользователя по e-mail
    * Function send e-mail with confirm user 
    * @param string $name, int $user_id, string $hash
    * @return boolean 
    */ 
    public function sendUserConfirmMail($user_id, $name, $hash){
        $subject = "Подтверждение регистрации";
        $mail_body = "
            <h1 style='color:#555555; font-size:20px; font-family:Arial,sans-serif;' >Здравствуйте, ".$name."!</h1>
            <p style='color:#555555; font-size:16px; font-family:Arial,sans-serif;'>На Ваше имя был сформирован запрос о регистрации в системе <strong>\"".AS_SYSTEM_NAME."\"</strong>.</p>
            <p style='color:#555555; font-size:16px; font-family:Arial,sans-serif;'>Для начала работы Вам необходимо пройти регистрацию. Для этого пройдите по ссылке, указанной ниже:</p>            
            <p style='color:#555555; font-size:16px; font-family:Arial,sans-serif;'><a href='http://".AS_DOMAIN."/confirm-registration/?user=".$user_id."&hash=".$hash."'  style='color:#2d88c4;'>подтвердить регистрацию</a></p>
            <p style='color:#555555; font-size:16px; font-family:Arial,sans-serif;'>Если Вы не знаете о чем идет речь, просто проигнорируйте данное письмо</p>
            <p style='color:#555555; font-size:16px; font-family:Arial,sans-serif;'>Желаем успехов!</p>
            ";
        $this->sendMail($subject, $mail_body);
    }
    /** 
    * Функция для отправки письма об успешной регистрации
    * Function send e-mail for user about success confirm registration
    * @param string $name, string $mail
    * @return boolean 
    */ 
    public function sendUserConfirmSuccessMail($name, $mail){
        $subject = "Регистрация прошла успешно";
        $mail_body = "
            <h1 style='color:#555555; font-size:20px; font-family:Arial,sans-serif;' >Здравствуйте, ".$name."!</h1>
            <p style='color:#555555; font-size:16px; font-family:Arial,sans-serif;'>Вы успешно зарегистрированы в системе \"".AS_SYSTEM_NAME."\".</p>            
            <p style='color:#555555; font-size:16px; font-family:Arial,sans-serif;'>Для входа в систему используйте ссылку: <a href='http://".AS_DOMAIN."/'  style='color:#2d88c4;'>".AS_DOMAIN."</a></p>     
            <p style='color:#555555; font-size:16px; font-family:Arial,sans-serif;'>Ваш логин: ".$mail."</p>
            <p style='color:#555555; font-size:16px; font-family:Arial,sans-serif;'>Желаем успехов!</p>
            ";
        $this->sendMail($subject, $mail_body);
    }
}