$(function () {
    $('.comment-form .comment-form__send-btn').click(function (event) {

        event.preventDefault();
        
        var form = $('#comment-form');
        var formData = new FormData(form[0]);
        
        var textContent = form.find('.comment-form__text-content');
        
        formData.append('CommentForm[post_id]', form.attr('data-post-id'));
        formData.append('CommentForm[parent_id]', form.attr('data-parent-id'));
        formData.append('CommentForm[content]', textContent.html());
        
        var helpBlock = form.find('.help-block');
        helpBlock.html('');
        
        $.ajax({
            type: 'POST', // тип запроса
            url: '/post/default/add-comment', // куда будем отправлять, можно явно указать
            data: formData, // данные, которые передаем
            cache: false, // кэш и прочие настройки писать именно так (для файлов)
            // (связано это с кодировкой и всякой лабудой)
            contentType: false, // нужно указать тип контента false для картинки(файла)
            processData: false, // для передачи картинки(файла) нужно false 
            success: function (data) { // в случае успешного завершения
                if (data.success) {
                    console.log("Комментарий отправлен успешно"); // выведем в консоли успех 
                    
                    var commentsBlock = $('.comments-row');
                    commentsBlock.append(data.response);
                }
                else {
                    console.log("Ошибка при отправке комментария");
                    console.log(data);
                    errors = data.errors;
                    
                    var form = $('#comment-form');
                    for (var key in errors){
                        var attrName = key;
                        var attrValue = errors[key];
                        var helpBlock = form.find('.help-block');
                        helpBlock.append(attrName+': ' + attrValue+'<br>');
                    }
                }
            },
            error: function (data) { // в случае провала
                console.log("Ошибка при отправке комментария"); // сообщение об ошибке
                console.log(data); // и данные по ошибке в том числе
            }
        });
        textContent.html('');
        return 0;
    });

});