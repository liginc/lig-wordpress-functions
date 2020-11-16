(function($) {
    $(function() {
        var $button = $('#clear-cache');
        $button.on('click', function(){
            "use strict";
            $button.attr('disabled','disabled');
            $button.css({opacity:0.7});
            $button.text('キャッシュクリア中……');
            $.ajax({
                type: "POST",
                url: localize.ajax_url,
                dataType: 'text',
                data: {
                    action: localize.action
                }
            }).done(function(data, textStatus, jqXHR) {
                location.reload();
            });
        });
    })
})(jQuery)