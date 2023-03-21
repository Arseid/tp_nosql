<?php

    $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    $query = new MongoDB\Driver\Query([],['limit' => 300]);

    $namespace = 'tests.restaurants';

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Liste des restaurants</title>
    </head>
    <body>
        <h1>Liste des restaurants</h1>
        <?php
        try { $cursor = $manager->executeQuery($namespace, $query); } catch (\MongoDB\Driver\Exception\Exception $e) {}

        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th><th>Cuisine</th><th>Borough</th><th>Zipcode</th></tr>";
        foreach ($cursor as $document) {
            echo "<tr>";
            echo "<td>".$document->_id."</td>";
            echo "<td>".$document->name."</td>";
            echo "<td>".$document->cuisine."</td>";
            echo "<td>".$document->borough."</td>";
            echo "<td>".$document->address->zipcode."</td>";
            echo "</tr>";
        }
        echo "</table>";
        ?>
    </body>
</html>
