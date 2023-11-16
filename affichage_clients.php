<?php
@include 'configuration.php';

// Vérifier si l'utilisateur est connecté en tant que banquier
session_start();
if (!isset($_SESSION['banquier_id'])) {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header('location: login.php');
    exit();
}

// Récupérer tous les utilisateurs de type client
$query = "SELECT soldeCompte, name, phone, email FROM users WHERE user_type = 'client'";
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
    <title>Liste des Clients</title>
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
            border: 1px solid #dddddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: #ffffff;
        }

        .bon-client {
            background-color: #2ecc71;
            color: #ffffff;
        }

        .normal-client {
            background-color: #FFD700;
            color: #ffffff;
        }

        .mauvais-client {
            background-color: #e74c3c;
            color: #ffffff;
        }
    </style>
</head>
<body>

    <h1>Liste des Clients</h1>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Numéro</th>
                <th>Email</th>
                <th>Solde du Compte</th>
                <th>État du Client</th>
                
            </tr>
        </thead>
        <tbody>
            <?php
            // Afficher les données dans le tableau
            while ($row = mysqli_fetch_assoc($result)) {
                // Déterminer l'état du client en fonction du solde du compte
                if ($row['soldeCompte'] > 20000) {
                    $etatClientClass = 'bon-client';
                    $etatClientText = 'Bon Client';
                } elseif ($row['soldeCompte'] > 3000) {
                    $etatClientClass = 'normal-client';
                    $etatClientText = 'Normal Client';
                } else {
                    $etatClientClass = 'mauvais-client';
                    $etatClientText = 'Mauvais Client';
                }

                echo "<tr>";
                echo "<td>{$row['name']}</td>";
                echo "<td>{$row['phone']}</td>";
                echo "<td>{$row['email']}</td>";
                echo "<td>{$row['soldeCompte']} DH</td>";
                echo "<td class='$etatClientClass'>$etatClientText</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
