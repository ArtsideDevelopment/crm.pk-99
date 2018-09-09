<!-- skins/tpl/form/pages/add_page.tpl begin -->
<div class="as-card">
    <form id="EditCategory" action="javascript:void(null);" onSubmit="tinyMCE.triggerSave(false,false); xajax_Edit_Category(xajax.getFormValues('EditCategory'));"> 
        <?php include AS_ROOT.'skins/tpl/form/catalog/category_pattern.tpl';  ?>   
        <input type="submit" name="send_form" id="send_form" class="button" value="Сохранить" />
    </form>
</div>