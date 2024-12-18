<?php
// 1. Connexion à la base de données
$host = 'localhost'; // Adresse du serveur de base de données
$dbname = 'ttt'; // Nom de la base de données
$username = 'root'; // Votre nom d'utilisateur de la base de données
$password = ''; // Votre mot de passe de la base de données

// Créer une connexion avec PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Gérer les erreurs
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit();
}

// 2. Vérification si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $type = $_POST['type'];

    // Traitement de l'image téléchargée
    if (isset($_FILES['userfile']) && $_FILES['userfile']['error'] == 0) {
        // Récupérer l'image et son type
        $imageData = file_get_contents($_FILES['userfile']['tmp_name']);
        $imageType = $_FILES['userfile']['type'];

        // Insérer les données dans la base de données
        $sql = "INSERT INTO events (title, description, date_debut, date_fin, type, image, image_type)
                VALUES (:title, :description, :date_debut, :date_fin, :type, :image, :image_type)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':date_debut', $date_debut);
        $stmt->bindParam(':date_fin', $date_fin);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':image', $imageData, PDO::PARAM_LOB);
        $stmt->bindParam(':image_type', $imageType);

        // Exécuter la requête d'insertion
        if ($stmt->execute()) {
            echo "Événement ajouté avec succès !";
        } else {
            echo "Erreur lors de l'ajout de l'événement.";
        }
    } else {
        echo '
                <div class="alert">
                    <input type="checkbox" id="btn-alert">
                    <div>
                        <img src="photo/erreur.png">
                        <h3>\' aucune photo ajoutée , faite le </h3>
                        <h3>Merci</h3>
                        <label for="btn-alert"><a href="ajouterEvenements.php">FERMER</a></label>
                    </div>
                </div>
                ';
    }
}
?>
