<?php
@include 'configuration.php';

if (isset($_GET['id'])) {
    $user_id = mysqli_real_escape_string($conn, $_GET['id']);

    $deleteQuery = "DELETE FROM users WHERE id = $user_id";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if (!$deleteResult) {
        die('Delete query failed: ' . mysqli_error($conn));
    }
} else {
    die('ID not provided');
}

// Récupérer tous les utilisateurs
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
    <!-- Ajoutez les liens vers les fichiers CSS et JavaScript de Bootstrap ici -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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

    <div class="container">
        <h1>Liste des Utilisateurs</h1>

        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Numéro</th>
                    <th>Email</th>
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
                    echo "<td class='action-links'>
                            <a href='edit_user.php?id={$row['id']}' class='btn btn-primary'>Éditer</a> 
                            <button class='btn btn-danger' onclick='deleteUser({$row['id']})'>Supprimer</button>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>
