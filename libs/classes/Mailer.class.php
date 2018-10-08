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
    private $_to_admin = "dulebsky.a@artside.su";
    //private $_to_admin = "dulebsky@mail.ru";
    private $_from = "no-reply";
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
       $headers .= "From: ".$this->_from."@".AS_DOMAIN."<".$this->_from."@".AS_DOMAIN.">\r\n";      
       $headers .= "Bcc: dulebsky@gmail.com\r\n";
       $headers .= "X-Mailer: PHP/".phpversion()."\r\n";
       
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
                                                            <img src='http://".AS_DOMAIN."/skins/img/style/logo.png' />
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
    * Функция отправки обычного письма
    * Functio send mail to e-mail
    * @param 
    * @return boolean 
    */ 
    function sendMail($subject, $mail_body) 
    { 
        /*
        $to      = $this->_to;
        $subject = $subject;
        $message = $mail_body;
        $headers = $this->createHeaders();

        mail($to, $subject, $message, $headers);
         * 
         */      
        require(AS_ROOT ."libs/sendgrid-php/sendgrid-php.php");
        $sendgrid = new SendGrid('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');
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
        /*
        $subject = "Исключение на ".AS_DOMAIN;
        $to      = $this->_to_admin;
        $message = $mail_body;
        $headers = $this->createHeaders();
        
         mail($to, $subject, $message, $headers);
         * 
         */
        $subject = "Исключение на ".AS_DOMAIN;
        require(AS_ROOT ."libs/sendgrid-php/sendgrid-php.php");
        $sendgrid = new SendGrid('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');
        $email = new SendGrid\Email();
        $email
            ->addTo($this->_to_admin)
            //->addTo('bar@foo.com') //One of the most notable changes is how `addTo()` behaves. We are now using our Web API parameters instead of the X-SMTPAPI header. What this means is that if you call `addTo()` multiple times for an email, **ONE** email will be sent with each email address visible to everyone.
            ->setFrom($this->_from."@".AS_DOMAIN)
            ->setSubject($subject)
            ->setHtml($this->createBody($mail_body))
        ;
        $sendgrid->send($email);
    }    
}