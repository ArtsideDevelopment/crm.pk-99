<div class="page-header">
    <div class="page-header-left">
        <h1><? echo $PAGE->getTitle();?></h1>
        <div class="breadcrumbs">
            <?php echo $lk_bread_crumbs;?>
        </div>
    </div>
    <div class="page-header-right">
        <a href="/users/add-user" class="button">Добавить пользователя</a>
    </div>
</div>
<div class="as-table-card" id="users_table_replace">
    <?php echo $users_table;?>
</div>
