<!-- skins/tpl/form/pages/add_page.tpl begin -->
<div class="as-card">
    <form id="AddPage" action="javascript:void(null);" onSubmit="tinyMCE.triggerSave(false,false); xajax_Add_Page(xajax.getFormValues('AddPage'));"> 
        <input type="hidden" id="upload_timestamp" name="upload_timestamp" value="<?php echo $timestamp;?>">
        <input type="hidden" id="upload_token" name="upload_token" value="<?php echo $token;?>">
        <div class="form-row">
            <div class="form-group">                                        
                <p>Выберите файл или перетащите его для импорта*</p>
                <input id="import_excel_upload" type="file" name="import_excel_upload" multiple="true"/>
                <div id="import_excel_data_block"></div>                        
                <div id="queue_import_excel"></div>
                <div class="form_error" id="form_error_name"></div>
            </div> 
        </div>  
        
        <input type="submit" name="send_form" id="send_form" class="button" value="Импортировать" />
    </form>
</div>