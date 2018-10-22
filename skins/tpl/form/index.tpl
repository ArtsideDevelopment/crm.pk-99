<!DOCTYPE html>
<!--

-->
<html lang="ru">
    <head>
        <title>ПИК-99. Система управления контентом</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Remove Tap Highlight on Windows Phone IE -->
        <meta name="msapplication-tap-highlight" content="no"/>
        <link rel="icon" type="image/png" href="/skins/img/favicon-16x16.png" sizes="16x16">
        <link rel="icon" type="image/png" href="/skins/img/favicon-32x32.png" sizes="32x32">
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script src="https://yastatic.net/jquery/3.1.1/jquery.min.js"></script>
    </head>
    <body class="sidebar_main_active">        
        <link rel="stylesheet" href="/skins/css/styles.css">
        <?php include 'skins/tpl/for_all/header.tpl'; ?>
        <!-- main sidebar -->
        <?php include 'skins/tpl/for_all/left_menu.tpl'; ?>
        <!-- main sidebar end -->
        <!-- page content -->
        <div id="page-content">
            <div class="page-header">    
                <h1><? echo $PAGE->getTitle();?></h1>
                <div class="breadcrumbs">
                    <?php echo $PAGE->getBreadCrumbs();?>
                </div>   
            </div>
            <?php echo $content; ?>
        </div>
        <!-- page content end-->
        <?php include 'skins/tpl/for_all/modal_dialog.tpl'; ?>
        <!--<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500' rel='stylesheet' type='text/css'>   -->     
        <!--<script src="/skins/js/libs/ckeditor/ckeditor.js"></script>-->
        <script src="/skins/js/libs/tinymce/tinymce.min.js"></script>
        <script src="/skins/js/libs/jquery.uploadifive.min.js" type="text/javascript"></script>
        <script src='/skins/js/libs/chosen.jquery.min.js'></script>
        <script src="/skins/js/libs/datatables/datatables.min.js"></script>
        <!--<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>-->
        <script src="/skins/js/core.js"></script>
        <script src="/skins/js/form.js"></script>
        <script src="/skins/js/uploadifive_init.js" type="text/javascript"></script>
        <script src="/skins/js/modal_dialog.js"></script>
        <?php $xajax->printJavascript(); ?>
    </body>
</html>
