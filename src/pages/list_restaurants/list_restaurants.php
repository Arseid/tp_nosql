<?php
    session_start();

    if (!isset($_SESSION['user']->_id)) {
        // If user is not logged in, redirect to login page
        header("Location: /index.php");
        exit();
    }

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
    <title>Restos favoris</title>
    <link href="../../img/favicon.ico" rel="shortcut icon" />
    <link href="../style/common.css" rel="stylesheet" />
    <link href="../style/table.css" rel="stylesheet" />
    <link href="../style/layout.css" rel="stylesheet" />
</head>
<body>
<div class="container">
    <div class="sidebar">
        <img
                class="logo"
                alt="logo"
                src="../../img/logo_white.png"
                height="36px"
        />
        <div class="divider"></div>
        <ul>
            <li>
                <a href="../list_restaurants/list_restaurants.php" class="activenav"
                >→ Tous les restos</a
                >
            </li>
            <li>
                <a href="../fav_restaurants/fav_restaurants.php"
                >→ Restos Favoris</a
                >
            </li>
        </ul>
        <div class="space"></div>
        <div class="divider"></div>
        <ul>
            <li><a href="../../../index.php" class="logout">← Se déconnecter</a></li>
        </ul>
    </div>
    <div class="content">
        <h1>TOUS LES RESTAURANTS</h1>
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
        <div class="tablebox">
            <?php
            try { $cursor = $manager->executeQuery($namespace, $query); } catch (\MongoDB\Driver\Exception\Exception $e) {}

            echo "<table>";
            echo "<thead><tr><th class='sortable'>ID</th><th class='sortable'>RID</th><th class='sortable'>Restaurant</th><th class='sortable'>Style culinaire</th><th class='sortable'>Arr.</th><th class='sortable'>CP</th><th></th></tr></thead>";
            foreach ($cursor as $document) {
                echo "<tr>";
                echo "<td>".$document->_id."</td>";
                echo "<td>".$document->restaurant_id."</td>";
                echo "<td>".$document->name."</td>";
                echo "<td>".$document->cuisine."</td>";
                echo "<td>".$document->borough."</td>";
                echo "<td>".$document->address->zipcode."</td>";
                echo "<td>";
                echo "<form method='post' action='addToFavorites.php'>";
                echo "<input type='hidden' name='restaurant_id' value='".$document->_id."' />";
                echo "<input type='submit' value='Add to favorites' />";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
            ?>
        </div>
    </div>
</div>
</body>
</html>