<?php
// Array of cities with lat/long
$cities = [
    "Toronto"     => ["lat" => 43.651070, "lon" => -79.347015],
    "Etobicoke"   => ["lat" => 43.6205,   "lon" => -79.5132],
    "Mississauga" => ["lat" => 43.5890,   "lon" => -79.6441],
];

foreach ($cities as $name => $coords) {
    $apiUrl = "https://api.open-meteo.com/v1/forecast?latitude={$coords['lat']}&longitude={$coords['lon']}&current_weather=true";

    // Step 1: Initialize cURL
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "cURL Error for $name: " . curl_error($ch) . "<br>";
        continue;
    }
    curl_close($ch);

    // Step 2: Decode JSON
    $data = json_decode($response, true);

    // Step 3: Display weather info
    if (isset($data["current_weather"])) {
        $weather = $data["current_weather"];
        echo "🌍 Location: $name ({$coords['lat']}, {$coords['lon']})<br>";
        echo "🌡 Temperature: " . $weather["temperature"] . "°C<br>";
        echo "💨 Windspeed: " . $weather["windspeed"] . " km/h<br>";
        echo "🕒 Time: " . $weather["time"] . "<br><br>";
    } else {
        echo "No weather data found for $name!<br><br>";
    }
}

