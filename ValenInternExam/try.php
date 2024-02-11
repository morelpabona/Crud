<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div id="performance-container">
        <div id="performance-header">
            <p class="performance-header">Shop Performance</p>
        </div>
        <p class="performance-subheader">Breakdown:</p>
        <ul id="performance-list" class="performance-list">
            <!-- Results will be dynamically added here -->
        </ul>
    </div>

    <script>
        // Fetch data using AJAX
        fetch('dataComplete.php')
            .then(response => response.json())
            .then(data => {
                const performanceList = document.getElementById('performance-list');

                for (const key in data) {
                    if (data.hasOwnProperty(key)) {
                        const value = data[key];
                        const listItem = document.createElement('li');
                        listItem.className = 'performance-item';
                        listItem.innerHTML = `${key}: <strong>${value}</strong>`;
                        performanceList.appendChild(listItem);
                    }
                }
            })
            .catch(error => console.error('Error fetching data:', error));
    </script>

</body>
</html>
