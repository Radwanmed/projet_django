<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>SuppUtilisateur</title>
</head>
<body>
     <!--- SIDE BAR ----->
     <aside>
        <div class="user-img"></div>
        <h2>Administrateur</h2>
        <nav>
            <ul>
                <li>
                        <img src="photo/accueil.png" ><a href="accueil.html">Accueil</a>
                </li>
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
                        <li><img src=""><a href="acceuil.html">accueil</a></li>
                    </ul>
                <li>
                    <img src="photo/gallery.jpg" >Gallerie
                    <input type="checkbox" id="down3">
                        <label for="down3" class="nav-toggle">
                            <img src="photo/down-arrow.png" id="down">
                            <img src="photo/up-arrow.png" id="up">
                        </label>
                    <ul class="sous-menu">
                        <li><img src="photo/liste.png"><a href="listeGalleries.php">Liste des photos</a></li>
                        <li><img src="photo/ajouter.png"><a href="ajouterGalleries.php">Ajouter une photo</a></li>
                        <li><img src="photo/supprimer.png"><a href="supprimerGalleries.php">Supprimer une photo</a></li>
                    </ul>
               </ul>
        </nav>
    </aside>
    
<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'ttt'; // Nom de la base de données
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // En cas d'erreur de connexion
    echo "Erreur de connexion : " . $e->getMessage();
    exit();
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $gmail = $_POST['gmail'];

    if (!empty($gmail)) {
        // Suppression basée uniquement sur le Gmail
        $sql = "DELETE FROM user WHERE gmail = :gmail";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':gmail', $gmail, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo '
            <div class="alert">
                <input type="checkbox" id="btn-alert">
                <div>
                    <img src="photo/ok.png">
                    <h3>L\'utilisateur a été supprimé avec succès.</h3>
                    <h3>Merci</h3>
                    <label for="btn-alert"><a href="supprimerUtilisateur.php">FERMER</a></label>
                </div>
            </div>
            ';
        } else {
            echo '
            <div class="alert">
                <input type="checkbox" id="btn-alert">
                <div>
                    <img src="photo/erreur.png">
                    <h3>UNE ERREUR S\'EST PRODUITE</h3>
                    <h3>VEUILLEZ RÉESSAYER ULTERIEUREMENT.</h3>
                    <label for="btn-alert"><a href="supprimerUtilisateur.php">FERMER</a></label>
                </div>
            </div>
            ';
        }
    } else {
        echo '
        <div class="alert">
            <input type="checkbox" id="btn-alert">
            <div>
                <img src="photo/erreur.png">
                <h3>UNE ERREUR S\'EST PRODUITE</h3>
                <h3>VEUILLEZ RENSEIGNER L\'EMAIL DE L\'UTILISATEUR.</h3>
                <label for="btn-alert"><a href="supprimerUtilisateur.php">FERMER</a></label>
            </div>
        </div>
        ';
    }
}
?>

<!-- FORMULAIRE -->
<section id="corps">
    <form action="" method="POST">
        <h2>Supprimer un utilisateur</h2>
        
        <span>Email (Gmail) : </span>
        <select name="gmail">
            <option value=""></option>
            <?php
            // Récupérer la liste des utilisateurs
            $sql = "SELECT * FROM user";
            $stmt = $pdo->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option value="<?php echo htmlspecialchars($row['gmail']); ?>">
                    <?php echo htmlspecialchars($row['gmail']); ?>
                </option>
            <?php } ?>
        </select>

        <div id="button">
            <input type="submit" value="SUPPRIMER" id="submit-btn">
        </div>
    </form>
</section>

</body>
</html>