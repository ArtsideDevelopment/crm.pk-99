$(document).ready(function(){
    AutoComplete.init('.js-typeahead');
});

var AutoComplete = function () {    
    return {
        init: function (target) {
            var myTypeahead =$(target).typeahead({
                minLength: 0,
                maxItem: 8,
                maxItemPerGroup: 6,
                order: "asc",
                hint: true,
                blurOnTab: false,
                searchOnFocus: true,            
                emptyTemplate: 'no result for {{query}}',
                display: ["code", "name", "address"],
                correlativeTemplate: true,
                template: '<span>' +
                '<p class="name">{{name}}</p>' + 
                '<p class="division">Адрес: ({{address}}</p>' +
                '<p class="name">Site Code: {{code}}</p>' + 
                '</span>',
                source: {
                    teams: {
                        url: "/api/get-objects?key=1"
                    }
                },
                callback: {
                    onClickAfter: function (node, a, item, event) {                                                
                        $('#object_code').val(item.code);
                        $('#object_name').val(item.name);
                        $('#object_address').html(item.address).text();
                    }
                },
                debug: true
            });
        }
    }
}();
