<?php
require_once 'app/router.php';// Include router file
require_once 'app/dbconnect.php';// Include the database configuration file

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