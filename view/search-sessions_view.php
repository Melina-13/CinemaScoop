<?php
include_once "../model/search-sessions_model.php";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Films en projection</title>
    <link rel="stylesheet" href="../css/style_search-sessions.css">
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
        <h1>Films en projection</h1>
        <section>
            <h2>Quels films passent ce soir ?</h2>
            <form method="post">
                <label for="search_date">Sélectionnez une date :</label>
                <input type="date" name="search_date" value="<?= htmlspecialchars($search_date); ?>" required>
                <button type="submit">Rechercher</button>
            </form>
        </section>

        <section>
            <h3>Films projetés actuellement</h3>
            <?php if (mysqli_num_rows($movies) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Film</th>
                            <th>Salle</th>
                            <th>Date de projection</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($movie = mysqli_fetch_assoc($movies)) : ?>
                            <tr>
                                <td><?= htmlspecialchars($movie['title']); ?></td>
                                <td><?= htmlspecialchars($movie['number']); ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($movie['date_begin'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucun film trouvé pour cette date.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Cinéma</p>
    </footer>
</body>
</html>
