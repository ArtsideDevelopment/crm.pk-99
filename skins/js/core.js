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
    var ProductCategoriesCheck = {
        init: function(){
            $(".categories_check input").change(function(){
                
                var category_id=$(this).val();
                //if($(this).hasClass("find_area")) li_location_class = "area";
                //if($(this).hasClass("find_metro")) li_location_class = "metro";
                if(this.checked){            
                    var category_name=$(this).data('text');
                    var location_block="<li data-text='"+location_id+"' id='category_"+category_id+"'>"+category_name+"<span class='form_location_close'></span></li>";
                    $(".product_categories_block").append(location_block);
                    //alert($(this).val());
                }
                else{
                    $("#viz_"+li_location_class+"_"+location_id).remove();
                }
            });
        }
    };
/*var GoToLabel = function () {
    return {
        
    }
}*/