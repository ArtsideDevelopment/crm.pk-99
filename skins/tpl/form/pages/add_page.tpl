<!-- skins/tpl/form/pages/add_page.tpl begin -->
<div class="as-card">
    <form id="AddPage" action="javascript:void(null);" onSubmit="tinyMCE.triggerSave(false,false); xajax_Add_Page(xajax.getFormValues('AddPage'));"> 
        <?php include AS_ROOT.'skins/tpl/form/pages/page_pattern.tpl';  ?>   
        <?php include AS_ROOT.'skins/tpl/form/for_all/floating_form_btn.tpl';  ?>
    </form>
</div>