<?php
/*   
* libs/xajax/xajax_func/shop_func_xajax.php 
* Functions for working with shop section    
* Функции для работы с разделом магазин
* @author ArtSide A. 06.04.2018  
* @copyright © 2018 ArtSide   
*/
/* 
* Функция добавления продукта
* Function to add a new page
* @param array $Id 
* @return xajaxResponse 
*/ 
function Add_Product($Id)
{
  $objResponse = new xajaxResponse();
  require_once(AS_ROOT .'libs/query_set.php');
  require_once(AS_ROOT .'libs/query_variables/query_product.php'); 
  $all_error="";
   // Подключаем проверку заполнения полей
  include_once AS_ROOT .'libs/check/check_product.php';   
  if($errors==0){   
      $date = date('Y-m-d H:i:s');
      //инициализация переменных
      // проверяем все входящие переменные на наличие xss и sql инъекции
      $alias=str_replace(" ", "-", strtolower(trim(trim(check_form($Id['alias'])),"/")));
      $url_path='product/'.$alias;
      try{
          /*
          * Добавляем продукт в базу данных
          * insert product in to db      
          */ 
          $res = DB::mysqliQuery(AS_DATABASE_SITE,"
              INSERT INTO
                  `". AS_DBPREFIX ."products`
              SET 
                  ".m_query($new_product_str, $Id).",
                  `alias`='".$alias."',
                  `url_path`='".$url_path."',
                  `date`='".$date."'
              ");
          $dialog_msg= DB::GetSuccessExeption('success');
          $objResponse->assign("modal_content_replace","innerHTML",  $dialog_msg);
          $objResponse->call("modal_dialog_show");
      }
      catch (ExceptionDataBase $edb){
          $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
          $dialog_msg = $edb->GetNoticeExeption("save_error");
      }       
  } 
  else{
      $all_error="Проверьте правильность заполнения полей отмеченных *. ";
  }
  $objResponse->assign("all_error","innerHTML", $all_error);
  return $objResponse;
}
/* 
* Функция редактирования страницы 
* Function to edit a page 
* @param array $Id 
* @return xajaxResponse 
*/ 
function Edit_Product($Id)
{
  $objResponse = new xajaxResponse();
  // подключаем необходимые библиотеки
  require_once(AS_ROOT .'libs/query_set.php');
  require_once(AS_ROOT .'libs/query_variables/query_product.php');
  // Подключаем проверку заполнения полей
  $all_error="";
  include_once AS_ROOT .'libs/check/check_product.php';   
  if($errors==0){
      //инициализация переменных      
      $url_path="";
      // проверяем все входящие переменные на наличие xss и sql инъекции
      $product_id = check_form($Id['product_id']);
      $alias=str_replace(" ", "-", strtolower(trim(trim(check_form($Id['alias'])),"/")));
      $url_path='product/'.$alias;
      $date_change = date('Y-m-d H:i:s');
      //$content = $Id['content'];
      /*----------------------------------------
      * Формируем url адрес страницы
      * get url of new page   
      -----------------------------------------*/
      try {
          /*
          * Обновляем информацию странице в базе данных
          * Update page data in db      
          */ 
          $res_update = DB::mysqliQuery(AS_DATABASE_SITE,"
               UPDATE   
                   `". AS_DBPREFIX ."products` 
               SET 
                   ".m_query($new_product_str, $Id).",
                   `alias`='".$alias."',
                   `url_path`='".$url_path."',
                   `date_change`='".$date_change."'
               WHERE
                   `id`=".$product_id."
               ");         
          
          /*--------------------------------------*/
          $dialog_msg= DB::GetSuccessExeption('success');
          $objResponse->assign("modal_content_replace","innerHTML",  $dialog_msg);
          $objResponse->call("modal_dialog_show");
      }
      catch (ExceptionDataBase $edb){
          $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
          $dialog_msg = $edb->GetNoticeExeption("save_error");
      }
      
  }
  else{
      $all_error="Проверьте правильность заполнения полей, отмеченных *. ";
  }
  $objResponse->assign("all_error","innerHTML", $all_error);
  return $objResponse;
}
/* 
* Функция удаления товара 
* Function to delete a product 
* @param array $Id 
* @return xajaxResponse 
*/ 
function Delete_Product($Id){
    if(strlen(trim($Id))!=0){
        $objResponse = new xajaxResponse();
        parse_str($Id, $arr_var); // $content_id; $parent_id; $hierarchy
        /*
        * проверяем все входящие переменные на sql иньекции
        * check all input variables on sql injections
        */ 
        $table=  check_form($arr_var['type']);
        $content_id=  check_form($arr_var['id']);        
        $parent_id=  check_form($arr_var['parent_id']);
        $hierarchy=  check_form($arr_var['hierarchy']);
        try {
            /*
            * Удаляем страницу
            * Delete page      
            */ 
            $res_del = DB::mysqliQuery(AS_DATABASE_SITE,"
                DELETE FROM   
                    `". AS_DBPREFIX .$table."`
                WHERE 
                    `id`=".$content_id.""  
                              ); 
            /*
            * уменьшаем на 1 иерархию всех страниц являющихся братьями
            * decrement hierarchy all brothers pages
            */  
            $res_hierarchy = DB::mysqliQuery(AS_DATABASE_SITE,"
               UPDATE   
                   `". AS_DBPREFIX .$table."` 
               SET
                   hierarchy = hierarchy - 1
               WHERE  
                   `parent_id`=".$parent_id." && hierarchy>".$hierarchy." "  
                          );
            /*-----------------------------------*/
            include_once AS_ROOT .'libs/pages_func.php'; 
            $pages_table=  getPagesTable('content');
            $objResponse->assign("pages_table_replace", "innerHTML", $pages_table);
        }
        catch (ExceptionDataBase $edb){
            $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
            $dialog_msg = $edb->GetNoticeExeption("save_error");
        }                 
    }
    return $objResponse;
}
/* 
* Функция добавления категории
* Function to add a new category
* @param array $Id 
* @return xajaxResponse 
*/ 
function Add_Category($Id)
{
  $objResponse = new xajaxResponse();
  require_once(AS_ROOT .'libs/query_set.php');
  require_once(AS_ROOT .'libs/query_variables/query_category.php'); 
  $all_error="";
   // Подключаем проверку заполнения полей
  include_once AS_ROOT .'libs/check/check_category.php';   
  if($errors==0){   
      $date = date('Y-m-d H:i:s');
      //инициализация переменных
      $hierarchy =1;
      $url_path="";
      // проверяем все входящие переменные на наличие xss и sql инъекции
      $parent_id=check_form($Id['parent_id']);
      $alias=str_replace(" ", "-", strtolower(trim(trim(check_form($Id['alias'])),"/")));
      try{
          /*
          * находим максимальное занчение hierarchy, записанное в bd, 
          * для определения текущего значения hierarchy для добавляемой страницы       
          */  
          $res_hierarchy = DB::mysqliQuery(AS_DATABASE_SITE, "
              SELECT 
                  MAX(hierarchy) 
              FROM
                  `". AS_DBPREFIX ."catalog`
              WHERE  
                  `parent_id`=".$parent_id."
              ");
          if($res_hierarchy->num_rows>0){
              $row_hierarchy = $res_hierarchy->fetch_array();
              $hierarchy=$row_hierarchy[0]+1;
          }
          // находим url адрес родителя для построения текущего url адреса категории      
          if($parent_id*1>0){
              $res_parent = DB::mysqliQuery(AS_DATABASE_SITE,"
                  SELECT 
                      `url_path` 
                  FROM
                      `". AS_DBPREFIX ."catalog` 
                  WHERE  
                      `id`=".$parent_id."
                  "); 
              if($res_parent->num_rows>0){
                   $row_parent = $res_parent->fetch_array();
                   $url_path=trim($row_parent[0], "/"); // удаляем лишние / чтобы сформировать необходимый url
              }
          }
          else{
              $url_path="/catalog";
          }
          // формируем url адрес текущей страницы
          $url_path=trim($url_path."/".$alias, "/"); // удаляем лишние / он появляется если parent_id = 0   
          /*
          * Добавляем информацию о новой странице в базу данных
          * insert page data in to db      
          */ 
          require_once(AS_ROOT .'libs/uploads_func.php');
          //$content = check_form(handleOutText($Id['content']));
          $content = check_form($Id['content']);
          $content_bottom = check_form($Id['content_bottom']);
          $res = DB::mysqliQuery(AS_DATABASE_SITE,"
              INSERT INTO
                  `". AS_DBPREFIX ."catalog`
              SET 
                  ".m_query($new_category_str, $Id).",                  
                  `url_path`='".$url_path."', 
                  `alias`='".$alias."', 
                  `hierarchy`=".$hierarchy.",
                  `date`='".$date."',
                  `content`='".$content."',
                  `content_bottom`='".$content_bottom."',
                  `priority`=0.8
              ");
          $dialog_msg= DB::GetSuccessExeption('success');
          $objResponse->assign("modal_content_replace","innerHTML",  $dialog_msg);
          $objResponse->call("modal_dialog_show");
      }
      catch (ExceptionDataBase $edb){
          $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
          $dialog_msg = $edb->GetNoticeExeption("save_error");
      }       
  } 
  else{
      $all_error="Проверьте правильность заполнения полей отмеченных *. ";
  }
  $objResponse->assign("all_error","innerHTML", $all_error);
  return $objResponse;
}
/* 
* Функция удаления категории 
* Function to delete a category 
* @param array $Id 
* @return xajaxResponse 
*/ 
function Delete_Category($Id){
    if(strlen(trim($Id))!=0){
        $objResponse = new xajaxResponse();
        /*
        * проверяем все входящие переменные на sql иньекции
        * check all input variables on sql injections
        */ 
        $catalog_id=  check_form($Id);        
        try {
            DB::mysqliBegin(AS_DATABASE_SITE);
            /*
            * Удаляем категорию из таблицы as_product_categories
            * Delete category from table as_product_categories      
            */ 
            $res_del = DB::mysqliQuery(AS_DATABASE_SITE,"
                DELETE FROM   
                    `". AS_DBPREFIX ."product_categories`
                WHERE 
                    `as_catalog_id`=".$catalog_id.""  
                              ); 
            /*
            * Удаляем категорию из таблицы as_catalog
            * Delete category from table as_catalog
            */  
             $res_del = DB::mysqliQuery(AS_DATABASE_SITE,"
                DELETE FROM   
                    `". AS_DBPREFIX ."catalog`
                WHERE 
                    `id`=".$catalog_id.""  
                              ); 
            /*-----------------------------------*/
            DB::mysqliCommit();
            $dialog_msg = DialogMessages::delete_category_success;
            include_once AS_ROOT .'libs/shop_func.php'; 
            $categories_table=  getCategoriesTable('catalog');
            $objResponse->assign("catalog_table_replace", "innerHTML", $categories_table);
            $objResponse->call("artside_data_tables.init('.dataTables', true)");
        }
        catch (ExceptionDataBase $edb){
            $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
            $dialog_msg = $edb->GetNoticeExeption("save_error");
        }                 
    }
    $objResponse->assign("modal_content_replace","innerHTML",  $dialog_msg);
    $objResponse->call("modal_dialog_show");
    return $objResponse;
}
/* 
* Функция редактирования категории 
* Function to edit a category 
* @param array $Id 
* @return xajaxResponse 
*/ 
function Edit_Category($Id)
{
  $objResponse = new xajaxResponse();
  // подключаем необходимые библиотеки
  require_once(AS_ROOT .'libs/query_set.php');
  require_once(AS_ROOT .'libs/query_variables/query_category.php');
  // Подключаем проверку заполнения полей
  $all_error="";
  include_once AS_ROOT .'libs/check/check_category.php';   
  if($errors==0){
      //инициализация переменных      
      $url_path="";
      // проверяем все входящие переменные на наличие xss и sql инъекции
      $category_id=check_form($Id['category_id']);
      $parent_id=check_form($Id['parent_id']);
      $parent_id_old=check_form($Id['parent_id_old']);
      $hierarchy_old=check_form($Id['hierarchy_old']);
      $alias=str_replace(" ", "-", strtolower(trim(trim(check_form($Id['alias'])),"/")));
      $content = check_form(str_replace('../uploads/', AS_HOST.'uploads/', $Id['content']));
      $content_bottom = check_form(str_replace('../uploads/', AS_HOST.'uploads/', $Id['content_bottom']));
      //$content = $Id['content'];
      /*----------------------------------------
      * Формируем url адрес страницы
      * get url of new page   
      -----------------------------------------*/
      try {
          // находим url адрес родителя для построения текущего url адреса страницы      
          if($parent_id*1>0){
              $res_parent = DB::mysqliQuery(AS_DATABASE_SITE, "
                  SELECT 
                      `url_path` 
                  FROM
                      `". AS_DBPREFIX ."catalog` 
                  WHERE  
                      `id`=".$parent_id." 
                  "); 
              if($res_parent->num_rows>0){
                   $row_parent = $res_parent->fetch_array();
                   $url_path = trim($row_parent['url_path'], "/"); // удаляем лишние / чтобы сформировать необходимый url
              }
          }
          // формируем url адрес текущей страницы
          $url_path=trim($url_path."/".$alias, "/"); // удаляем лишние / он появляется если parent_id = 0 
          /*----------------------------------------
          * Проверяем изменился ли родитель страницы
          * check parent page    
          -----------------------------------------*/ 
          // родитель изменился
          if($parent_id!=$parent_id_old){
              $hierarchy =1;
              /*
              * находим максимальное занчение hierarchy, записанное в bd, 
              * для определения текущего значения hierarchy для редактируемой страницы    
              */      
              $res_hierarchy = DB::mysqliQuery(AS_DATABASE_SITE, "
                  SELECT 
                      MAX(hierarchy) 
                  FROM
                      `". AS_DBPREFIX ."catalog` 
                  WHERE  
                      `parent_id`=".$parent_id." 
                  ");
              if($res_hierarchy->num_rows>0){
                  $row_hierarchy = $res_hierarchy->fetch_array();;
                  $hierarchy=$row_hierarchy[0]+1;
              }
              // уменьшаем на 1 иерархию всех страниц являющихся братьями
              $res_hierarchy = DB::mysqliQuery(AS_DATABASE_SITE,"
                   UPDATE   
                       `". AS_DBPREFIX ."catalog` 
                   SET
                       hierarchy = hierarchy - 1
                   WHERE  `parent_id`=".$parent_id_old." && hierarchy>".$hierarchy_old." "  
                              );
              /*
              * Обновляем информацию в базе данных
              * Update data in db      
              */ 
              $res_update = DB::mysqliQuery(AS_DATABASE_SITE,"
                   UPDATE   
                       `". AS_DBPREFIX ."catalog` 
                   SET 
                       ".m_query($new_category_str, $Id).",
                       `url_path`='".$url_path."', 
                       `alias`='".$alias."', 
                       `hierarchy`=".$hierarchy.",
                       `content`='".$content."',
                       `content_bottom`='".$content_bottom."'
                   WHERE
                       `id`=".$category_id."
                   ");
          }
          // Родитель не измнился
          else{ 
              /*
              * Обновляем информацию в базе данных
              * Update data in db      
              */ 
              $res_update = DB::mysqliQuery(AS_DATABASE_SITE,"
                   UPDATE   
                       `". AS_DBPREFIX ."catalog` 
                   SET 
                       ".m_query($new_category_str, $Id).",
                       `url_path`='".$url_path."', 
                       `alias`='".$alias."',
                       `content`='".$content."',
                       `content_bottom`='".$content_bottom."'
                   WHERE
                       `id`=".$category_id."
                   ");
          }      
          /*--------------------------------------*/
          $dialog_msg= DB::GetSuccessExeption('success');
          $objResponse->assign("modal_content_replace","innerHTML",  $dialog_msg);
          $objResponse->call("modal_dialog_show");
      }
      catch (ExceptionDataBase $edb){
          $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
          $dialog_msg = $edb->GetNoticeExeption("save_error");
      }
      
  }
  else{
      $all_error="Проверьте правильность заполнения полей, отмеченных *. ";
  }
  $objResponse->assign("all_error","innerHTML", $all_error);
  return $objResponse;
}
/* 
* Функция формирвоания отчета
* Function get report
* @param array $Id 
* @return xajaxResponse 
*/ 
function Products_Filter($Id){
    $objResponse = new xajaxResponse(); 
    include_once AS_ROOT .'libs/shop_func.php';
        $as_categories_id = isset($Id['parent_id']) ? $Id['parent_id'] : 0; 
        $as_vendor_id = isset($Id['as_vendor_id']) ? $Id['as_vendor_id'] : 0; 
        $amount = isset($Id['amount']) ? $Id['amount'] : ''; 
        $button_link = isset($Id['button_link']) ? $Id['button_link'] : '';
        $mail_text_checked = isset($Id['mail_text']) ? $Id['mail_text'] : '';  
        $size_checked = isset($Id['size']) ? $Id['size'] : '';  
        $products_table=  getProductsTable($as_categories_id, $as_vendor_id, $amount, $button_link, $mail_text_checked, $size_checked);
        $objResponse->assign("products_table_replace","innerHTML",  $products_table);
        
    return $objResponse;
}