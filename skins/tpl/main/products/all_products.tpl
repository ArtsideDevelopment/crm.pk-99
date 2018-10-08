
<div class="page-header">
    <div class="page-header-left">
        <h1><? echo $PAGE->getTitle();?></h1>
        <div class="breadcrumbs">
            <?php echo $lk_bread_crumbs;?>
        </div>
    </div>
    <div class="page-header-right">
        <a href="/shop/products/add-product" class="button">Добавить товар</a>
    </div>
</div>
<div class="as-card">
    <form id="FormProductsFilter" action="javascript:void(null);" onSubmit="xajax_Products_Filter(xajax.getFormValues('FormProductsFilter'));"> 
        <div class="form-row row">
            <div class="col-4">
                <div class="form-group">
                    <?php echo $as_categories_select; ?>
                    <label class="control-label" for="name">Категория товара</label><i class="bar"></i>         
                </div> 
            </div>
            <div class="col-4">
                <div class="form-group">
                    <?php echo $as_vendor_select; ?>
                    <label class="control-label" for="amount">Производитель</label><i class="bar"></i>                    
                </div> 
            </div>
            <div class="col-4">
                <div class="form-group">
                    <select id="amount" name="amount">
                        <option selected="selected" value="">------------</option>                        
                        <option value="0">Нет в наличии</option>
                        <option value="1">В наличии</option>
                    </select>
                    <label class="control-label" for="amount">Наличие товара</label><i class="bar"></i>                    
                </div> 
            </div>
        </div>  
        <div class="form-row row">
            <div class="col-4">
                <div class="form-group">
                    <select id="button_link" name="button_link">
                        <option selected="selected" value="">------------</option>
                        <option value="0">Ссылка есть, но не отображается</option>
                        <option value="1">Ссылка есть</option>
                        <option value="2">Ссылки нет</option>
                    </select>
                    <label class="control-label" for="name">Статус ссылки “под кнопкой купить”</label><i class="bar"></i>
                    <div class="form_error" id="form_error_name"></div>
                </div> 
            </div>
            <div class="col-4">
                <div class="form-group">
                    <select id="status" name="status">
                        <option selected="selected" value="0">------------</option>
                        <option value="1">Активный</option>
                        <option value="2">Архивный</option>
                        <option value="3">Временно нет</option>
                    </select>
                    <label class="control-label" for="name">Cтатус страницы товара</label><i class="bar"></i>
                    <div class="form_error" id="form_error_name"></div>
                </div> 
            </div>
            <div class="col-4">                
                 <div class="header">Дополнительные параметры</div>                 
                 <div class="checkbox">    
                    <label>
                        <input type="checkbox" id="mail_text" name="mail_text" value="1" /><i class="helper"></i>Поле в письме клиенту не пустое
                    </label>  
                     <label>
                        <input type="checkbox" id="size" name="size" value="1" /><i class="helper"></i>У товара есть размер
                    </label>  
                </div>                              
            </div>            
        </div> 
        <input type="submit" name="send_form" id="send_form" class="button" value="Фильтровать товары" />
    </form>
</div>
<p>&nbsp;</p>

<form id="FormProductsGroupActions" action="javascript:void(null);" onSubmit="xajax_Products_Actions(xajax.getFormValues('FormProductsGroupActions'));">
    <div class="as-table-card" id="products_table_replace">    
        <?php echo $products_table;?>      
    </div>
    <div class="row">
        <div class="col-8">
            <div class="form-group">
                <select id="products_actions" name="products_actions">
                    <option selected="selected">Выберите действие</option>
                    <option value="delete">Удалить товары</option>
                    <option value="add_to_category">Добавить в категорию</option>
                    <option value="move_to_category">Перенести в категорию (если товар входит в несколько категорий, то он будет пернесен только в одну выбранную категорию)</option>
                    <option value="delete_category">Убрать из категории (товары не удаляются)</option>
                    <option value="add_vendor">Выбрать производителя</option>
                    <option value="add_amount">Установить количество товара</option>
                    <option value="---">Указать сопутствующие товары</option>
                    <optgroup label="Групповое управление содержанием полей">                        
                        <option value="add_button_link_text">Текст ссылки под кнопкой купить</option>
                        <option value="add_button_link">Ссылка под кнопкой купить</option>
                        <option value="add_button_link_show">отображать/скрыть ссылку</option>
                        <option value="add_mail_text">Поле в письме клиенту</option>                        
                    </optgroup> 
                    <optgroup label="SEO">        
                        <option value="---">Скрыть без доступа (404)</option>
                        <option value="---">Запретить индексацию</option>
                        <option value="---">Разрешить индексацию</option>
                    </optgroup>  
                </select>
                <label class="control-label" for="products_actions">Выберите действия с отмеченными товарами</label><i class="bar"></i>
                <div class="form_error" id="form_error_name"></div>
            </div>                
        </div>
        <div class="col-4"><input type="submit" name="send_form" id="send_form" class="button" value="Применить" /></div>
    </div>      
</form>
