(function(){
    
 var inputfile = document.getElementById("file");
 inputfile.addEventListener("change", previewFile);
 
 function previewFile() {
  var preview = document.getElementById("blah");
  var file    = document.querySelector('input[type=file]').files[0];
  var reader  = new FileReader();

  reader.onloadend = function () {
    preview.src = reader.result;
  }

  if (file) {
    reader.readAsDataURL(file);
  } else {
    preview.src = "";
  }
}   
    
    
}());
