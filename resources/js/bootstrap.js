var $ = window.$ = window.jQuery = require('jquery');
import Alpine from 'alpinejs';
var jQueryBridget = require('jquery-bridget');
window.Alpine = Alpine;
Alpine.start();

(function ($) {

    $.fn.fmSingle = function (type, options) {
        type = type || 'file';

        this.on('click', function (e) {
            var route_prefix = (options && options.prefix) ? options.prefix : '/filemanager';

            window.open(route_prefix + '?type=' + type, 'FileManager', 'width=900,height=600');
            window.SetUrl = function (items) {
                var file_path = items.map(function (item) {
                    return item.url;
                }).join(',');


                Livewire.emit('lfmSingle', file_path)

            };
            return false;
        });
    }

})(jQuery);
$('#lfmSingle').fmSingle('image');



