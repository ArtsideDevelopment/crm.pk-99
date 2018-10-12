<?php
/**    
* The excel functions   
* Функции для работы с excel документами     
* @author ArtSide Dulebsky A.   
* @copyright © 03.07.2017 ArtSide   
*/ 

/** 
* Функция загрузки товаров из excel файла
* Function load products from excel
* @param 
* @return string 
*/
function loadProductsFromExcel($file="5b90bf171afbc.xlsx", $file_type='job',$start, $limit){ 
    if(is_file(AS_EXCEL_FILES_ROOT.$file)){
        require_once(AS_ROOT .'libs/PHPExcel/IOFactory.php');
        $xls = PHPExcel_IOFactory::load(AS_EXCEL_FILES_ROOT.$file);
        $filename = uniqid();
        $xls->setActiveSheetIndex(0);
        // Получаем активный лист
        $worksheet = $xls->getActiveSheet();
        $rowIterator = $worksheet->getRowIterator();
        // Получаем количество строк и стобцов
        $rows_count = $worksheet->getHighestRow();
        $columns_count = PHPExcel_Cell::columnIndexFromString($worksheet->getHighestColumn());
        $values = array();
        $count=$start;
        for ($row = $start; $row <= $rows_count; $row++) {
            // Строка со значениями всех столбцов в строке листа Excel
            $row_values = "";
            for ($column = 0; $column < $columns_count; $column++) {
                $cell = $worksheet->getCellByColumnAndRow($column, $row);  
                $row_values[]= $cell->getCalculatedValue();   
            }
            if(!empty($row_values)){
                $values[] = $row_values;
            }     
            $count++;
            if($count==$limit){
                break;
            }
        }
        //dbg($values);
        // Добавляем строки в таблицу
        require_once(AS_ROOT .'libs/translit_func.php');
        $as_status = 1;
        try{ 
            if(!empty($values)){
                foreach ($values as $key => $value) {
                    $product_id_old = $value[0];
                    // артикул
                    $vendor_code = $value[1];
                    // название товара
                    $name = $value[2];
                    // alias
                    $alias = check_form(strToUrl($name));
                    // url_path
                    $url_path = "product/".$alias; 
                    // Стоимость
                    if($file_type=='arhive'){
                        $cost = 0;
                    }
                    else{
                        $cost = $value[3]*1;
                    }
                    // Количество
                    $amount = $value[4];
                    // Measure
                    $unit = $value[5];
                    // 1C
                    $one_c = "";
                    $one_c_strlen = strlen($value[10]);
                    $one_c_prefix = array(
                        0=>'',
                        1=>'0',
                        2=>'00',
                        3=>'000',
                        4=>'0000',
                        5=>'00000',
                        6=>'000000',
                        7=>'0000000',
                    );
                    if($one_c_strlen>0 && $one_c_strlen<8 ){
                        $one_c = $one_c_prefix[8-$one_c_strlen].$value[10];
                    }
                    else{
                        $one_c = $value[10];
                    }                    
                    // category
                    $category_id = getCategoryIdByExcel($value[11]);
                    if($category_id==0){
                        $category_id=  ProductCategories::empty_category;
                    }
                    // category_id_old
                    $category_id_old = $value[11];
                    // category_name_old
                    $category_name_old = check_form($value[12]);
                    // vendor
                    $vendor_id = getVendorIdByExel($value[13], $value[14]);
                    // Anonce
                    $announce = check_form($value[15]);                    
                    
                    require_once(AS_ROOT .'libs/uploads_func.php');
                    /*========Images============*/                   
                    // image
                    $image = uploadOutImagesCurl($value[17], 'products/transfer');
                    // Thumbnail 
                    $thumb_img = uploadOutImagesCurl($value[18], 'products/transfer', 'thumb_');
                    /*===========================*/
                    // URL
                    $url_path_old = 'http://pk-99.ru/'.trim($value[19],'/');
                    
                    
                    // Описание товара
                    $description = handleOutText($value[16],'products/transfer', $url_path, $url_path_old);
                    
                    // cost_old
                    if($file_type=='arhive'){
                        $cost_old = 0;
                    }
                    else{
                        $cost_old = $value[20]*1;
                    }                    
                    // characteristic
                    $characteristic = $value[21];
                    // sizes_old
                    $sizes_old = $value[22];
                    // button_link_text
                    $button_link_text = $value[23];
                    //button_link_show_set
                    $button_link_show_set = 0;
                    if(strlen(trim($value[26]))>0){
                        $button_link_show_set = $value[26];
                    }
                    // button_link
                    $button_link = $value[27];
                    // mail_text
                    $mail_text = $value[25];
                    // delivery
                    $delivery_set = $value[29];
                    if(strlen(trim($delivery_set))==0){
                        $delivery_set=3;
                    }
                    // meta_keywords
                    $meta_keywords  = $value[31];
                    // meta_description
                    $meta_description = $value[32];
                    // title
                    $title = $value[33];
                    // noindex_set  
                    $noindex_set = 0;
                    if(strlen(trim($value[34]))>0){
                        $noindex_set = $value[34];
                    }

                    $res = DB::mysqliQuery(AS_DATABASE_SITE,"
                         INSERT INTO   
                            `". AS_DBPREFIX ."products`
                          SET
                            `product_id_old`=".check_form($product_id_old).",
                            `name`='".check_form($name)."',
                            `alias`='".check_form($alias)."', 
                            `url_path`='".check_form($url_path)."', 
                            `cost`=".check_form($cost).",
                            `cost_old`=".check_form($cost_old).",
                            `amount`=".check_form($amount).",
                            `unit`='".check_form($unit)."',
                            `1c`='".check_form($one_c)."',
                            `description`='".check_form($description)."',
                            `as_vendor_id` = ".check_form($vendor_id).",  
                            `vendor_code` = '".check_form($vendor_code)."',
                            `announce` = '".check_form($announce)."',
                            `characteristic` = '".check_form($characteristic)."',
                            `sizes_old` = '".check_form($sizes_old)."',
                            `img` = '".check_form($image)."',
                            `thumb_img` = '".check_form($thumb_img)."',
                            `url_path_old` = '".check_form($url_path_old)."',  
                            `button_link_text`= '".check_form($button_link_text)."',  
                            `button_link`= '".check_form($button_link)."',
                            `button_link_show_set`= ".check_form($button_link_show_set).",
                            `mail_text`= '".check_form($mail_text)."',
                            `delivery_set` = ".check_form($delivery_set).",
                            `category_id_old` = '".check_form($category_id_old)."',
                            `category_name_old` = '".check_form($category_name_old)."',
                            `meta_keywords` = '".check_form($meta_keywords)."',
                            `meta_description` = '".check_form($meta_description)."',
                            `title` = '".check_form($title)."',
                            `noindex_set` = ".check_form($noindex_set).",
                            `as_status_id`=".check_form($as_status)."                    
                        "); 
                    $product_id=DB::getInsertId(); 
                    // Добавляем к продукту категорию
                    $res = DB::mysqliQuery(AS_DATABASE_SITE,"
                         INSERT INTO   
                            `". AS_DBPREFIX ."product_categories`
                          SET
                            `as_products_id`=".$product_id.",
                            `as_catalog_id`=".$category_id.",
                            `main_category_set`=1   
                        "); 
                    set_time_limit(20);
                }                
            }
            else{
                throw new Exception("Передан пустой файл:".AS_ROOT .'uploads/input/prices/'.$price_file);
            }
        }                
        catch (ExceptionDataBase $edb){
            throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
        }
        return true;
    }    
    else{
        return false;
    }
}
/** 
* Функция загрузки категории из excel файла
* Function load categories from excel
* @param 
* @return string 
*/
function loadCategoriesFromExcel($file="folders.xls", $start, $limit){ 
    if(is_file(AS_EXCEL_FILES_ROOT.$file)){
        require_once(AS_ROOT .'libs/PHPExcel/IOFactory.php');
        $xls = PHPExcel_IOFactory::load(AS_EXCEL_FILES_ROOT.$file);
        $filename = uniqid();
        $xls->setActiveSheetIndex(0);
        // Получаем активный лист
        $worksheet = $xls->getActiveSheet();
        $rowIterator = $worksheet->getRowIterator();
        // Получаем количество строк и стобцов
        $rows_count = $worksheet->getHighestRow();
        $columns_count = PHPExcel_Cell::columnIndexFromString($worksheet->getHighestColumn());
        $values = array();
        $count=$start;
        for ($row = $start; $row <= $rows_count; $row++) {
            // Строка со значениями всех столбцов в строке листа Excel
            $row_values = "";
            for ($column = 0; $column < $columns_count; $column++) {
                $cell = $worksheet->getCellByColumnAndRow($column, $row);                                   
                $row_values[]= $cell->getCalculatedValue();           
            }
            if(!empty($row_values)){
                $values[] = $row_values;
            }     
            $count++;
            if($count==$limit){
                break;
            }
        }
        //dbg($values);
        // Добавляем строки в таблицу

        require_once(AS_ROOT .'libs/translit_func.php');
        require_once(AS_ROOT .'libs/uploads_func.php');
        $parent_id=0;
        $as_status=1;
        $hierarchy=2;
        try{ 
            if(!empty($values)){
                foreach ($values as $key => $value) {                    
                    if(stripos($value[1],'архив')===FALSE){
                        $as_status=1;
                    }
                    else{
                        $as_status=2;
                    }
                    // name
                    //$name = iconv('windows-1251', 'UTF-8', $value[1]);
                    $name = $value[1];
                    // Создаем url категории                    
                    $translit = strToUrl($name);
                    $url_path = 'catalog/'.$translit;
                    // content
                    //$content = check_form(iconv('windows-1251', 'UTF-8', $value[2]));
                    $content = handleOutText($value[2], 'categories/transfer', $url_path);
                    
                    $res = DB::mysqliQuery(AS_DATABASE_SITE,"
                     INSERT INTO   
                        `". AS_DBPREFIX ."catalog`
                     SET
                        `category_id_old`=".check_form($value[0]).",
                        `hierarchy`=".check_form($hierarchy).",
                        `parent_id`=0,   
                        `name`='".check_form($name)."',
                        `alias`='".check_form($translit)."',  
                        `url_path`='".check_form($url_path)."',    
                        `content`='".check_form($content)."',
                        `as_status_id`=".check_form($as_status)."
                    ");
                    $category_id=DB::getInsertId(); 
                    $hierarchy++;
                }                 
            }
            else{
                throw new Exception("Передан пустой файл:".AS_ROOT .'uploads/input/prices/'.$price_file);
            }
        }                
        catch (ExceptionDataBase $edb){
            throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
        }

        return true;
    }    
    else{
        return false;
    }
}
function getCategoryIdByExcel($category_id_old){
    $category_id=0;
    try {
        $res = DB::mysqliQuery(AS_DATABASE_SITE,"
            SELECT 
                `id`
            FROM 
                `". AS_DBPREFIX ."catalog` 
            WHERE 
                `category_id_old`='".  check_form($category_id_old)."'
            ");
    } catch (ExceptionDataBase $edb) {
        throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
    }            
    if($res->num_rows>0){
        $row = $res->fetch_array();
        $category_id=$row[0];
    }
    return $category_id;
}
function getVendorIdByExel($vendor_id_old, $vendor_name){
    $vendor_id=0;
    try {
        $res = DB::mysqliQuery(AS_DATABASE_SITE,"
            SELECT 
                `id`
            FROM 
                `". AS_DBPREFIX ."vendor` 
            WHERE 
                `vendor_id_old`='".  check_form($vendor_id_old)."'
            ");
    } catch (ExceptionDataBase $edb) {
        throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
    }            
    if($res->num_rows>0){
        $row = $res->fetch_array();
        $vendor_id=$row[0];
    }
    else{
        try {
            $res = DB::mysqliQuery(AS_DATABASE_SITE,"
                 INSERT INTO   
                    `". AS_DBPREFIX ."vendor`
                  SET
                    `name`='".check_form($vendor_name)."',
                    `vendor_id_old`=".check_form($vendor_id_old)."
                ");
            $vendor_id=DB::getInsertId();
        } catch (ExceptionDataBase $edb) {
            throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
        }
    }
    return $vendor_id;
}