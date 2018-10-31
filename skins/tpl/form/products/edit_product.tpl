<!-- skins/tpl/form/pages/add_page.tpl begin -->
<form id="EditProductForm" action="javascript:void(null);" onSubmit="tinyMCE.triggerSave(false,false); xajax_Edit_Product(xajax.getFormValues('EditProductForm'));" novalidate> 
    <?php include AS_ROOT.'skins/tpl/form/products/product_pattern.tpl';  ?>
    <div class="floating-block-bottom">
    <div class="row floating-block-bottom__block">
        <div class="col-6">               
            <input type="submit" name="send_form" id="send_form" class="button" value="Сохранить" />
        </div>
        <div class="col-6" id="preview_btn_replace">     

        </div>
    </div>
</div>
</form>