<!-- skins/tpl/form/pages/add_page.tpl begin -->

<form id="AddProductForm" action="javascript:void(null);" onSubmit="tinyMCE.triggerSave(false,false); xajax_Add_Product(xajax.getFormValues('AddProductForm'));" novalidate> 
    <?php include AS_ROOT.'skins/tpl/form/products/product_pattern.tpl';  ?>
    <?php include AS_ROOT.'skins/tpl/form/for_all/floating_form_btn.tpl';  ?>
</form>
<?php include AS_ROOT.'skins/tpl/form/for_all/modal_category_check.tpl';  ?>