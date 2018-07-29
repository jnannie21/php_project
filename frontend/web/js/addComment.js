$(function () {
    $('.comment-form .comment-form__send-btn').click(function (event) {

        event.preventDefault();
        
        var form = $('#comment-form');
        var formData = new FormData(form[0]);
        
        var content = document.querySelector('#comment-form__text-content');
        
        formData.append('CommentForm[post_id]', form.attr('data-post-id'));
        formData.append('CommentForm[parent_id]', form.attr('data-parent-id'));
        formData.append('CommentForm[content]', content.innerHTML);

        $.ajax({
            type: 'POST', // тип запроса
            url: '/post/default/add-comment', // куда будем отправлять, можно явно указать
            data: formData, // данные, которые передаем
            cache: false, // кэш и прочие настройки писать именно так (для файлов)
            // (связано это с кодировкой и всякой лабудой)
            contentType: false, // нужно указать тип контента false для картинки(файла)
            processData: false, // для передачи картинки(файла) нужно false 
            success: function (data) { // в случае успешного завершения
                console.log("Завершилось успешно"); // выведем в консоли успех 
                console.log(data); // и что в ответе получили, если там что-то есть
                var commentsBlock = $('#comments-block');
                commentsBlock.append(data);
            },
            error: function (data) { // в случае провала
                console.log("Завершилось с ошибкой"); // сообщение об ошибке
                console.log(data); // и данные по ошибке в том числе
            }
        });
        return 0;
    });

});