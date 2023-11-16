<?php
@include 'configuration.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['client_id'])) {
    header('location: login.php');
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['client_id'];

// Retrieve user information from the database
$query = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);

if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}

if (mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
} else {
    die('User not found');
}

// Traitement du formulaire de transfert d'argent
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['transfer_money'])) {
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $beneficiary_id = mysqli_real_escape_string($conn, $_POST['beneficiary_id']);

    // Vérifier si le bénéficiaire existe
    $beneficiary_query = "SELECT * FROM users WHERE id = $beneficiary_id";
    $beneficiary_result = mysqli_query($conn, $beneficiary_query);

    if ($beneficiary_result && mysqli_num_rows($beneficiary_result) > 0) {
        $beneficiary_data = mysqli_fetch_assoc($beneficiary_result);

        // Vérifier si le solde du client est suffisant pour le transfert
        if ($user_data['soldeCompte'] >= $amount) {
            // Effectuer le transfert
            $new_balance_user = $user_data['soldeCompte'] - $amount;
            $new_balance_beneficiary = $beneficiary_data['soldeCompte'] + $amount;

            // Mettre à jour les soldes des comptes
            $update_user_query = "UPDATE users SET soldeCompte = $new_balance_user WHERE id = {$user_data['id']}";
            $update_beneficiary_query = "UPDATE users SET soldeCompte = $new_balance_beneficiary WHERE id = $beneficiary_id";

            $update_user_result = mysqli_query($conn, $update_user_query);
            $update_beneficiary_result = mysqli_query($conn, $update_beneficiary_query);

            if ($update_user_result && $update_beneficiary_result) {
                // Enregistrez la transaction dans la table "transactions"
                $insert_transaction_query = "INSERT INTO transactions (id_sender, id_receiver, amount, statut) VALUES ($user_id, $beneficiary_id, $amount, 'success')";
                mysqli_query($conn, $insert_transaction_query);

                $message = 'Transfert d\'argent réussi!';
            } else {
                // Enregistrez la transaction avec le statut "failure" en cas d'échec
                $insert_transaction_query = "INSERT INTO transactions (id_sender, id_receiver, amount, statut) VALUES ($user_id, $beneficiary_id, $amount, 'failure')";
                mysqli_query($conn, $insert_transaction_query);

                $message = 'Échec du transfert d\'argent.';
            }
        } else {
            $message = 'Solde insuffisant pour effectuer le transfert.';
        }
    } else {
        $message = 'Bénéficiaire non trouvé.';
    }
}
if (isset($_POST['logout'])) {
    $_SESSION = array();
    session_destroy();
    header('location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Client</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            background: url('images/clientside.jpg') center/cover no-repeat;
            color: #ecf0f1;
        }

        h1 {
            color: white;
            margin-top: 20px;
        }

        p {
            color: #ffffff;
            background-color: #34495e;
            padding: 10px;
            border-radius: 8px;
            margin: 0.5px 0;
        }

        h2 {
            color: white;
            margin-top: 30px;
        }

        form {
            width: 50%;
            margin: 20px auto;
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 20px;
            box-sizing: border-box;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333333;
        }

        input {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: #ffffff;
            cursor: pointer;
            border: none;
            padding: 12px;
            border-radius: 8px;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

table {
    width: 80%;
    margin: 20px auto;
    border-collapse: collapse;
    background-color: #ecf0f1;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
}

th, td {
    padding: 15px;
    text-align: left;
    border: 1px solid #bdc3c7;
    color:#333;
}

thead {
    background-color: #ecf0f1;
    color: #ffffff;
}

tbody {
    background-color: #ecf0f1;
}

tr:hover {
    background-color: #dfe6e9;
}


    </style>
</head>
<body>

    <h1>Bonjour Mr/Mme "<?php echo $user_data['name']; ?>"</h1>
   

    <h2>Transfert d'argent</h2>
    <form action="" method="post">
    <p>Votre solde est de: <?php echo $user_data['soldeCompte']; ?>DH</p>
    <br><br>
    <?php
    if (isset($message)) {
        echo "<p>$message</p>";
    }
    ?>
        <label>ID du bénéficiaire:</label>
        <input type="text" name="beneficiary_id" required>
        <label>Montant à transférer:</label>
        <input type="number" name="amount" required>
        <input type="submit" name="transfer_money" value="Transférer">
    </form>

    <br><br>

    <h2>Historique des opérations</h2>
    <table>
        <thead>
            <tr>
                <th>Bénéficiaire</th>
                <th>Montant</th>
                <th>Date</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <!-- Fetch and display transaction history from the "transactions" table -->
            <?php
            $transaction_history_query = "SELECT * FROM transactions WHERE id_sender = $user_id OR id_receiver = $user_id";
            $transaction_history_result = mysqli_query($conn, $transaction_history_query);

            if ($transaction_history_result && mysqli_num_rows($transaction_history_result) > 0) {
                while ($transaction_row = mysqli_fetch_assoc($transaction_history_result)) {
                    echo "<tr>";
                    echo "<td>{$transaction_row['id_receiver']}</td>";
                    echo "<td>{$transaction_row['amount']}</td>";
                    echo "<td>{$transaction_row['transaction_date']}</td>";
                    echo "<td>{$transaction_row['statut']}</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>

    <form action="" method="post" name="deco">
        <input type="submit" name="logout" value="Déconnecter">
    </form>

</body>
</html>
