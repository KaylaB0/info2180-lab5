<?php
// Allow CORS if necessary for cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

if (isset($_GET['country'])) {
    $country = $_GET['country'];

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if 'lookup' parameter is set to 'cities'
        if (isset($_GET['lookup']) && $_GET['lookup'] === 'cities') {
            // SQL query to join countries and cities tables
            $stmt = $conn->prepare("
                SELECT cities.name AS city_name, cities.district, cities.population
                FROM cities
                JOIN countries ON cities.country_code = countries.code
                WHERE countries.name LIKE :country
                ORDER BY cities.population DESC
            ");
            $stmt->bindValue(':country', '%' . $country . '%', PDO::PARAM_STR);
            $stmt->execute();

            $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($cities) {
                echo "<h2>Cities in {$country}</h2>";
                echo "<table border='1' cellpadding='5' cellspacing='0'>";
                echo "<thead><tr><th>City Name</th><th>District</th><th>Population</th></tr></thead>";
                echo "<tbody>";

                // Loop through results and display each city in a table
                foreach ($cities as $city) {
                    echo "<tr>";
                    echo "<td>{$city['city_name']}</td>";
                    echo "<td>{$city['district']}</td>";
                    echo "<td>{$city['population']}</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>No cities found for '{$country}'</p>";
            }
        } else {
            // Default query for country information
            $stmt = $conn->prepare("SELECT name, continent, independence_year, head_of_state FROM countries WHERE name LIKE :country");
            $stmt->bindValue(':country', '%' . $country . '%', PDO::PARAM_STR);
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($results) {
                echo "<h2>Country Information</h2>";
                echo "<table border='1' cellpadding='5' cellspacing='0'>";
                echo "<thead><tr><th>Country Name</th><th>Continent</th><th>Independence Year</th><th>Head of State</th></tr></thead>";
                echo "<tbody>";

                // Loop through results and display country info in a table
                foreach ($results as $row) {
                    echo "<tr>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['continent']}</td>";
                    echo "<td>{$row['independence_year']}</td>";
                    echo "<td>{$row['head_of_state']}</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>No results found for '{$country}'</p>";
            }
        }
    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>Please enter a country name to search.</p>";
}
?>
