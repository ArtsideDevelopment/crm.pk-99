<?php
$errors=0; 
// Название страницы
$form_error_name="";
if(strlen(trim($Id['name']))==0){
    $form_error_name="Укажите название товара"; 
    $errors++;
}
$objResponse->assign("form_error_name","innerHTML",$form_error_name);
// Проверка url адреса
// Алиас страницы
$form_error_alias = "";
if(strlen(trim($Id['alias']))==0){    
    $form_error_alias='Поле "Алиас товара" должно быть заполнено'; 
    $errors++;
}
else{
    // Добавление товара
    if($Id['product_id']*1==0){
        try {
            $res = DB::mysqliQuery(AS_DATABASE_SITE,"
                SELECT 
                    `id`
                FROM 
                    `". AS_DBPREFIX ."products` 
                WHERE 
                    `url_path`='".  check_form($Id['alias'])."'
                ");
        } catch (ExceptionDataBase $edb) {
            throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
        }            
        if($res->num_rows>0){
            $form_error_alias="Такой алиас товара уже существует в базе данных";
            $errors++;
        }
    }      
    else{
        if($Id['alias_old']!=$Id['alias']){
            $res = DB::mysqliQuery(AS_DATABASE_SITE,"
                SELECT 
                    `id`   
                FROM 
                    `". AS_DBPREFIX ."products` 
                WHERE 
                    `url_path`='".  check_form($Id['alias'])."' "  
                    );
            if($res->num_rows>0){
                $form_error_alias="Такой алиас страницы уже существует в базе данных";
                $errors++;
            }
        }
    }
}
$objResponse->assign("form_error_alias","innerHTML",$form_error_alias);

// Старый url адрес
$form_error_url_path_old="";
if(strlen(trim($Id['url_path_old']))==0){
    $form_error_url_path_old="Поле должно быть заполнено"; 
    $errors++;
}
$objResponse->assign("form_error_url_path_old","innerHTML",$form_error_url_path_old);

// Статус
$form_error_status="";
if($Id['as_status_id']*1==0){
    $form_error_status="Необходимо выбрать значение"; 
    $errors++;
}
$objResponse->assign("form_error_status","innerHTML",$form_error_status);

// Заголовок страницы
$form_error_title="";
if(strlen(trim($Id['title']))==0){
    $form_error_title="Поле должно быть заполнено"; 
    $errors++;
}
$objResponse->assign("form_error_title","innerHTML",$form_error_title);
