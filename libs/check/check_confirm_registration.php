<?php
$errors=0;
$form_error_password=""; 
$form_error_password_dubl="";
// Имя пользователя
if(strlen(trim($Id['password']))==0){
    $form_error_password="Поле должно быть заполнено"; 
    $errors++;
}
else{
    if(strlen(trim($Id['password']))<6){
        $form_error_password="Пароль не должен быть меньше 6 символов"; 
        $errors++;
    }
    if(strlen(trim($Id['password_dubl']))==0){
        $form_error_password_dubl="Поле должно быть заполнено"; 
         $errors++;
    }
    else{
        if($Id['password']!=$Id['password_dubl']){
            $form_error_password_dubl="Введенные Вами пароли не совпадают";
             $errors++;
        }
    }
}
$objResponse->assign("form_error_password","innerHTML",$form_error_password);
$objResponse->assign("form_error_password_dubl","innerHTML",$form_error_password_dubl);
