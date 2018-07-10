$(document).ready(function () {
    $('a.button-like').click(function () {
        var button = $(this);
        var span = button.find('.glyphicon');
        var params = {
            'id': $(this).attr('data-id')
        };

        if (span.hasClass('glyphicon-thumbs-up')) {
            $.post('/post/default/like', params, function (data) {
                if (data.success) {
                    button.siblings('.likes-count').html(data.likesCount);
                    
                    span.removeClass('glyphicon-thumbs-up').addClass('glyphicon-thumbs-down');
                    
                    button.html('Unlike&nbsp;&nbsp;'+span[0].outerHTML);
                }
            });
        } else {
            $.post('/post/default/unlike', params, function (data) {
                if (data.success) {
                    button.siblings('.likes-count').html(data.likesCount);
                    
                    span.removeClass('glyphicon-thumbs-down').addClass('glyphicon-thumbs-up');
                    
                    button.html('Like&nbsp;&nbsp;'+span[0].outerHTML);
                }
            });
        }
        return false;
    });
});
