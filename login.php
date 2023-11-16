<?php

@include 'configuration.php';

session_start();

if(isset($_POST['submit'])){

   $filter_username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
   $username = mysqli_real_escape_string($conn, $filter_username);
   $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
   $pass = mysqli_real_escape_string($conn, md5($filter_pass));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE name = '$username' AND password = '$pass'") or die('query failed');


   if(mysqli_num_rows($select_users) > 0){
      
      $row = mysqli_fetch_assoc($select_users);

      if($row['user_type'] == 'banquier'){

         $_SESSION['banquier_name'] = $row['name'];
         $_SESSION['banquier_email'] = $row['email'];
         $_SESSION['banquier_id'] = $row['id'];
         header('location:banquier.php');

      }elseif($row['user_type'] == 'client'){

         $_SESSION['client_name'] = $row['name'];
         $_SESSION['client_email'] = $row['email'];
         $_SESSION['client_id'] = $row['id'];
         header('location:client.php');

      }else{
         $message[] = 'no user found!';
      }

   }else{
      $message[] = 'incorrect username or password!';
   }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>
   <link rel="icon" href="images/logoo.png">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">
   <script>
function showPassword() {
  var x = document.getElementsByName("pass")[0];
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
<style>
   body {
    margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif;
    background: url('images/log1.jpg') no-repeat center center fixed;
    background-size: cover;
}

.form-container {
    width: 500px;
    margin: 100px auto;
    background: rgba(255, 255, 255, 0.8);
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
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

.show-password {
    text-align: left;
    margin: 10px 0;
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
   <h1 class="heading"><span>Login</span> Now</h1></br></br>
   <input type="text" name="username" class="box" placeholder="entrer votre nom" required>
   <input type="password" name="pass" class="box" placeholder="entrer votre mot de pass" required></br></br></br>
   <div class="show-password">
   <input type="checkbox" onclick="showPassword()">Voire le mot de pass
   
</div>

   <input type="submit" class="btn" name="submit" value="Login now">
  
   <p>Vous n'avez pas de compte ? <a href="registre.php"> S'inscrire maintenant</a></p>

</form>

</section>


</body>
</html>