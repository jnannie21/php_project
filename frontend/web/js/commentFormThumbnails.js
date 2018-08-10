(function(){
    document.addEventListener('DOMContentLoaded', function(){
      document.getElementById('commentform-picture').addEventListener('change', handleFileSelect);
      
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
      
      
        function handleFileSelect(evt) {
            var helpBlock = document.querySelector('#comment-form .help-block');
            helpBlock.innerHTML = '';
            
            var files = evt.target.files;
            for (var i = 0, f; f = files[i]; i++) {
              if (!f.type.match('image.*')) {
                continue;
              }
              
              var commentForm = document.querySelector('#comment-form.active');
              var maxFileSize = commentForm.getAttribute('data-maxfilesize');
              if (f.size > maxFileSize) {
                  var helpBlock = commentForm.querySelector('#comment-form .help-block');
                  maxFileSizeMb = maxFileSize/1024/1024;
                  helpBlock.innerHTML = 'Error: max file size is '+maxFileSizeMb+'Mb';
                  continue;
              }
              
              var reader = new FileReader();
              reader.onload = (function(theFile) {
                return function(e) {
                  // Render thumbnail.
                  var img = document.createElement('img');
                  img.setAttribute('class', 'thumb');
                  img.setAttribute('src', e.target.result);
                  img.setAttribute('title', encodeURIComponent(theFile.name));
                  
                  var content = document.getElementById('comment-form__content');
                  if (content.lastChild !== null && content.lastChild.nodeName === 'DIV' && content.lastChild.innerHTML === '<br>') {content.lastChild.remove();}
                  content.appendChild(img);
                  var div = document.createElement('div');
                  var br = document.createElement('br');
                  div.appendChild(br);
                  content.appendChild(div);
                  placeCaretAtEnd(content);
                };
              })(f);
              reader.readAsDataURL(f);
            }
          }
}, false);
})();