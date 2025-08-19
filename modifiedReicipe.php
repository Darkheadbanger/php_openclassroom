<?php
if (session_start() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/authentification/authentificationVerif.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifie your reicipes</title>
</head>

<body>
    <?php include_once './views/forms/recipe-form.php'; ?>
</body>

</html>