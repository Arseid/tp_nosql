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
    $password = $_POST['password'];

    // Retrieve the user corresponding to the provided email
    foreach ($collection as $user) {
        if ($user->email === $email) { // If the user is found in the database
            // Password verification
            if ($user->password === ($password)) {
                // If password is validated then it redirects to the restaurants page
                $_SESSION['email'] = $email;
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