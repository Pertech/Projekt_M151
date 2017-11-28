<?php
  if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
    $mysqli = new mysqli("localhost", "root", "", "beta");
    if ($mysqli->connect_errno) {
        die("Verbindung fehlgeschlagen: " . $mysqli->connect_error);
    }

    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "SELECT * FROM users WHERE username = ? or email = ?";
    $statement = $mysqli->prepare($sql);
    $statement->bind_param('ss', $username, $email);
    $statement->execute();

    $result = $statement->get_result();


    if($result->num_rows == 0){
      $sql = "INSERT INTO users (firstname,lastname,username,password,email) VALUES ('$firstname', '$lastname', '$username', '$password', '$email')";
      $mysqli->query($sql);
    }
  }
 ?>
<html>
  <head>
    <title>Regsitrierung</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
  </head>
  <body>
    <h1>Registrierung</h1>
      <form action="#" method="post">
        <div class="form-group">
          <label for="firstname">Vorname:</label>
          <input type="text" name="firstname" class="form-control" id="firstname">
        </div>
        <div class="form-group">
          <label for="lastname">Nachname:</label>
          <input type="text" name="lastname" class="form-control" id="lastname">
        </div>
        <div class="form-group">
          <label for="username">Benutzername:</label>
          <input type="text" name="username" class="form-control" id="username">
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" name="email" class="form-control" id="email">
        </div>
        <div class="form-group">
          <label for="password">Passwort:</label>
          <input type="password" name="password" class="form-control" id="password">
        </div>
        <input type="submit" name="submit" value="Registrieren">
      </form>
  </body>
</html>
