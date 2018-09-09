<?php
/*   
* libs/xajax/xajax_func/pages_func_xajax.php 
* Functions for working with pages    
* Функции для работы с пользователями
* @author ArtSide A. 06.04.2018  
* @copyright © 2018 ArtSide   
*/
/* 
* Функция добавления новой страницы
* Function to add a new page
* @param array $Id 
* @return xajaxResponse 
*/ 
function Add_Page($Id)
{
  $objResponse = new xajaxResponse();
  require_once(AS_ROOT .'libs/query_set.php');
  require_once(AS_ROOT .'libs/query_variables/query_content.php'); 
  $all_error="";
   // Подключаем проверку заполнения полей
  include_once AS_ROOT .'libs/check/check_page.php';   
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
                  `". AS_DBPREFIX ."content`
              WHERE  
                  `parent_id`=".$parent_id."
              ");
          if($res_hierarchy->num_rows>0){
              $row_hierarchy = $res_hierarchy->fetch_array();
              $hierarchy=$row_hierarchy[0]+1;
          }
          // находим url адрес родителя для построения текущего url адреса страницы      
          if($parent_id*1>0){
              $res_parent = DB::mysqliQuery(AS_DATABASE_SITE,"
                  SELECT 
                      `url_path` 
                  FROM
                      `". AS_DBPREFIX ."content` 
                  WHERE  
                      `id`=".$parent_id."
                  "); 
              if($res_parent->num_rows>0){
                   $row_parent = $res_parent->fetch_array();
                   $url_path=trim($row_parent[0], "/"); // удаляем лишние / чтобы сформировать необходимый url
              }
          }
          // формируем url адрес текущей страницы
          $url_path=trim($url_path."/".$alias, "/"); // удаляем лишние / он появляется если parent_id = 0   
          /*
          * Добавляем информацию о новой странице в базу данных
          * insert page data in to db      
          */ 
          require_once(AS_ROOT .'libs/uploads_func.php');
          $content = check_form(handleOutText($Id['content'], 'content/transfer', $url_path, $Id['url_path_old']));
          //$content = check_form($Id['content']);
          $res = DB::mysqliQuery(AS_DATABASE_SITE,"
              INSERT INTO
                  `". AS_DBPREFIX ."content`
              SET 
                  ".m_query($new_page_str, $Id).",                  
                  `url_path`='".$url_path."', 
                  `alias`='".$alias."', 
                  `hierarchy`=".$hierarchy.",
                  `date`='".$date."',
                  `content`='".$content."',
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
* Функция редактирования страницы 
* Function to edit a page 
* @param array $Id 
* @return xajaxResponse 
*/ 
function Edit_Page($Id)
{
  $objResponse = new xajaxResponse();
  // подключаем необходимые библиотеки
  require_once(AS_ROOT .'libs/query_set.php');
  require_once(AS_ROOT .'libs/query_variables/query_content.php');
  // Подключаем проверку заполнения полей
  $all_error="";
  include_once AS_ROOT .'libs/check/check_page.php';   
  if($errors==0){
      //инициализация переменных      
      $url_path="";
      // проверяем все входящие переменные на наличие xss и sql инъекции
      $page_id=check_form($Id['page_id']);
      $parent_id=check_form($Id['parent_id']);
      $parent_id_old=check_form($Id['parent_id_old']);
      $hierarchy_old=check_form($Id['hierarchy_old']);
      $alias=str_replace(" ", "-", strtolower(trim(trim(check_form($Id['alias'])),"/")));
      
      //$content = check_form(str_replace('../uploads/content/transfer/', AS_HOST.'uploads/content/transfer/', $Id['content']));
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
                      `". AS_DBPREFIX ."content` 
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
          require_once(AS_ROOT .'libs/uploads_func.php');
          $content = check_form(handleOutText($Id['content'], 'content/transfer', $url_path, $Id['url_path_old']));
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
                      `". AS_DBPREFIX ."content` 
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
                       `". AS_DBPREFIX ."content` 
                   SET
                       hierarchy = hierarchy - 1
                   WHERE  `parent_id`=".$parent_id_old." && hierarchy>".$hierarchy_old." "  
                              );
              /*
              * Обновляем информацию странице в базе данных
              * Update page data in db      
              */ 
              $res_update = DB::mysqliQuery(AS_DATABASE_SITE,"
                   UPDATE   
                       `". AS_DBPREFIX ."content` 
                   SET 
                       ".m_query($new_page_str, $Id).",
                       `url_path`='".$url_path."', 
                       `alias`='".$alias."', 
                       `hierarchy`=".$hierarchy.",
                       `content`='".$content."'
                   WHERE
                       `id`=".$page_id."
                   ");
          }
          // Родитель не измнился
          else{ 
              /*
              * Обновляем информацию странице в базе данных
              * Update page data in db      
              */ 
              $res_update = DB::mysqliQuery(AS_DATABASE_SITE,"
                   UPDATE   
                       `". AS_DBPREFIX ."content` 
                   SET 
                       ".m_query($new_page_str, $Id).",
                       `url_path`='".$url_path."', 
                       `alias`='".$alias."',
                       `content`='".$content."'
                   WHERE
                       `id`=".$page_id."
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
* Функция редактирования страницы 
* Function to edit a page 
* @param array $Id 
* @return xajaxResponse 
*/ 
function Edit_Page_Script_Free($Id)
{
  $objResponse = new xajaxResponse();
  // подключаем необходимые библиотеки
  require_once(AS_ROOT .'libs/query_set.php');
  require_once(AS_ROOT .'libs/query_variables/query_content.php');
  // Подключаем проверку заполнения полей
  $all_error="";
  include_once AS_ROOT .'libs/check/check_page.php';   
  if($errors==0){
      //инициализация переменных      
      $url_path="";
      // проверяем все входящие переменные на наличие xss и sql инъекции
      $page_id=check_form($Id['page_id']);
      $parent_id=check_form($Id['parent_id']);
      $parent_id_old=check_form($Id['parent_id_old']);
      $hierarchy_old=check_form($Id['hierarchy_old']);
      $alias=str_replace(" ", "-", strtolower(trim(trim(check_form($Id['alias'])),"/")));
      
      //$content = check_form(str_replace('../uploads/content/transfer/', AS_HOST.'uploads/content/transfer/', $Id['content']));
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
                      `". AS_DBPREFIX ."content` 
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
          require_once(AS_ROOT .'libs/uploads_func.php');
          $content = check_form(handleText($Id['content']));
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
                      `". AS_DBPREFIX ."content` 
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
                       `". AS_DBPREFIX ."content` 
                   SET
                       hierarchy = hierarchy - 1
                   WHERE  `parent_id`=".$parent_id_old." && hierarchy>".$hierarchy_old." "  
                              );
              /*
              * Обновляем информацию странице в базе данных
              * Update page data in db      
              */ 
              $res_update = DB::mysqliQuery(AS_DATABASE_SITE,"
                   UPDATE   
                       `". AS_DBPREFIX ."content` 
                   SET 
                       ".m_query($new_page_str, $Id).",
                       `url_path`='".$url_path."', 
                       `alias`='".$alias."', 
                       `hierarchy`=".$hierarchy.",
                       `content`='".$content."'
                   WHERE
                       `id`=".$page_id."
                   ");
          }
          // Родитель не измнился
          else{ 
              /*
              * Обновляем информацию странице в базе данных
              * Update page data in db      
              */ 
              $res_update = DB::mysqliQuery(AS_DATABASE_SITE,"
                   UPDATE   
                       `". AS_DBPREFIX ."content` 
                   SET 
                       ".m_query($new_page_str, $Id).",
                       `url_path`='".$url_path."', 
                       `alias`='".$alias."',
                       `content`='".$content."'
                   WHERE
                       `id`=".$page_id."
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
* Функция удаления страницы 
* Function to delit a page 
* @param array $Id 
* @return xajaxResponse 
*/ 
function Delete_Page($Id){
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