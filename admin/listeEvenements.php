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
        $res1=mysqli_query($sum,"SELECT * FROM events");
       // Requête pour récupérer les données des événements
$res2 = mysqli_query($sum, "SELECT id, title, description, date_debut, date_fin, type, image, image_type FROM events ORDER BY date_debut");

if ($_POST) {
    $type = $_POST['type'];
    if (!empty($type)) {
        $res2 = mysqli_query($sum, "SELECT id, title, description, date_debut, date_fin, type, image, image_type FROM events WHERE type='$type' ORDER BY date_debut");
    }
}

?>
<section id="corpsliste">
    <form action="" method="POST">
        <span>
            Type d'événement
            <select name="type">
                <option value="" selected>Tous</option>
                <option value="futur">Futur</option>
                <option value="vedette">Vedette</option>
            </select>
        </span>
        <input type="submit" value="CHERCHER">
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Date de Début</th>
                <th>Date de Fin</th>
                <th>Type</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_array($res2)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                echo "<td>" . htmlspecialchars($row['date_debut']) . "</td>";
                echo "<td>" . htmlspecialchars($row['date_fin']) . "</td>";
                echo "<td>" . htmlspecialchars($row['type']) . "</td>";

                // Vérifier si une image existe
                if (!empty($row['image']) && !empty($row['image_type'])) {
                    // Générer un lien de type data URI pour afficher l'image
                    $imageData = base64_encode($row['image']);
                    $imageType = htmlspecialchars($row['image_type']);
                    echo "<td><img src='data:$imageType;base64,$imageData' alt='Image de l\'événement' style='max-width:100px;'></td>";
                } else {
                    echo "<td>Aucune image</td>";
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