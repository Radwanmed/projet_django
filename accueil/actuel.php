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

// 2. Récupérer les événements en cours (date actuelle entre date_debut et date_fin)
$sql = "SELECT title, description, date_debut, date_fin, image FROM events WHERE CURDATE() BETWEEN date_debut AND date_fin ORDER BY date_debut ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();

// 3. Affichage dans une page HTML
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Événements en cours</title>
    <link rel="stylesheet" href="eventstyle.css">
</head>
<body>

    <section class="events">
        <h1 class="heading">Événements en cours</h1>

        <?php if ($stmt->rowCount() > 0): ?>
            <div class="events-container">
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="event-card">
                        <div class="event-image">
                            <?php
                                // Vérifier si une image est présente (BLOB)
                                if ($row['image']) {
                                    $imageData = $row['image'];
                                    $imageType = 'image/jpeg'; // Par défaut, suppose que l'image est JPEG

                                    // Si l'image est un autre format, ajuster le type MIME en conséquence
                                    if (substr($imageData, 0, 3) == "\x89\x50\x4E") {
                                        $imageType = 'image/png'; // PNG
                                    } elseif (substr($imageData, 0, 3) == "\x47\x49\x46") {
                                        $imageType = 'image/gif'; // GIF
                                    }

                                    // Convertir le BLOB en image affichable
                                    echo '<img src="data:' . $imageType . ';base64,' . base64_encode($imageData) . '" alt="Image">';
                                } else {
                                    echo 'Aucune image';
                                }
                            ?>
                        </div>

                        <div class="event-info">
                            <h3 class="event-title"><?php echo htmlspecialchars($row['title']); ?></h3>
                            <p class="event-date">
                                <?php echo 'Début : ' . htmlspecialchars($row['date_debut']) . '<br>Fin : ' . htmlspecialchars($row['date_fin']); ?>
                            </p>
                            <p class="event-description"><?php echo htmlspecialchars($row['description']); ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>Aucun événement en cours.</p>
        <?php endif; ?>
    </section>

</body>
</html>
