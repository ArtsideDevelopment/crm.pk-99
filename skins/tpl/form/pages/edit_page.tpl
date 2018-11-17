<!-- skins/tpl/form/pages/add_page.tpl begin -->
<div class="as-card">
    <form id="EditPage" action="javascript:void(null);" onSubmit="tinyMCE.triggerSave(false,false); if (confirm('Вы действительно хотите сохранить с использованием скрипта? Скрипт будет пытаться скачать изображения со старого сайта')) xajax_Edit_Page(xajax.getFormValues('EditPage'));" novalidate> 
        <?php include AS_ROOT.'skins/tpl/form/pages/page_pattern.tpl';  ?> 
        <div class="floating-block-bottom">
            <div class="row floating-block-bottom__block">
                <div class="col-3">  
                    <a href="javascript:void(null);" class="button" onClick="tinyMCE.triggerSave(false,false); xajax_Edit_Page_Script_Free(xajax.getFormValues('EditPage'));">Сохранить</a>
                    
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