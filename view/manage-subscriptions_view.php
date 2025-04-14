<?php
include_once "../model/manage-subscriptions_model.php";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des abonnements</title>
    <link rel="stylesheet" href="../css/style_subscriptions.css">
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
        <h1>Gestion des abonnements</h1>
        
        <form method="post" action="manage_subscriptions.php">
            <h2>Ajouter un abonnement</h2>
            <label for="user_id">Choisir un membre :</label>
            <select name="user_id">
                <?php while ($user = mysqli_fetch_assoc($users)) : ?>
                    <option value="<?= $user['id']; ?>"><?= $user['firstname']; ?> <?= $user['lastname']; ?></option>
                <?php endwhile; ?>
            </select>

            <label for="subscription_id">Choisir un abonnement :</label>
            <select name="subscription_id">
                <?php while ($subscription = mysqli_fetch_assoc($subscriptions)) : ?>
                    <option value="<?= $subscription['id']; ?>"><?= $subscription['name']; ?> - <?= $subscription['price']; ?> €</option>
                <?php endwhile; ?>
            </select>

            <button type="submit" name="add_subscription">Ajouter</button>
        </form>

        
        <form method="post" action="manage_subscriptions.php">
        <h2>Supprimer un abonnement</h2>
            <label for="membership_id">Choisir un abonnement à supprimer :</label>
            <select name="membership_id">
                <?php
                $memberships = mysqli_query($conn, "SELECT * FROM membership");
                while ($membership = mysqli_fetch_assoc($memberships)) :
                    echo "<option value='{$membership['id']}'>Abonnement de l'utilisateur {$membership['id_user']}</option>";
                endwhile;
                ?>
            </select>
            <button type="submit" name="delete_subscription">Supprimer</button>
        </form>
    </main>
</body>
</html>
