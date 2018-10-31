<input type="hidden" name="product_id" id="product_id" value="<? echo $product_id; ?>"/>
<input type="hidden" name="alias_old" id="alias_old" value="<? echo $alias_old; ?>"/>

<ul class="tabs" role="tablist">
    <li>        
        <input type="radio" name="tabs" id="tab1" checked /> 
        <label for="tab1" role="tab" aria-selected="true" aria-controls="panel1" tabindex="0" class="tabs__control">Общая информация</label>
        <div id="tab-content1" class="tabs__content" role="tabpanel" aria-labelledby="description" aria-hidden="false">
            <?php include AS_ROOT.'skins/tpl/form/products/product_pattern_tab1.tpl';  ?>
        </div>
    </li>
    <li>        
        <input type="radio" name="tabs" id="tab2" />    
        <label for="tab2" role="tab" aria-selected="true" aria-controls="panel2" tabindex="0" class="tabs__control">Описание товара</label>
        <div id="tab-content2" class="tabs__content" role="tabpanel" aria-labelledby="description" aria-hidden="false">
            <?php include AS_ROOT.'skins/tpl/form/products/product_pattern_tab2.tpl';  ?>
        </div>
    </li>
    <li>        
        <input type="radio" name="tabs" id="tab3" />    
        <label for="tab3" role="tab" aria-selected="true" aria-controls="panel3" tabindex="0" class="tabs__control">SEO параметры</label>
        <div id="tab-content3" class="tabs__content" role="tabpanel" aria-labelledby="description" aria-hidden="false">
            <?php include AS_ROOT.'skins/tpl/form/products/product_pattern_tab3.tpl';  ?>
        </div>
    </li>
    <li>        
        <input type="radio" name="tabs" id="tab4" />    
        <label for="tab4" role="tab" aria-selected="true" aria-controls="panel4" tabindex="0" class="tabs__control">Сопутствующие товары</label>
        <div id="tab-content4" class="tabs__content" role="tabpanel" aria-labelledby="description" aria-hidden="false">
          Данный функционал временно не доступен.
        </div>
    </li>
    <li>        
        <input type="radio" name="tabs" id="tab5" />    
        <label for="tab5" role="tab" aria-selected="true" aria-controls="panel5" tabindex="0" class="tabs__control">Общие блоки</label>
        <div id="tab-content5" class="tabs__content" role="tabpanel" aria-labelledby="description" aria-hidden="false">
          Данный функционал временно не доступен.
        </div>
    </li>
</ul>
<div class="modal-dialog-bg">   
    <!-- Контейнер с контентом внутри модального окна -->
    <div class="modal-dialog form-multiple-choice__modal" id="modal-dialog-categories">
         <!-- Кнопка закрыть в правом углу -->
        <i class="modal-dialog__close icon-close"></i>
        <div class="modal-dialog__content">
            <form id="FormProductsCategoryDialog" action="javascript:void(null);" onSubmit="xajax_Add_Product_To_Category(xajax.getFormValues(\'FormProductsCategoryDialog\'));">
                <h2>Укажите категории, в которые необходимо добавить товар</h2>
                <div class="categories_check">
                    <? echo $categories_check; ?> 
                </div>
                <div class="form_error" id="form_error_replace"></div>
                <a href="javascript:void(null);" class="button modal-dialog__btn-close" >Добавить</a>
            </form>
        </div>
    </div>
</div>