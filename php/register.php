<?php
  session_start();
  if (isset($_POST['signup_firstname']) && isset($_POST['signup_lastname']) && isset($_POST['signup_username']) && isset($_POST['signup_email']) && isset($_POST['signup_password']) && isset($_POST['signup_password2'])) {
    $mysqli = new mysqli("localhost", "root", "", "");
    if ($mysqli->connect_errno) {
        die("Verbindung fehlgeschlagen: " . $mysqli->connect_error);
    }

    $username = $_POST['signup_username'];
    $firstname = $_POST['signup_firstname'];
    $lastname = $_POST['signup_lastname'];
    $email = $_POST['signup_email'];
    if($_POST['signup_password'] == $_POST['signup_password2']){
      $password = password_hash($_POST['signup_password'], PASSWORD_DEFAULT);

      $sql = "SELECT * FROM users WHERE username = ? or email = ?";
      $statement = $mysqli->prepare($sql);
      $statement->bind_param('ss', $username, $email);
      $statement->execute();

      $result = $statement->get_result();


      if($result->num_rows == 0){
        $sql = "INSERT INTO users (firstname,lastname,username,password,email) VALUES ('$firstname', '$lastname', '$username', '$password', '$email')";
        $mysqli->query($sql);
      }
    }else{
      $_SESSION['type'] = 'signup';
      $_SESSION['errMsg'] = 'Eingegebene Passwörter stimmen nicht überein!';
      header('Location: ../pages/index.php');
    }
  }
 ?>
