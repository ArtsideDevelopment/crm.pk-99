<?php
/*   
* libs/shop_func.php 
* File of shop functions  
* Файл функций управления разделом "Магазин"
* @author ArtSide 07.05.2018   
* @copyright © 2018 ArtSide   
*/

/** 
* Функция получения таблицы категорий интернет-магазина
* Function get categories table
* @param
* @return string 
*/ 
function getCategoriesTable($table){
    $table_body=getCategoriesStructTable(0, $table, "", "");
    $table = "<h3>У вас пока нет ни одной категории в интернет-магазине.</h3>";
    if(strlen(trim($table_body))>0){
        $table="
            <table width='100%' border='0' cellspacing='0' cellpadding='0' class='dataTables'>
                <thead>
                    <tr class='tr_header'>
                        <th>Категории интернет-магазина</th>
                        <th>Ссылка</th>                        
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    ".$table_body."
                </tbody>
            </table>";
    }    
    return $table;
}
/** 
* Функция получения таблицы страниц 
* function get table of pages
* @param int $id, string $table, int $hierarchy string $nbsp
* @return string 
*/ 
function getCategoriesStructTable($parent_id, $table, $hierarchy, $nbsp){
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
                <td align='left'><a href='".AS_SITE.$row['url_path']."' target='_blank'>".$row['url_path']."</a></td>                    
                <td align='center'>                    
                    <a href='javascript:void(null);' onclick='if (confirm(\"Вы действительно хотите удалить страницу?\")) xajax_Delete_Category(\"type=content&id=".$row['id']."&hierarchy=".$row['hierarchy']."&parent_id=".$row['parent_id']."\"); return false;' class='btn btn-danger'><i class='icon-trash'></i></a>
                    <a href='/shop/catalog/edit-category?category_id=".$row['id']."' class='btn btn-default'><i class='icon-note'></i></a>                   
                </td>
            </tr>
            ";
            $st.=getCategoriesStructTable($row['id'], $table, $time_hierarchy, $nbsp);
        }
        return $st;
    }
}
/** 
* Функция получения массива категорий
* Function get objects array
* @param
* @return string 
*/ 
function getCategoriesArray(){
    $categories_array = array();
    try{
        $res = DB::mysqliQuery(AS_DATABASE,"
            SELECT 
               id, name
            FROM 
                ". AS_DBPREFIX ."catalog             
            "  
        );
    }
    catch (ExceptionDataBase $edb){
        throw new ExceptionDataBase("Ошибка в стеке запросов к базе данных",2, $edb);
    }
    if($res->num_rows > 0)
    {
        while($row = $res->fetch_assoc()){
            $object_array[] = $row;
        }
    }
    return $object_array;
}
/** 
* Функция получения таблицы категорий интернет-магазина
* Function get categories table
* @param
* @return string 
*/ 
function getProductsTable($categories_id=0, $as_vendor_id=0, $amount="", $button_link="", $mail_text="", $size=""){  
    $query = "";
    // формирование запроса
    
    // Категория
    if($categories_id*1>0){                
        $query.="product_categories.as_catalog_id=".check_form($categories_id)."  AND ";        
    }
    // Производитель
    if($as_vendor_id*1>0){                
        $query.="products.as_vendor_id=".check_form($as_vendor_id)."  AND ";        
    }
    // Наличие товара 
    if(strlen(trim($amount))>0){
        $query.="products.amount=".check_form($amount)."  AND ";
    }
    //Статус ссылки “под кнопкой купить
    if(strlen(trim($button_link))>0){
        if($button_link*1==0){
            // Ссылка есть, но не отображается
            $query.="(products.button_link_text != '' AND products.button_link_show_set=0)  AND ";
        }
        elseif($button_link*1==1){
            // Ссылка есть
            $query.="(products.button_link_text != '' AND products.button_link_show_set=1)  AND ";
        }
        elseif($button_link*1==2){
            // Ссылки нет
            $query.="products.button_link_text = ''  AND ";
        }
        
    }    
    //Поле в письме клиенту не пустое
     if(strlen(trim($mail_text))>0){
         $query.="products.mail_text != ''  AND ";
     }
     
     //У товара есть размер
     if(strlen(trim($size))>0){
         $query.="products.sizes_old != ''  AND ";
     }
    
    if(strlen(trim($query))>0){
        $query="WHERE ". trim($query, ' AND ');
    }
    try{     
        $res = DB::mysqliQuery(AS_DATABASE_SITE,"
            SELECT 
                cost, cost_old, products.name, vendor_code, cost, 1c, amount, products.id as product_id, as_catalog_id, url_path
            FROM 
                ". AS_DBPREFIX ."products AS products
            JOIN
                ". AS_DBPREFIX ."product_categories AS product_categories
            ON
                products.id=product_categories.as_products_id
                ".$query."
            "  
        );             
    }
    catch (ExceptionDataBase $edb){
        throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
    }    
    $num_rows = $res->num_rows;
    if($num_rows>0){
        $table="
        <table width='100%' border='0' cellspacing='0' cellpadding='0' class='dataTables'>
            <thead>
                <tr class='tr_header'>
                    <th width='20px'></th>
                    <th width='250px'>Товар</th>
                    <th width='150px'>Категория</th> 
                    <th width='100px'>Артикул</th>
                    <th>Цена/старая цена</th>
                    <th>Код 1С</th>
                    <th>Количество</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>";
        $categories_array = DB::getTableDataArray(AS_DATABASE_SITE, 'catalog', 'name');
        while($row = $res->fetch_assoc()){
            $old_cost="";
            if($row['cost_old']*1>0) {
                $old_cost = $row['cost_old'];
            }
            $table.="
                <tr>
                    <td>
                        <input type='checkbox' name='productsChecked[]' value='".$row['product_id']."' />
                    </td>
                    <td align='left'>
                        ".$row['name']."
                        <div><a href='".AS_SITE.$row['url_path']."' target='_blank'>".$row['url_path']."</a></div>
                    </td>
                    <td align='left' id='category_".$row['product_id']."'>
                        ".$categories_array[$row['as_catalog_id']]."
                    </td>
                    <td align='left'>
                        ".$row['vendor_code']."                         
                    </td>
                    <td align='left'>
                        ".$row['cost']." <div class='old-cost'>".$old_cost."</div>
                        
                    </td>
                    <td align='left'>
                        ".$row['1c']."                         
                    </td>
                    <td align='left' id='amount_".$row['product_id']."'>
                        ".$row['amount']."                         
                    </td>
                    <td align='center'>                    
                        <a href='javascript:void(null);' onclick='if (confirm(\"Вы действительно хотите удалить товар?\")) xajax_Delete_Category(".$row['product_id']."); return false;' class='btn btn-danger'><i class='icon-trash'></i></a>
                        <a href='/shop/products/edit-product?product_id=".$row['product_id']."' class='btn btn-default'><i class='icon-note'></i></a>                   
                    </td>
                </tr>
                ";
        }
        $table.="</tbody>
        </table>";
    } 
    else{
        $table = "<h3>Не удалось найти ни одного товара по вашему запросу</h3>"; 
    }
    return $table;
}

