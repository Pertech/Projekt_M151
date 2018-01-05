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

$key = htmlspecialchars($_POST['key']);



  // select statement erstellen
  $query = "SELECT * from betakeys where key = ? and stateID = ?";
  // query vorbereiten
  $stmt = $mysqli->prepare($query);
  if($stmt===false){
    echo 'prepare() failed '. $mysqli->error;
  }
  // parameter an query binden
  if(!$stmt->bind_param("si", $key, 1)){
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

    $sql = "UPDATE betakeys SET stateID = ?, userID = ? WHERE key = ? AND stateID = ?";
    $statement = $mysqli->prepare($sql);
    $statement->bind_param('iisi', 2, $_SESSION['userID'], $key, 1);
    $statement->execute();

    $sql = "UPDATE users SET hasGame = true WHERE id = ?";
    $statement = $mysqli->prepare($sql);
    $statement->bind_param('i', $_SESSION['userID']);
    $statement->execute();

  } else {

  }
 ?>
