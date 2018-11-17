<input type="hidden" name="page_id" id="page_id" value="<? echo $page_id; ?>"/>
<input type="hidden" name="parent_id_old" id="parent_id_old" value="<? echo $CONTENT['parent_id']; ?>"/>
<input type="hidden" name="alias_old" id="alias_old" value="<? echo $CONTENT['alias']; ?>"/>
<input type="hidden" name="hierarchy_old" id="hierarchy_old" value="<? echo $CONTENT['hierarchy']; ?>"/>
<input type="hidden" name="default_set" id="default_set" value="<? echo $CONTENT['default_set']; ?>"/>
<div class="form-row">
    <div class="form-input">
        <div class="form-group">
            <input type="text" required="required" name="name" id="name" class="translit" value="<? echo $CONTENT['name']; ?>"/>
            <label class="control-label" for="name">Название страницы*</label><i class="bar"></i>
            <div class="form_error" id="form_error_name"></div>
        </div> 
    </div>
    <div class="form-description">
        Имя страницы внутри системы управления и в меню сайта
    </div>
</div>  
<div class="form-row">
    <div class="form-input">
        <div class="form-group">
            <input type="text" required="required" name="alias" id="alias" value="<? echo $CONTENT['alias']; ?>"/>
            <label class="control-label" for="alias">Алиас страницы</label><i class="bar"></i>
            <div class="form_error" id="form_error_alias"></div>
        </div> 
    </div>
    <div class="form-description">
        Алиас страницы - название страницы на английском языке. Алиас используется при создании страниц вида www.site.ru/page
    </div>
</div>  
<div class="form-row">
    <div class="form-input">
        <div class="form-group">
            <input type="text" required="required" name="url_path_old" id="url_path_old" value="<? echo $CONTENT['url_path_old']; ?>"/>
            <label class="control-label" for="url_path_old">Старый адрес страницы*</label><i class="bar"></i>
            <div class="form_error" id="form_error_url_path_old"></div>
        </div> 
    </div>
    <div class="form-description">
        Скопируйте старый url адрес страницы целиком с http://
    </div>
</div> 
<div class="form-row">
    <div class="form-input">
        <div class="form-group">
            <? echo $as_content_type; ?>
            <label class="control-label" for="as_content_type_id">Тип страницы*</label><i class="bar"></i>
            <div class="form_error" id="form_error_content_type"></div>
        </div> 
    </div>
    <div class="form-description">
        
    </div>
</div>
<div class="form-row">
    <div class="form-input">
        <div class="form-group">
            <? echo $as_select_parent; ?>
            <label class="control-label" for="parent_id">Родитель страницы</label><i class="bar"></i>
        </div> 
    </div>
    <div class="form-description">
        Поле служит для создания иерархической структуры сайта
    </div>
</div>
<div class="form-row">
    <p><strong>Дополнительные настройки страницы</strong></p>
    <div class="checkbox">
        <label>
            <? echo $left_menu_set;?><i class="helper"></i>Отображать в левом меню
        </label>
    </div>
    <div class="checkbox">
        <label>
            <? echo $top_menu_set;?><i class="helper"></i>Отображать в верхнем меню
        </label>
    </div>
</div>
<div class="form-row">
    <div class="form-input">
        <div class="form-group">           
            <textarea name="title" id="title"><? echo $CONTENT['title']; ?></textarea>
            <label class="control-label" for="meta_keywords">Заголовок (title):</label><i class="bar"></i>
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
            <textarea name="meta_description" id="meta_description"><? echo $CONTENT['meta_description']; ?></textarea>
            <label class="control-label" for="meta_description">Meta-description:</label><i class="bar"></i>
        </div> 
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
    <div class="form-group">
        <p><strong>Контент (основное содержание страницы)</strong></p>
        <textarea name="content" id="content" class="tinymce"><? echo $CONTENT['content']; ?></textarea>        
    </div>   
</div>