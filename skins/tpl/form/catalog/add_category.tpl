<!-- skins/tpl/form/pages/add_page.tpl begin -->
<div class="as-card">
    <form id="AddCategory" action="javascript:void(null);" onSubmit="tinyMCE.triggerSave(false,false); xajax_Add_Category(xajax.getFormValues('AddCategory'));" novalidate> 
        <?php include AS_ROOT.'skins/tpl/form/catalog/category_pattern.tpl';  ?>   
        <div class="floating-block-bottom">
            <div class="row floating-block-bottom__block">
                <div class="col-3">   
                    <input type="submit" name="send_form" id="send_form" class="button" value="Сохранить" />                    
                </div>
                <div class="col-6"> 
                    <a href="javascript:void(null);" class="border-button" onClick="tinyMCE.triggerSave(false,false); if (confirm('Вы действительно хотите сохранить с использованием скрипта? Скрипт будет пытаться скачать изображения со старого сайта')) xajax_Add_Category_Script(xajax.getFormValues('AddCategory'));">Сохранить со скриптом</a>
                           
                </div>
                <div class="col-3" id="preview_btn_replace">     
                    <? echo $preview_btn; ?>
                </div>
            </div>
        </div>
    </form>
</div>