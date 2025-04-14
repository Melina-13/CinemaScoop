<?php
include_once "db.php";

// Ajouter une séance
if (isset($_POST['add_session'])) {
    // Récupérer les données formulaire
    $movie_id = $_POST['movie_id'];
    $room_id = $_POST['room_id'];
    $date_begin = $_POST['date_begin'];

    // Vérification basique si les champs valides
    if (is_numeric($movie_id) && is_numeric($room_id)) {  // is_numeric= return true si nbr numerique (int ou float)
        $query = "INSERT INTO movie_schedule (id_movie, id_room, date_begin) VALUES ($movie_id, $room_id, '$date_begin')";

        if (!mysqli_query($conn, $query)) {
            die("Erreur SQL : " . mysqli_error($conn));
        } else {
            echo "Séance ajoutée avec succès !";
        }
    } else {
        echo "Les identifiants de film ou de salle ne sont pas valides.";
    }
}

// Récupérer les films et salles
$movies = mysqli_query($conn, "SELECT * FROM movie");
$rooms = mysqli_query($conn, "SELECT * FROM room");
?>