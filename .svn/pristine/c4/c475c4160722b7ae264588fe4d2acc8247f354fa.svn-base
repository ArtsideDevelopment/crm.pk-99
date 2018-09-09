<?php
$errors=0;

// Фамилия
$form_error_fam=""; 
if(strlen(trim($Id['fam']))==0){
    $form_error_fam="Поле должно быть заполнено"; 
    $errors++;
}
$objResponse->assign("form_error_fam","innerHTML",$form_error_fam);


// Имя пользователя
$form_error_name=""; 
if(strlen(trim($Id['name']))==0){
    $form_error_name="Поле должно быть заполнено"; 
    $errors++;
}
$objResponse->assign("form_error_name","innerHTML",$form_error_name);


// Тип пользователя
$form_error_type="";
if($Id['as_lk_users_type_id']*1==0){
    $form_error_type="Необходимо выбрать значение"; 
}
$objResponse->assign("form_error_type","innerHTML",$form_error_type);


// Руководитель
$form_error_parent="";
if($Id['parent_id']*1==0){
    $form_error_parent="Необходимо выбрать значение"; 
}
$objResponse->assign("form_error_parent","innerHTML",$form_error_parent);


// Телефон
$form_error_phone="";
if(strlen(trim($Id['phone']))==0){
    $form_error_phone="Поле должно быть заполнено"; 
    $errors++;
}
$objResponse->assign("form_error_phone","innerHTML",$form_error_phone);

// Логин
$form_error_login="";
if(strlen(trim($Id['login']))==0){
    $form_error_login="Поле должно быть заполнено"; 
    $errors++;
}
else{
    $user_login= check_form(trim($Id['login']));
    if(!preg_match("/^([a-zA-Z0-9])+([\.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)*\.([a-zA-Z]{2,6})$/", $Id['login'])){
        $form_error_login="Не корректный формат e-mail адреса";        
        $errors++;
    }
    else{
        if($user_login !=$Id['old_login']){
            try{
                $res = DB::mysqliQuery(AS_DATABASE,"
                    SELECT 
                        `id`   
                    FROM 
                        `". AS_DBPREFIX ."lk_users` 
                    WHERE 
                        `login`='". $user_login ."'
                    ");
                }
            catch (ExceptionDataBase $edb){
                throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
            }
            if($res->num_rows>0){
                $form_error_login="Пользователь с таким адресом e-mail уже существует"; 
                $errors++;
        }
        }        
    }
}
$objResponse->assign("form_error_login","innerHTML",$form_error_login);
