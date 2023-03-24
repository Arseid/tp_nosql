<?php
    session_start();

    if (!isset($_SESSION['user']->_id)) {
    // If user is not logged in, redirect to login page
    header("Location: /index.php");
    exit();
    }

    $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    $bulk = new MongoDB\Driver\BulkWrite();
    $bulk->update(
        ['_id' => $_SESSION['user']->_id],
        ['$addToSet' => ['restaurants' => $_POST['restaurant_id']]]
    );
    $manager->executeBulkWrite('tests.users', $bulk);

    header('Location: list_restaurants.php');
?>