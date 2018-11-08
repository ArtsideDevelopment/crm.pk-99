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
                <div class="floating-btn">  
                    <a href="javascript:void(null);" class="round-button modal-dialog__btn-close" >Добавить</a>                   
                </div>
            </form>
        </div>
    </div>
</div>