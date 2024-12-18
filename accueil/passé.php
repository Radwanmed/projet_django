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

// 2. Récupérer les événements passés
$sql = "SELECT title, description, date_debut, date_fin, image FROM events WHERE date_fin < CURDATE() ORDER BY date_debut ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Événements passés</title>
    <link rel="stylesheet" href="eventstyle.css">
</head>
<body>

<section class="events">
    <h2 class="heading">Événements passés</h2>
    <div class="events-container">
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <div class="event-card">
                <div class="event-image">
                    <?php
                        // Vérifier si une image est présente (BLOB)
                        if ($row['image']) {
                            // Créer un fichier temporaire pour l'image
                            $imageData = $row['image'];
                            $tempImagePath = 'images/temp_image_' . uniqid() . '.jpg';
                            
                            // Sauvegarder le fichier temporaire
                            file_put_contents($tempImagePath, $imageData);
                            
                            // Afficher l'image depuis le fichier temporaire
                            echo '<img src="' . $tempImagePath . '" alt="Image">';
                        } else {
                            echo 'Aucune image';
                        }
                    ?>
                </div>
                <div class="event-info">
                    <h3 class="event-title"><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p class="event-date"><?php echo htmlspecialchars($row['date_debut']) . ' - ' . htmlspecialchars($row['date_fin']); ?></p>
                    <p class="event-description"><?php echo htmlspecialchars($row['description']); ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</section>

</body>
</html>
