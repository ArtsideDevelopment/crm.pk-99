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
      require_once(AS_ROOT .'libs/uploads_func.php');
      $description = check_form(handleText($Id['description']));
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
                  `description`='".$description."',
                  `alias`='".$alias."',
                  `url_path`='".$url_path."',
                  `date`='".$date."'
              ");
          $product_id=DB::getInsertId();
          /*
          * Добавляем категории
          * insert categories     
          */ 
          // Основная категория
          $main_category_id = check_form($Id['as_main_category_id']);
          if($main_category_id*1>0){
                $res = DB::mysqliQuery(AS_DATABASE_SITE,"
                    INSERT 
                    INTO ". AS_DBPREFIX ."product_categories 
                    SET
                        as_catalog_id= ". $main_category_id .",
                        as_products_id= ".$product_id.",
                        main_category_set=1    
                    "  
                ); 
          }
          // Дополнительные категории
          if(isset($Id['categoriesChecked'])){
            $categories_checked = $Id['categoriesChecked'];
            $query="";            
            foreach ($categories_checked as $category_id) {
                if($main_category_id!==$category_id){
                    $query.="(".$category_id.", ".$product_id."),";
                }
            }    
            $res = DB::mysqliQuery(AS_DATABASE_SITE,"
                INSERT 
                INTO ". AS_DBPREFIX ."product_categories 
                    (as_catalog_id, as_products_id)
                VALUES
                    ".trim(check_form($query), ",").";
                "  
            );                                
          }          
          $dialog_msg= DB::GetSuccessExeption('success');
          $objResponse->assign("modal-dialog-notice__replace","innerHTML",  $dialog_msg);
          $preview_btn = getPreviewButton($url_path);
          $objResponse->assign("preview_btn_replace","innerHTML",  $preview_btn);
          $objResponse->call("ModalDialog.show('notice')");
      }
      catch (ExceptionDataBase $edb){
          $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
          $dialog_msg = $edb->GetNoticeExeption("save_error");
      }       
  } 
  else{
      $all_error="Проверьте правильность заполнения полей отмеченных *. ";
      $dialog_msg = DialogMessages::validation_error;
      $objResponse->assign("modal-dialog-notice__replace","innerHTML",  $dialog_msg);
      $objResponse->call("ModalDialog.show('notice')");
  }
  $objResponse->assign("all_error","innerHTML", $all_error);
  return $objResponse;
}
/* 
* Функция добавления продукта
* Function to add a new page
* @param array $Id 
* @return xajaxResponse 
*/ 
function Add_ProductScript($Id)
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
      require_once(AS_ROOT .'libs/uploads_func.php');
      $description = check_form(handleOutText($Id['description'], 'products/transfer', $url_path, $Id['url_path_old']));
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
                  `description`='".$description."',
                  `alias`='".$alias."',
                  `url_path`='".$url_path."',
                  `date`='".$date."'
              ");
          $product_id=DB::getInsertId();
          /*
          * Добавляем категории
          * insert categories     
          */ 
          // Основная категория
          $main_category_id = check_form($Id['as_main_category_id']);
          if($main_category_id*1>0){
                $res = DB::mysqliQuery(AS_DATABASE_SITE,"
                    INSERT 
                    INTO ". AS_DBPREFIX ."product_categories 
                    SET
                        as_catalog_id= ". $main_category_id .",
                        as_products_id= ".$product_id.",
                        main_category_set=1    
                    "  
                ); 
          }
          // Дополнительные категории
          if(isset($Id['categoriesChecked'])){
            $categories_checked = $Id['categoriesChecked'];
            $query="";            
            foreach ($categories_checked as $category_id) {
                if($main_category_id!==$category_id){
                    $query.="(".$category_id.", ".$product_id."),";
                }
            }    
            $res = DB::mysqliQuery(AS_DATABASE_SITE,"
                INSERT 
                INTO ". AS_DBPREFIX ."product_categories 
                    (as_catalog_id, as_products_id)
                VALUES
                    ".trim(check_form($query), ",").";
                "  
            );                                
          }          
          $dialog_msg= DB::GetSuccessExeption('success');
          $objResponse->assign("modal-dialog-notice__replace","innerHTML",  $dialog_msg);
          $preview_btn = getPreviewButton($url_path);
          $objResponse->assign("preview_btn_replace","innerHTML",  $preview_btn);
          $objResponse->call("ModalDialog.show('notice')");
      }
      catch (ExceptionDataBase $edb){
          $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
          $dialog_msg = $edb->GetNoticeExeption("save_error");
      }       
  } 
  else{
      $all_error="Проверьте правильность заполнения полей отмеченных *. ";
      $dialog_msg = DialogMessages::validation_error;
      $objResponse->assign("modal-dialog-notice__replace","innerHTML",  $dialog_msg);
      $objResponse->call("ModalDialog.show('notice')");
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
      require_once(AS_ROOT .'libs/uploads_func.php');
      $description = check_form(handleText($Id['description']));
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
                   `description`='".$description."',
                   `alias`='".$alias."',
                   `url_path`='".$url_path."',
                   `date_change`='".$date_change."'
               WHERE
                   `id`=".$product_id."
               ");         
          /*
          * Добавляем категории
          * insert categories     
          */ 
          // удаляем все предыдущие значения
          $res_del = DB::mysqliQuery(AS_DATABASE_SITE,"
                DELETE                 
                FROM 
                    ". AS_DBPREFIX ."product_categories               
                WHERE
                    `as_products_id`=".$product_id." 
                "  
            ); 
          // Основная категория
          $main_category_id = check_form($Id['as_main_category_id']);
          if($main_category_id*1>0){
                $res = DB::mysqliQuery(AS_DATABASE_SITE,"
                    INSERT 
                    INTO ". AS_DBPREFIX ."product_categories 
                    SET
                        as_catalog_id= ". $main_category_id .",
                        as_products_id= ".$product_id.",
                        main_category_set=1    
                    "  
                ); 
          }
          // Дополнительные категории
          if(isset($Id['categoriesChecked'])){
            $categories_checked = $Id['categoriesChecked'];
            $query="";            
            foreach ($categories_checked as $category_id) {
                if($main_category_id!==$category_id){
                    $query.="(".$category_id.", ".$product_id."),";
                }
            }    
            $res = DB::mysqliQuery(AS_DATABASE_SITE,"
                INSERT 
                INTO ". AS_DBPREFIX ."product_categories 
                    (as_catalog_id, as_products_id)
                VALUES
                    ".trim(check_form($query), ",").";
                "  
            );                                
          }          
          /*--------------------------------------*/
          $dialog_msg= DB::GetSuccessExeption('success');
          $objResponse->assign("modal-dialog-notice__replace","innerHTML",  $dialog_msg);
          $preview_btn = getPreviewButton($url_path);
          $objResponse->assign("preview_btn_replace","innerHTML",  $preview_btn);
          $objResponse->call("ModalDialog.show('notice')");
      }
      catch (ExceptionDataBase $edb){
          $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
          $dialog_msg = $edb->GetNoticeExeption("save_error");
      }
      
  }
  else{
      $all_error="Проверьте правильность заполнения полей, отмеченных *. ";
      $dialog_msg = DialogMessages::validation_error;
      $objResponse->assign("modal-dialog-notice__replace","innerHTML",  $dialog_msg);
      $objResponse->call("ModalDialog.show('notice')");
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
function Edit_Product_Script($Id)
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
      require_once(AS_ROOT .'libs/uploads_func.php');
      $description = check_form(handleOutText($Id['description'], 'products/transfer', $url_path, $Id['url_path_old']));
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
                   `description`='".$description."',
                   `alias`='".$alias."',
                   `url_path`='".$url_path."',
                   `date_change`='".$date_change."'
               WHERE
                   `id`=".$product_id."
               ");         
          /*
          * Добавляем категории
          * insert categories     
          */ 
          // удаляем все предыдущие значения
          $res_del = DB::mysqliQuery(AS_DATABASE_SITE,"
                DELETE                 
                FROM 
                    ". AS_DBPREFIX ."product_categories               
                WHERE
                    `as_products_id`=".$product_id." 
                "  
            ); 
          // Основная категория
          $main_category_id = check_form($Id['as_main_category_id']);
          if($main_category_id*1>0){
                $res = DB::mysqliQuery(AS_DATABASE_SITE,"
                    INSERT 
                    INTO ". AS_DBPREFIX ."product_categories 
                    SET
                        as_catalog_id= ". $main_category_id .",
                        as_products_id= ".$product_id.",
                        main_category_set=1    
                    "  
                ); 
          }
          // Дополнительные категории
          if(isset($Id['categoriesChecked'])){
            $categories_checked = $Id['categoriesChecked'];
            $query="";            
            foreach ($categories_checked as $category_id) {
                if($main_category_id!==$category_id){
                    $query.="(".$category_id.", ".$product_id."),";
                }
            }    
            $res = DB::mysqliQuery(AS_DATABASE_SITE,"
                INSERT 
                INTO ". AS_DBPREFIX ."product_categories 
                    (as_catalog_id, as_products_id)
                VALUES
                    ".trim(check_form($query), ",").";
                "  
            );                                
          }          
          /*--------------------------------------*/
          $dialog_msg= DB::GetSuccessExeption('success');
          $objResponse->assign("modal-dialog-notice__replace","innerHTML",  $dialog_msg);
          $preview_btn = getPreviewButton($url_path);
          $objResponse->assign("preview_btn_replace","innerHTML",  $preview_btn);
          $objResponse->call("ModalDialog.show('notice')");
      }
      catch (ExceptionDataBase $edb){
          $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
          $dialog_msg = $edb->GetNoticeExeption("save_error");
      }
      
  }
  else{
      $all_error="Проверьте правильность заполнения полей, отмеченных *. ";
      $dialog_msg = DialogMessages::validation_error;
      $objResponse->assign("modal-dialog-notice__replace","innerHTML",  $dialog_msg);
      $objResponse->call("ModalDialog.show('notice')");
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
        /*
        * проверяем все входящие переменные на sql иньекции
        * check all input variables on sql injections
        */ 
        $product_id=  check_form($Id);        
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
                    `as_products_id`=".$product_id.""  
                              ); 
            /*
            * Удаляем категорию из таблицы as_catalog
            * Delete category from table as_catalog
            */  
             $res_del = DB::mysqliQuery(AS_DATABASE_SITE,"
                DELETE FROM   
                    `". AS_DBPREFIX ."products`
                WHERE 
                    `id`=".$product_id.""  
                              ); 
            /*-----------------------------------*/
            DB::mysqliCommit();
            $dialog_msg = DialogMessages::delete_products_success;            
            $objResponse->assign("product-id-".$product_id, "innerHTML", "");
        }
        catch (ExceptionDataBase $edb){
            $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
            $dialog_msg = $edb->GetNoticeExeption("save_error");
        }                 
    }
    $objResponse->assign("modal-dialog-notice__replace","innerHTML",  $dialog_msg);
    $objResponse->call("ModalDialog.show('notice')");
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
          $content = check_form(handleText($Id['content']));
          $content_bottom = check_form(handleText($Id['content_bottom']));
          
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
          $objResponse->assign("modal-dialog-notice__replace","innerHTML",  $dialog_msg);
          $preview_btn = getPreviewButton($url_path);
          $objResponse->assign("preview_btn_replace","innerHTML",  $preview_btn);
          $objResponse->call("ModalDialog.show('notice')");
      }
      catch (ExceptionDataBase $edb){
          $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
          $dialog_msg = $edb->GetNoticeExeption("save_error");
      }       
  } 
  else{
      $all_error="Проверьте правильность заполнения полей отмеченных *. ";
      $dialog_msg = DialogMessages::validation_error;
      $objResponse->assign("modal-dialog-notice__replace","innerHTML",  $dialog_msg);
      $objResponse->call("ModalDialog.show('notice')");
  }
  $objResponse->assign("all_error","innerHTML", $all_error);
  return $objResponse;
}
/* 
* Функция добавления категории
* Function to add a new category
* @param array $Id 
* @return xajaxResponse 
*/ 
function Add_Category_Script($Id)
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
          $content = check_form(handleOutText($Id['content'], 'categories/transfer', $url_path, $Id['url_path_old']));
          $content_bottom = check_form(handleOutText($Id['content_bottom'], 'categories/transfer', $url_path, $Id['url_path_old']));
          
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
          $objResponse->assign("modal-dialog-notice__replace","innerHTML",  $dialog_msg);
          $preview_btn = getPreviewButton($url_path);
          $objResponse->assign("preview_btn_replace","innerHTML",  $preview_btn);
          $objResponse->call("ModalDialog.show('notice')");
      }
      catch (ExceptionDataBase $edb){
          $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
          $dialog_msg = $edb->GetNoticeExeption("save_error");
      }       
  } 
  else{
      $all_error="Проверьте правильность заполнения полей отмеченных *. ";
      $dialog_msg = DialogMessages::validation_error;
      $objResponse->assign("modal-dialog-notice__replace","innerHTML",  $dialog_msg);
      $objResponse->call("ModalDialog.show('notice')");
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
            $objResponse->assign("category-id-".$catalog_id, "innerHTML", "");
        }
        catch (ExceptionDataBase $edb){
            $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
            $dialog_msg = $edb->GetNoticeExeption("save_error");
        }                 
    }
    $objResponse->assign("modal-dialog-notice__replace","innerHTML",  $dialog_msg);
    $objResponse->call("ModalDialog.show('notice')");
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
      $url_prefix="";
      // проверяем все входящие переменные на наличие xss и sql инъекции
      $category_id=check_form($Id['category_id']);
      $parent_id=check_form($Id['parent_id']);
      $parent_id_old=check_form($Id['parent_id_old']);
      $hierarchy_old=check_form($Id['hierarchy_old']);
      $alias=str_replace(" ", "-", strtolower(trim(trim(check_form($Id['alias'])),"/")));
      require_once(AS_ROOT .'libs/uploads_func.php');
      $content = check_form(handleOutText($Id['content'], 'categories/transfer', $url_path, $Id['url_path_old']));
      $content_bottom = check_form(handleOutText($Id['content_bottom'], 'categories/transfer', $url_path, $Id['url_path_old']));
      //$content = check_form(str_replace('../uploads/', AS_HOST.'uploads/', $Id['content']));
      //$content_bottom = check_form(str_replace('../uploads/', AS_HOST.'uploads/', $Id['content_bottom']));
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
          else{
              $url_prefix="catalog/";
          }
          // формируем url адрес текущей страницы
          $url_path=$url_prefix.trim($url_path."/".$alias, "/"); // удаляем лишние / он появляется если parent_id = 0 
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
          $objResponse->assign("modal-dialog-notice__replace","innerHTML",  $dialog_msg);
          $preview_btn = getPreviewButton($url_path);
          $objResponse->assign("preview_btn_replace","innerHTML",  $preview_btn);
          $objResponse->call("ModalDialog.show('notice')");
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
* Функция редактирования категории без использования скрипта 
* Function to edit a category 
* @param array $Id 
* @return xajaxResponse 
*/ 
function Edit_Category_Script_Free($Id)
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
      $url_prefix="";
      // проверяем все входящие переменные на наличие xss и sql инъекции
      $category_id=check_form($Id['category_id']);
      $parent_id=check_form($Id['parent_id']);
      $parent_id_old=check_form($Id['parent_id_old']);
      $hierarchy_old=check_form($Id['hierarchy_old']);
      $alias=str_replace(" ", "-", strtolower(trim(trim(check_form($Id['alias'])),"/")));
      require_once(AS_ROOT .'libs/uploads_func.php');
      $content = check_form(handleText($Id['content']));
      $content_bottom = check_form(handleText($Id['content_bottom']));
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
          else{
              $url_prefix="catalog/";
          }
          // формируем url адрес текущей страницы
          $url_path=$url_prefix.trim($url_path."/".$alias, "/"); // удаляем лишние / он появляется если parent_id = 0 
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
          $objResponse->assign("modal-dialog-notice__replace","innerHTML",  $dialog_msg);
          $preview_btn = getPreviewButton($url_path);
          $objResponse->assign("preview_btn_replace","innerHTML",  $preview_btn);
          $objResponse->call("ModalDialog.show('notice')");
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
* Функция редактирования описания под товаром
* Function to edit a content bottom
* @param array $Id 
* @return xajaxResponse 
*/ 
function Edit_Category_Content_Bottom($Id)
{
    $objResponse = new xajaxResponse();
    $all_error = "";
    if(strlen(trim($Id['content_bottom']))>0){
        //инициализация переменных  
        $url_path = $Id['url_path_current'];
        require_once(AS_ROOT .'libs/uploads_func.php');
        $content_bottom = check_form(handleOutText($Id['content_bottom'], 'categories/transfer', $url_path, $Id['url_path_old']));
        $category_id=check_form($Id['category_id']);
        try {          
            /*
            * Обновляем информацию в базе данных
            * Update data in db      
            */ 
            $res_update = DB::mysqliQuery(AS_DATABASE_SITE,"
               UPDATE   
                   `". AS_DBPREFIX ."catalog` 
               SET 
                   `content_bottom`='".$content_bottom."'
               WHERE
                   `id`=".$category_id."
               ");
          
          /*--------------------------------------*/
          $dialog_msg= DB::GetSuccessExeption('success');          
          $objResponse->assign("modal-dialog-notice__replace","innerHTML",  $dialog_msg);
          $preview_btn = getPreviewButton($url_path);
          $objResponse->assign("preview_btn_replace","innerHTML",  $preview_btn);
          $objResponse->call("ModalDialog.show('notice')");
          sleep(2);
          $objResponse->script("window.location.reload()");
      }
      catch (ExceptionDataBase $edb){
          $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
          $dialog_msg = $edb->GetNoticeExeption("save_error");
      }
      
  }
  else{
      $all_error="Поле \"Описание под товаром\" должно быть заполнено";
  }
  $objResponse->assign("form_error_content_bottom","innerHTML", $all_error);
  return $objResponse;
}
/* 
* Функция редактирования описания под товаром
* Function to edit a content bottom
* @param array $Id 
* @return xajaxResponse 
*/ 
function Edit_Category_Content_Top($Id)
{
    $objResponse = new xajaxResponse();
    $all_error = "";
    if(strlen(trim($Id['content_bottom']))>0){
        //инициализация переменных  
        $url_path = $Id['url_path_current'];
        require_once(AS_ROOT .'libs/uploads_func.php');
        $content = check_form(handleOutText($Id['content'], 'categories/transfer', $url_path, $Id['url_path_old']));
        $category_id=check_form($Id['category_id']);
        try {          
            /*
            * Обновляем информацию в базе данных
            * Update data in db      
            */ 
            $res_update = DB::mysqliQuery(AS_DATABASE_SITE,"
               UPDATE   
                   `". AS_DBPREFIX ."catalog` 
               SET 
                   `content`='".$content."'
               WHERE
                   `id`=".$category_id."
               ");
          
          /*--------------------------------------*/
          $dialog_msg= DB::GetSuccessExeption('success');          
          $objResponse->assign("modal-dialog-notice__replace","innerHTML",  $dialog_msg);
          $preview_btn = getPreviewButton($url_path);
          $objResponse->assign("preview_btn_replace","innerHTML",  $preview_btn);
          $objResponse->call("ModalDialog.show('notice')");
          sleep(2);
          $objResponse->script("window.location.reload()");
      }
      catch (ExceptionDataBase $edb){
          $edb->HandleExeption(__FILE__."->".__FUNCTION__."->".__LINE__);
          $dialog_msg = $edb->GetNoticeExeption("save_error");
      }
      
  }
  else{
      $all_error="Поле \"Описание под товаром\" должно быть заполнено";
  }
  $objResponse->assign("form_error_content_bottom","innerHTML", $all_error);
  return $objResponse;
}
/* 
* Функция добавления изображения по ссылке
* Function add image from link
* @param array $Id 
* @return xajaxResponse 
*/ 
function Add_Link_Img($Id)
{
    $objResponse = new xajaxResponse();
    $all_error = "";
    if(strlen(trim($Id['link_img_url_path']))>0 && strlen(trim($Id['img_folder']))){
        //инициализация переменных  
        $link_img = trim(trim((string)$Id['link_img_url_path'],'"'), '/');
        $folder = $Id['img_folder'];
        require_once(AS_ROOT .'libs/uploads_func.php');
        $tempFile = uploadOutImagesCurlFromAnySource($link_img, $folder);
        $fileParts = pathinfo($tempFile);
        $uploadDir = AS_IMG_ROOT.trim($folder, '/').'/';
        $fileDestName = trim($fileParts['filename'],'tmp_').".".strtolower($fileParts['extension']);
        $fileDest = $uploadDir.$fileDestName;
        if(file_exists($fileDest)){
            $time = time();
            $fileDest=$uploadDir.$fileParts['filename']."_".$time.".".strtolower($fileParts['extension']);          
            $fileDestThumb=$uploadDir. "thumb_".$fileParts['filename']."_".$time.".".strtolower($fileParts['extension']);
        }
        else {
            $fileDestThumb=$uploadDir. "thumb_".$fileDestName; 
        }
        $width = 0;
        $thumb_width = 0;
        switch($folder)  
        {        
            case 'categories':
                $width = AS_CATEGORY_IMG_WIDTH;
                $thumb_width = AS_CATEGORY_THUMB_IMG_WIDTH;
            break;
            case 'product':
                      
            break; 
            default :
            break;
        } 
        if($width>0){
            imgResizeWidth($tempFile, $fileDest, $width);
            imgResizeWidth($tempFile, $fileDestThumb, $thumb_width);
        }
        unlink($tempFile);

        $dialog_msg= DB::GetSuccessExeption('success');          
        $objResponse->assign("modal-dialog-notice__replace","innerHTML",  $dialog_msg);
        $img_data_block = 
                '<input type="hidden" name="img" id="img" value="'.$fileDestName.'">
                <img src="'.AS_IMG_PATH.$folder.'/thumb_'.$fileDestName.'">';
        $objResponse->assign($folder."_img_data_block","innerHTML",  $img_data_block);
        $objResponse->call("ModalDialog.show('notice')");
  }
  else{
      $all_error="Поле \"Ссылка на изображение\" должно быть заполнено";
  }
  $objResponse->assign("form_error_link_img","innerHTML", $all_error);
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
        $objResponse->call("artside_data_tables.init('.dataTablesProduct', true, true)");
    return $objResponse;
}
/* 
* Функция формирвоания отчета
* Function get report
* @param array $Id 
* @return xajaxResponse 
*/ 
function Modal_Dialog_Open($Id){
    $objResponse = new xajaxResponse(); 
    $objResponse->assign("modal-dialog-notice__replace","innerHTML", "test");
    $objResponse->call("ModalDialog.show('notice')");
        
    return $objResponse;
}