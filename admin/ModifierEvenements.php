<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Acceuil</title>
</head>
<body>
     <!--- SIDE BAR ----->
     <aside>
        <div class="user-img"></div>
        <h2>Administrateur</h2>
        <nav>
            <ul>
              
                <li>
                    <img src="photo/user.png">Utilisateur
                    <input type="checkbox" id="down1">
                        <label for="down1" class="nav-toggle">
                            <img src="photo/down-arrow.png" id="down">
                            <img src="photo/up-arrow.png" id="up">
                        </label>
                    <ul class="sous-menu">
                        <li><img src="photo/liste.png"><a href="listeUtilisateurs.php">Liste des Utilisateurs</a></li>
                        <li><img src="photo/supprimer.png"><a href="supprimerUtilisateur.php">Supprimer un Utilisateur</a></li>
                    </ul>
                </li>
                <li>
                    <img src="photo/event.jpg" >événements
                    <input type="checkbox" id="down2">
                        <label for="down2" class="nav-toggle">
                            <img src="photo/down-arrow.png" id="down">
                            <img src="photo/up-arrow.png" id="up">
                        </label>
                    <ul class="sous-menu">
                        <li><img src="photo/liste.png"><a href="listeEvenements.php">Liste des événements</a></li>
                        <li><img src="photo/ajouter.png"><a href="ajouterEvenements.php">Ajouter un événement</a></li>
                        <li><img src="photo/supprimer.png"><a href="supprimerEvenements.php" id="petit">Supprimer un événement</a></li>
                        <li><img src="photo/modifier.jpg"><a href="ModifierEvenements.php">Modifier un événement</a></li>
                    </ul>
                <li>
                    <img src="photo/gallery.jpg" >Gallerie
                    <input type="checkbox" id="down3">
                        <label for="down3" class="nav-toggle">
                            <img src="photo/down-arrow.png" id="down">
                            <img src="photo/up-arrow.png" id="up">
                        </label>
                    <ul class="sous-menu">
                    <li><img src="photo/liste.png"><a href="../gallery/?page=albums">Albums</a></li>
                    </ul>
               </ul>
        </nav>
    </aside>

    <?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'ttt';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit();
}

// Étape 1 : Vérifier si un titre a été soumis
if (!isset($_POST['titre']) && !isset($_GET['titre'])) {
    // Affichage du formulaire pour demander le titre
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <title>Rechercher un Événement</title>
    </head>
    <body>
    <section id="corps">
       
        <form action="ModifierEvenements.php" method="POST">
        <h2>Rechercher un Événement </h2>
            <span>Titre :</span>
            <input type="text" name="titre" required>
            <div id="button">
            <input type="submit" value="Rechercher" id="submit-btn">
            </div>
        </form>
    </section>
    </body>
    </html>
    <?php
    exit();
}

// Récupération du titre
$eventTitle = isset($_POST['titre']) ? $_POST['titre'] : $_GET['titre'];

// Étape 2 : Récupérer les données de l'événement par titre
$sql = "SELECT * FROM events WHERE title = :title";
$stmt = $pdo->prepare($sql);
$stmt->execute(['title' => $eventTitle]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    echo '<div class="alert">
    <input type="checkbox" id="btn-alert">
    <div>
        <img src="photo/erreur.png">
        <h3>Le titre n\'a pas été trouvé.</h3>
        <h3>Merci</h3>
        <label for="btn-alert"><a href="ModifierEvenements.php">FERMER</a></label>
    </div>
</div>
';
    exit();
}

// Étape 3 : Traitement du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $type = $_POST['type'];

    // Gestion de l'image
    if (isset($_FILES['userfile']) && $_FILES['userfile']['error'] == 0) {
        $imageData = file_get_contents($_FILES['userfile']['tmp_name']);
    } else {
        $imageData = $event['image']; // Garder l'image actuelle si aucune nouvelle n'est fournie
    }

    // Mise à jour dans la base de données
    $sql = "UPDATE events SET 
            title = :title, 
            description = :description, 
            date_debut = :date_debut, 
            date_fin = :date_fin, 
            type = :type, 
            image = :image 
            WHERE title = :title";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'title' => $title,
        'description' => $description,
        'date_debut' => $date_debut,
        'date_fin' => $date_fin,
        'type' => $type,
        'image' => $imageData
    ]);

    echo '<div class="alert">
    <input type="checkbox" id="btn-alert">
    <div>
        <img src="photo/ok.png">
        <h3>L\'événement a été modifié avec succès.</h3>
        <h3>Merci</h3>
        <label for="btn-alert"><a href="ModifierEvenements.php">FERMER</a></label>
    </div>
</div>
';
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Modifier l'Événement</title>
</head>
<body>
    
    <section id="corps">
    
    <form action="ModifierEvenements.php?titre=<?php echo urlencode($event['title']); ?>" method="POST" enctype="multipart/form-data">
    <h2>Modifier l'Événement</h2>
        <span>Titre :</span>
        <input type="text" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required><br>

        <span>Description:</span>
        <input type ="text" name="description" value="<?php echo htmlspecialchars($event['description']); ?>" required><br>

        <span>Date de début :</span>
        <input type="date" name="date_debut" value="<?php echo $event['date_debut']; ?>" required><br>

        <span>Date de fin :</span>
        <input type="date" name="date_fin" value="<?php echo $event['date_fin']; ?>" required><br>

        <span>Type :</span>
        <select name="type" required>
            <option value="futur" <?php if ($event['type'] == 'futur') echo 'selected'; ?>>Événement Futur</option>
            <option value="vedette" <?php if ($event['type'] == 'vedette') echo 'selected'; ?>>Événement Vedette</option>
        </select><br>

        <span>Image :</span><br>
        <?php if ($event['image']): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($event['image']); ?>" width="100"><br>
        <?php endif; ?>
        <input type="file" name="userfile"><br><br>
         
        <div id="button"> 
        <input type="submit" value="Modifier" id="submit-btn">
        </div>
    </form>
    </section>
</body>
</html>

  
