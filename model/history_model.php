<?php
include_once "db.php";;

// Initialisation des variables
$user_id = isset($_GET['user_id']) ? (int) $_GET['user_id'] : 0; //force user_id en int , si user_id pas present sur url on met 0 par defaut
$message = "";

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_history'])) {
    $movie_title = trim($_POST['movie_title'] ?? '');  // trim=supp espace
    $date_time = $_POST['date_time'] ?? '';

    if (empty($movie_title) || empty($date_time)) {
        $message = "❌ Veuillez remplir tous les champs.";
    } else {
        // Vérification de l'abonnement
        $query = "SELECT id FROM membership WHERE id_user = $user_id LIMIT 1";
        $result = mysqli_query($conn, $query);
        
        if ($membership = mysqli_fetch_assoc($result)) {  // recup ligne de $result forme de tableau 
            $membership_id = $membership['id'];
            
            // Vérification du film
            $query = "SELECT id FROM movie WHERE title = '$movie_title' LIMIT 1";
            $result = mysqli_query($conn, $query);
            
            if ($movie = mysqli_fetch_assoc($result)) {
                $movie_id = $movie['id'];
                
                // Vérification de la séance
                $query = "SELECT id FROM movie_schedule WHERE id_movie = $movie_id AND date_begin = '$date_time' LIMIT 1";
                $result = mysqli_query($conn, $query);
                
                if ($session = mysqli_fetch_assoc($result)) {
                    $session_id = $session['id'];
                } else {
                    // Ajout d'une nouvelle séance
                    $query = "INSERT INTO movie_schedule (id_movie, id_room, date_begin) VALUES ($movie_id, 1, '$date_time')";
                    mysqli_query($conn, $query);
                    $session_id = mysqli_insert_id($conn);
                }
                
                // Ajout à l'historique
                $query = "INSERT INTO membership_log (id_membership, id_session) VALUES ($membership_id, $session_id)";
                if (mysqli_query($conn, $query)) {
                    $message = "🎉 Film ajouté à l'historique !";
                } else {
                    $message = "❌ Erreur lors de l'ajout.";
                }
            } else {
                $message = "❌ Film non trouvé.";
            }
        } else {
            $message = "❌ Pas d'abonnement actif.";
        }
    }
}

// Récupération des utilisateurs
$users = mysqli_query($conn, "SELECT id, firstname, lastname FROM user"); //mysqli_query = connection+requete

// Récupération de l'historique
$history = [];
if ($user_id > 0) {
    $query = "SELECT m.title, ms.date_begin FROM membership_log ml
              JOIN movie_schedule ms ON ml.id_session = ms.id
              JOIN movie m ON ms.id_movie = m.id
              JOIN membership mb ON ml.id_membership = mb.id
              WHERE mb.id_user = $user_id ORDER BY ms.date_begin DESC";
    $history = mysqli_query($conn, $query);
}
?>

