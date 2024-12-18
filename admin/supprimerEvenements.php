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
        $server="localhost";
        $utilisateur="root";
        $motdepasse="";
        $base="ttt";
        $sum=mysqli_connect($server,$utilisateur,$motdepasse,$base)
        or die("Impossible de se connecter au server de base de donnees.");
        mysqli_select_db($sum,$base)
        or die("Impossible de trouver la base de donnees");
        // Requête pour récupérer les événements
        $res = mysqli_query($sum, "SELECT * FROM events ORDER BY id");

        if ($_POST) {
            $id = $_POST['id'];
        
            if (!empty($id)) {
                // Suppression basée uniquement sur l'ID
                $resultat = mysqli_query($sum, "DELETE FROM events WHERE id=$id");
        
                if (!$resultat) {
                    echo '
                    <div class="alert">
                        <input type="checkbox" id="btn-alert">
                        <div>
                            <img src="photo/erreur.png">
                            <h3>UNE ERREUR S\'EST PRODUITE</h3>
                            <h3>VEUILLEZ RÉESSAYER ULTERIEUREMENT.</h3>
                            <label for="btn-alert"><a href="supprimerEvenements.php">FERMER</a></label>
                        </div>
                    </div>
                    ';
                } else {
                    echo '
                    <div class="alert">
                        <input type="checkbox" id="btn-alert">
                        <div>
                            <img src="photo/ok.png">
                            <h3>L\'événement a été supprimé avec succès.</h3>
                            <h3>Merci</h3>
                            <label for="btn-alert"><a href="supprimerEvenements.php">FERMER</a></label>
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
                        <h3>VEUILLEZ RENSEIGNER L\'ID DE L\'ÉVÉNEMENT.</h3>
                        <label for="btn-alert"><a href="supprimerEvenements.php">FERMER</a></label>
                    </div>
                </div>
                ';
            }
        }
        ?>
        
        <!-- FORMULAIRE -->
        <section id="corps">
            <form action="" method="POST">
                <h2>Supprimer un événement</h2>
                
                <span>ID : </span>
                <select name="id">
                    <option value=""></option>
                    <?php while ($row = mysqli_fetch_array($res)) { ?>
                        <option value="<?php echo htmlspecialchars($row['id']); ?>">
                            <?php echo htmlspecialchars($row['id'] . ' - ' . $row['title']); ?>
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