<?php
@include 'configuration.php';

// Vérifier si l'utilisateur est connecté en tant que banquier
session_start();
if (!isset($_SESSION['banquier_id'])) {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header('location: login.php');
    exit();
}

// Récupérer seulement les bons clients (soldeCompte > 20000)
$query = "SELECT soldeCompte, name, phone, email FROM users WHERE user_type = 'client' AND soldeCompte > 20000";
$result = mysqli_query($conn, $query);

// Vérifier si la requête a réussi
if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Bons Clients</title>
        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            text-align: center;
            color: #333;
            margin: 20px 0;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            border: 1px solid #bdc3c7; /* Gris clair */
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #3498db; /* Bleu roi */
            color: #ffffff;
        }

        td {
            color: #333333;
        }
        </style>
</head>
<body>

    <h1>Liste des Bons Clients</h1>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Numéro</th>
                <th>Email</th>
                <th>Solde du Compte</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Afficher les données dans le tableau
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['name']}</td>";
                echo "<td>{$row['phone']}</td>";
                echo "<td>{$row['email']}</td>";
                echo "<td>{$row['soldeCompte']} DH</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
