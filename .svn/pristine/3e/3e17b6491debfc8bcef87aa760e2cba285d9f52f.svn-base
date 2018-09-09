<?php
/**    
* The dashboard functions   
* Функции дашборда
* @author ArtSide Dulebsky A.   
* @copyright © 30.11.2015 ArtSide   
*/ 

/** 
* Функция поиска дежурного агента
* Function get duty handler agent
* @param 
* @return string 
*/
function getDashboard($content_id, $user_type="", $user_id=0)  
{  
    $dashboard ="";
    $query="";
    if($user_id*1>0){
        $query.= " AND (`as_lk_users_id`=".  check_form($user_id)." || `as_lk_users_id`=0)";               
    }   
    if(strlen(trim($user_type))>0){
        $query.= " AND (`user_type`='".  check_form($user_type) ."' || `user_type`='all')";  
    }
    try{        
        $res = DB::mysqliQuery(AS_DATABASE,"
            SELECT `function`   
            FROM 
                `". AS_DBPREFIX."dashboard` 
            WHERE 
                `as_content_id`=".  check_form($content_id)." ".$query."
        "); 
    }
    catch (ExceptionDataBase $edb){
        throw new ExceptionDataBase("Ошибка в стеке запросов к базе данных",2, $edb);
    }
    if($res->num_rows>0){
        while ($row = $res->fetch_array()){
            $dashboard_func = "get" . $row[0] ."Widget";
            if(function_exists($dashboard_func)){
               $dashboard.= $dashboard_func();
            }            
        }
    }
    return $dashboard;
}
/** 
* Функция получения виджета стабилизационного фонда
* Function get stab fond widget
* @param 
* @return string 
*/
function getStabFondWidget()  
{  
    $widget = "";
    try{        
        $res = DB::mysqliQuery(AS_DATABASE,"
            SELECT sum(stab_fond) as `total_stab_fond`   
            FROM 
                `". AS_DBPREFIX."orders` 
            WHERE 
                `status`='manager_paid'
        "); 
    }
    catch (ExceptionDataBase $edb){
        throw new ExceptionDataBase("Ошибка в стеке запросов к базе данных",2, $edb);
    }
    if($res->num_rows>0){
        $row = $res->fetch_array();
        $widget = "
            <div class='col-md-4'>
                <div class='widget'>
                    <div class='widget_stat'>
                        <div class='header'>".number_format($row[0], 0, '.', ' ')." &#8381;</div>
                        <div class='font discription'>Стабилизационный фонд</div>               
                    </div> 
                    <div class='widget_icon'>
                        <span class='icon-wallet'></span>            
                    </div>
                    <div class='clear'></div>
                </div>            
            </div>";
        
    }
    return $widget;
}
/** 
* Функция получения виджета баланса р/с
* Function get balance
* @param 
* @return string 
*/
function getBalanceWidget()  
{  
    $widget = "";
    try{        
        $res = DB::mysqliQuery(AS_DATABASE,"
            SELECT sum(pay_sum) as `balance`   
            FROM 
                `". AS_DBPREFIX."invoices` 
        "); 
    }
    catch (ExceptionDataBase $edb){
        throw new ExceptionDataBase("Ошибка в стеке запросов к базе данных",2, $edb);
    }
    if($res->num_rows>0){
        $row = $res->fetch_array();
        $widget = "
            <div class='col-md-4'>
                <div class='widget'>
                    <div class='widget_stat'>
                        <div class='header'>".number_format($row[0], 0, '.', ' ')." &#8381;</div>
                        <div class='font discription'>Баланс счета</div>               
                    </div> 
                    <div class='widget_icon'>
                        <span class='icon-wallet'></span>            
                    </div>
                    <div class='clear'></div>
                </div>            
            </div>";
        
    }
    return $widget;
}
/** 
* Функция получения виджета необработанных заявок
* Function get order requests widget
* @param 
* @return string 
*/
function getOrdersRequestWidget()  
{  
    $widget = "";
    try{        
        $res = DB::mysqliQuery(AS_DATABASE,"
            SELECT count(id) as `request_count`   
            FROM 
                `". AS_DBPREFIX."orders` 
            WHERE
                `result`='request'
        "); 
    }
    catch (ExceptionDataBase $edb){
        throw new ExceptionDataBase("Ошибка в стеке запросов к базе данных",2, $edb);
    }
    if($res->num_rows>0){
        $row = $res->fetch_array();
        $widget = "
            <div class='col-md-4'>
                <div class='widget'>
                    <div class='widget_stat'>
                        <div class='header'>".$row[0]." </div>
                        <div class='font discription'>Необработанных заявок</div>               
                    </div> 
                    <div class='widget_icon'>
                        <span class='icon-call-out'></span>            
                    </div>
                    <div class='clear'></div>
                </div>            
            </div>";
        
    }
    return $widget;
}