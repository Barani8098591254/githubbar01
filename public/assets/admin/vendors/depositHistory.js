$(document).ready(function(){

});

function refresh() {
   location.reload();
}

function copyValue(value) {
    console.log("copy");
    var textArea = document.createElement("textarea");
    textArea.value = value;
    document.body.appendChild(textArea);
    textArea.select();
    document.execCommand("Copy");
    textArea.remove();
    toastr.success('copied !!!', 'Success', {timeOut: 2000});
}
