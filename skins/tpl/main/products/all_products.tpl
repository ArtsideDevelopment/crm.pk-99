<script src="/skins/js/libs/jquery.typeahead.js" type="text/javascript"></script>
<script src="/skins/js/autocomplete_init.js" type="text/javascript"></script>
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
    <form id="FormProductsFilter" action="javascript:void(null);" onSubmit="tinyMCE.triggerSave(false,false); xajax_Products_Filtr(xajax.getFormValues('FormProductsFilter'));"> 
        <div class="form-row">
            <div class="form-input">
                <div class="form-group">
                    <?php echo $as_categories_select; ?>
                    <label class="control-label" for="name">Категория товара</label><i class="bar"></i>
                    <div class="form_error" id="form_error_name"></div>
                </div> 
            </div>
            <div class="form-input">
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

<div class="as-table-card" id="pages_table_replace">
    <?php echo $products_table;?>
</div>
