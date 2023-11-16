<!-- editer_client.php -->
<?php
@include 'configuration.php';

session_start();
if (!isset($_SESSION['banquier_id'])) {
    header('location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Récupérer les données de l'utilisateur à éditer
    $query = "SELECT * FROM users WHERE id = $user_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
    } else {
        die('User not found');
    }
} else {
    die('User ID not provided');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éditer Utilisateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            background: url('images/client.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        h1 {
            text-align: center;
            color: #333;
            margin: 20px 0;
        }

        form {
            width: 60%;
            margin: 20px auto;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 50px;
            box-sizing: border-box;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333333;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #ffffff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <h1>Éditer Utilisateur</h1>

    <form action="traitement_edition.php" method="post">
        <input type="hidden" name="user_id" value="<?php echo $user_data['id']; ?>">
        <label>Nom:</label>
        <input type="text" name="name" value="<?php echo $user_data['name']; ?>" required><br>
        <label>Numéro:</label>
        <input type="text" name="phone" value="<?php echo $user_data['phone']; ?>" required><br>
        <label>Email:</label>
        <input type="text" name="email" value="<?php echo $user_data['email']; ?>" required><br>
        <input type="submit" name="update_user" value="Mettre à jour">
    </form>

</body>
</html>
