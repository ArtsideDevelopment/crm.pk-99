<div class="form-row">
    <div class="form-input">
        <div class="form-group">
            <input type="text" required="required" name="title" id="title" value="<? echo $CONTENT['title']; ?>"/>
            <label class="control-label" for="title">Заголовок (title):</label><i class="bar"></i>
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
            <textarea name="meta_keywords" required="required" id="meta_keywords"><? echo $CONTENT['meta_keywords']; ?></textarea>
            <label class="control-label" for="meta_keywords">Meta-keywords:</label><i class="bar"></i>
        </div> 
    </div>    
</div>
<div class="form-row">
    <div class="form-input">
        <div class="form-group">
            <textarea name="meta_description" required="required" id="meta_description"><? echo $CONTENT['meta_description']; ?></textarea>
            <label class="control-label" for="meta_description">Meta-description:</label><i class="bar"></i>
        </div> 
    </div>    
</div>
<div class="form-row">    
    <div class="checkbox">
        <label>
            <? echo $noindex_set;?><i class="helper"></i>Запретить индексацию страницы
        </label>
    </div>
</div>