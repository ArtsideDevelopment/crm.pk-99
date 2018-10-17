<?php
/*   
* libs/pages_func.php 
* File of pages functions  
* Файл функций управления страницаси
* @author ArtSide 05.04.2018   
* @copyright © 2018 ArtSide   
*/

/** 
* Функция получения таблицы страниц
* Function get pages table
* @param
* @return string 
*/ 
function getPagesTable($table){
    $page_table="
        <table width='100%' border='0' cellspacing='0' cellpadding='0' class='dataTables'>
            <thead>
                <tr class='tr_header'>
                    <th>Страница сайта</th>
                    <th>Ссылка</th>                    
                    <th>Действия</th>
                </tr>
            </thead>";
    $page_table.="<tbody>";
    $page_table.=getPagesStructTable(0, $table, "", "");
     $page_table.="</tbody>";
    $page_table.="</table>";
    return $page_table;
}
/** 
* Функция получения таблицы страниц 
* function get table of pages
* @param int $id, string $table, int $hierarchy string $nbsp
* @return string 
*/ 
function getPagesStructTable($parent_id, $table, $hierarchy, $nbsp){
    $st="";
    $nbsp.="&nbsp;&nbsp;";
    try{        
        $res = DB::mysqliQuery(AS_DATABASE_SITE,"
            SELECT *   
            FROM `". AS_DBPREFIX .$table."` 
            WHERE `parent_id`='".$parent_id."' 
            ORDER BY `hierarchy` "  
                );        
    }
    catch (ExceptionDataBase $edb){
        throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
    }    
    $num_rows = $res->num_rows;
    if($num_rows == 0)  
        return $st;
    else{	     
        while($row = $res->fetch_assoc()){   
            $time_hierarchy="";			
            $time_hierarchy=$hierarchy.$row['hierarchy']."."; 
            $st.="
                <tr>                    
                    <td align='left'>".$nbsp.$time_hierarchy." ".$row['name']."</td>
                    <td align='left'><a href='".AS_SITE.$row['url_path']."' target='_blank'>".$row['url_path']."</a></td>";
                    
            $del="";
            if($row['not_delete_set']!=1){
                $del="<a href=\"javascript:void(null);\" onclick=\"if (confirm('Вы действительно хотите удалить страницу?')) xajax_Delete_Page('type=content&id=".$row['id']."&hierarchy=".$row['hierarchy']."&parent_id=".$row['parent_id']."'); return false;\" class='btn btn-danger'><i class='icon-trash'></i></a>";
            }
            $st.="              
                
                <td align='center'>                    
                    ".$del."
                    <a href='/pages/edit-page?page_id=".$row['id']."' target='_blank'><i class='icon-note'></i></a>                   
                </td>
            </tr>
            ";
            $st.=getPagesStructTable($row['id'], $table, $time_hierarchy, $nbsp);
        }
        return $st;
    }
}