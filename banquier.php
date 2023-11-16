
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banquier</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
            background: url('images/banque.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .content {
            text-align: center;
            max-width: 600px; /* Limite la largeur du contenu pour une meilleure lisibilité */
            width: 100%;
            padding: 20px;
           
        }

        h1 {
            color: white; 
            font-size: 36px;
            margin-bottom: 20px;
        }

        .buttons-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around; /* Espace équitablement les boutons */
        }

        a {
            display: block;
            margin: 10px;
            font-size: 18px;
            text-decoration: none;
            background-color: #333;
            color: white;
            padding: 15px; /* Augmentation du rembourrage pour une apparence plus grande */
            border-radius: 5px;
            width: 45%; /* Même largeur pour tous les boutons */
            box-sizing: border-box; /* Prend en compte le padding dans la largeur */
            transition: background-color 0.3s ease;
        }

        a:hover {
            color: #333;
            background-color: white;
        }

        form {
            margin-top: 20px;
        }

        input[type="submit"] {
            background-color: #e74c3c; /* Couleur rouge pour le bouton de déconnexion */
            color: #ffffff;
            padding: 15px;
            border: none;
            border-radius: 5px;
            width: 100%; /* Utilise la pleine largeur du parent */
            box-sizing: border-box;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="content">
    <?php
        session_start();

        if (isset($_SESSION['banquier_name'])) {
            $banquierName = $_SESSION['banquier_name'];
            echo '<h1>Bonjour Mr "' . $banquierName . '"</h1>';
        } else {
            header('location: login.php');
            exit();
        }
        if (isset($_POST['logout'])) {
           
            $_SESSION = array();
        
            // Destroy the session
            session_destroy();
        
            // Redirect to the login page
            header('location: login.php');
            exit();
        }
        ?>


    <div class="buttons-container">
        <a href="affichage_clients.php">Afficher tous les clients</a>
        <a href="affichage_bon_clients.php">Afficher tous les bons clients</a>
    </div>
    <div class="buttons-container">
        <a href="ajouter_client.php">Ajouter un client</a>
        <a href="maj_suppression_client.php">MAJ ou suppression d'un client</a>
    </div>
        <form action="" method="post">
            <input type="submit" name="logout" value="Déconnecter">
        </form>
    </div>
   
</body>
</html>
