<?php

$dbhost = 'mongodb://localhost:27017';
$dbname = 'tests';

// Connection to the MongoDB database
$manager = new MongoDB\Driver\Manager($dbhost);
$query = new MongoDB\Driver\Query([]);
try {
    $collection = $manager->executeQuery("$dbname.users", $query)->toArray();
} catch (\MongoDB\Driver\Exception\Exception $e) {
}

// Start the session
session_start();

// Verify authentication information
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    // Retrieve the user corresponding to the provided email
    foreach ($collection as $user) {
        if ($user->email === $email) { // If the user is found in the database
            // Password verification
            if ($user->password === ($password)) {
                // If password is validated then it redirects to the restaurants page
                $_SESSION['email'] = $email;
                $_SESSION['user'] = $user;
                header('Location: ./src/pages/list_restaurants/list_restaurants.php');
                exit;
            } else {
                $_SESSION['error'] = "Mot de passe incorrect.";
                header('Location: index.php');
                exit;
            }
        }
        else {
            $_SESSION['error'] = "Email incorrect.";
            header('Location: index.php');
            exit;
        }
    }exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Connectez-vous</title>
    <link href="./src/img/favicon.ico" rel="shortcut icon" />
    <link href="./src/pages/style/common.css" rel="stylesheet" />
    <link href="./src/pages/style/login.css" rel="stylesheet" />
</head>
<body>
<div class="container">
    <div class="title">
        <img
                class="logo"
                alt="logo"
                src="./src/img/logo_black.png"
                width="400px"
        />
    </div>
    <div class="panel">
        <h1>SE CONNECTER</h1>
        <form method="post" action="index.php">
            <div class="space"></div>
            <div>
                <label for="email">Email</label>
                <input type="text" id="email" name="email"><br><br>
            </div>
            <div class="space"></div>
            <div>
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password">
            </div>
            <input type="submit" value="Submit" value="ENTRER →" />
        </form>
    </div>
</div>
</body>
</html>