<?php

/** 
* Функция обновления иерархии категорий
* function get table of categories
* @param int $id, string $table, int $hierarchy string $nbsp
* @return string 
*/ 
function fixCategoriesHierarhy(){       
    try {
        // уменьшаем на 1 иерархию всех страниц являющихся братьями
        for ($index = 172; $index < 407; $index++) {
            $res_hierarchy = DB::mysqliQuery(AS_DATABASE_SITE,"
                UPDATE   
                   `". AS_DBPREFIX ."catalog` 
                SET
                   hierarchy = ".$index." - 1
                WHERE  
                    id =".$index." "  
                          );
        }       
        
    } catch (ExceptionDataBase $edb) {
        throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
    }
    return true;
}