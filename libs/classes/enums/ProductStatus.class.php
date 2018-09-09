<?php
/*   
* libs/classes/enums/JobType.class.php 
* File of the JobType class  
* @author Dulebsky A. 06.09.2016   
* @copyright © 2016 ArtSide   
*/
/** 
* Класс перечислений типов работ. Значение констант получаем из таблицы content - id соответсвующих страниц
* Class jon type enum
* @param  
*/ 
class ProductStatus extends Enum
{    
    const active="1";
    const arhive="2";
    const absent="3";
}
