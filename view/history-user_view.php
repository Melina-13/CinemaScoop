<?php
include_once "../model/history_model.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique des films vus</title>
    <link rel="stylesheet" href="../css/style_history.css">
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
    
        <form method="get">
             <h2>Choisir un abonné</h2>
            <label for="user_id">Sélectionner un abonné :</label>
            <select name="user_id" required>
                <option value="">-- Sélectionnez un utilisateur --</option>
                <?php while ($user = mysqli_fetch_assoc($users)) : ?>
                    <option value="<?= $user['id']; ?>" <?= ($user_id == $user['id']) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($user['firstname'] . " " . $user['lastname']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <button type="submit">Voir l'historique</button>
        </form>

        <?php if ($user_id > 0) : ?>
            <h2>Historique des films vus</h2>
            <?php if (mysqli_num_rows($history) > 0) : ?>
                <ul>
                    <?php while ($row = mysqli_fetch_assoc($history)) : ?>
                        <li><?= htmlspecialchars($row['title']); ?> - Vu le <?= date('d/m/Y H:i', strtotime($row['date_begin'])); ?></li>
                    <?php endwhile; ?>
                </ul>
            <?php else : ?>
                <p>Aucun film vu pour cet utilisateur.</p>
            <?php endif; ?>

            <h2>Ajouter un film vu</h2>
            <form method="post">
                <input type="hidden" name="user_id" value="<?= $user_id; ?>">
                
                <label for="movie_title">Titre du film :</label>
                <input type="text" name="movie_title" required placeholder="Ex: Inception">

                <label for="date_time">Date et heure :</label>
                <input type="datetime-local" name="date_time" required>

                <button type="submit" name="add_history">Ajouter</button>
            </form>

            <p><?= $message; ?></p>
        <?php endif; ?>
    </main>
</body>
</html>
