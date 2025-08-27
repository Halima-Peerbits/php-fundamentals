<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set("display_errors", 1);

// File where feedback will be saved
$feedbackFile = "feedback.txt";
$name = $email = $message = "";
$errors = [];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize name
    if (empty($_POST["name"])) {
        $errors[] = "Name is required!";
    } else {
        $name = htmlspecialchars(trim($_POST["name"]));
    }

    // Validate and sanitize email
    if (empty($_POST["email"])) {
        $errors[] = "Email is required!";
    } else {
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format!";
        }
    }

    // Validate and sanitize feedback message
    if (empty($_POST["message"])) {
        $errors[] = "Message cannot be empty!";
    } else {
        $message = htmlspecialchars(trim($_POST["message"]));
    }

    // If no errors → Save feedback to file
    if (empty($errors)) {
        $entry = "Name: $name | Email: $email | Message: $message | Date: " . date("Y-m-d H:i:s") . "\n";
        file_put_contents($feedbackFile, $entry, FILE_APPEND);
        $successMsg = "✅ Thank you! Your feedback has been saved.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Feedback Form</title>
</head>
<body>
    <h2>Feedback Form</h2>
    <form method="POST" action="">
        Name: <input type="text" name="name" value="<?php echo $name; ?>"><br><br>
        Email: <input type="text" name="email" value="<?php echo $email; ?>"><br><br>
        Message: <br>
        <textarea name="message" rows="5" cols="40"><?php echo $message; ?></textarea><br><br>
        <input type="submit" value="Submit Feedback">
    </form>

    <hr>
    <?php
    // Show errors or success message
    if (!empty($errors)) {
        echo "<p style='color:red;'>Please fix these errors:</p><ul>";
        foreach ($errors as $err) {
            echo "<li>$err</li>";
        }
        echo "</ul>";
    } elseif (!empty($successMsg)) {
        echo "<p style='color:green;'>$successMsg</p>";
    }
    ?>
</body>
</html>
