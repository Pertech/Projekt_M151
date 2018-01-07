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

$oldPassword = htmlspecialchars($_POST['oldPassword']);
$newPassword1 = htmlspecialchars($_POST['newPassword1']);
$newPassword2 = htmlspecialchars($_POST['newPassword2']);

if($newPassword1 == $newPassword2){

  // select statement erstellen
  $query = "SELECT username, password from users where id = ?";
  // query vorbereiten
  $stmt = $mysqli->prepare($query);
  if($stmt===false){
    echo 'prepare() failed '. $mysqli->error;
  }
  // parameter an query binden
  if(!$stmt->bind_param("i", $_SESSION['userID'])){
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
    if(password_verify($oldPassword, $user['password'])){

      $password = password_hash($newPassword1, PASSWORD_DEFAULT);
      $sql = "UPDATE users SET password = ? where id = ?";
      $statement = $mysqli->prepare($sql);
      $statement->bind_param('si', $password, $_SESSION['userID']);
      $statement->execute();
    }
  } else {
    /*$_SESSION['type'] = "login";
    $_SESSION['errMsg'] = "Benutzername oder Passwort sind falsch";
    header('Location: ../pages/index.php');*/
  }
}
?>
