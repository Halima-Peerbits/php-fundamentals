<?php
// ==============================
// NEWS API Example with cURL
// ==============================

$apiKey = "cabbe815df134928a66a0bb6dc959f9f"; 
$query  = "technology"; 
$apiUrl = "https://newsapi.org/v2/everything?q=" . urlencode($query) . "&pageSize=5&apiKey=$apiKey";

// Step 1: Initialize cURL
$ch = curl_init($apiUrl);

// Step 2: Set options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// ✅ Add User-Agent header (important!)
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "User-Agent: MyNewsApp/1.0"
]);

// Step 3: Execute request
$response = curl_exec($ch);

// Step 4: Handle errors
if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
    exit;
}

// Step 5: Close cURL
curl_close($ch);

// Step 6: Decode JSON response
$data = json_decode($response, true);

// Step 7: Display results in a clean format
if (isset($data["status"]) && $data["status"] === "ok" && !empty($data["articles"])) {
    echo "<h2 style='font-family: Arial; color: #2c3e50;'>📰 Top News on '$query'</h2>";
    
    foreach ($data["articles"] as $article) {
        echo "<div style='margin-bottom:20px; padding:10px; border:1px solid #ddd; border-radius:8px;'>";
        
        // Title
        echo "<h3 style='margin:0; color:#2980b9;'>" . htmlspecialchars($article["title"]) . "</h3>";
        
        // Description
        if (!empty($article["description"])) {
            echo "<p style='color:#555;'>" . htmlspecialchars($article["description"]) . "</p>";
        }
        
        // Link
        if (!empty($article["url"])) {
            echo "<a href='" . htmlspecialchars($article["url"]) . "' target='_blank' 
                    style='color:#27ae60; text-decoration:none; font-weight:bold;'>🔗 Read more</a>";
        }
        
        echo "</div>";
    }
} else {
    echo "<p style='color:red;'>API Error: " . ($data["message"] ?? "No news data found!") . "</p>";
}
?>

