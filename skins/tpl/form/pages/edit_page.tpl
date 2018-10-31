<!-- skins/tpl/form/pages/add_page.tpl begin -->
<div class="as-card">
    <form id="EditPage" action="javascript:void(null);" onSubmit="tinyMCE.triggerSave(false,false); xajax_Edit_Page(xajax.getFormValues('EditPage'));"> 
        <?php include AS_ROOT.'skins/tpl/form/pages/page_pattern.tpl';  ?> 
        <div class="floating-block-bottom">
            <div class="row floating-block-bottom__block">
                <div class="col-3">               
                    <input type="submit" name="send_form" id="send_form" class="button" value="Сохранить" />
                </div>
                <div class="col-6">     
                    <a href="javascript:void(null);" class="border-button" value="Сохранить без использования скрипта" onClick="tinyMCE.triggerSave(false,false); xajax_Edit_Page_Script_Free(xajax.getFormValues('EditPage'));">Сохранить без использования скрипта</a>
                </div>
                <div class="col-3" id="preview_btn_replace">     

                </div>
            </div>
        </div>        
    </form>
</div>