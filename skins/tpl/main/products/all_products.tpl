
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
    <form id="FormProductsFilter" action="javascript:void(null);" onSubmit="xajax_Products_Filtr(xajax.getFormValues('FormProductsFilter'));"> 
        <div class="form-row row">
            <div class="col-4">
                <div class="form-group">
                    <?php echo $as_categories_select; ?>
                    <label class="control-label" for="name">Категория товара</label><i class="bar"></i>
                    <div class="form_error" id="form_error_name"></div>
                </div> 
            </div>
            <div class="col-4">
                <div class="form-group">
                    <select id="shop_product_actions" name="amount">
                        <option selected="selected" value="0">------------</option>
                        <option value="0">В наличии</option>
                        <option value="1">Нет в наличии</option>
                    </select>
                    <label class="control-label" for="amount">Наличие товара</label><i class="bar"></i>
                    <div class="form_error" id="form_error_name"></div>
                </div> 
            </div>
            <div class="col-4">
                <div class="form-group">
                    <input type="text" name="name" id="name" class="translit" value=""/>
                    <label class="control-label" for="name">Количество товаров</label><i class="bar"></i>
                    <div class="form_error" id="form_error_name"></div>
                </div> 
            </div>
        </div>  
        <input type="submit" name="send_form" id="send_form" class="button" value="Фильтровать товары" />
    </form>
</div>
<p>&nbsp;</p>

<form id="FormProductsGroupActions" action="javascript:void(null);" onSubmit="xajax_Products_Actions(xajax.getFormValues('FormProductsGroupActions'));">
    <div class="as-table-card" id="pages_table_replace">    
        <?php echo $products_table;?>      
    </div>
    <div class="row">
        <div class="col-8">
            <div class="form-group">
                <select id="products_actions" name="products_actions">
                    <option selected="selected">Выберите действие</option>
                    <option value="delete">Удалить товары</option>
                    <option value="---">Добавить в категорию</option>
                    <option value="---">Перенести в категорию (если товар входит в несколько категорий, то он будет пернесен только в одну выбранную категорию)</option>
                    <option value="---">Убрать из категории (товары не удаляются)</option>
                    <option value="---">Выбрать производителя</option>
                    <option value="---">Указать сопутствующие товары</option>
                    <optgroup label="Групповое управление содержанием полей">                        
                        <option value="---">Текст ссылки под кнопкой купить</option>
                        <option value="---">Ссылка под кнопкой купить</option>
                        <option value="---">Поле в письме клиенту</option>
                        <option value="---">отображать/скрыть ссылку</option>
                    </optgroup> 
                    <optgroup label="---SEO---">        
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
