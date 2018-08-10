$(function () {
    function FF(){
        var form = $('#comment-form');
        var formData = new FormData(form[0]);
        this.count = 0;
        
        this.getFormData = function(){
            return formData;
        };
        
        this.setNewFormData = function() {
            this.count = 0;
            formData = new FormData(form[0]);
        };
        
        this.getCount = function() {
            return this.count;
        };
        
        this.setCount = function(count) {
            this.count = count;
        };
    };
    
    var F = new FF();
        
    
    function stripNewlines(content) {
        while (content.lastChild !== null && (content.lastChild.nodeName === 'DIV' || content.lastChild.nodeName === 'BR')) {
            
            stripNewlines(content.lastChild);
            
            if(content.lastChild.nodeName === 'BR') {
                content.lastChild.remove();
            } else if (content.lastChild.innerHTML === '<br>' || content.lastChild.innerHTML === '') {
                content.lastChild.remove();
            } else {return null;}
        }
    };
    
    
    $('.comment-form .comment-form__send-btn').click(function (event) {

        event.preventDefault();
        
        var form = $('#comment-form');
        var content = form.find('#comment-form__content');
        
        stripNewlines(content[0]);
        
        var img = content.find('img');
        
        img.removeAttr('title').removeAttr('class').attr('src', '');
        
        var formData = F.getFormData();
        
        formData.append('CommentForm[post_id]', form.attr('data-post-id'));
        formData.append('CommentForm[parent_id]', form.attr('data-parent-id'));
        formData.append('CommentForm[content]', content.html());
        
        
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
        
        var helpBlock = form.find('.help-block');
        helpBlock.html('');
        content.html('');
        $('#commentform-picture').wrap('<form>').closest('form').get(0).reset();
        $('#commentform-picture').unwrap();
        F.setNewFormData();
        return 0;
    });
        
    
    $('#commentform-picture').on('change',(function(){
                
        return function() {
            var count = F.getCount();
            var formData = F.getFormData();
            var files = this.files;

              var commentForm = $('#comment-form.active');
              var maxFileSize = commentForm.attr('data-maxfilesize');

            for(var i=0; i<files.length; i++){
                if (files[i].size > maxFileSize) {
                    continue;
                }
                formData.append('CommentForm[pictures]['+count+']', files[i]);
                F.setCount(++count);
            }
        };
    })());
    
    
    $('#comment-form__content').on('focus',function(){
        $('.comment-form__send-btn').removeClass('display-none');
        $('.load-picture-btn').removeClass('display-none');
    });
    
    
//    $('#comment-form__content').on('blur',function(){
//        $('.comment-form__send-btn').addClass('display-none');
//        $('.load-picture-btn').addClass('display-none');
//    });
    
});