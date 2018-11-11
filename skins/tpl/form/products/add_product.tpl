<!-- skins/tpl/form/pages/add_page.tpl begin -->

<form id="AddProductForm" action="javascript:void(null);" onSubmit="tinyMCE.triggerSave(false,false); xajax_Add_Product(xajax.getFormValues('AddProductForm'));" novalidate> 
    <?php include AS_ROOT.'skins/tpl/form/products/product_pattern.tpl';  ?>
    <div class="floating-block-bottom">
        <div class="row floating-block-bottom__block">
            <div class="col-3">               
                <input type="submit" name="send_form" id="send_form" class="button" value="Сохранить" />
            </div>
            <div class="col-6"> 
                <a href="javascript:void(null);" class="border-button" onClick="tinyMCE.triggerSave(false,false); if (confirm('Вы действительно хотите сохранить с использованием скрипта? Скрипт будет пытаться скачать изображения со старого сайта')) xajax_Add_Product_Script(xajax.getFormValues('AddProductForm'));">Сохранить со скриптом</a>                     
            </div>
            <div class="col-3" id="preview_btn_replace">     
                <? echo $preview_btn; ?>
            </div>
        </div>
    </div>
</form>
<?php include AS_ROOT.'skins/tpl/form/for_all/modal_category_check.tpl';  ?>