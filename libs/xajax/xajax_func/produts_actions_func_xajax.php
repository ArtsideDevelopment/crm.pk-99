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
                $dialog_form_body= '
                    <h2>Внимание! Изменения будут применены ко всем выбранным товарам</h2>
                    <p></p>  
                    <div class="form-group">
                        <input type="text" name="amount" id="amount" required="required" value="">
                        <label class="control-label" for="meta_keywords">Укажите количество товара</label><i class="bar"></i>
                    </div> 
                    ';
            break;
            case 'add_button_link_text':
                $dialog_form_body= '
                    <h2>Внимание! Изменения будут применены ко всем выбранным товарам</h2>
                    <p></p>  
                    <div class="form-group">
                        <textarea name="button_link_text" id="button_link_text" required="required"></textarea>
                        <label class="control-label" for="meta_keywords">Укажите текст под кнопкой купить</label><i class="bar"></i>
                    </div> 
                    ';
            break;
            case 'add_button_link':
                $dialog_form_body= '
                    <h2>Внимание! Изменения будут применены ко всем выбранным товарам</h2>
                    <p></p>  
                    <div class="form-group">
                        <textarea name="button_link" id="button_link" required="required"></textarea>
                        <label class="control-label" for="meta_keywords">Укажите ссылку под кнопкой купить</label><i class="bar"></i>
                    </div> 
                    ';
            break;
            case 'add_mail_text':
                $dialog_form_body= '
                    <h2>Внимание! Изменения будут применены ко всем выбранным товарам</h2>
                    <p></p>  
                    <div class="form-group">
                        <textarea name="mail_text" id="mail_text" required="required"></textarea>
                        <label class="control-label" for="meta_keywords">Поле в письме клиенту</label><i class="bar"></i>
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
    </div>          </div>
                    ';
            break;
            case '6':
            break;
            default :
                $dialog_form.= 'Вы не выбрали никакого действия';
            break;
        } 
        $dialog_form = '
            <form id="FormProductsActionsDialog" action="javascript:void(null);" onSubmit="'.$dialog_form_action.'">
                <input type="hidden" name="productsChecked" id="productsChecked" value="'.$products_checked.'"/>
                '.$dialog_form_body.'     
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
