$(function () {
    $('.post , .comments-row').on('click', 'a.button-like', function () {
        var button = $(this);
        var span = button.find('.glyphicon');
        var params = {
            'id': button.attr('data-id'),
            'entity': button.attr('data-entity'),
        };

        if (span.hasClass('glyphicon-thumbs-up')) {
            params.action = 'like';
            $.post('/post/default/rate', params, function (data) {
                if (data.success) {
                    button.siblings('.likes-count').html(data.likesCount);
                    
                    span.removeClass('glyphicon-thumbs-up').addClass('glyphicon-thumbs-down');
                    
                    button.html('Unlike&nbsp;'+span[0].outerHTML);
                }
            });
        } else {
            params.action = 'unlike';
            $.post('/post/default/rate', params, function (data) {
                if (data.success) {
                    button.siblings('.likes-count').html(data.likesCount);
                    
                    span.removeClass('glyphicon-thumbs-down').addClass('glyphicon-thumbs-up');
                    
                    button.html('Like&nbsp;'+span[0].outerHTML);
                }
            });
        }
        return false;
    });
});
