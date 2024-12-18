<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Découvrez les images de l'album sélectionné.">
    <title>Album Photo</title>

    <!-- Inclusion du fichier CSS -->
    <link rel="stylesheet" href="galuser.css"> <!-- Assurez-vous que le chemin est correct -->
    <script src="galuser.js" defer></script>

    <!-- Ajout du Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
   
    </div>

    <?php
    require_once('config.php');

    // Connexion à la base de données
    if (isset($_GET['id'])) {
        $album_id = $_GET['id'];
        
        // Récupérer les détails de l'album
        $album_query = "SELECT * FROM album_list WHERE id = ? AND delete_f = 0";
        $stmt = $conn->prepare($album_query);
        $stmt->bind_param('i', $album_id);
        $stmt->execute();
        $album_result = $stmt->get_result();

        if ($album_result->num_rows > 0) {
            $album = $album_result->fetch_assoc();
            
            // Afficher les informations de l'album
            echo "<div class='album-header'>";
            echo "
<h2>" . htmlspecialchars($album['name']) . "</h2>";
            echo "<p>Créé le : " . date("d M Y", strtotime($album['date_created'])) . "</p>";
            echo "</div>";

            // Récupérer les images de l'album
            $image_query = "SELECT * FROM images WHERE album_id = ? AND delete_f = 0";
            $stmt = $conn->prepare($image_query);
            $stmt->bind_param('i', $album_id);
            $stmt->execute();
            $image_result = $stmt->get_result();

            if ($image_result->num_rows > 0) {
                echo "<div class='row' id='filterable-cards'>"; // Début de la grille pour les images
                while ($image = $image_result->fetch_assoc()) {
                    // Affichage de l'image avec la classe card-img-top
                    echo "
                        <div class='col-12 col-sm-6 col-md-2 mb-3'>
                            <div class='card'>
                                <div class='card-img-wrapper'>
                                    <img class='card-img-top' src='" . htmlspecialchars($image['path_name']) . "' alt='" . htmlspecialchars($image['original_name']) . "'>
                                </div>
                                <div class='card-body'>
                                    <p class='card-text'>" . htmlspecialchars($image['original_name']) . "</p>
                                </div>
                            </div>
                        </div>
                    ";
                }
                echo "</div>"; // Fin de la grille des images
            } else {
                echo "<div class='alert alert-info'>Aucune image dans cet album.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Album introuvable.</div>";
        }
    }
    ?>
</div>

<!-- Optionally include JavaScript files here -->
<script src="galuser.js" defer></script>

</body>
</html>
