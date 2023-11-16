<!-- liste_utilisateurs.php -->
<?php
@include 'configuration.php';

session_start();
if (!isset($_SESSION['banquier_id'])) {
    header('location: login.php');
    exit();
}

$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);

if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Utilisateurs</title>
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

        tr:nth-child(even) {
            background-color: #ecf0f1; /* Fond alterné pour une meilleure lisibilité */
        }

        a {
            text-decoration: none;
            padding: 5px 10px;
            margin: 0 5px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            background-color: #333; /* Changement de couleur au survol */
            color: #ffffff;
        }

        a:hover {
            background-color: #ffffffff; /* Changement de couleur au survol */
            color: #333;
        }
    </style>
</head>
<body>

    <h1>Liste des Utilisateurs</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Numéro</th>
                <th>Email</th>
                <th>Solde Compte</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['name']}</td>";
                echo "<td>{$row['phone']}</td>";
                echo "<td>{$row['email']}</td>";
                echo "<td>{$row['soldeCompte']} DH</td>";
                echo "<td>
                        <a href='editer_client.php?id={$row['id']}'>Éditer</a> 
                        <a href='supprimer_client.php?id={$row['id']}' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet utilisateur ?\")'>Supprimer</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
