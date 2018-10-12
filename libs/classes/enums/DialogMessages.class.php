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
class DialogMessages extends Enum
{    
    const error="<h2>Что-то пошло не так, обратитесь к разработчику системы</h2>";
    const delete_products_success="
            <h2>Товары успешно удалены</h2>
            <p>Вы можете продолжить работу с системой</p>";
    const add_to_category_success="
            <h2>Товары успешно добавлены в указанные категории</h2>
            <p>Вы можете продолжить работу с системой</p>";
    const move_to_category_success="
            <h2>Товары успешно перемещены в указанную категории</h2>
            <p>Вы можете продолжить работу с системой</p>";
    const add_vendor_success="
            <h2>У товара успешно изменен производитель</h2>
            <p>Вы можете продолжить работу с системой</p>";
    const add_value_success="
            <h2>Изменения сохранены</h2>
            <p>Вы можете продолжить работу с системой</p>";
}
