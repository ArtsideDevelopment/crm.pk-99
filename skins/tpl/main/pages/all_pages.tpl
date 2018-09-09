<div class="page-header">
    <div class="page-header-left">
        <h1><? echo $PAGE->getTitle();?></h1>
        <div class="breadcrumbs">
            <?php echo $lk_bread_crumbs;?>
        </div>
    </div>
    <div class="page-header-right">
        <a href="/pages/add-page" class="button">Добавить страницу</a>
    </div>
</div>
<div class="as-table-card" id="pages_table_replace">
    <?php echo $pages_table;?>
</div>
