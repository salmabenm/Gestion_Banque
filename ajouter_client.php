<?php

@include 'configuration.php';

if(isset($_POST['submit'])){

   $filter_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $name = mysqli_real_escape_string($conn, $filter_name);
   $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   $email = mysqli_real_escape_string($conn, $filter_email);
   $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
   $pass = mysqli_real_escape_string($conn, md5($filter_pass));
   $filter_cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);
   $cpass = mysqli_real_escape_string($conn, md5($filter_cpass));
   $filter_soldeCompte = filter_var($_POST['soldeCompte'], FILTER_SANITIZE_STRING);
   $soldeCompte = mysqli_real_escape_string($conn, $filter_soldeCompte);
   $filter_phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
   $phone = mysqli_real_escape_string($conn, $filter_phone);

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'User already exists!';
   }else{
      if($pass != $cpass){
         $message[] = 'Confirm password does not match!';
      }elseif(!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[a-zA-Z0-9]).{4,8}$/', $_POST['pass'])){
         $message[] = 'Password must be between 4 and 8 characters, containing at least one uppercase letter, one digit, and one special character.';
      }elseif(strlen($_POST['phone']) !== 10){
         $message[] = 'Phone number must be exactly 10 digits.';
      }else{
         mysqli_query($conn, "INSERT INTO `users`(name, email, password,soldeCompte,phone) VALUES('$name', '$email', '$pass','$soldeCompte','$phone')") or die('query failed');
         $message[] = 'Registered successfully!';
         header('location:banquier.php');
      }
   }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Registre</title>
   <link rel="icon" href="images/logoo.png">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">
   <style>
   body {
    margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif;
    background: url('images/log1.jpg') no-repeat center center fixed;
    background-size: cover;
   }

.form-container {
    width: 600px;
    margin: 50px auto;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.heading {
    color: #333;
}

.box {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.btn {
    background: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.btn:hover {
    background: #45a049;
}

.message {
    background: #f2dede;
    color: #a94442;
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
    position: relative;
}

.message i {
    position: absolute;
    top: 5px;
    right: 10px;
    cursor: pointer;
    color: #a94442;
}

a {
    color: #4CAF50;
}

</style>
</head>
<body>
<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   

<section class="form-container">

   <form action="" method="post">
      <h1 class="heading"><span>Ajouter</span> Client</h1>
      <input type="text" name="name" class="box" placeholder="entrer le nom du client" required>
      <input type="email" name="email" class="box" placeholder="enter l'email de client" required>
      <input type="number" name="phone" class="box" placeholder="entrer le numéro du client" required>
      <input type="number" name="soldeCompte" class="box" placeholder="enter le solde de client" required>
      <input type="password" name="pass" class="box" placeholder="entrer le mot de pass" required>
      <input type="password" name="cpass" class="box" placeholder="confirmer le mot de pass" required>
      <input type="submit" class="btn" name="submit" value="register now">
      <p>Déja un compte ?<a href="login.php">Login now</a></p>
   </form>

</section>
</body>
</html>