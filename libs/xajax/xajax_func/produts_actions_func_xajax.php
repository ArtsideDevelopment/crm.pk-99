<?php
/*   
* libs/xajax/xajax_func/products_actions_func_xajax.php 
* Functions for working with products   
* Функции для работы с товарамм
* @author ArtSide 24.09.2018  
* @copyright © 2018 ArtSide   
*/

/* 
* Функция групповой обработки товаров
* Function goods group actions
* @param array $Id 
* @return xajaxResponse 
*/ 
function Products_Actions($Id){
    $objResponse = new xajaxResponse(); 
    $dialog_form = '';
    $products_checked='';
    $dialog_form_action = '';
    $dialog_form_body = '';
    if(isset($Id['productsChecked'])){
        $products_checked = implode(",", $Id['productsChecked']);        
        switch($Id['products_actions'])  
        {        
            case 'delete':
                $dialog_form_action='xajax_Products_Actions_Delete(xajax.getFormValues(\'FormProductsActionsDialog\'));';
                $dialog_form_body= '
                    <h2>Внимание! Выбранные товары будут полностью удалены</h2>
                    <p>Вы точно хотите продолжить?</p>                    
                    ';
            break;
            case 'add_to_category':
                include_once AS_ROOT .'libs/shop_func.php';
                $dialog_form_action='xajax_Products_Actions_Add_To_Category(xajax.getFormValues(\'FormProductsActionsDialog\'));';
                $categories_check = getCategoriesTableCheck('catalog');
                $dialog_form_body= '
                    <h2>Укажите категории, в которые необходимо добавить выбранные товары</h2>
                    '.$categories_check.'
                                        ';
                     
            break; 
            case 'move_to_category':
                include_once AS_ROOT .'libs/shop_func.php';
                $dialog_form_action='xajax_Products_Actions_Move_To_Category(xajax.getFormValues(\'FormProductsActionsDialog\'));';
                $categories_check = getCategoriesTableCheck('catalog');
                $dialog_form_body= '
                    <h2>Укажите категории, в которые необходимо перенести выбранные товары</h2>
                    '.$categories_check.'
                    ';
                 
            break;
            case 'delete_category':
                $dialog_form_action='xajax_Products_Actions_Delete_Category(xajax.getFormValues(\'FormProductsActionsDialog\'));';
                $dialog_form_body= '
                    <h2>Внимание! Выбранные товары будут удалены из всех категорий</h2>
                    <p>Вы точно хотите продолжить?</p>                    
                    ';
            break;
            case 'add_vendor':
                include_once AS_ROOT .'libs/shop_func.php';
                $dialog_form_action='xajax_Products_Actions_Add_Vendor(xajax.getFormValues(\'FormProductsActionsDialog\'));';
                $vendor_check = getVendorTableCheck();
                $dialog_form_body= '
                    <h2>Укажите производителя, которого необходимо добавить к выбранным товарам</h2>
                    '.$vendor_check.'
                    ';
            break; 
            case 'add_amount':
                $dialog_form_action='xajax_Products_Actions_Add_Numeric_Values(xajax.getFormValues(\'FormProductsActionsDialog\'));';
                $dialog_form_body= '
                    <h2>Внимание! Изменения будут применены ко всем выбранным товарам</h2>
                    <p></p>  
                    <div class="form-group">
                        <input type="hidden" name="field" id="field" value="amount"/>
                        <input type="text" name="field_value" id="field_value" required="required" value="">
                        <label class="control-label" for="field_value">Укажите количество товара</label><i class="bar"></i>
                    </div> 
                    ';
            break;
            case 'add_button_link_text':
                $dialog_form_action='xajax_Products_Actions_Add_Text_Values(xajax.getFormValues(\'FormProductsActionsDialog\'));';
                $dialog_form_body= '
                    <h2>Внимание! Изменения будут применены ко всем выбранным товарам</h2>
                    <p></p>  
                    <div class="form-group">
                        <input type="hidden" name="field" id="field" value="button_link_text"/>                   
                        <textarea name="field_value" id="field_value" required="required"></textarea>
                        <label class="control-label" for="field_value">Укажите текст под кнопкой купить</label><i class="bar"></i>
                    </div> 
                    ';
            break;
            case 'add_button_link':
                $dialog_form_action='xajax_Products_Actions_Add_Text_Values(xajax.getFormValues(\'FormProductsActionsDialog\'));';
                $dialog_form_body= '
                    <h2>Внимание! Изменения будут применены ко всем выбранным товарам</h2>                    
                    <div class="form-group">
                        <input type="hidden" name="field" id="field" value="button_link"/>
                        <textarea name="field_value" id="field_value" required="required"></textarea>
                        <label class="control-label" for="field_value">Укажите ссылку под кнопкой купить</label><i class="bar"></i>
                    </div> 
                    ';
            break;
            case 'add_mail_text':
                $dialog_form_action='xajax_Products_Actions_Add_Text_Values(xajax.getFormValues(\'FormProductsActionsDialog\'));';
                $dialog_form_body= '
                    <h2>Внимание! Изменения будут применены ко всем выбранным товарам</h2>                     
                    <div class="form-group">
                        <input type="hidden" name="field" id="field" value="mail_text"/>
                        <textarea name="field_value" id="field_value" required="required"></textarea>
                        <label class="control-label" for="field_value">Поле в письме клиенту</label><i class="bar"></i>
                    </div> 
                    ';
            break;
            case 'add_button_link_show':
                include_once AS_ROOT .'libs/form_func.php'; 
                $button_link_show_set = getCheckBoxSet('button_link_show_set');
                $dialog_form_body= '
                    <h2>Внимание! Изменения будут применены ко всем выбранным товарам</h2>
                    <p></p>  
                    <div class="checkbox">
                        <label>
                            '.$button_link_show_set.'<i class="helper"></i>Отображать ссылку на сайте
                        </label>
                    </div>
                    ';
            break;
            case '6':
            break;
            default :
                $dialog_form_action = '';
                $dialog_form_body = '<h2>Вы не выбрали никакого действия</h2>';
            break;
        } 
        $dialog_form = '
            <form id="FormProductsActionsDialog" action="javascript:void(null);" onSubmit="'.$dialog_form_action.'">
                <input type="hidden" name="productsChecked" id="productsChecked" value="'.$products_checked.'"/>
                '.$dialog_form_body.'  
                <div class="form_error" id="form_error_replace"></div>
                <input type="submit" name="send_form" id="send_form" class="button" value="Продолжить" />
            </form>';
    }
    else{
        $dialog_form= "<h2>Не отмечено ни одного товара</h2>";
    }        
    $objResponse->assign("modal_content_replace","innerHTML",  $dialog_form);
    $objResponse->call("modal_dialog_show");
    $objResponse->call("artside_data_tables.init('.dataTablesCategories', false)");
    return $objResponse;
}
/* 
* Функция группового удаления товаров
* Function goods delete products
* @param array $Id 
* @return xajaxResponse 
*/ 
function Products_Actions_Delete($Id){
    $objResponse = new xajaxResponse(); 
    $dialog_msg= "";
    $products_checked="";
    if(isset($Id['productsChecked'])){
        //$products_checked = explode(",", $Id['productsChecked']);
        $products_checked = trim($Id['productsChecked'], ',');
        try{     
            $res = DB::mysqliQuery(AS_DATABASE_SITE,"
                DELETE                 
                FROM 
                    ". AS_DBPREFIX ."products               
                WHERE
                    `id` IN (".$products_checked.") 
                "  
            ); 
            $dialog_msg=DialogMessages::delete_products_success;
            include_once AS_ROOT .'libs/shop_func.php';       
            $products_table=  getProductsTable();
            $objResponse->assign("products_table_replace","innerHTML",  $products_table);
            $objResponse->call("artside_data_tables.init('.dataTables', true)");
        }
        catch (ExceptionDataBase $edb){
            $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
            $dialog_msg = $edb->GetNoticeExeption("delete_error");
        }         
    }
    else{
        $dialog_msg= DialogMessages::error;
    }        
    $objResponse->assign("modal_content_replace","innerHTML",  $dialog_msg);
    $objResponse->call("modal_dialog_show");
    return $objResponse;
}
/* 
* Функция группового добавления товара в категорию
* Function group add to category
* @param array $Id 
* @return xajaxResponse 
*/ 
function Products_Actions_Add_To_Category($Id){
    $objResponse = new xajaxResponse(); 
    $dialog_msg= "";
    $products_checked="";
    if(isset($Id['productsChecked'])){
        if(isset($Id['categoriesChecked'])){
            $products_checked = explode(",", $Id['productsChecked']);
            $categories_checked = $Id['categoriesChecked'];
            $query="";
            foreach ($products_checked as $product_id) {
                foreach ($categories_checked as $category_id) {
                    $query.="(".$category_id.", ".$product_id."),";
                }
            }
            try{     
                $res = DB::mysqliQuery(AS_DATABASE_SITE,"
                    INSERT 
                    INTO ". AS_DBPREFIX ."product_categories 
                        (as_catalog_id, as_products_id)
                    VALUES
                        ".trim(check_form($query), ",").";
                    "  
                ); 
                $dialog_msg = DialogMessages::add_to_category_success;
            }
            catch (ExceptionDataBase $edb){
                $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
                $dialog_msg = $edb->GetNoticeExeption("add_error");
            }                     
        }
        else{
            $objResponse->assign("form_error_replace","innerHTML",  "Не выбрана ни одна категория");
            return $objResponse;
        }
    }
    else{
        $dialog_msg= DialogMessages::error;
    }        
    $objResponse->assign("modal_content_replace","innerHTML",  $dialog_msg);
    $objResponse->call("modal_dialog_show");
    return $objResponse;
}
/* 
* Функция группового перемещение товара в категорию
* Function group move to category
* @param array $Id 
* @return xajaxResponse 
*/ 
function Products_Actions_Move_To_Category($Id){
    $objResponse = new xajaxResponse(); 
    $dialog_msg= "";
    $products_checked="";
    if(isset($Id['productsChecked'])){
        if(isset($Id['categoriesChecked'])){
            if(count($Id['categoriesChecked'])==1){
                $products_checked = explode(",", $Id['productsChecked']);
                $products_checked_str = trim($Id['productsChecked'], ',');
                $categories_checked = $Id['categoriesChecked'];
                $query="";
                $category_id_val = 0;
                foreach ($products_checked as $product_id) {
                    foreach ($categories_checked as $category_id) {
                        $query.="(1, ".$category_id.", ".$product_id."),";
                        $category_id_val = $category_id;
                    }
                }
                try{  
                    DB::mysqliBegin(AS_DATABASE);
                    $res_del = DB::mysqliQuery(AS_DATABASE_SITE,"
                        DELETE                 
                        FROM 
                            ". AS_DBPREFIX ."product_categories               
                        WHERE
                            `as_products_id` IN (".$products_checked_str.") 
                        "  
                    ); 
                    $res = DB::mysqliQuery(AS_DATABASE_SITE,"
                        INSERT 
                        INTO ". AS_DBPREFIX ."product_categories 
                            (main_category_set, as_catalog_id, as_products_id)
                        VALUES
                            ".trim(check_form($query), ",").";
                        "  
                    ); 
                    DB::mysqliCommit();
                    $dialog_msg = DialogMessages::move_to_category_success;
                    $categories_array = DB::getTableDataArray(AS_DATABASE_SITE, 'catalog', 'name');                  
                    foreach ($products_checked as $product_id) {            
                        $objResponse->assign("category_".$product_id,"innerHTML", $categories_array[$category_id_val]);
                    }                
                }
                catch (ExceptionDataBase $edb){
                    $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
                    $dialog_msg = $edb->GetNoticeExeption("add_error");
                    DB::mysqliRollback();
                }    
            }
            else{
                $objResponse->assign("form_error_replace","innerHTML",  "Вы выбрали более чем 1 категорию");
                return $objResponse;
            }
        }
        else{
            $objResponse->assign("form_error_replace","innerHTML",  "Не выбрана ни одна категория");
            return $objResponse;
        }
    }
    else{
        $dialog_msg= DialogMessages::error;
    }        
    $objResponse->assign("modal_content_replace","innerHTML",  $dialog_msg);
    $objResponse->call("modal_dialog_show");
    return $objResponse;
}
/* 
* Функция группового удаления товаров из категорий
* Function group ву to category
* @param array $Id 
* @return xajaxResponse 
*/ 
function Products_Actions_Delete_Category($Id){
    $objResponse = new xajaxResponse(); 
    $dialog_msg= "";
    $products_checked="";
    if(isset($Id['productsChecked'])){  
        $products_checked = explode(",", $Id['productsChecked']);
        $products_checked_str = trim($Id['productsChecked'], ',');        
        $query="";
        foreach ($products_checked as $product_id) {            
            $query.="(1, ".ProductCategories::empty_category.", ".$product_id."),";
        }
        try{  
            DB::mysqliBegin(AS_DATABASE);
            $res_del = DB::mysqliQuery(AS_DATABASE_SITE,"
                DELETE                 
                FROM 
                    ". AS_DBPREFIX ."product_categories               
                WHERE
                    `as_products_id` IN (".$products_checked_str.") 
                "  
            ); 
            $res = DB::mysqliQuery(AS_DATABASE_SITE,"
                INSERT 
                INTO ". AS_DBPREFIX ."product_categories 
                    (main_category_set, as_catalog_id, as_products_id)
                VALUES
                    ".trim(check_form($query), ",").";
                "  
            ); 
            DB::mysqliCommit();
            $dialog_msg = DialogMessages::move_to_category_success;
        }
        catch (ExceptionDataBase $edb){
            $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
            $dialog_msg = $edb->GetNoticeExeption("add_error");
            DB::mysqliRollback();
        }    
                   
    }
    else{
        $dialog_msg= DialogMessages::error;
    }        
    $objResponse->assign("modal_content_replace","innerHTML",  $dialog_msg);
    $objResponse->call("modal_dialog_show");
    return $objResponse;
}
/* 
* Функция группового выбора производителя
* Function group move to category
* @param array $Id 
* @return xajaxResponse 
*/ 
function Products_Actions_Add_Vendor($Id){
    $objResponse = new xajaxResponse(); 
    $dialog_msg= "";
    $products_checked="";
    if(isset($Id['productsChecked'])){
        if(isset($Id['vendorChecked'])){
            if(count($Id['vendorChecked'])==1){
                $products_checked_str = trim($Id['productsChecked'], ',');
                $vendor_checked = $Id['vendorChecked'];
                
                try{                      
                    $res = DB::mysqliQuery(AS_DATABASE_SITE,"
                        UPDATE 
                            ". AS_DBPREFIX ."products 
                        SET
                            as_vendor_id=".  check_form($vendor_checked[0])."
                        WHERE
                            id IN (".$products_checked_str.") 
                        "  
                    ); 
                    
                    $dialog_msg = DialogMessages::add_vendor_success;
                }
                catch (ExceptionDataBase $edb){
                    $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
                    $dialog_msg = $edb->GetNoticeExeption("save_error");
                }    
            }
            else{
                $objResponse->assign("form_error_replace","innerHTML",  "Вы выбрали более чем 1 производителя");
                return $objResponse;
            }
        }
        else{
            $objResponse->assign("form_error_replace","innerHTML",  "Не выбран ни один производитель");
            return $objResponse;
        }
    }
    else{
        $dialog_msg= DialogMessages::error;
    }        
    $objResponse->assign("modal_content_replace","innerHTML",  $dialog_msg);
    $objResponse->call("modal_dialog_show");
    return $objResponse;
}
/* 
* Функция группового изменения значений цифрового поля
* Function group numeric value edit
* @param array $Id 
* @return xajaxResponse 
*/ 
function Products_Actions_Add_Numeric_Values($Id){
    $objResponse = new xajaxResponse(); 
    $dialog_msg= "";
    if(isset($Id['productsChecked'])){
        if(isset($Id['field']) && strlen(trim($Id['field_value']))>0 && is_numeric($Id['field_value'])){            
            $products_checked_str = trim($Id['productsChecked'], ',');                
            try{                      
                $res = DB::mysqliQuery(AS_DATABASE_SITE,"
                    UPDATE 
                        ". AS_DBPREFIX ."products 
                    SET
                        ".check_form($Id['field'])."=".  check_form($Id['field_value'])."
                    WHERE
                        id IN (".$products_checked_str.") 
                    "  
                );                     
                $dialog_msg = DialogMessages::add_value_success;
                if($Id['field']=='amount'){
                    $products_checked = explode(",", $Id['productsChecked']);                   
                    foreach ($products_checked as $product_id) {            
                        $objResponse->assign("amount_".$product_id,"innerHTML", $Id['field_value']);
                    }
                }
            }
            catch (ExceptionDataBase $edb){
                $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
                $dialog_msg = $edb->GetNoticeExeption("save_error");
            }                
        }
        else{
            $objResponse->assign("form_error_replace","innerHTML",  "Не корректное значение");
            return $objResponse;
        }
    }
    else{
        $dialog_msg= DialogMessages::error;
    }        
    $objResponse->assign("modal_content_replace","innerHTML",  $dialog_msg);
    $objResponse->call("modal_dialog_show");
    return $objResponse;
}
/* 
* Функция группового изменения значений текстового поля
* Function group text value edit
* @param array $Id 
* @return xajaxResponse 
*/ 
function Products_Actions_Add_Text_Values($Id){
    $objResponse = new xajaxResponse(); 
    $dialog_msg= "";
    if(isset($Id['productsChecked'])){
        if(isset($Id['field']) && strlen(trim($Id['field_value']))>0){            
            $products_checked_str = trim($Id['productsChecked'], ',');                
            try{                      
                $res = DB::mysqliQuery(AS_DATABASE_SITE,"
                    UPDATE 
                        `". AS_DBPREFIX ."products` 
                    SET
                        `".check_form($Id['field'])."`='".  check_form($Id['field_value'])."'
                    WHERE
                        `id` IN (".$products_checked_str.") 
                    "  
                );                     
                $dialog_msg = DialogMessages::add_value_success;
                include_once AS_ROOT .'libs/shop_func.php';       
                $products_table=  getProductsTable();
                $objResponse->assign("products_table_replace","innerHTML",  $products_table);
                $objResponse->call("artside_data_tables.init('.dataTables', true)");
            }
            catch (ExceptionDataBase $edb){
                $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
                $dialog_msg = $edb->GetNoticeExeption("save_error");
            }                
        }
        else{
            $objResponse->assign("form_error_replace","innerHTML",  "Не корректное значение");
            return $objResponse;
        }
    }
    else{
        $dialog_msg= DialogMessages::error;
    }        
    $objResponse->assign("modal_content_replace","innerHTML",  $dialog_msg);
    $objResponse->call("modal_dialog_show");
    return $objResponse;
}
