<?php
// modules/_novostroiki
/**  
* Controller  
* Контроллер  
* @author IT studio IRBIS-team  
* @copyright © 2009 IRBIS-team  
*/  
/////////////////////////////////////////////////////////  

/**  
* Generation of page of an error at access out of system  
* Генерация страницы ошибки при доступе вне системы  
*/  
    if(!defined('AS_KEY'))  
    {  
       Router::routeErrorPage404();   
    }      
///////////////////////////////////////////////////////////  

/**  
* check user access 
* проверяем права доступа 
*/    
   $PAGE = Page::getInstance(Router::getUrlPath());
   if(Users::checkUserAccess($PAGE::getId())){     
       include_once AS_ROOT .'libs/excel_func.php';             
       //loadProductsFromExcel('job.xls', 'job',100 ,120);
       //sleep(20);
       //loadProductsFromExcel('job.xls', 'job',60 ,90);
       //sleep(20);
      // loadProductsFromExcel('job.xls', 'job',90 ,120);
       //loadProductsFromExcel('arhive.xls', 'arhive');
       
       //$n=500/10;
       //loadProductsFromExcel('arhive.xls', 'job',2 ,20);
       $step = 10;
       $col = 700;
       $n=$col/$step;
       //loadCategoriesFromExcel('folders.xls',2 , $step);
       //loadProductsFromExcel('job.xls', 'job',2 ,$step);
       //loadProductsFromExcel('arhive.xls', 'arhive',512 ,520);
       for($i=52; $i<$n; $i++){
           // folders.xls, job
           //loadCategoriesFromExcel('folders.xls',$i*$step , $i*$step+$step);
           //loadProductsFromExcel('arhive.xls', 'arhive',$i*$step , $i*$step+$step);           
           //sleep(20);
       }

       
       /*
       sleep(20);
       loadProductsFromExcel('arhive.xls', 'job',520 ,540);
       sleep(20);
       loadProductsFromExcel('arhive.xls', 'job',540 ,560);
       sleep(20);
       loadProductsFromExcel('arhive.xls', 'job',560 ,580);
       sleep(20);
       loadProductsFromExcel('arhive.xls', 'job',580 ,600);
       sleep(20);
       loadProductsFromExcel('arhive.xls', 'job',600 ,620);
       sleep(20);
       loadProductsFromExcel('arhive.xls', 'job',620 ,640);
       sleep(20);
       loadProductsFromExcel('arhive.xls', 'job',640 ,660);
       sleep(20);
       loadProductsFromExcel('arhive.xls', 'job',660 ,680);
       sleep(20);
       loadProductsFromExcel('arhive.xls', 'job',680 ,700);
       sleep(20);
       loadProductsFromExcel('arhive.xls', 'job',700 ,720);
       sleep(20);
       loadProductsFromExcel('arhive.xls', 'job',720 ,740);
       sleep(20);
       loadProductsFromExcel('arhive.xls', 'job',740 ,760);
       sleep(20);
       loadProductsFromExcel('arhive.xls', 'job',760 ,780);
       sleep(20);
       loadProductsFromExcel('arhive.xls', 'job',780 ,800);
        */
   }
   else{
       Router::routeAccessDenied();
   }