<?php
require_once 'vendor/autoload.php';

use MongoDB\Client;

try {
    // Connectez-vous à MongoDB
    $client = new Client('mongodb://mon_mongodb:27017');
    
    // Sélectionnez la base de données et la collection
    $collection = $client->ma_base_de_donnees->ma_collection;
    
    // Insérez un document dans la collection
    $insertResult = $collection->insertOne([
        'nom' => 'John Doe',
        'email' => 'john.doe@example.com',
    ]);
    
    echo "Nombre de documents insérés : " . $insertResult->getInsertedCount() . "<br>";

    // Récupérez les documents de la collection
    $documents = $collection->find();

    // Affichez les documents récupérés
    echo "Documents trouvés :<br>";
    foreach ($documents as $document) {
        echo "ID: " . $document['_id'] . ", Nom: " . $document['nom'] . ", Email: " . $document['email'] . "<br>";
    }

} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

