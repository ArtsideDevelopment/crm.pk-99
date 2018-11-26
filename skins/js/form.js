// JavaScript Document
$(function(){
    //CKEDITOR.replace('content');
    tinymce.init({         
        selector:'textarea.tinymce_min',
        language:"ru",
        height : "100",
        //language_url : '/skins/js/libs/languages/ru.js',
        plugins: [
         "code link image anchor table paste advlist lists responsivefilemanager"
        ],
        paste_auto_cleanup_on_paste : true,
        paste_convert_headers_to_strong : false,
        paste_strip_class_attributes : "all",
        paste_remove_spans : true,
        paste_remove_styles : true,
        //relative_urls : false,
        //remove_script_host : false,
        paste_retain_style_properties : "",
        toolbar: "code | undo redo | formatselect bold italic | alignleft aligncenter alignright | table bullist numlist | link unlink | image responsivefilemanager",
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//http://pk-99.u0096264.plsk.regruhosting.ru/skins/css/styles.css'
          ],
        image_advtab: true ,
   
       external_filemanager_path:"/filemanager/",
       filemanager_title:"Responsive Filemanager" ,
       external_plugins: { "filemanager" : "/filemanager/plugin.min.js"}
         });
    tinymce.init({         
        selector:'textarea.tinymce',
        language:"ru",
        height : "400",
        //language_url : '/skins/js/libs/languages/ru.js',
        plugins: [
         "code link image anchor table paste advlist lists responsivefilemanager"
        ],
        paste_auto_cleanup_on_paste : true,
        paste_convert_headers_to_strong : false,
        paste_strip_class_attributes : "all",
        paste_remove_spans : true,
        paste_remove_styles : true,
        //relative_urls : false,
        //remove_script_host : false,
        paste_retain_style_properties : "",
        toolbar: "code | undo redo | formatselect bold italic | alignleft aligncenter alignright | table bullist numlist | link unlink | image responsivefilemanager",
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//http://pk-99.u0096264.plsk.regruhosting.ru/skins/css/styles.css'
          ],
        image_advtab: true ,
   
       external_filemanager_path:"/filemanager/",
       filemanager_title:"Responsive Filemanager" ,
       external_plugins: { "filemanager" : "/filemanager/plugin.min.js"}
         });
        
    $('.translit').keyup(function(){ 
        if(!$('#alias').hasClass("no_tranlit")){
            var alias_ru = $('#name').val();
            //alert(alias_ru);
            var alias_en=aliasTranslit(alias_ru);
            $('#alias').val(alias_en);
        }
    });
    $('.chosen-select').chosen({no_results_text: 'По вашему апросу ничего не найдено!', width:'100%'});     
});
// перевод строки в транслит
function aliasTranslit(str){
    // Символ, на который будут заменяться все спецсимволы
    var space = '-';
    // Берем значение из нужного поля и переводим в нижний регистр
    var text = str.toLowerCase();
    // Массив для транслитерации
    var transl = {
    'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'e', 'ж': 'zh',
    'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n',
    'о': 'o', 'п': 'p', 'р': 'r','с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h',
    'ц': 'c', 'ч': 'ch', 'ш': 'sh', 'щ': 'sh','ъ': space, 'ы': 'y', 'ь': space, 'э': 'e', 'ю': 'yu', 'я': 'ya',
    ' ': space, '_': space, '`': space, '~': space, '!': space, '@': space,
    '#': space, '$': space, '%': space, '^': space, '&': space, '*': space,
    '(': space, ')': space,'-': space, '\=': space, '+': space, '[': space,
    ']': space, '\\': space, '|': space, '/': space,'.': space, ',': space,
    '{': space, '}': space, '\'': space, '"': space, ';': space, ':': space,
    '?': space, '<': space, '>': space, '№':space
    }
    var result = '';
    var curent_sim = '';

    for(i=0; i < text.length; i++) {
        // Если символ найден в массиве то меняем его
        if(transl[text[i]] != undefined) {
             if(curent_sim != transl[text[i]] || curent_sim != space){
                 result += transl[text[i]];
                 curent_sim = transl[text[i]];
             }                                                                            
        }
        // Если нет, то оставляем так как есть
        else {
            result += text[i];
            curent_sim = text[i];
        }                             
    }
    return result;
}