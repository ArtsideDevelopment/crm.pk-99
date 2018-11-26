<?php
/*   
* libs/form_func.php 
* File of form functions
* Файл функций формы
* @author Dulebsky A. 12.11.2014   
* @copyright © 2015 ArtSide   
*/
/** 
* Функция получения выпадающего списка из дерева
* function get select from tree
* @param string $select_name, $tree
* @return array $table_arr 
*/ 
function getSelectBlockFromTree($select_name, $tree, $active=0, $xajax_function="", $xajax_form=""){
    $select_block="";
    $onchange="";
    if(strlen(trim($xajax_function))>0){
        $onchange="onchange='xajax_".$xajax_function."(xajax.getFormValues(\"".$xajax_form."\"));'";
    }
    $select_block.="
        <select name='".$select_name."' id='".$select_name."' ".$onchange.">\n\t
            <option value='0'>------------</option>\n\t
            ".getSelectBlockFromTreeRecursuion($tree, $active)."
        </select>\n\t";   
    return $select_block;
}
/** 
* Рекурсивная функция получения элементов выпадающего списка
* function get select from tree
* @param string $select_name, $tree
* @return array $table_arr 
*/ 
function getSelectBlockFromTreeRecursuion($tree, $active=0){
    $select_block="";
    foreach ($tree as $node) {
        if($node['id']*1===$active*1){
            $select_block.="<option value='".$node['id']."' selected='selected'>".$node['value']."</option>\n\t";
        }
        else{
            $select_block.="<option value='".$node['id']."'>".$node['value']."</option>\n\t";
        }        
        if(isset($node['childs'])){
            $select_block.=getSelectBlockFromTreeRecursuion($node['childs'], $active);
        }
    }
    return $select_block;
}
/** 
* Функция получения выпадающего списка
* function get select list
* @param string $database, string $table, string $table_row_name, string $select_name, int $active, string $xajax_function, string $xajax_form, string $order_by, 
* @return array $table_arr 
*/ 
function getSelectBlock($database, $table, $table_row_name, $select_name, $active=0, $xajax_function="", $xajax_form="", $order_by=""){
    $select_block="";
    $onchange="";
    $order_by_query="";
    if(strlen(trim($order_by))>0) $order_by_query = $order_by;
    else $order_by_query = $table_row_name;
    try{
        $res = DB::mysqliQuery($database,"
            SELECT 
                `id`, `".$table_row_name."`
            FROM 
                `". AS_DBPREFIX."".$table."`               
            ORDER BY 
                `".$order_by_query."`" );  
    }
    catch (ExceptionDataBase $edb){
        throw new ExceptionDataBase("Ошибка в стеке запросов к базе данных",2, $edb);
    } 
    if($res->num_rows>0){
        if(strlen(trim($xajax_function))>0){
            $onchange="onchange='xajax_".$xajax_function."(xajax.getFormValues(\"".$xajax_form."\"));'";
        }
        $select_block.="
            <select name='".$select_name."' id='".$select_name."' ".$onchange." required>\n\t
                <option value='0'>------------</option>\n\t";
        while ($row=  $res->fetch_assoc()){  
            if($row['id']*1===$active*1){
                $select_block.="<option value='".$row['id']."' selected='selected'>".htmlspecialchars_decode($row[$table_row_name])."</option>\n\t";
            }
            else{
                $select_block.="<option value='".$row['id']."' >".htmlspecialchars_decode($row[$table_row_name])."</option>\n\t";
            }
            
        }
        $select_block.="</select>\n\t";       
    }    
    return $select_block;    
}

/** 
* Функция получения выпадающего списка с зависимостью
* function get select list width relation
* @param string $table, int $table_id 
* @return array $table_arr 
*/ 
function getSelectRelationBlock($database, $table, $table_row_name, $relation_row, $relation_val, $select_name, $active=0, $xajax_function="", $xajax_form=""){
    $select_block="";
    $onchange="";
    try{
        $res = DB::mysqliQuery($database,"
            SELECT 
                `id`, `".$table_row_name."`
            FROM 
                `". AS_DBPREFIX."".$table."`  
            WHERE
                `".  check_form($relation_row)."` = '".  check_form($relation_val)."'
            ORDER BY 
                `".$table_row_name."`" );  
    }
    catch (ExceptionDataBase $edb){
        throw new ExceptionDataBase("Ошибка в стеке запросов к базе данных",2, $edb);
    } 
    if($res->num_rows>0){
        if(strlen(trim($xajax_function))>0){
            $onchange="onchange='xajax_".$xajax_function."(xajax.getFormValues(\"".$xajax_form."\"));'";
        }
        $select_block.="
            <select name='".$select_name."' id='".$select_name."' ".$onchange.">\n\t
                <option value='0'>------------</option>\n\t";
        while ($row=  $res->fetch_assoc()){  
            if($row['id']==$active){
                $select_block.="<option value='".$row['id']."' selected='selected'>".$row[$table_row_name]."</option>\n\t";
            }
            else{
                $select_block.="<option value='".$row['id']."' >".$row[$table_row_name]."</option>\n\t";
            }
            
        }
        $select_block.="</select>\n\t";       
    }    
    return $select_block;    
}
/** 
* Функция получения выпадающего списка пользователей
* Function get hierarchy of user for select
* @param int $user_id
* @return string 
*/ 
function getUserChildSelect($user_id, $current_user_id=0){
        $user_select="";
        try{
            $res = DB::mysqliQuery(AS_DATABASE,"
                SELECT 
                    `id`, `parent_id`, `name`, `fam`, `patronymic`
                FROM 
                    `". AS_DBPREFIX ."lk_users` 
                WHERE 
                    `id`='".check_form($user_id)."' 
                    "  
            );
        }
        catch (ExceptionDataBase $edb){
            throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
        }
        if($res->num_rows>0){
            $row=  $res->fetch_assoc();
            $user_select.="
                <select id='parent_id' name='parent_id'>
                <option value='0'>------------</option>";
                if($row['id']==$current_user_id){
                    $user_select.="<option value='".$row['id']."' selected='selected'>".$row['fam']." ".$row['name']." ".$row['patronymic']."</option>";
                }   
                else{
                    $user_select.="<option value='".$row['id']."'>".$row['fam']." ".$row['name']." ".$row['patronymic']."</option>";
                }
                $user_select.=getUserChildSelectRecursion($row['id'], "", $current_user_id);
            $user_select.="
                </select>
                <script src='/skins/js/libs/chosen.jquery.min.js'></script>
                <script type='text/javascript'>
                    $('#parent_id').chosen({no_results_text: 'Упс...Такой человек не найден!', width:'100%'});                       
                </script>
                ";
        }
        return $user_select;
    }
/** 
* Рекурсивная функция получения иерархии пользователей для выпадающего списка
* Recursion function get hierarchy of user for select
* @param int $id, string $nbsp
* @return string 
*/ 
function getUserChildSelectRecursion($id, $nbsp, $current_user_id=0){
    $user_select="";    
    $nbsp.="--";
    try{
        $res = DB::mysqliQuery(AS_DATABASE,"
            SELECT 
                `id`, `name`, `fam`, `patronymic`
            FROM 
                `". AS_DBPREFIX ."lk_users` 
            WHERE 
                `parent_id`='".$id."'
                "  
        );
    }
    catch (ExceptionDataBase $edb){
        throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
    }
    $num_rows = $res->num_rows;
    if($num_rows == 0)  
        return $user_select;
    else{	     
        while($row = $res->fetch_assoc()){  
            if($current_user_id==$row['id']){
                $user_select.="
                    <option value='".$row['id']."' selected='selected'>".$nbsp." ".$row['fam']." ".$row['name']." ".$row['patronymic']."</option>";            
                $user_select.=self::getUserChildSelectRecursion($row['id'], $nbsp);
            }
            else{
                $user_select.="
                    <option value='".$row['id']."'>".$nbsp." ".$row['fam']." ".$row['name']." ".$row['patronymic']."</option>";            
                $user_select.=getUserChildSelectRecursion($row['id'], $nbsp);
            }
        }
        return $user_select;
    }
}
/** 
* Функция получения выпадающего списка для выбора родителя
* function get select list of parents
* @param string $table
* @return string $select_parent 
*/ 
function getParentSelect($table, $parent_selected=0, $select_name="parent_id"){
    $select_parent = "
        <select name='".$select_name."' id='".$select_name."' class='chosen-select'>
            <option value='0'>------------</option>
            ".  getParentSelectRecursion($table, 0, "", $parent_selected)."
        </select>\n\t";
    return $select_parent;
}
/** 
* Рекурсивная функция получения выпадающего списка для выбора родителя
* Recursion function get select list of parents
* @param string $table, int $parent_id, int $hierarchy, string $parent_selected
* @return array $table_arr 
*/ 
function getParentSelectRecursion($table, $parent_id=0, $hierarchy="", $parent_selected=0){
    $select_parent="";
    try{
        $res =  DB::mysqliQuery(AS_DATABASE_SITE,"
            SELECT 
                `id`, `hierarchy`, `name`  
            FROM 
                `". AS_DBPREFIX."".$table."` 
            WHERE 
                `parent_id`='".$parent_id."' 
            ORDER BY `hierarchy`"  
        );  
    }
    catch (ExceptionDataBase $edb){
        throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
    }     
    if($res->num_rows>0){        
        while ($row= $res->fetch_assoc()){  
            $time_hierarchy=$hierarchy.$row['hierarchy'].".";
            if($parent_selected==$row['id']){
                $select_parent.="<option value='".$row['id']."' selected='selected'>".$time_hierarchy." - ".$row['name']."</option>\n\t";
            }
            else{
                $select_parent.="<option value='".$row['id']."'>".$time_hierarchy." - ".$row['name']."</option>\n\t";
            }
            $select_parent.=getParentSelectRecursion($table, $row['id'], $time_hierarchy, $parent_selected);
        }
        return $select_parent;
    }
    else{
        return $select_parent;
    }
}
/** 
* Функция получения переключателя
* function get radio input element
* @param string $radio_name, int $cheched 
* @return string $radio_input 
*/ 
function getRadioInput($radio_name, $cheched=""){
    $radio_input="";
    if(strlen(trim($cheched))!=0){
        if($cheched==0){
            $radio_input="
            <label for='".$radio_name."_yes'>Да</label>
            <input id='".$radio_name."_yes' type='radio' value='1' name='".$radio_name."_set'>
            <label for='".$radio_name."_no'>Нет</label>
            <input id='".$radio_name."_no' type='radio' value='0' name='".$radio_name."_set' checked='checked' >";
        }
        elseif($cheched==1){
            $radio_input="
            <label for='".$radio_name."_yes'>Да</label>
            <input id='".$radio_name."_yes' type='radio' value='1' name='".$radio_name."_set' checked='checked' >
            <label for='".$radio_name."_no'>Нет</label>
            <input id='".$radio_name."_no' type='radio' value='0' name='".$radio_name."_set' >";
        }
    }
    else{
        $radio_input="
            <label for='".$radio_name."_yes'>Да</label>
            <input id='".$radio_name."_yes' type='radio' value='1' name='".$radio_name."_set'>
            <label for='".$radio_name."_no'>Нет</label>
            <input id='".$radio_name."_no' type='radio' value='0' name='".$radio_name."_set'>";
    }
   
    return $radio_input;    
}
/** 
* Функция получения checkbox set
* function get checkbox set
* @param string $check_name, int $cheched 
* @return string $radio_input 
*/ 
function getCheckBoxSet($check_name, $cheched=0){
    $check_input="";
    if($cheched*1!=0){
        $check_input='<input type="checkbox" name="'.$check_name.'" checked="checked"/>';
    }
    else{
        $check_input='<input type="checkbox" name="'.$check_name.'" />';
    }   
    return $check_input;    
}
/** 
* Функция получения набора checkbox
* function get checkbox
* @param string $database, string $table, string $check_name, array $check_str
* @return string $ $check_block
*/ 
function getCheckBox($database, $table, $check_name, $check_str=""){ 
    $check_block="";
    $check_arr=array();
    if(strlen(trim($check_str))>0){
        $check_arr_tmp=  explode(",", $check_str);        
        $check_arr=array_fill_keys($check_arr_tmp, "yes");
    }
    try{
        $res = DB::mysqliQuery(AS_DATABASE,"
            SELECT 
                `id`, `name`
            FROM 
                `". AS_DBPREFIX."".$table."`               
            ORDER BY `name`
        ");  
    }
    catch (ExceptionDataBase $edb){
        throw new ExceptionDataBase("Ошибка в стеке запросов к базе данных",2, $edb);
    } 
    if($res->num_rows>0){        
        while ($row=  $res->fetch_assoc()){  
            if(isset($check_arr[$row['id']])) $checked="checked='checked'";
            else $checked="";
            $check_block.="
                <div>
                <label>
                    <input type='checkbox' name='".$check_name."[]' value='".$row['id']."' ".$checked.">".$row['name']."
                </label>
                </div>
                ";
        }        
    }        
    return $check_block;    
}
/** 
* Функция получения поля для редактирования изображения
* function get image input
* @param string $input_name, string $img_src 
* @return string $radio_input 
*/ 
function getImageInput($input_name, $img_src){
    $image_input = "";
    $img_dest = AS_ROOT.$img_src;
    if(file_exists($img_dest)){
        $image_input.="
            <img src='/".$img_src."'>
            <input id='".$input_name."' name='".$input_name."' type='hidden' value='".$img_src."'>";
    }
    else{
        $image_input.="            
            <input id='".$input_name."' name='".$input_name."' type='hidden' value='".$img_src."'>";
    }   
   
    return $image_input;    
}
/** 
* Функция получения поля для редактирования изображения
* function get image input
* @param string $input_name, string $img_src 
* @return string $radio_input 
*/ 
function getProductImageInput($input_name, $img_src, $thumb_img_src){
    $image_input = "";
    $img_dest = AS_ROOT.$img_src;
    if(file_exists($img_dest)){
        $image_input.="
            <img src='/".$img_src."'>
            <input id='".$input_name."' name='".$input_name."' type='hidden' value='".$img_src."'>
            <input id='thumb_".$input_name."' name='thumb_".$input_name."' type='hidden' value='".$thumb_img_src."'>";
    }
    else{
        $image_input.="            
            <input id='".$input_name."' name='".$input_name."' type='hidden' value='".$img_src."'>";
    }   
   
    return $image_input;    
}
/** 
* Функция получения поля для редактирования изображения
* function get image input
* @param string $input_name, string $img_src 
* @return string $radio_input 
*/ 
function getCategoryImageInput($input_name, $img_src){
    $image_input = "";
    $img_dest = AS_CATEGORY_IMG_ROOT.$img_src;
    if(file_exists($img_dest)){
        $image_input.="
            <img src='".AS_CATEGORY_IMG.$img_src."'>
            <input id='".$input_name."' name='".$input_name."' type='hidden' value='".$img_src."'>
            <input id='thumb_".$input_name."' name='thumb_".$input_name."' type='hidden' value='thumb_".$img_src."'>";
    }
    else{
        $image_input.="            
            <input id='".$input_name."' name='".$input_name."' type='hidden' value='".$img_src."'>";
    }   
   
    return $image_input;    
}