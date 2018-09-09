<div class="form-row">
    <div class="form-input">
        <div class="form-group">
            <p><strong>Основное изображение товара*</strong></p>
            <input type="hidden" id="upload_timestamp" name="upload_timestamp" value="<?php echo $timestamp;?>">
            <input type="hidden" id="upload_token" name="upload_token" value="<?php echo $token;?>">
            <input id="product_img_upload" type="file" name="product_img_upload" multiple="true"/>
            <div id="product_img_queue"></div>  
            <div class="form_error" id="form_error_img"></div>
        </div> 
    </div>
    <div class="form-description">
        
    </div>
    <div class="clear"></div>
    <div class="form-img">
        <div id="product_img_data_block"><? echo $img; ?></div>
    </div>
</div>  
<!--
<div class="form-row">
    <div class="form-input">
        <div class="form-group">
            <input type="text" required="required" name="alias" id="alias" value="<? echo $CONTENT['alias']; ?>"/>
            <label class="control-label" for="alias">Дополнительные изображения товара</label><i class="bar"></i>
        </div> 
    </div>
    <div class="form-description">
        
    </div>
</div>  
-->
<div class="form-row">    
    <div class="form-group">
        <p><strong>Характеристика товара</strong></p>
        <textarea name="characteristic" id="characteristic" class="tinymce"><? echo $CONTENT['characteristic']; ?></textarea>        
    </div>   
</div>
<div class="form-row">    
    <div class="form-group">
        <p><strong>Анонс товара</strong></p>
        <textarea name="announce" id="announce" class="tinymce"><? echo $CONTENT['announce']; ?></textarea>        
    </div>   
</div>
<div class="form-row">    
    <div class="form-group">
        <p><strong>Описание товара</strong></p>
        <textarea name="description" id="description" class="tinymce"><? echo $CONTENT['description']; ?></textarea>        
    </div>   
</div>
<input type="submit" name="send_form" id="send_form" class="button" value="Сохранить" />