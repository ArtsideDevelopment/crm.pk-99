<div class="form-row">
    <div class="form-input">
        <div class="form-group">
            <input type="text" required="required" name="name" id="name" class="<? echo $tranlit_class; ?>" value="<? echo $copy_prefix; ?><? echo $CONTENT['name']; ?>"/>
            <label class="control-label" for="name">Название товара*</label><i class="bar"></i>
            <!--<a href="javascript:void(null);" onClick="xajax_Modal_Dialog_Open(0);">Вызвать окно</a>-->
            <div class="form_error" id="form_error_name"></div>
        </div> 
    </div>
    <div class="form-description"></div>
</div>  
<div class="form-row">
    <div class="form-input">
        <div class="form-group">
            <input type="text" required="required" name="alias" id="alias" value="<? echo $copy_prefix; ?><? echo $CONTENT['alias']; ?>"/>
            <label class="control-label" for="alias">Алиас товара*</label><i class="bar"></i>
            <div class="form_error" id="form_error_alias"></div>
        </div> 
    </div>
    <div class="form-description">
        Алиас страницы - название товара на английском языке. Алиас используется при создании страниц вида www.site.ru/products/product-name
    </div>
</div>  
<div class="form-row">
    <div class="form-input">
        <div class="form-group">
            <input type="text" required="required" name="url_path_old" id="url_path_old" value="<? echo $CONTENT['url_path_old']; ?>"/>
            <label class="control-label" for="url_path_old">Старый адрес страницы</label><i class="bar"></i>
            <div class="form_error" id="form_error_url_path_old"></div>
        </div> 
    </div>
    <div class="form-description">
        Скопируйте старый url адрес страницы целиком с http://
    </div>
</div> 
<div class="form-row">
    <div class="form-input">
        <div class="form-chosen">
            <? echo $as_main_category_select; ?>
            <label class="control-label" for="as_main_category_id">Основная категория товара*</label><i class="bar"></i>
            <div class="form_error" id="form_error_main_category"></div>
        </div> 
    </div>
    <div class="form-description">
        
    </div>
</div>
<div class="form-row">
    <div class="form-multiple-choice">        
        <input type="hidden" id="product_categories_val" name="product_categories_val" value="">
        <ul class="form-multiple-choice__items"></ul>        
        <div id="modal-dialog-categories__show" class="form-multiple-choice__button">Добавить категории</div>
       
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
    <div class="form-input-25">
        <div class="form-group">
            <input type="text" name="vendor_code" required="required" id="vendor_code" value="<? echo $CONTENT['vendor_code']; ?>"/>
            <label class="control-label" for="vendor_code">Артикул</label><i class="bar"></i>
        </div> 
    </div>
    <div class="form-input-25">
        <div class="form-group">
            <input type="text" name="1c" id="1c" required="required" value="<? echo $CONTENT['1c']; ?>"/>
            <label class="control-label" for="1c">1С</label><i class="bar"></i>
        </div> 
    </div>
    <div class="form-description"></div>
</div> 
<div class="form-row">
    <div class="form-input-25">
        <div class="form-group">
            <input type="text" name="amount" required="required" id="vamount" value="<? echo $CONTENT['amount']; ?>"/>
            <label class="control-label" for="amount">Количество единиц</label><i class="bar"></i>
        </div> 
    </div>
    <div class="form-input-25">
        <div class="form-group">
            <input type="text" name="unit" id="unit" required="required" value="<? echo $CONTENT['unit']; ?>"/>
            <label class="control-label" for="unit">Единица измерения</label><i class="bar"></i>
        </div> 
    </div>
    <div class="form-description"></div>
</div> 
<div class="form-row">
    <div class="form-input-25">
        <div class="form-group">
            <input type="text" name="cost" required="required" id="cost" value="<? echo $CONTENT['cost']; ?>"/>
            <label class="control-label" for="cost">Цена</label><i class="bar"></i>
        </div> 
    </div>
    <div class="form-input-25">
        <div class="form-group">
            <input type="text" name="cost_old" required="required" id="cost_old" value="<? echo $CONTENT['cost_old']; ?>"/>
            <label class="control-label" for="cost_old">Зачеркнутая цена</label><i class="bar"></i>
        </div> 
    </div>
    <div class="form-description"></div>
</div> 
<div class="form-row">
    <div class="form-input">
        <div class="form-group">
            <input type="text" required="required" name="sizes_old" id="sizes_old" value="<? echo $CONTENT['sizes_old']; ?>"/>
            <label class="control-label" for="sizes_old">Размер</label><i class="bar"></i>
            <div class="form_error" id="form_error_url_path_old"></div>
        </div> 
    </div>
    <div class="form-description">
        
    </div>
</div> 
<div class="form-row">
    <div class="form-input">
        <div class="form-group">
            <input type="text" name="button_link_text" required="required" id="button_link_text" value="<? echo $CONTENT['button_link_text']; ?>"/>
            <label class="control-label" for="button_link_text">Текст ссылки под кнопкой Купить</label><i class="bar"></i>           
        </div> 
    </div>
    <div class="form-description">        
    </div>
</div> 
<div class="form-row">
    <div class="form-input">
        <div class="form-group">
            <input type="text" name="button_link" required="required" id="button_link" value="<? echo $CONTENT['button_link']; ?>"/>
            <label class="control-label" for="button_link">Cсылка под кнопкой Купить</label><i class="bar"></i>           
        </div> 
    </div>
    <div class="form-description">        
    </div>
</div> 
<div class="form-row">    
    <div class="checkbox">
        <label>
            <? echo $button_link_show_set;?><i class="helper"></i>Отображать ссылку на сайте
        </label>
    </div>
</div>
<div class="form-row">
    <div class="form-input">
        <div class="form-group">
            <input type="text" name="mail_text" required="required" id="mail_text" value="<? echo $CONTENT['mail_text']; ?>"/>
            <label class="control-label" for="mail_text">Поле в письме клиенту:</label><i class="bar"></i>           
        </div> 
    </div>
    <div class="form-description">        
    </div>
</div> 