var Uploadifive = function () {    
    return {
        init: function (target, name, main_width, thumb_width, timestamp, token) {
           $('#'+target+'_img_upload').uploadifive({
                'auto': true,
                'multi'    : false,
                'buttonText' : 'Выбрать изображение',
                'checkScript'      : 'check-exists.php',                
                'formData':{
                       'folder': target+'/',
                       'preffix': target+'_',               
                       'timestamp': timestamp,
                       'token'    : token,
                       'main_width' : main_width,
                       'thumb_width' : thumb_width
                 },
                'queueID': target+'_img_queue',
                'uploadScript': '/libs/uploadifive/uploadifive.php',
                'onUploadComplete': function(file, data) {
                    var upload_block="<input type='hidden' name='"+name+"' id='"+name+"' value='"+data+"'>";            
                   $('#'+target+'_img_data_block').html(upload_block);           
                }
            }); 
        },
        init_excel: function (target, timestamp, token) {
           $('#'+target+'_upload').uploadifive({
                'auto': true,
                'multi'    : false,
                'buttonText' : 'Выбрать файл',
                'checkScript'      : 'check-exists.php',                
                'formData':{
                       'folder':'excel/',              
                       'timestamp': timestamp,
                       'token'    : token
                 },
                'queueID': 'queue_'+target,
                'uploadScript': '/libs/uploadifive/uploadifive_excels.php',
                'onUploadComplete': function(file, data) {
                    var upload_block="<input type='hidden' name='"+target+"_file' id='"+target+"_file' value='"+data+"'>";            
                   $('#'+target+'_data_block').html(upload_block);           
                }
            }); 
        }
    };
}();
$(function() {       
    /*------------------
    * Инициализация uploadifive
    ---------------------*/    
    var timestamp=$("#upload_timestamp").val(); 
    var token=$("#upload_token").val();
   
    Uploadifive.init_excel('import_excel', timestamp, token);
    Uploadifive.init('categories', 'img', 800, 120, timestamp, token);
    Uploadifive.init('product', 'img', 800, 120, timestamp, token);
});