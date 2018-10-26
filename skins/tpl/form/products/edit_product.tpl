<!-- skins/tpl/form/pages/add_page.tpl begin -->
<form id="EditProductForm" action="javascript:void(null);" onSubmit="tinyMCE.triggerSave(false,false); xajax_Edit_Product(xajax.getFormValues('EditProductForm'));" novalidate> 
    <?php include AS_ROOT.'skins/tpl/form/products/product_pattern.tpl';  ?>
</form>