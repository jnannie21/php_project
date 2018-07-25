function handleFileSelect(evt) {
    var files = evt.target.files;
    for (var i = 0, f; f = files[i]; i++) {
      if (!f.type.match('image.*')) {
        continue;
      }

      var reader = new FileReader();
      reader.onload = (function(theFile) {
        return function(e) {
          // Render thumbnail.
          var span = document.createElement('span');
          span.innerHTML = '<img class="thumb" src="' + e.target.result + '" title="' + encodeURIComponent(theFile.name) + '"/>';
          var list = document.getElementById('thumb-list');
          list.insertBefore(span, list.children[0]);
        };
      })(f);
      reader.readAsDataURL(f);
    }
  }

  document.getElementById('postform-picture').addEventListener('change', handleFileSelect);