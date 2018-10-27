<input type="hidden" name="category_id" id="category_id" value="<? echo $category_id; ?>"/>
<input type="hidden" name="parent_id_old" id="parent_id_old" value="<? echo $CONTENT['parent_id']; ?>"/>
<input type="hidden" name="alias_old" id="alias_old" value="<? echo $CONTENT['alias']; ?>"/>
<input type="hidden" name="hierarchy_old" id="hierarchy_old" value="<? echo $CONTENT['hierarchy']; ?>"/>
<div class="form-row">
    <div class="form-input">
        <div class="form-group">
            <input type="text" required="required" name="name" id="name" class="translit" value="<? echo $CONTENT['name']; ?>"/>
            <label class="control-label" for="name">Название категории*</label><i class="bar"></i>
            <div class="form_error" id="form_error_name"></div>
        </div> 
    </div>
    <div class="form-description">        
    </div>
</div>  
<div class="form-row">
    <div class="form-input">
        <div class="form-group">
            <input type="text" required="required" name="alias" id="alias" value="<? echo $CONTENT['alias']; ?>"/>
            <label class="control-label" for="alias">Алиас категории</label><i class="bar"></i>
            <div class="form_error" id="form_error_alias"></div>
        </div> 
    </div>
    <div class="form-description">
        Алиас категории - название на английском языке. Алиас используется при создании категорий интернет-магазина вида www.site.ru/shop/page
    </div>
</div>  
<div class="form-row">
    <div class="form-input">
        <div class="form-group">
            <input type="text" required="required" name="url_path_old" id="url_path_old" value="<? echo $CONTENT['url_path_old']; ?>"/>
            <label class="control-label" for="url_path_old">Старый адрес категории*</label><i class="bar"></i>
            <div class="form_error" id="form_error_url_path_old"></div>
        </div> 
    </div>
    <div class="form-description">
        Скопируйте старый url адрес категории целиком с http://
    </div>
</div> 
<div class="form-row">
    <div class="form-input">
        <div class="form-group">
            <input type="text" required="required" name="category_id_old" id="category_id_old" value="<? echo $CONTENT['category_id_old']; ?>"/>
            <label class="control-label" for="url_path_old">id категории в старой системе*</label><i class="bar"></i>
            <div class="form_error" id="form_error_category_id_old"></div>
        </div> 
    </div>
    <div class="form-description">
        Скопируйте id из старой системы управления
    </div>
</div> 

<div class="form-row">
    <div class="form-input">
        <div class="form-chosen">
            <? echo $as_select_parent; ?>
            <label class="control-label" for="parent_id">Родитель категории</label><i class="bar"></i>
        </div> 
    </div>
    <div class="form-description">
        Поле служит для создания иерархической структуры интернет-магазина
    </div>
</div>
<div class="form-row">
    <div class="form-input">
        <div class="form-group">
            <? echo $as_status; ?>
            <label class="control-label" for="as_status_id">Статус*</label><i class="bar"></i>
            <div class="form_error" id="form_error_status"></div>
        </div> 
    </div>
    <div class="form-description">
        
    </div>
</div>
<div class="form-row">
    <p><strong>Дополнительные настройки страницы</strong></p>
    <div class="checkbox">
        <label>
            <? echo $menu_hidden_set;?><i class="helper"></i>Не выводить в левом меню
        </label>
    </div>    
</div>
<div class="form-row">
    <div class="form-input">
        <div class="form-group">
            <input type="text" required="required" name="title" id="title" value="<? echo $CONTENT['title']; ?>"/>
            <label class="control-label" for="title">Заголовок (title):*</label><i class="bar"></i>
            <div class="form_error" id="form_error_title"></div>
        </div> 
    </div>
    <div class="form-description">
        Заголовок не должен превышать 12 слов и 70 символов (не обязательное условие поисковых систем)
    </div>
</div>
<div class="form-row">
    <div class="form-input">
        <div class="form-group">
            <textarea name="meta_keywords" id="meta_keywords"><? echo $CONTENT['meta_keywords']; ?></textarea>
            <label class="control-label" for="meta_keywords">Meta-keywords:</label><i class="bar"></i>
        </div> 
    </div>    
</div>
<div class="form-row">
    <div class="form-input">
        <div class="form-group">
            <textarea name="meta_description" id="meta_description"><? echo $CONTENT['meta_description']; ?></textarea>
            <label class="control-label" for="meta_description">Meta-description:</label><i class="bar"></i>
        </div> 
    </div>    
</div>
<div class="form-row">    
    <div class="form-group">
        <p><strong>Описание над товаром</strong></p>
        <textarea name="content" id="content" class="tinymce"><? echo htmlspecialchars_decode($CONTENT['content']); ?></textarea>        
    </div>   
</div>
<div class="form-row">    
    <div class="form-group">
        <p><strong>Изображение раздела </strong></p>
        <input type="hidden" id="upload_timestamp" name="upload_timestamp" value="<?php echo $timestamp;?>">
        <input type="hidden" id="upload_token" name="upload_token" value="<?php echo $token;?>">
        <input id="categories_img_upload" type="file" name="categories_img_upload" multiple="true"/>  
        <div id="categories_img_data_block"><? echo $category_img; ?></div>                        
        <div id="categories_img_queue"></div>              
    </div>   
</div>
<div class="form-row">    
    <div class="form-group">
        <p><strong>Описание под товаром</strong></p>
        <textarea name="content_bottom" id="content_bottom" class="tinymce"><? echo htmlspecialchars_decode($CONTENT['content_bottom']); ?></textarea>        
    </div>   
</div>