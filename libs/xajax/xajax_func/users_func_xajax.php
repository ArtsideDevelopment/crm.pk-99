<?php
/*   
* libs/xajax/xajax_func/users_func_xajax.php 
* Functions for working with users    
* Функции для работы с пользователями
* @author Dulebsky A. 16.04.2014  
* @copyright © 2014 ArtSide   
*/
/* 
* Функция добавления нового пользователя
* Function to add a new user
* @param array $Id 
* @return xajaxResponse 
*/ 
function Add_User($Id)
{
  $objResponse = new xajaxResponse();
  //require_once(AS_ROOT .'libs/mail_func.php');
  require_once(AS_ROOT .'libs/query_set.php');
  require_once(AS_ROOT .'libs/query_variables/query_user.php'); 
  $all_error="";
   // Подключаем проверку заполнения полей
  include_once AS_ROOT .'libs/check/check_user.php';   
  if($errors==0){   
      // проверяем все входящие переменные на наличие xss и sql инъекции     
      $hash=  md5(time());
      $user_mail=  check_form(trim($Id['login']));
      //$user_type = DB::getTableValue(AS_DATABASE, 'department', 'type', $Id['as_department_id']);
      try{
          $res = DB::mysqliQuery(AS_DATABASE,"
              INSERT INTO   
                `". AS_DBPREFIX ."lk_users` 
              SET 
                   ".m_query($new_user_str, $Id).",                           
                   `active`=0,
                   `mail`='".$user_mail."',
                   `hash`='".$hash."'                           
                    ");  
          $user_id=DB::getInsertId();
          $dialog_msg= DB::GetSuccessExeption('add_user');
      }
      catch (ExceptionDataBase $edb){
          $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
          $dialog_msg = $edb->GetNoticeExeption("save_error");
      } 
      /*
       * Отправка письма с подтверждением 
       * Send mail with confirm
       */
      $name=$Id['name']." ".$Id['patronymic'];      
      $mail = new UserRegistration('no-reply', $user_mail);
      $mail->sendUserConfirmMail($user_id, $name, $hash);
      $objResponse->assign("modal-dialog-notice__replace","innerHTML",  $dialog_msg);
      $objResponse->call("ModalDialog.show('notice')");
  } 
  else{
      $all_error="Проверьте правильность заполнения полей отмеченных *. ";
  }
  $objResponse->assign("all_error","innerHTML", $all_error);
  return $objResponse;
}
/* 
* Функция редактирования пользователя
* Function edit user
* @param array $Id 
* @return xajaxResponse 
*/ 
function Edit_User($Id)
{
  $objResponse = new xajaxResponse();
  //require_once(AS_ROOT .'libs/mail_func.php');
  require_once(AS_ROOT .'libs/query_set.php');
  require_once(AS_ROOT .'libs/query_variables/query_user.php'); 
  $all_error="";
   // Подключаем проверку заполнения полей
  include_once AS_ROOT .'libs/check/check_user.php';   
  if($errors==0){   
      // проверяем все входящие переменные на наличие xss и sql инъекции     
      $user_mail=  check_form(trim($Id['login']));
      $user_id=  check_form(trim($Id['user_id']));
      //$user_type = DB::getTableValue(AS_DATABASE, 'department', 'type', $Id['as_department_id']);
      try{
          $res = DB::mysqliQuery(AS_DATABASE,"
              UPDATE   
                `". AS_DBPREFIX ."lk_users` 
              SET 
                   ".m_query($new_user_str, $Id).",                           
                   `mail`='".$user_mail."'
               WHERE 
                    `id`=".$user_id."
                ");  
          $dialog_msg= DB::GetSuccessExeption('edit_user');
      }
      catch (ExceptionDataBase $edb){
          $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
          $dialog_msg = $edb->GetNoticeExeption("save_error");
      }       
      $objResponse->assign("modal-dialog-notice__replace","innerHTML",  $dialog_msg);
      $objResponse->call("ModalDialog.show('notice')");
  } 
  else{
      $all_error="Проверьте правильность заполнения полей отмеченных *. ";
  }
  $objResponse->assign("all_error","innerHTML", $all_error);
  return $objResponse;
}
/* 
* Функция удаления пользователя
* Function delete user
* @param array $Id 
* @return xajaxResponse 
*/ 
function Delete_User($Id)
{
    $objResponse = new xajaxResponse(); 
    // проверяем все входящие переменные на наличие xss и sql инъекции    
    $user_id = check_form($Id);
    $dialog_msg="";  
    if(strlen(trim($user_id))>0){  
        try{     
          $res = DB::mysqliQuery(AS_DATABASE,"
              DELETE FROM   
                `". AS_DBPREFIX ."lk_users` 
              WHERE                                              
                   `id`=".$user_id."                                        
                    ");
          $dialog_msg= DB::GetSuccessExeption('delete_user');
        }
        catch (ExceptionDataBase $edb){
          $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
          $dialog_msg = $edb->GetNoticeExeption("delete_error");
        } 
        include_once AS_ROOT .'libs/users_func.php';       
        $users_table=  getUsersHierarchyTable(Users::getCookieUserId());
        $objResponse->assign("users_table_replace","innerHTML",  $users_table);
  } 
  else{
      $dialog_msg="<h3>Ошибка!</h3>
              <p>В процессе удаления что-то пошло не так!</p>";
  }
  $objResponse->assign("modal-dialog-notice__replace","innerHTML",  $dialog_msg);
  $objResponse->call("ModalDialog.show('notice')");
  return $objResponse;
}
/* 
* Функция перевода пользователя в архив
* Function make user arhive
* @param array $Id 
* @return xajaxResponse 
*/ 
function User_Make_Arhive($Id)
{
    $objResponse = new xajaxResponse(); 
    // проверяем все входящие переменные на наличие xss и sql инъекции    
    $user_id = check_form($Id);
    $dialog_msg="";  
    if(strlen(trim($user_id))>0){ 
        include_once AS_ROOT .'libs/users_func.php';        
        try{     
            $user_list = getUserActiveRequestsId($user_id);      
            $as_user_parent_select= Users::getUserChildSelect(Users::getCookieUserId());                    
        }
        catch (ExceptionDataBase $edb){
            $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
            $dialog_msg = $edb->GetNoticeExeption("delete_error");            
        } 
        $dialog_msg='
            <form id="UserRequestTransfer" action="javascript:void(null);" class="uk-form-stacked"> 
                <div class="uk-grid form_section">
                    <div class="uk-width-1-1">
                        <input type="hidden" name="user_id" id="user_list" value="'.$user_id.'" /> 
                        <input type="hidden" name="user_list" id="user_list" value="'.$user_list.'" />                        
                        <div class="md-input-wrapper as_select">
                            <h3>Пользователь, которому будут переданы заявки</h3>
                            '.$as_user_parent_select.'
                        </div>                        
                        <div class="md-input-wrapper">
                            <p>&nbsp;</p>
                        </div>
                        <div id="all_error" class="parsley-errors-list"></div>
                        <button type="submit" class="md-btn md-btn-primary" onclick="xajax_User_Request_Transfer(xajax.getFormValues(\'UserRequestTransfer\'));">Передать</button>
                    </div>
                </div>
            </form>'; 
    } 
    else{
        $dialog_msg="<h3>Ошибка!</h3>
              <p>В процессе удаления что-то пошло не так!</p>";      
    }  
    $objResponse->assign("uk-modal-content-replace","innerHTML",  $dialog_msg);
    $objResponse->script("
    var modal = UIkit.modal('#modal_default');
    modal.show();
    ");
  return $objResponse;
}
/* 
* Функция перевода пользователя в активное состояние
* Function make user active
* @param array $Id 
* @return xajaxResponse 
*/ 
function User_Make_Active($Id)
{
    $objResponse = new xajaxResponse(); 
    // проверяем все входящие переменные на наличие xss и sql инъекции    
    $user_id = check_form($Id);
    $dialog_msg="";  
    if(strlen(trim($user_id))>0){  
        try{     
          $res = DB::mysqliQuery(AS_DATABASE,"
              UPDATE   
                `". AS_DBPREFIX ."lk_users` 
              SET
                 `active`=1
              WHERE                                              
                   `id`=".$user_id."                                        
                    ");
        }
        catch (ExceptionDataBase $edb){
            $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
            $dialog_msg = $edb->GetNoticeExeption("delete_error");
            $objResponse->assign("uk-modal-content-replace","innerHTML",  $dialog_msg);
            $objResponse->script("
            var modal = UIkit.modal('#modal_default');
            modal.show();
            ");
        } 
        include_once AS_ROOT .'libs/users_func.php';       
        $users_table=  getUsersHierarchyTable(Users::getCookieUserId());
        $objResponse->assign("users-table-replace","innerHTML",  $users_table);
  } 
  else{
      $dialog_msg="<h3>Ошибка!</h3>
              <p>В процессе удаления что-то пошло не так!</p>";
      $objResponse->assign("uk-modal-content-replace","innerHTML",  $dialog_msg);
        $objResponse->script("
        var modal = UIkit.modal('#modal_default');
        modal.show();
        ");
  }
  
  return $objResponse;
}
/* 
* Функция подтверждения регистрации нового пользователя системы
* Function confirm user registraion
* @param array $Id 
* @return xajaxResponse 
*/ 
function Confirm_Registration($Id)
{
  $objResponse = new xajaxResponse();
  require_once(AS_ROOT .'libs/security.php');
  
  $all_error="";
   // Подключаем проверку заполнения полей
  include_once AS_ROOT .'libs/check/check_confirm_registration.php';   
  if($errors==0){   
      include_once AS_ROOT .'libs/users_func.php'; 
      $salt="as_salt";
      // проверяем все входящие переменные на наличие xss и sql инъекции
      $user_mail=$Id['user_mail'];
      $user_name=$Id['user_name'];
      $password=md5(md5(check_form(trim($Id['password']))).$salt);      
      $hash= check_form($Id['hash']);
      $user_id = check_form($Id['user_id']);
      $dialog_msg="";
      if (Users::checkUserRegistration($user_id, $hash)){
          try{
              $res = DB::mysqliQuery(AS_DATABASE,"
                    UPDATE   
                        `". AS_DBPREFIX ."lk_users` 
                    SET                           
                        `active`=1,
                        `password`='".$password."',
                        `hash`='' 
                    WHERE 
                         `id`='".$user_id."'                           
                    ");  
              $user_id=DB::getInsertId();
              $dialog_msg="
                  <h1>Регистрация успешно завершена!</h1>
                  <p>Вы успешно зарегистрировались в системе \"".AS_SYSTEM_NAME."\"!</p>
                  <p>На Вашу электронную почту отправлено уведомление о регистрации.</p>
                  <p>Теперь Вы можете <a href='http://".AS_DOMAIN."'>войти в систему.</a></p>
                  <p></p>
                  <p>Желаем успехов!</p>";
              /*
              * Отправка письма с подтверждением 
              * Send mail with confirm
              */ 
              $mail = new UserRegistration('no-reply', $user_mail);
              $mail->sendUserConfirmSuccessMail($user_name, $user_mail);
          }
          catch (ExceptionDataBase $edb){
              $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
              $dialog_msg="
                  <h1>Ошибка</h1>
                  <p>В процессе подтверждения регистрации возникла ошибка! Обратитесь в службу поддержки</p>";              
          }             
      }
      else{
          $dialog_msg="Ошибка авторизации";
      }
      $objResponse->assign("login_form","innerHTML",  $dialog_msg);
  } 
  else{
      $all_error="Проверьте правильность заполнения полей отмеченных *. ";
  }
  $objResponse->assign("all_error","innerHTML", $all_error);
  return $objResponse;
}

/* 
* Функция запроса на восстанолвние пароля
* Function to add a new user
* @param array $Id 
* @return xajaxResponse 
*/ 
function Password_Recovery_Request($Id)
{
  $objResponse = new xajaxResponse();
  require_once(AS_ROOT .'libs/security.php');
  include_once AS_ROOT .'libs/users_func.php';
  require_once(AS_ROOT .'libs/mail_func.php');
  $error="";
   // Подключаем проверку заполнения полей  
  if(strlen(trim($Id['mail']))>0){   
      $user_mail=  check_form(trim($Id['mail']));
      $user_arr=  getUserInfo("`id`, `name`, `patronymic` ", "login", $user_mail);
      // проверяем существует ли указанный e-mail в базе данных
      if(!empty($user_arr)){
          // проверяем все входящие переменные на наличие xss и sql инъекции     
          $hash=  md5(time());      
          $res = DB::mysqliQuery(AS_DATABASE,"UPDATE   
                                   `". AS_DBPREFIX ."lk_users` 
                               SET                          
                                   `active`=0,                               
                                   `hash`='".$hash."' 
                               WHERE `mail`='".$user_mail."'
                                "
                          );  
          /*
           * Отправка письма с интсрукцией по восстановлению 
           * Send mail with recovery instruction
           */
          $name=$user_arr['name']." ".$user_arr['patronymic'];      
          sendUserPasswordRecoveryInstructionMail($name, $user_arr['id'], $hash, $user_mail);
          if($res){
              $dialog_msg="
                  <p>В течение 15 минут вы получите на ящик ".$user_mail." письмо с инструкцией по восстановлению пароля.</p>";
          }
          else{
              $dialog_msg="
                  <h2>Ошибка</h2>
                  <p>В процессе восстановления пароля возникла ошибка! Обратитесь в службу тхнической поддержки</p>";
          }
          $objResponse->assign("password_recovery_replace","innerHTML",  $dialog_msg);
      }
      else{
          $error="Указанный e-mail не найден в системе. Обратитесь в службу технической поддержки";
      }
  } 
  else{
      $error="Укажите Ваш e-mail *. ";
  }
  $objResponse->assign("form_error_mail","innerHTML", $error);
  return $objResponse;
}
/* 
* Функция смены пароля пользователя для доступа к системе
* Function change user password for system access
* @param array $Id 
* @return xajaxResponse 
*/ 
function Change_Password($Id)
{
  $objResponse = new xajaxResponse();
  include_once AS_ROOT .'libs/mysql.php';
  require_once(AS_ROOT .'libs/security.php');
  require_once(AS_ROOT .'libs/mail_func.php');
  require_once(AS_ROOT .'libs/form_func.php');
  
  $all_error="";
   // Подключаем проверку заполнения полей
  include_once AS_ROOT .'libs/check/check_confirm_registration.php';   
  if($errors==0){   
      include_once AS_ROOT .'libs/users_func.php'; 
      // проверяем все входящие переменные на наличие xss и sql инъекции
      $password=md5(md5(check_form(trim($Id['password']))));      
      $hash= check_form($Id['hash']);
      $user_id = check_form($Id['user_id']);
      $user_arr=  getUserInfo("`name`, `patronymic`, `login` ", "id", $user_id);
      if (checkUserRegistration($user_id, $hash)){
          $res = mysqlQuery("UPDATE   
                               `". AS_DBPREFIX ."lk_users` 
                           SET                           
                               `active`=1,
                               `password`='".$password."',
                               `hash`='' 
                           WHERE 
                               `id`='".$user_id."'
                            "
                      );  
      }      
      /*
       * Отправка письма об успешной смене пароля
       * Send mail with information about success of change password
       */     
      $user_name=$user_arr['name']." ".$user_arr['patronymic'];
      sendUserPasswordRecoverySuccessMail($user_name, $user_arr['login']);
      if($res){
          $dialog_msg="
              <h2>Восстановление пароля прошло успешно!</h2>
              <p>Вы успешно изменили пароль для доступа в систему \"База новостроек Санкт-Петербурга\"!</p>             
              <p>Теперь Вы можете <a href='http://crm.mgflat.ru'>войти в систему</a>, используя новый пароль</p>
              <p></p>
              <p>Желаем успехов!</p>";
      }
      else{
          $dialog_msg="
              <h2>Ошибка</h2>
              <p>В процессе восстановления пароля возникла ошибка! Обратитесь в службу поддержки</p>";
      }
      $objResponse->assign("password_recovery_replace","innerHTML",  $dialog_msg);
  } 
  else{
      $all_error="Проверьте правильность заполнения полей отмеченных *. ";
  }
  $objResponse->assign("all_error","innerHTML", $all_error);
  return $objResponse;
}
/* 
* Функция смены пароля пользователя для доступа к системе
* Function change user password for system access
* @param array $Id 
* @return xajaxResponse 
*/ 
function Logout()
{
  $objResponse = new xajaxResponse();
  Users::clearCookies();
  $url = Router::getUrlPath();
  $objResponse->redirect($url);
  return $objResponse;
}
/*
* ToDo: Delete after release
*/

function Delete_Img_Log($Id)
{
    $objResponse = new xajaxResponse(); 
    // проверяем все входящие переменные на наличие xss и sql инъекции    
    $log_id = check_form($Id);
    $dialog_msg="";  
    if(strlen(trim($log_id))>0){  
        try{     
          $res = DB::mysqliQuery(AS_DATABASE_SITE,"
              DELETE FROM   
                `". AS_DBPREFIX ."img_log` 
              WHERE                                              
                   `id`=".$log_id."                                        
                    ");
          $dialog_msg= DB::GetSuccessExeption('success');
        }
        catch (ExceptionDataBase $edb){
          $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
          $dialog_msg = $edb->GetNoticeExeption("delete_error");
        } 
        require_once(AS_ROOT .'libs/uploads_func.php');
        $log_table = getImgLog();
        $objResponse->assign("log-table-replace","innerHTML",  $log_table);
  } 
  else{
      $dialog_msg="<h3>Ошибка!</h3>
              <p>В процессе удаления что-то пошло не так!</p>";
  }
  $objResponse->assign("modal-dialog-notice__replace","innerHTML",  $dialog_msg);
  $objResponse->call("ModalDialog.show('notice')");
  return $objResponse;
}