<!-- skins/tpl/form/pages/add_page.tpl begin -->
<div class="as-card">
    <form id="AddCategory" action="javascript:void(null);" onSubmit="tinyMCE.triggerSave(false,false); xajax_Add_Category(xajax.getFormValues('AddCategory'));" novalidate> 
        <?php include AS_ROOT.'skins/tpl/form/catalog/category_pattern.tpl';  ?>   
        <?php include AS_ROOT.'skins/tpl/form/for_all/floating_form_btn.tpl';  ?>
    </form>
</div>