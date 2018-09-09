<?php
/*   
* libs/classes/Page.class.php 
* File of the Page class  
* Файл класса для работы со страницей 
* @author Dulebsky A. 15.06.2015   
* @copyright © 2015 ArtSide   
*/
class Tree{    
    private $_tree_array=array();
    private $_tree=array();

    /** 
    * Конструктор класса
    * Class construct
    * @param 
    * @return boolean 
    */ 
    public function __construct($table, $query, $query_id=0){
        $query_arr = explode(',',str_replace(' ', '', $query));
        try{        
            $res =  DB::mysqliQuery(AS_DATABASE, "
                SELECT 
                    id, parent_id, ".$query." 
                FROM 
                    ". AS_DBPREFIX .$table."
                " 
                    
            );        
        }
        catch (ExceptionDataBase $edb){
            throw new ExceptionDataBase("Ошибка в запросе к базе данных",2, $edb);
        } 
        $menu_array = array();
        if($res->num_rows>0){            
            while($row = $res->fetch_assoc())
            {  
                $str = "";
                $row_n = array();
                foreach ($query_arr as $value) {
                    $str.= $row[$value]." ";
                }
                $row_n['id'] = $row['id'];
                $row_n['parent_id'] = $row['parent_id'];
                $row_n['value'] = trim($str);
                $menu_array[$row['id']]=$row_n;
            }            
        } 
        $this->_tree_array = $menu_array;
    }      
    
    /* 
    * Рекурсивная функция получения дерева (Tommy Lacroix)
    * Recursion function get tree (Tommy Lacroix)  
    * @param 
    * @return boolean 
    */ 
    public function getTree(){  
        $tree_array = $this->_tree_array;
	$tree = array();
	foreach ($tree_array as $id => &$node) {
            //dbg($tree_array);
            //Если нет вложений
            if (!$node['parent_id']){
                    $tree[$id] = &$node;                    
            }else{ 
                //Если есть потомки то перебераем массив
                $tree_array[$node['parent_id']]['childs'][$id] = &$node;
                //dbg($tree_array);
            }
            //dbg($tree_array);
	}
        // сортируем массив по возрастанию
        ksort($tree);
        //krsort($tree);
        $this->_tree = $tree;
	return $this->_tree;
    }
    public function getTreeFlat($tree){
        $flat_arr = array();
        foreach ($tree as $node) {
            $node_arr = array_values($node);
            foreach ($array as $key => $value) {
                
            }
            if(isset($node['childs'])){
                $this->getTreeFlatRecursion($node);
            }            
        }
        return ;
    }
    public function getTreeFlatRecursion($tree){
        $flat_arr = array();
        foreach ($tree as $node) {
            if(isset($node['childs'])){
                $this->getTreeFlat($node);
            }            
        }
        return ;
    }
}