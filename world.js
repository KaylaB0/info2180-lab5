document.addEventListener('DOMContentLoaded', function() {
    const lookupBtn = document.getElementById('lookup');
    const lookupCitiesBtn = document.getElementById('lookupCities');

    // Event listener for the "Lookup" button (Country information)
    lookupBtn.addEventListener('click', function() {
        const country = document.getElementById('country').value.trim();

        // Use the fetch API to make the GET request to world.php for country info
        fetch(`http://localhost/info2180-lab5/world.php?country=${encodeURIComponent(country)}`)
            .then(response => response.text()) // Expect HTML response
            .then(data => {
                const resultDiv = document.getElementById('result');
                
                // Clear previous results
                resultDiv.innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    // Event listener for the "Lookup Cities" button (City information)
    lookupCitiesBtn.addEventListener('click', function() {
        const country = document.getElementById('country').value.trim();

        // Use the fetch API to make the GET request to world.php for city info
        fetch(`http://localhost/info2180-lab5/world.php?country=${encodeURIComponent(country)}&lookup=cities`)
            .then(response => response.text()) // Expect HTML response
            .then(data => {
                const resultDiv = document.getElementById('result');
                
                // Clear previous results
                resultDiv.innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
});

