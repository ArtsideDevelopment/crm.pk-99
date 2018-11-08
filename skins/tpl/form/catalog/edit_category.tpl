<!-- skins/tpl/form/pages/add_page.tpl begin -->
<div class="as-card">
    <form id="EditCategory" action="javascript:void(null);" onSubmit="tinyMCE.triggerSave(false,false); if (confirm('Вы действительно хотите сохранить с использованием скрипта? Скрипт будет пытаться скачать изображения со старого сайта')) xajax_Edit_Category(xajax.getFormValues('EditCategory'));" novalidate> 
        <?php include AS_ROOT.'skins/tpl/form/catalog/category_pattern.tpl';  ?>
        <div class="floating-block-bottom">
            <div class="row floating-block-bottom__block">
                <div class="col-3">   
                    <a href="javascript:void(null);" class="button" onClick="tinyMCE.triggerSave(false,false); xajax_Edit_Category_Script_Free(xajax.getFormValues('EditCategory'));">Сохранить</a>
                    
                </div>
                <div class="col-6"> 
                    <input type="submit" name="send_form" id="send_form" class="border-button" value="Сохранить со скриптом" />       
                </div>
                <div class="col-3" id="preview_btn_replace">     

                </div>
            </div>
        </div>       
    </form>
</div>