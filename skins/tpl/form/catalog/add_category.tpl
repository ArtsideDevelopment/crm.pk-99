<!-- skins/tpl/form/pages/add_page.tpl begin -->
<div class="as-card">
    <form id="AddCategory" action="javascript:void(null);" onSubmit="tinyMCE.triggerSave(false,false); xajax_Add_Category(xajax.getFormValues('AddCategory'));" novalidate> 
        <?php include AS_ROOT.'skins/tpl/form/catalog/category_pattern.tpl';  ?>   
        <div class="floating-block-bottom">
            <div class="row floating-block-bottom__block">
                <div class="col-3">   
                    <a href="javascript:void(null);" class="button" onClick="tinyMCE.triggerSave(false,false); xajax_Edit_Category_Script_Free(xajax.getFormValues('AddCategory'));">Сохранить</a>
                    
                </div>
                <div class="col-6"> 
                    <input type="submit" name="send_form" id="send_form" class="border-button" value="Сохранить со скриптом" />       
                </div>
                <div class="col-3" id="preview_btn_replace">     
                    <? echo $preview_btn; ?>
                </div>
            </div>
        </div>
    </form>
</div>