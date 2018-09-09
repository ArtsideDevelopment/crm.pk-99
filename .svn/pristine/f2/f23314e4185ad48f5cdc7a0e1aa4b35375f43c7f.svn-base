<?php
/*   
* libs/classes/enums/Enum.class.php 
* File of the Enum class  
* Файл класса Перечислений 
* @author Dulebsky A. 06.09.2016   
* @copyright © 2016 ArtSide   
*/
/** 
* Класс для работы с перечислениями
* Class for work with enums
* @param  
*/ 
abstract class Enum
{
    private $current_val;
    final public function __construct( $type ) {
        $c = new ReflectionClass($this);
        if(!in_array($value, $c->getConstants())) {
            throw IllegalArgumentException();
        }        
        $this->current_val = $value;
    }    
    final public function __toString()
    {
        return $this->current_val;
    }
}
