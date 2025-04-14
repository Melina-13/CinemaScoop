<?php
include_once "../model/search-movies_model.php";
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche de films</title>
    <link rel="stylesheet" href="../css/style_search-movies.css">
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
        <form method="post">
            <h1>Rechercher un film</h1>
            <label for="search">Nom du film :</label>
            <input type="text" name="search" placeholder="Rechercher un film..." value="<?= htmlspecialchars($search); ?>">

            <label for="genre">Genre :</label>
            <select name="genre">
                <option value="0">-- Tous les genres --</option>
                <?php while ($genre = mysqli_fetch_assoc($genres)) : ?>
                    <option value="<?= $genre['id']; ?>" <?= ($genre_id == $genre['id']) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($genre['name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="distributor">Distributeur :</label>
            <select name="distributor">
                <option value="0">-- Tous les distributeurs --</option>
                <?php while ($distributor = mysqli_fetch_assoc($distributors)) : ?> <!-- endwhile = termine la boucle-->
                    <option value="<?= $distributor['id']; ?>" <?= ($distributor_id == $distributor['id']) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($distributor['name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <button type="submit">Rechercher</button>
        </form>

        <?php if (mysqli_num_rows($result) > 0) : ?>  <!-- mysqli_num_rows= obtenir le nombre de lignes retournées par une requête SELECT-->
            <h2>Résultats</h2>
            <ul class="movie-list">
                <?php while ($movie = mysqli_fetch_assoc($result)) : ?>
                    <li class="movie-item">
                        <strong><?= htmlspecialchars($movie['title']); ?></strong> 
                        - Distributeur : <?= htmlspecialchars($movie['distributor_name']); ?> 
                        - Genres : 
                        <?php
                        // Récupérer les genres du film
                        $movie_id = $movie['id'];
                        $genre_query = "SELECT g.name FROM genre g 
                                        JOIN movie_genre mg ON g.id = mg.id_genre 
                                        WHERE mg.id_movie = $movie_id";
                        $genre_result = mysqli_query($conn, $genre_query);
                        $genres_list = [];
                        while ($genre_row = mysqli_fetch_assoc($genre_result)) {
                            $genres_list[] = htmlspecialchars($genre_row['name']);
                        }
                        echo implode(", ", $genres_list);
                        ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else : ?>
            <p>Aucun film trouvé.</p>
        <?php endif; ?>

        <!-- Pagination -->
        <div class="pagination">
            <?php if ($page > 1) : ?>
                <a href="?page=1"><<</a>
                <a href="?page=<?= $page - 1; ?>">Précédent</a>
            <?php endif; ?>

            <?php 
            // affiche 5 pages max avant et après la page actuelle
            $start_page = max(1, $page - 2); // départ
            $end_page = min($total_pages, $page + 2); // fin

            for ($i = $start_page; $i <= $end_page; $i++) :
                ?>
                <a href="?page=<?= $i; ?>" class="<?= ($i == $page) ? 'active' : ''; ?>"><?= $i; ?></a>
            <?php endfor; ?>

            <?php if ($page < $total_pages) : ?>
                <a href="?page=<?= $page + 1; ?>">Suivant</a>
                <a href="?page=<?= $total_pages; ?>">>></a>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
