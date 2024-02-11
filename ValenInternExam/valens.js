function updateColor2() {
    let selectElement = document.querySelector('.mySelect');
    let selectedOption = selectElement.value;
    let displayCarElement = document.querySelector('.displayCar');

    // Set a default image
    displayCarElement.innerHTML = '<img src="./img/default.jpg" alt="Default Car" style="padding-right: 150px;">';

    // Update the displayed car based on the selected color
    if (selectedOption === 'red') {
        displayCarElement.innerHTML = '<img src="./img/rightred.jpg" alt="Red Car">';
    } else if (selectedOption === 'green') {
        displayCarElement.innerHTML = '<img src="./img/rightgreen.jpg" alt="Green Car">';
    } else if (selectedOption === 'blue') {
        displayCarElement.innerHTML = '<img src="./img/rightblue.jpg" alt="Blue Car">';
    }
}window.onload = updateColor2;



function updateColor1() {
    let selectElement = document.querySelector('.mySelect1');
    let selectedOption = selectElement.value;
    let displayCarElement = document.querySelector('.displayCar1'); 



        if (selectedOption === 'red') {
            displayCarElement.innerHTML = '<img src="./img/rightred.jpg" alt="Red Car">';
        } else if (selectedOption === 'green') {
            displayCarElement.innerHTML = '<img src="./img/rightgreen.jpg" alt="Green Car">';
        } else if (selectedOption === 'blue') {
            displayCarElement.innerHTML = '<img src="./img/rightblue.jpg" alt="Blue Car">';
        } 
}

// ---------------------------------------------------------------------------------------------------------



        // You can perform any necessary actions here, such as updating color counts or making an AJAX request.
        // For demonstration purposes, let's just reload the "Paint Job in Process" section.

        $.ajax({
            url: 'dataComplete.php', // Replace with the actual URL that handles paint job updates.
            type: 'GET',    
            success: function (res) {
                console.log (res);
                
            },
            error: function ( error) {
                console.error('', error);
            }
        });
 





