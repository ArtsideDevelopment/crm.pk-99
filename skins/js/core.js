$(document).ready(function(){
    artside_main_sidebar.init();
    artside_data_tables.init('.dataTables', true);
    ModalDialog.init('categories');
    artside_data_tables.init('.dataTablesCategories', false);
    MultipleChoise.init();
});
// 1. Common functions & variables
        
    var $body = $('body'),
        $html = $('html'),
        $document = $(document),
        $window = $(window),
        $mobile_width = 767;
    
    // 1.1 main sidebar / main menu (left)    
    var artside_main_sidebar = {
        init: function() {
            if( $window.width() < $mobile_width ) {
                $body.addClass('sidebar-main-close');
            }
        }
    };
    function lsTest(){
        var test = 'test';
        try {
            localStorage.setItem(test, test);
            localStorage.removeItem(test);
            return true;
        } catch(e) {
            return false;
        }
    }
    // 1.2 datatables
    var artside_data_tables = {
        init: function(target, paging) {
            if ($(target).length > 0) {
                $(target).DataTable({
                    "paging":   paging,
                    "ordering": false,
                    "info":     false,
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Russian.json"
                    }
                });
            }            
        }
    };
    var ChangeInputVal = function () {
        function changeVal(target, val){
            $(target).val(val);
        }
        return {
            //main function to initiate the module
            init: function () {
                $('.change-input-val').on('click', function () {                
                    changeVal($(this).data('target'), $(this).data('val'));
                });
            },
            value: function (target, val) {            
                changeVal(target, val);
            }
        };
    }();
    var ModalDialog = {  
        init: function (target){
            if ($("#modal-dialog-"+target+"__show").length > 0) {
                $("#modal-dialog-"+target+"__show").click(function(){
                    ModalDialog.show(target);
                });
            }
        },
        show: function(target){
            var oldBodyOuterWidth = $('body').outerWidth();
            $('body').css("overflow", "hidden");
            var newBodyOuterWidth = $('body').outerWidth();
            $('body').css('margin-right', (newBodyOuterWidth - oldBodyOuterWidth) + 'px');
            $('.modal-dialog-bg').css({'top':$(window).scrollTop()});
            // Отображаем скрытое модальное окно
    
            $('#modal-dialog-'+target).show();
            $('#modal-dialog-'+target).parent().show();
            // Устанавливаем модальное окно по середине
            $('.modal-dialog').VerticalAlign();
            // запрещаем распростарнение щелчка вниз по дереву DOM
            $('.modal-dialog').click(function(event){
               event.stopPropagation();
            });
            // Закрытие модального окна при щелчке по #modal_dialog_bg
            $('.modal-dialog-bg, .modal-dialog__close, .modal-dialog__btn-close').click(function(){
               ModalDialog.close();
            });            
            // Событие клик, происходит при нажатии по модальному окну и ссылке "закрыть"
            // Для крестика-картинки этого делать не нужно, т.к. он является частью контейнера .body2
            
        },
        close: function(){
            $('body').css('margin-right', 0 + 'px');
            $('body').css("overflow", "auto");
            $(".modal-dialog-bg").hide();
            $('.modal-dialog').hide();
        }
    };
    var MultipleChoise = {
        init: function(){
            if ($(".form-multiple-choice__modal").length > 0) {                
                $('.form-multiple-choice__modal input').each(function(){
                    if(this.checked){ 
                        var choice_id=$(this).val();
                        var choice_name=$(this).data('text');
                        MultipleChoise.appendChoiceItem(choice_id, choice_name);
                        MultipleChoise.deleteChoiceItemInit();
                    }
                });
                $(".form-multiple-choice__modal input").change(function(){
                    var choice_id=$(this).val();
                    //var parent = $(this).parent();                                        
                    if(this.checked){            
                        var choice_name=$(this).data('text');                    
                        //var choice_item="<li data-text='"+choice_id+"' id='form-multiple-choice__items_item-id-"+choice_id+"'>"+choice_name+"<i class='icon-close form-multiple-choice__delete'></i></li>";
                        MultipleChoise.appendChoiceItem(choice_id, choice_name);
                        MultipleChoise.deleteChoiceItemInit();
                    }
                    else{
                        $("#form-multiple-choice__items_item-id-"+choice_id).remove();
                    }
                });                
            }            
        },
        appendChoiceItem:  function(choice_id, choice_name){
            var choice_item="<li data-text='"+choice_id+"' id='form-multiple-choice__items_item-id-"+choice_id+"'>"+choice_name+"<i class='icon-close form-multiple-choice__delete'></i></li>";
            $(".form-multiple-choice__items").append(choice_item);
        },
        deleteChoiceItemInit: function(){
            $(".form-multiple-choice__delete").click(function(){
                //console.log("Failed to open the specified link");
                var li = $(this).parent('li');                    
                var choice_id = li.data('text');                
                $(".form-multiple-choice__checkbox_check-id-"+choice_id).prop( "checked", false );
                li.remove();                
            }); 
        }
    };
jQuery.fn.VerticalAlign = function () {
    var block_height=this.outerHeight();
    console.log("Block height:"+block_height);
    var window_height=$(window).height();
    if(window_height>block_height){
        this.css("top", ((window_height - block_height) / 2) + "px");
    }
    else{
        this.css("top", 0 + "px");
    }
    return this;
}
/*var GoToLabel = function () {
    return {
        
    }
}*/