$(document).ready(function(){
    artside_main_sidebar.init();
    artside_data_tables.init('.dataTables', true);
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
/*var GoToLabel = function () {
    return {
        
    }
}*/