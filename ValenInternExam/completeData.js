

// -------------------Sum of Data--------------------
$(document).ready(function() {
    // Function to update the paint job statistics
    function updatePaintJobStatistics() {
        $.ajax({
            type: 'GET',
            url: 'dataComplete.php',
            dataType: 'json',
            success: function(data) {
                // Update the DOM with the fetched data
                $('#totalCarsPainted').text(data['Total Cars Painted']);
                $('#redCount').text(data['Red']);
                $('#greenCount').text(data['Green']);
                $('#blueCount').text(data['Blue']);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Handle error
            }
        });
    }

    // Initial call to update statistics when the page loads
    updatePaintJobStatistics();

    // Set interval to update the statistics every 5 seconds
    setInterval(updatePaintJobStatistics, 5000);
});