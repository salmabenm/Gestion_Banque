<!-- traitement_edition.php -->
<?php
@include 'configuration.php';

session_start();
if (!isset($_SESSION['banquier_id'])) {
    header('location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Mettre à jour les informations de l'utilisateur
    $query = "UPDATE users SET name = '$name', phone = '$phone', email = '$email' WHERE id = $user_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header('location: maj_suppression_client.php');
        exit();
    } else {
        die('Update query failed: ' . mysqli_error($conn));
    }
} else {
    header('location: erreur.php');
    exit();
}
?>
