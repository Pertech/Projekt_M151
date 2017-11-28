<?php


//do müsse mr no luege wie das isch mit de anmeldedate für d DB
$host = 'localhost'; // Host
$username = 'root'; // Username
$password = ''; // Passwort
$database = 'beta'; // Datenbank

// mit Datenbank verbinden
$mysqli = new mysqli($host, $username, $password, $database);

// Fehlermeldung, falls Verbindung fehl schlägt
if ($mysqli->connect_error) {
  die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
}

$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);



  // select statement erstellen
  $query = "SELECT username, password from users where username = ?";
  // query vorbereiten
  $stmt = $mysqli->prepare($query);
  if($stmt===false){
    echo 'prepare() failed '. $mysqli->error;
  }
  // parameter an query binden
  if(!$stmt->bind_param("s", $username)){
    echo 'bind_param() failed '. $mysqli->error;
  }
  // query ausführen
  if(!$stmt->execute()){
    echo 'execute() failed '. $mysqli->error;
  }
  // daten auslesen
  $result = $stmt->get_result();
  // benutzer vorhanden?
  if($result->num_rows){
    // userdaten lesen
    $user = $result->fetch_assoc();
    // passwort prüfen
    if(password_verify($password, $user['password'])){
      echo "Sie sind nun eingeloggt";
      session_start();
      $_SESSION['loggedin'] = true;
      $_SESSION['username'] = $username;
      $username = $password = '';
      //header('Location: index.php');
      //Session starten und weiterleiten auf Adminbereich.
      // benutzername oder passwort stimmen nicht,
    } else {
      echo "Benutzername oder Passwort sind falsch<br />";
    }
  } else {
    echo "Benutzername oder Passwort sind falsch.<br />";
  }
 ?>
<html>
  <head>
    <title>Anmeldung</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
  </head>
  <body>
    <h1>Anmeldung</h1>
      <form action="#" method="post">
        <div class="form-group">
          <label for="username">Benutzername:</label>
          <input type="text" name="username" class="form-control" id="username">
        </div>
        <div class="form-group">
          <label for="password">Passwort:</label>
          <input type="password" name="password" class="form-control" id="password">
        </div>
        <input type="submit" name="submit" value="Anmelden">
      </form>
  </body>
</html>
