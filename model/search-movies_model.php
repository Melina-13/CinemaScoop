
<?php
include('db.php');

// Si la page n'est pas définie dans l'URL, on l'initialise à 1
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

// Nombre de résultats par page
$results_per_page = 10;

// Récupérer les genres et distributeurs pour les filtres
$genres = mysqli_query($conn, "SELECT * FROM genre");
$distributors = mysqli_query($conn, "SELECT * FROM distributor");

// Construire la requête SQL de base sans la pagination
$query = "SELECT m.*, d.name AS distributor_name
          FROM movie m
          JOIN distributor d ON m.id_distributor = d.id
          WHERE 1=1";

// Vérifier les entrées utilisateur pour les filtres
$search = isset($_POST['search']) ? $_POST['search'] : '';
$genre_id = isset($_POST['genre']) ? (int) $_POST['genre'] : 0;
$distributor_id = isset($_POST['distributor']) ? (int) $_POST['distributor'] : 0;

// Ajouter la recherche par titre (si l'utilisateur a entré quelque chose)
if (!empty($search)) {
    $query .= " AND m.title LIKE '%$search%'";
}

// Ajouter le filtre par genre (si un genre est sélectionné)
if ($genre_id > 0) {
    $query .= " AND m.id IN (SELECT id_movie FROM movie_genre WHERE id_genre = $genre_id)";
}

// Ajouter le filtre par distributeur (si un distributeur est sélectionné)
if ($distributor_id > 0) {
    $query .= " AND m.id_distributor = $distributor_id";
}

// ------------------ LOGIQUE DE PAGINATION ------------------

// Calculer le nombre total de films pour la pagination
$count_query = "SELECT COUNT(*) AS total_movies FROM movie m
                JOIN distributor d ON m.id_distributor = d.id
                WHERE 1=1";

// Appliquer les mêmes filtres à la requête de comptage
if (!empty($search)) {
    $count_query .= " AND m.title LIKE '%$search%'";
}
if ($genre_id > 0) {
    $count_query .= " AND m.id IN (SELECT id_movie FROM movie_genre WHERE id_genre = $genre_id)";
}
if ($distributor_id > 0) {
    $count_query .= " AND m.id_distributor = $distributor_id";
}

// Exécuter la requête de comptage des films
$count_result = mysqli_query($conn, $count_query);
$count_data = mysqli_fetch_assoc($count_result);
$total_movies = $count_data['total_movies'];

// Calculer le nombre total de pages (arrondi vers le haut)
$total_pages = ceil($total_movies / $results_per_page);

// Déterminer la limite de départ pour la pagination
$start_limit = ($page - 1) * $results_per_page;

// Ajouter la limite de pagination dans la requête principale
$query .= " LIMIT $start_limit, $results_per_page";

// ------------------ FIN LOGIQUE DE PAGINATION ------------------

// Exécuter la requête principale pour récupérer les films
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Erreur SQL : " . mysqli_error($conn));
}
