$(function () {
    $('a.button-like').click(function () {
        var button = $(this);
        var span = button.find('.glyphicon');
        var params = {
            'id': $(this).attr('data-id')
        };

        if (span.hasClass('glyphicon glyphicon-thumbs-up')) {
            $.post('/post/default/like', params, function (data) {
                if (data.success) {
                    button.siblings('.likes-count').html(data.likesCount);
                    
                    span.removeClass('glyphicon glyphicon-thumbs-up').addClass('glyphicon glyphicon-thumbs-down');
                    
                    button.html('Unlike&nbsp;'+span[0].outerHTML);
                }
            });
        } else {
            $.post('/post/default/unlike', params, function (data) {
                if (data.success) {
                    button.siblings('.likes-count').html(data.likesCount);
                    
                    span.removeClass('glyphicon glyphicon-thumbs-down').addClass('glyphicon glyphicon-thumbs-up');
                    
                    button.html('Like&nbsp;'+span[0].outerHTML);
                }
            });
        }
        return false;
    });
});
