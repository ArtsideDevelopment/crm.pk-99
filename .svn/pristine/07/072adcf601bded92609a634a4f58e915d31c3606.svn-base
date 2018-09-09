function modal_dialog_show(){
    // избавляемся от скачка контента, за счет изменения ширины элемента 'body'
    var oldBodyOuterWidth = $('body').outerWidth();
    $('body').css("overflow", "hidden");
    var newBodyOuterWidth = $('body').outerWidth();
    $('body').css('margin-right', (newBodyOuterWidth - oldBodyOuterWidth) + 'px');
   
    $('#modal-dialog-bg').css({'top':$(window).scrollTop()});
    // Отображаем скрытое модальное окно
    $("#modal-dialog-bg").show();
    
        $('#modal-dialog').show();
        // Устанавливаем модальное окно по середине
        $('#modal-dialog').modal_v_center();
        // запрещаем распростарнение щелчка вниз по дереву DOM
        $('#modal-dialog').click(function(event){
           event.stopPropagation();
        });
        // Закрытие модального окна при щелчке по #modal_dialog_bg
        $('#modal-dialog-bg').click(function(){
           modal_dialog_close();
        });
        // Событие клик, происходит при нажатии по модальному окну и ссылке "закрыть"
        // Для крестика-картинки этого делать не нужно, т.к. он является частью контейнера .body2
        $("#modal-dialog__close").click(function(){
           modal_dialog_close();
        });
     
}
function modal_dialog_close(){
    $('body').css('margin-right', 0 + 'px');
    $('body').css("overflow", "auto");
    $("#modal-dialog-bg").hide();
    $('#modal-dialog').hide();
}
jQuery.fn.center = function () {
    var block_height=this.outerHeight();
    var window_height=$(window).height();
    if(window_height>block_height){
        this.css("top", ((window_height - block_height) / 2) + $(window).scrollTop() + "px");
    }
    else{
        this.css("top", $(window).scrollTop() + "px");
    }
    this.css("left", (($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft() + "px");
    return this;
}
jQuery.fn.center_vertical = function () {
    var block_height=this.outerHeight();
    var window_height=$(window).height();
    if(window_height>block_height){
        this.css("top", ((window_height - block_height) / 2) + $(window).scrollTop() + "px");
    }
    else{
        this.css("top", $(window).scrollTop() + "px");
    }  
    return this;
}
jQuery.fn.modal_v_center = function () {
    var block_height=this.outerHeight();
    var window_height=$(window).height();
    if(window_height>block_height){
        this.css("top", ((window_height - block_height) / 2) + "px");
    }
    else{
        this.css("top", 0 + "px");
    }
    return this;
}