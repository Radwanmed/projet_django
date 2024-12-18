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
$server = "localhost";
$utilisateur = "root";
$motdepasse = "";
$base = "auth_db";
$sum = mysqli_connect($server, $utilisateur, $motdepasse, $base)
or die("Impossible de se connecter au serveur de base de données.");

mysqli_select_db($sum, $base)
or die("Impossible de trouver la base de données");

// Requête pour récupérer les données des utilisateurs
$res1 = mysqli_query($sum, "SELECT * FROM user");

// Requête pour récupérer les utilisateurs, éventuellement filtrée par nom
$res2 = mysqli_query($sum, "SELECT id, nom, gmail, password FROM user ORDER BY nom");

// Traitement du formulaire pour filtrer par nom
if ($_POST) {
    $nom = $_POST['nom'];
    if (!empty($nom)) {
        $res2 = mysqli_query($sum, "SELECT id, nom, gmail, password FROM user WHERE nom LIKE '%$nom%' ORDER BY nom");
    }
}
?>

<section id="corpsliste">
    <!-- Formulaire de filtrage par nom -->
    <form action="" method="POST">
        <span>
            Nom de l'utilisateur
            <input type="text" name="nom" placeholder="Rechercher par nom">
        </span>
        <input type="submit" value="CHERCHER">
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Gmail</th>
                <th>Password</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Affichage des utilisateurs
            while ($row = mysqli_fetch_array($res2)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nom']) . "</td>";
                echo "<td>" . htmlspecialchars($row['gmail']) . "</td>";
                if (isset($row['password']) && !empty($row['password'])) {
                    echo "<td>" . htmlspecialchars($row['password']) . "</td>";
                } else {
                    echo "<td>Aucun mot de passe défini</td>"; // Message alternatif si pas de mot de passe
                }
                
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</section>

<?php ?>
</body>
</html>

