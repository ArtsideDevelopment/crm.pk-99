<div class="floating-block-bottom">
    <div class="row floating-block-bottom__block">
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
</div>