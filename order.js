var closeButton = document.getElementById("close");
var confirmationModal = document.getElementById("confirmationModal")
var furnitureModal = document.getElementById('furnitureModal');

function displayConfirmation() {
    var customerSelect = document.getElementById('customer');
    var customerName = customerSelect.options[customerSelect.selectedIndex].text;
    var progress = document.getElementById('progress').value;
    var deliveryDate = document.getElementById('delivery').value;
    var paymentMethod = document.getElementById('payment').value;
    var specialInstructions = document.getElementById('instruction').value;
    
    document.getElementById('customerOutput').textContent = customerName;
    document.getElementById('progressOutput').textContent = progress;
    document.getElementById('deliveryDateOutput').textContent = deliveryDate;
    document.getElementById('paymentMethodOutput').textContent = paymentMethod;
    document.getElementById('specialInstructionsOutput').textContent = specialInstructions;

    confirmationModal.style.display = "block";
}

function displayFurniture() {
    confirmationModal.style.display = "none";
    furnitureModal.style.display = "block";
}

function displayAdd() {
    furnitureModal.style.display = "block";
}

closeButton.onclick = function() {
    confirmationModal.style.display = "none";
    furnitureModal.style.display = "none";
}