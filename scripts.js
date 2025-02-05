function triggerClick() {
    document.querySelector('#create-img').click();
}
function displayImage(e){
    if(e.files[0]){
        var reader = new FileReader();

        reader.onload = function(e){
            document.querySelector('#profileIMG').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}

function triggerClick2() {
    document.querySelector('#edit-img').click();
}

function stopFormSubmission(event) {
    if (event.keyCode === 13) {
    event.preventDefault();
    return false;
    }
}
