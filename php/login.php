<?php

session_start();

// BENUTZERNAME vorhanden, mindestens 6 Zeichen und maximal 30 zeichen lang
if(isset($_POST['login_username']) && !empty(trim($_POST['login_username'])) && strlen(trim($_POST['login_username']) <= 30)){
  $login_username = trim($_POST['login_username']);
} else {
  $_SESSION['errMsg'] .= "Geben Sie bitte einen korrekten Benutzernamen ein.<br />";
}

// passwort vorhanden, mindestens 8 Zeichen
if(isset($_POST['login_password']) && !empty(trim($_POST['login_password']))){
  $login_password = trim($_POST['login_password']);
} else {
  $_SESSION['errMsg'] .= "Geben Sie bitte ein Passwort ein. <br />";
}

if ($_SESSION['errMsg'] == '') {
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

  // select statement erstellen
  $query = "SELECT * from users where username = ?";
  // query vorbereiten
  $stmt = $mysqli->prepare($query);
  if($stmt===false){
    echo 'prepare() failed '. $mysqli->error;
  }
  // parameter an query binden
  if(!$stmt->bind_param("s", $login_username)){
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
    if(password_verify($login_password, $user['password'])){
      $_SESSION['loggedin'] = true;
      $_SESSION['username'] = $login_username;
      $_SESSION['userID'] = $user['id'];
      $_SESSION['permissionLevel'] = $user['permissionLevel'];
      $login_username = $login_password = '';
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
} else {
  $_SESSION['type'] = "login";
  header('Location: ../pages/index.php');
}
 ?>
