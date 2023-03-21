<?php
    
    $trieur;
    if( empty($_POST['trie']) ){
        $trieur = "_id";
    }
    else{
        $trieur = $_POST['trie'];
    }
    $ordonner;
    if( empty($_POST['ordre']) ){
        $ordonner = 1;
    }
    else{
        $ordonner = (int)$_POST['ordre'];
    }
    $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    $query = new MongoDB\Driver\Query([],['limit' => 300, 'sort' => [$trieur => $ordonner]]);
    $namespace = 'tests.restaurants';

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Liste des restaurants</title>
    </head>
    <body>
        <h1>Liste des restaurants</h1>
        <form method="post">
            <select name="trie">
                <option value='name'>
                    alphabétique
                </option>
                <option value='restaurant_id'>
                    ordre d insertion 
                </option>
                <option value='_id'>
                    restaurant_id 
                </option>
                <option value='cuisine'>
                    type de cuisine
                </option>
                <option value='borough'>
                    arrondissement
                </option>
                <option value='address->zipcode'>
                    code postal
                </option>
            </select>
            <select name="ordre">
                <option value=1>
                    croissant
                </option>
                <option value=-1>
                    decroissant
                </option>
            </select>
            <input type='submit' value='Submit' />
        </form>
        <?php
        try { $cursor = $manager->executeQuery($namespace, $query); } catch (\MongoDB\Driver\Exception\Exception $e) {}

        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th><th>Cuisine</th><th>Borough</th><th>Zipcode</th><th>restaurant_id</th></tr>";
        foreach ($cursor as $document) {
            echo "<tr>";
            echo "<td>".$document->_id."</td>";
            echo "<td>".$document->name."</td>";
            echo "<td>".$document->cuisine."</td>";
            echo "<td>".$document->borough."</td>";
            echo "<td>".$document->address->zipcode."</td>";
            echo "<td>".$document->restaurant_id."</td>";

            echo "</tr>";
        }
        echo "</table>";
        ?>
    </body>
</html>