/** 
* Функция получения таблицы категорий для группового редактирования
* Function get categories table for group edit 
* @param
* @return string 
*/ 
function getCategoriesTableCheck($table){
    $table_body=getCategoriesStructTableCheck(0, $table, "", "");
    $table = "<h3>У вас пока нет ни одной категории в интернет-магазине.</h3>";
    if(strlen(trim($table_body))>0){
        $table="
            <table width='100%' border='0' cellspacing='0' cellpadding='0' class='dataTablesCategories'>
                <thead>
                    <tr class='tr_header'>
                        <th></th>
                        <th>Категории интернет-магазина</th>                   
                    </tr>
                </thead>
                <tbody>
                    ".$table_body."
                </tbody>
            </table>";
    }    
    return $table;
}
/** 
* Функция получения таблицы категорий 
* function get table of categories
* @param int $id, string $table, int $hierarchy string $nbsp
* @return string 
*/ 
function getCategoriesStructTableCheck($parent_id, $table, $hierarchy, $nbsp){
    $st="";
    $nbsp.="&nbsp;&nbsp;";
    try{        
        $res = DB::mysqliQuery(AS_DATABASE_SITE,"
            SELECT *   
            FROM `". AS_DBPREFIX .$table."` 
            WHERE `parent_id`='".$parent_id."' 
            ORDER BY `id` "  
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
            $time_hierarchy=$hierarchy.$row['id']."."; 
            $st.="
            <tr>   
                <td>
                    <input type='checkbox' name='categoriesChecked[]' value='".$row['id']."' />
                </td>
                <td align='left'>".$nbsp.$time_hierarchy." ".$row['name']."</td>                
            </tr>
            ";
            $st.=getCategoriesStructTable($row['id'], $table, $time_hierarchy, $nbsp);
        }
        return $st;
    }
}

/** 
* Функция получения таблицы категорий 
* function get table of categories
* @param int $id, string $table, int $hierarchy string $nbsp
* @return string 
*/ 
function getVendorTableCheck(){
    $table="";
    try{        
        $res = DB::mysqliQuery(AS_DATABASE_SITE,"
            SELECT *   
            FROM `". AS_DBPREFIX ."vendor`  
            ORDER BY `name` "  
                );        
    }
    catch (ExceptionDataBase $edb){
        throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
    }    
    if($res->num_rows>0){
        $table="
            <table width='100%' border='0' cellspacing='0' cellpadding='0' class='dataTablesCategories'>
                <thead>
                    <tr class='tr_header'>
                        <th></th>
                        <th>Категории интернет-магазина</th>                   
                    </tr>
                </thead>
                <tbody>";
        while($row = $res->fetch_assoc()){   
            $table.="
            <tr>   
                <td>
                    <input type='checkbox' name='vendorChecked[]' value='".$row['id']."' />
                </td>
                <td align='left'>".htmlspecialchars_decode($row['name'])."</td>                
            </tr>
            ";
        }
        $table.="</tbody>
            </table>";        
    }
    return $table;
}