<?php
// index.php

// Include router file
require_once 'router.php';
?>
<?php
// Include the database configuration file
require_once 'dbconnect.php';

try {
    // Call the connectDB function
    $conn = connectDB();
    // If connection is successful, display a success message
    echo "Connected successfully";
} catch (Exception $e) {
    // If connection fails, display an error message
    echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
</head>

<body>
    <?php echo $content; ?>
</body>

</html>