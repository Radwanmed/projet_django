<?php
// Inclure la configuration de la base de données
require_once('config.php');  // Cela inclut le fichier config.php et initialisera $conn

// Vérifiez si $conn est défini
if (!isset($conn)) {
    die('La connexion à la base de données a échoué.');
}

// La requête pour récupérer les albums
$query = "SELECT * FROM album_list WHERE delete_f = 0"; 

// Exécuter la requête
$result = $conn->query($query);

// Vérifier si la requête a échoué
if ($result === false) {
    die('Erreur dans la requête SQL : ' . $conn->errorInfo()[2]);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Découvrez tous les albums disponibles sur notre site.">
    <title>Albums</title>
    <link rel="stylesheet" href="galuser.css?v=1.0"> <!-- Assurez-vous que le cache est vidé -->
    <script src="galuser.js" defer></script>
     <!-- font awesome cdn link  -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
</head>
<body>


<!-- Formulaire de recherche -->
<div class="row mt-4">
    <div class="col-12">
        <form method="GET" action="albums.php">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Rechercher un album" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button class="btn btn-primary" type="submit">Rechercher</button>
            </div>
        </form>
    </div>
</div>

<?php
// Inclure la configuration de la base de données
require_once('config.php');  // Cela inclut le fichier config.php et initialisera $conn

// Vérifiez si $conn est défini
if (!isset($conn)) {
    die('La connexion à la base de données a échoué.');
}

// Initialiser la variable de recherche
$search_query = "";

// Vérifiez si un terme de recherche est passé via la méthode GET
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = $_GET['search'];
    $search_query = " AND name LIKE ?";
}

// La requête pour récupérer les albums
$query = "SELECT * FROM album_list WHERE delete_f = 0" . $search_query;

// Préparez la requête SQL
$stmt = $conn->prepare($query);

// Si un terme de recherche est fourni, liez le paramètre à la requête préparée
if ($search_query) {
    $search_term = "%" . $search_term . "%"; // Ajoute les symboles de pourcentage pour une recherche "LIKE"
    $stmt->bind_param('s', $search_term);
}

// Exécuter la requête
$stmt->execute();
$result = $stmt->get_result();

// Vérifier si la requête a échoué
if ($result === false) {
    die('Erreur dans la requête SQL : ' . $conn->errorInfo()[2]);
}
?>

    <!-- Section des images filtrables / Cartes -->
    <div class="row px-2 mt-4 gap-3" id="filterable-cards">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($album = $result->fetch_assoc()): ?>
            <?php
            // Récupérer la première image de chaque album
            $album_id = $album['id'];
            $image_query = "SELECT * FROM images WHERE album_id = ? AND delete_f = 0 LIMIT 1";
            $stmt = $conn->prepare($image_query);
            $stmt->bind_param('i', $album_id);
            $stmt->execute();
            $image_result = $stmt->get_result();
            $first_image_path = "path_to_default_image.jpg"; // Image par défaut au cas où
            if ($image_result->num_rows > 0) {
                $first_image = $image_result->fetch_assoc();
                $first_image_path = $first_image['path_name']; // Chemin de la première image
            }
            ?>

            <div class="card p-0" data-name="album">
                <div class="card-img-wrapper">
                    <!-- Affichage de la première image de l'album -->
                    <img class="card-img-top" src="<?php echo htmlspecialchars($first_image_path); ?>" alt="Image de l'album">
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($album['name']); ?></h5>
                    <p class="card-text">
                        <?php echo "Créé le: " . date("d M Y", strtotime($album['date_created'])); ?>
                    </p>
                    <a href="album.php?id=<?php echo $album['id']; ?>" class="btn btn-primary">Voir l'album</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <?php else: ?>
        <div class="alert alert-warning" role="alert">
            Aucun album disponible.
        </div>
    <?php endif; ?>
</div>

</body>
</html>
