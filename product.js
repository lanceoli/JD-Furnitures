
function setFormAction(action) {
    var form = document.getElementById('productForm');
    if (action === 'add') {
        form.action = 'add-product.php';
    } else if (action === 'finalize') {
        form.action = 'finalize.php';
    }
    form.submit();
}

function addProduct() {
    var buttonPress = document.getElementsByName('button-pressed')[0];
    buttonPress.value = 0;
    console.log(buttonPress.value);
}

function finalize() {
    var buttonPress = document.getElementsByName('button-pressed')[0];
    buttonPress.value = 1;
    console.log(buttonPress.value);
}