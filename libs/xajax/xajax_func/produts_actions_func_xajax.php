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
        $products_checked = json_encode($Id['productsChecked']);        
        switch($Id['products_actions'])  
        {        
            case 'delete':
                $dialog_form_action='xajax_Products_Actions(xajax.getFormValues(\'FormProductsGroupActions\'));';
                $dialog_form_body= '
                    <h2>Внимание! Выбранные товары будут полностью удалены</h2>
                    <p>Вы точно хотите продолжить?</p>
                    <input type="submit" name="send_form" id="send_form" class="button" value="Продолжить" />
                    ';
            break;
            case 'pages':
                     
            break; 
            case 'shop':
                 
            break;
            default :
                $dialog_form.= 'Вы не выбрали никакого действия';
            break;
        } 
        $dialog_form = '
            <form id="FormProductsActionsDialog" action="javascript:void(null);" onSubmit="'.$dialog_form_action.'">
                <input type="text" name="productsChecked" id="productsChecked" value="'.$products_checked.'"/>
                '.$dialog_form_body.'                
            </form>';
    }
    else{
        $dialog_form= "Не отмечено ни одного товара";
    }        
    $objResponse->assign("modal_content_replace","innerHTML",  $dialog_form);
    $objResponse->call("modal_dialog_show");
    return $objResponse;
}
/* 
* Функция группового удаления товаров
* Function goods delete products
* @param array $Id 
* @return xajaxResponse 
*/ 
function Products_Delete_Action($Id){
    $objResponse = new xajaxResponse(); 
    $dialog_msg= "";
    $products_checked="";
    if(isset($Id['productsChecked'])){
        $products_checked = json_encode($Id['productsChecked']);
        $dialog_form = '<form
            <input type="text" name="productsChecked" id="productsChecked" value="'.$products_checked.'"/>
            ';
        switch(Router::getUrlController())  
        {        
            case 'delete':
                
            break;
            case 'pages':
                require_once(AS_ROOT .'libs/xajax/xajax_pages_func_inc.php');       
            break; 
            case 'shop':
                require_once(AS_ROOT .'libs/xajax/xajax_shop_func_inc.php'); 
                require_once(AS_ROOT .'libs/xajax/xajax_products_actions_func_inc.php'); 
            break;
            default :
            break;
        } 
        $dialog_form.= '</form>';
    }
    else{
        $dialog_msg= "Не отмечено ни одного товара";
    }        
    $objResponse->assign("modal_content_replace","innerHTML",  $products_checked);
    $objResponse->call("modal_dialog_show");
    return $objResponse;
}