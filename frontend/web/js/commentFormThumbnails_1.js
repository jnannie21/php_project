(function(){
    document.addEventListener('DOMContentLoaded', function(){
      document.getElementById('commentform-picture').addEventListener('change', handleFileSelect.bind(null, 0));
      
        function placeCaretAtEnd(el) {
            el.focus();
            if (typeof window.getSelection != "undefined"
                    && typeof document.createRange != "undefined") {
                var range = document.createRange();
                range.selectNodeContents(el);
                range.collapse(false);
                var sel = window.getSelection();
                sel.removeAllRanges();
                sel.addRange(range);
            } else if (typeof document.body.createTextRange != "undefined") {
                var textRange = document.body.createTextRange();
                textRange.moveToElementText(el);
                textRange.collapse(false);
                textRange.select();
            }
        }      
      
      
        function handleFileSelect(i = 0, evt) {
            var files = evt.target.files;
            if(!files[i]){return false;}
            
            var helpBlock = document.querySelector('#comment-form .help-block');
            helpBlock.innerHTML = '';
            
            if (!files[i].type.match('image.*')) {
              helpBlock.innerHTML = 'Error: you can only upload image files';
              evt.stopImmediatePropagation();
              return false;
            }

            var commentForm = document.querySelector('#comment-form.active');
            var maxFileSize = commentForm.getAttribute('data-maxfilesize');
            if (files[i].size > maxFileSize) {
                var helpBlock = commentForm.querySelector('#comment-form .help-block');
                maxFileSizeMb = maxFileSize/1024/1024;
                helpBlock.innerHTML = 'Error: max file size is '+maxFileSizeMb+'Mb';
                evt.stopImmediatePropagation();
                return false;
            }

            var reader = new FileReader();
            reader.onloadend = (function(theFiles, i, evt) {
              return function(e) {
                // Render thumbnail.
                var img = document.createElement('img');
                img.setAttribute('class', 'thumb');
                img.setAttribute('src', e.target.result);
                img.setAttribute('title', encodeURIComponent(theFiles[i].name));

                var content = document.getElementById('comment-form__content');
                if (content.lastChild !== null && content.lastChild.nodeName === 'DIV' && content.lastChild.innerHTML === '<br>') {content.lastChild.remove();}
                content.appendChild(img);
                var div = document.createElement('div');
                var br = document.createElement('br');
                div.appendChild(br);
                content.appendChild(div);
                placeCaretAtEnd(content);
                handleFileSelect(++i, evt);
              };
            })(files, i, evt);
            reader.readAsDataURL(files[i]);
          }
}, false);
})();