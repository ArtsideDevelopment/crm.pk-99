<?php
/*   
* /libs/query_set.php 
* File of Initialization variable for work with db
* Файл для инициализации переменных для работы с БД
* @author ArtSide Dulebsky A. 26.03.2014 
* @copyright © 2014 ArtSide   
*/
function m_query($query_arr, $source){
    require_once(AS_ROOT .'libs/security.php');
    $keys=array_keys($query_arr);
	$query="";
	$cnt=count($query_arr);
	for($i = 0; $i < $cnt; $i++){
            $source_var = isset($source[$keys[$i]]) ? $source[$keys[$i]] : '';
          if(is_array($source_var)){
              if($query_arr[$keys[$i]]=="checkbox"){
                    if(empty($query_arr[$keys[$i]])){
                        $query=$query."`".$keys[$i]."`"."='', ";
                    }
                    else{                        
                        $checkbox_query = "";
                        foreach($source_var as $val){
                            $checkbox_query.= check_form($val).",";
                        }
                        $query=$query."`".$keys[$i]."`"."='".trim($checkbox_query,",")."',";
                    }                    
                }
                continue;
          }
	  if(strlen(trim($source_var))==0){	    
	    if($query_arr[$keys[$i]]=="str"){
		  $query=$query."`".$keys[$i]."`"."='', ";
		}
                if($query_arr[$keys[$i]]=="set"){
		  $query=$query."`".$keys[$i]."`"."='', ";
		}
		  if($query_arr[$keys[$i]]=="numb"){ 
		  $query=$query."`".$keys[$i]."`"."=0, ";
		}	
		 if($query_arr[$keys[$i]]=="check"){ 
		  $query=$query."`".$keys[$i]."`"."=0, ";
		}	
                if($query_arr[$keys[$i]]=="date"){ 
		  $query=$query."`".$keys[$i]."`"."='', ";
		} 
	  }
	  else{
	    if($query_arr[$keys[$i]]=="str"){
		  $query=$query."`".$keys[$i]."`"."='".check_form(trim($source_var))."', ";
		}
		if($query_arr[$keys[$i]]=="set"){
		  $query=$query."`".$keys[$i]."`"."='".check_form($source_var)."', ";
		}	    
		if($query_arr[$keys[$i]]=="numb"){
		  $query=$query."`".$keys[$i]."`"."=".  trim(check_form(formatStrToNumber($source_var))).", ";
		}	 
		if($query_arr[$keys[$i]]=="check"){
		  if($source_var=='on') 
		    $query=$query."`".$keys[$i]."`"."=1, ";
		  else
		    $query=$query."`".$keys[$i]."`"."=0, ";
		}	
                if($query_arr[$keys[$i]]=="date"){
                    $query=$query."`".$keys[$i]."`"."='". check_form(formatDateToMysql($source_var))."', ";
                }                
	  }

	}
	return trim($query,", ");
    
  }
function find_query($query_arr, $source){
    $keys=array_keys($query_arr);
	$query="";
	$cnt=count($query_arr);
	for($i = 0; $i < $cnt; $i++){
	  if(isset($source[$keys[$i]])){	    
		  if($source[$keys[$i]]=='on') 
		    $query.="`".$keys[$i]."`"."=1 || ";		  
		}
	}
	return trim($query,"|| ");
    
  }