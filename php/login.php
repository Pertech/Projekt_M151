<?php

session_start();

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

$username = htmlspecialchars($_POST['login_username']);
$password = htmlspecialchars($_POST['login_password']);



  // select statement erstellen
  $query = "SELECT * from users where username = ?";
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
      $_SESSION['loggedin'] = true;
      $_SESSION['username'] = $username;
      $_SESSION['userID'] = $user['id'];
      $_SESSION['permissionLevel'] = $user['permissionLevel'];
      $username = $password = '';
      header('Location: ../pages/user_home.php');
      //Session starten und weiterleiten auf Adminbereich.
      // benutzername oder passwort stimmen nicht,
    } else {
      $_SESSION['type'] = "login";
      $_SESSION['errMsg'] = "Benutzername oder Passwort sind falsch";
      header('Location: ../pages/index.php');
    }
  } else {
    $_SESSION['type'] = "login";
    $_SESSION['errMsg'] = "Benutzername oder Passwort sind falsch";
    header('Location: ../pages/index.php');
  }
 ?>
