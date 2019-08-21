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
class Mailer{
    private $_content_type = "text/html";
    private $_to;
    private $_to_admin = "support@artside.su";
    private $_from = "no-reply";
    private $_sendgrid_api = "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";
    /** 
    * Конструктор класса
    * Class construct
    * @param 
    * @return boolean 
    */ 
    function __construct($from=null, $to=null){
        if (!empty($from)) $this->_from = $from;
        if (!empty($from)) $this->_to = $to; 
    }
    /** 
    * Функция установки получателя
    * Functio set to
    * @param $to
    * @return boolean 
    */ 
    public function setTo($to) 
    { 
        $this->_to = $to;
        return true; 
    } 
    /** 
    * Функция установки отправителя
    * Functio set from
    * @param $from
    * @return boolean 
    */ 
    public function setFrom($from) 
    { 
        $this->_from = $from;
        return true; 
    } 
    /** 
    * Функция создания заголовокв
    * Functio create header
    * @param 
    * @return boolean 
    */ 
    private function createHeaders() 
    { 
       $headers  = "Content-type: text/html; charset=utf-8 \r\n";
       $headers .= "From: ".$this->_from."<".$this->_from."@".AS_DOMAIN.">\r\n";      
       $headers .= "Bcc: dulebsky@gmail.com\r\n";
       
       return $headers; 
    } 
    /** 
    * Функция создания тела письма
    * Functio create e-mail body
    * @param 
    * @return boolean 
    */ 
    private function createBody($mail_body) 
    { 
        $body="
            <html>        
                <body>
                    <table width='640' border='0' cellspacing='20' cellpadding='0' bgcolor='e4e4e4'>
                        <tbody>
                            <tr>
                                <td valign='top'>
                                    <table width='600' border='0' cellspacing='20' cellpadding='0' bgcolor='FFFFFF'>
                                        <tbody>
                                            <tr>
                                                <td valign='top'>
                                                <table width='560' border='0' cellspacing='0' cellpadding='0'>
                                                    <tr>
                                                        <td width='172'>
                                                            <img src='http://".AS_DOMAIN."/skins/img/header/logo.png' />
                                                        </td>
                                                        <td width='188'>&nbsp;</td>
                                                        <td>
                                                        <table width='200' border='0' cellspacing='0' cellpadding='0'>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p style='color:#555555; font-size:16px; font-family:Arial,sans-serif;'>info@".AS_DOMAIN."</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height='40'>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td valign='top'>                                                
                                                    ".$mail_body."                                        
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height='20'>&nbsp;</td>
                                            </tr>                                            
                                            <tr>
                                                <td height='40'>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td valign='top'>
                                                    <p style='color:#555555; font-size:16px; font-family:Arial,sans-serif;'>С уважением, команда ".AS_COMPANY."</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table width='600' border='0' cellspacing='0' cellpadding='20' bgcolor='464444'>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <p style='color:#efefef; font-size:12px; font-family:Arial,sans-serif;'> &copy; ".date('Y')." ".AS_COMPANY."</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table width='640' border='0' cellspacing='20' cellpadding='0' bgcolor='e4e4e4'>
                        <tbody>
                            <tr>
                                <td>
                                    <p style='color:#555555; font-size:16px; font-family:Arial,sans-serif;'>Вы получили это письмо, так как Вы зарегистрированы в системе \"".AS_SYSTEM_NAME."\". </p>                           
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </body>
            </html>";       
        return $body; 
    } 
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
    /** 
    * Функция отправки обычного письма
    * Functio send mail to e-mail
    * @param 
    * @return boolean 
    */ 
    protected function sendMail($subject, $mail_body) 
    { 
        /*
        $to      = $this->_to;
        $subject = $subject;
        $message = $this->createBody($mail_body);
        $headers = $this->createHeaders();

        mail($to, $subject, $message, $headers);  
         * 
         */
        require(AS_ROOT ."libs/sendgrid-php/sendgrid-php.php");
        $sendgrid = new SendGrid($this->_sendgrid_api);
        $email = new SendGrid\Email();
        $email
            ->addTo($this->_to)
            //->addTo('bar@foo.com') //One of the most notable changes is how `addTo()` behaves. We are now using our Web API parameters instead of the X-SMTPAPI header. What this means is that if you call `addTo()` multiple times for an email, **ONE** email will be sent with each email address visible to everyone.
            ->setFrom($this->_from."@".AS_DOMAIN)
            ->setSubject($subject)
            ->setHtml($this->createBody($mail_body))
        ;
        $sendgrid->send($email);     
    }
    /** 
    * Функция создания тела письма
    * Function create e-mail body
    * @param 
    * @return boolean 
    */ 
    public function sendExeption($mail_body) 
    { 
        $to      = $this->_to;
        $subject = "Исключение на ".AS_DOMAIN;
        $message = $this->createBody($mail_body);
        $headers = $this->createHeaders();

        mail($to, $subject, $message, $headers);  
    }
    /** 
    * Функция для отправки уведомлений о новой заявки
    * Function send notice about new  order
    * @param 
    * @return boolean 
    */ 
    function sendNewOrderNotice($order_info, $user_info, $parent_user_info){
        $subject = "Добавлена новая заявка";        
        $mail_body= "        
            <p style='color:#555555; font-size:16px; font-family:Arial,sans-serif;'><strong>Сотрудник, добавивший заявку: ". $user_info['fam'] ." ". $user_info['name'] ." ". $user_info['patronymic'] ."</strong></p>
            <p style='color:#555555; font-size:16px; font-family:Arial,sans-serif;'>Моб. телефон агента: ". $user_info['phone'] ." </p>
            <p></p>
            <p style='color:#555555; font-size:16px; font-family:Arial,sans-serif;'>Руководитель: ". $parent_user_info['fam'] ." ". $parent_user_info['name'] ." ". $parent_user_info['patronymic'] ."</strong></p>        
            <p style='color:#555555; font-size:16px; font-family:Arial,sans-serif;'>------------------------------------</p>
            <p style='color:#555555; font-size:16px; font-family:Arial,sans-serif;'>Дата и время добавления заявки:".  formatDate($order_info['date'])."</p>
            ";
        $this->sendMail($subject, $mail_body);
        return true;
    }
    /** 
    * Функция для отправки уведомлений руководителям агента о новом запросе с сайта 
    * Function send notice about new request from site to parent agent
    * @param string $name, int $user_id, string $hash
    * @return boolean 
    */ 
    function sendOrderStatusNotice($status, $notice_mails, $order_info, $agent_info, $parent_agent_info){
        include_once AS_ROOT .'libs/default.php';
        $subject = "Информация по заявке № ".$order_info['order_id'];
        switch ($status){
            case 'request_handled':
                $mail_body = "
                    <h1 style='color:#555555; font-size:20px; font-family:Arial,sans-serif;' >Заявка № ".$order_info['order_id']." успешно обработана</h1>";
                $headers = getMailHeaders("order_info","order_info");
            break; 
            case 'in_action':
                $mail_body = "
                    <h1 style='color:#555555; font-size:20px; font-family:Arial,sans-serif;' >Заявка № ".$order_info['order_id']." взята в работу</h1>";
                $headers = getMailHeaders("order_info","order_info");
            break;
            case 'transfer':
                $mail_body = "
                    <h1 style='color:#555555; font-size:20px; font-family:Arial,sans-serif;' >Перевод заявки № ".$order_info['order_id']." </h1>";
                $headers = getMailHeaders("order_transfer","order_transfer");
            break;
            default:    
            break; 
        }

        $mail_body.= "        
            <p style='color:#555555; font-size:16px; font-family:Arial,sans-serif;'><strong>Агент: ". $agent_info['fam'] ." ". $agent_info['name'] ." ". $agent_info['patronymic'] ."</strong></p>
            <p style='color:#555555; font-size:16px; font-family:Arial,sans-serif;'>Моб. телефон агента: ". $agent_info['phone'] ." </p>
            <p></p>
            <p style='color:#555555; font-size:16px; font-family:Arial,sans-serif;'>Руководитель агента: ". $parent_agent_info['fam'] ." ". $parent_agent_info['name'] ." ". $parent_agent_info['patronymic'] ."</strong></p>        
            <p style='color:#555555; font-size:16px; font-family:Arial,sans-serif;'>------------------------------------</p>
            <p style='color:#555555; font-size:16px; font-family:Arial,sans-serif;'>На обработку заявки отведено 5 минут.</p>
            <p style='color:#555555; font-size:16px; font-family:Arial,sans-serif;'>Дата и время поступления заявки:".  formatDate($order_info['date'])."</p>
            ";
        $message = getOrderMailTemplate($mail_body);

        mail($notice_mails, $subject, $message, $headers); 
        return true;
    }
}