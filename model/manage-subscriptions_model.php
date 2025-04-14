
<?php
include('db.php');  

// Ajouter un abonnement
if (isset($_POST['add_subscription'])) {
    $user_id = $_POST['user_id'];
    $subscription_id = $_POST['subscription_id'];
    $query = "INSERT INTO membership (id_user, id_subscription) VALUES ($user_id, $subscription_id)";
    mysqli_query($conn, $query);
}

// Supprimer un abonnement
if (isset($_POST['delete_subscription'])) {
    $membership_id = $_POST['membership_id'];
    $query = "DELETE FROM membership WHERE id = $membership_id";
    mysqli_query($conn, $query);
}

$subscriptions = mysqli_query($conn, "SELECT * FROM subscription");
$users = mysqli_query($conn, "SELECT * FROM user");
