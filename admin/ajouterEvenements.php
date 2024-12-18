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


         <!---- PHP------>
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
                echo '
                <div class="alert">
                    <input type="checkbox" id="btn-alert">
                    <div>
                        <img src="photo/ok.png">
                        <h3>L\' événement ajouté avec succés dans la base</h3>
                        <h3>Merci</h3>
                        <label for="btn-alert"><a href="ajouterEvenements.php">FERMER</a></label>
                   
                    </div>
                </div>
                ';
            }
            else
            {
                echo '
                <div class="alert">
                    <input type="checkbox" id="btn-alert">
                    <div>
                     <img src="photo/erreur.png">
                        <h3>UNE ERREUR S\'EST PRODUIT</h3>
                        <h3>VEUILEZ RESSAYER ULTERIEUREMENT.</h3>
                        <label for="btn-alert"><a href="ajouterEvenements.php">FERMER</a></label>
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
                            <h3>\ aucune photo ajoutée , faite le </h3>
                            <h3>Merci</h3>
                            <label for="btn-alert"><a href="ajouterEvenements.php">FERMER</a></label>
                        </div>
                    </div>
                    ';
        }
    }
    ?>
<!--FORMULAIRE--->
<section id="corps">
        <form  method="POST" enctype="multipart/form-data" >
            <h2>Ajouter un nouveau événement</h2>
            
            <span>title: </span>
           
            <input type="text" name="title" placeholder="conférence" required>
            <span>description :</span>
            <input type="text" name="description" required>

            <span>date_debut </span>
            <input type="date" name="date_debut" required>
            <span>date_fin:</span>
            <input type="date" name="date_fin" required>
            <span>type: </span>
            
            <select name="type"required>
               <option value="futur">Événement Futur</option>
               <option value="vedette">Événement Vedette</option>
            </select>
            <input type="hidden" name="MAX_FILE_SIZE" value="1000000000">
            <input name="userfile" type="file">
            
            <div id="button">
                <input type="submit" value="Ajouter" id="submit-btn">
            </div>
        </form>
    </section>
</body>
</html>