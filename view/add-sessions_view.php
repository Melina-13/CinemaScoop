<?php
include_once "../model/add-sessions_model.php";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des séances</title>
    <link rel="stylesheet" href="../css/style_add-sessions.css">
</head>
<body>
    <header>
        <div class="menue">
            <h1 class="name-site">CinemaScoop</h1>
            <nav>
                <ul>
                    <li><a href="home_view.php">Accueil</a></li>
                    <li><a href="search-movies_view.php">Rechercher un film</a></li>
                    <li><a href="manage-subscriptions_view.php">Abonnements</a></li>
                    <li><a href="history-user_view.php">Historique</a></li>
                    <li><a href="add-sessions_view.php">Séances</a></li>
                    <li><a href="search-sessions_view.php">Rechercher séances</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <h1>Ajouter une séance</h1>
        <form method="post">
            <label for="movie_id">Sélectionnez un film :</label>
            <select name="movie_id">
                <?php while ($movie = mysqli_fetch_assoc($movies)) : ?>
                    <option value="<?= $movie['id']; ?>"><?= htmlspecialchars($movie['title']); ?></option>
                <?php endwhile; ?>
            </select>

            <label for="room_id">Sélectionnez une salle :</label>
            <select name="room_id">
                <?php while ($room = mysqli_fetch_assoc($rooms)) : ?>
                    <option value="<?= $room['id']; ?>">Salle <?= htmlspecialchars($room['number']); ?></option>
                <?php endwhile; ?>
            </select>

            <label for="date_begin">Date et heure de la séance :</label>
            <input type="datetime-local" name="date_begin" required>

            <button type="submit" name="add_session">Ajouter la séance</button>
        </form>
    </main>
</body>
</html>
