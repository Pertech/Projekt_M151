<?php

session_start();

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

$key = htmlspecialchars($_POST['betakey']);



  // select statement erstellen
  $query = "SELECT * from betakeys where betakey = ? and stateID = 1";
  // query vorbereiten
  $stmt = $mysqli->prepare($query);
  if($stmt===false){
    echo 'prepare() failed '. $mysqli->error;
  }
  // parameter an query binden
  if(!$stmt->bind_param("s", $key)){
    echo 'bind_param() failed '. $mysqli->error;
  }
  // query ausführen
  if(!$stmt->execute()){
    echo 'execute() failed '. $mysqli->error;
  }

  if($result->num_rows){

    $sql = "UPDATE betakeys SET stateID = 2, userID = ? WHERE betakey = ? AND stateID = 1";
    $statement = $mysqli->prepare($sql);
    $statement->bind_param('is', $_SESSION['userID'], $key);
    $statement->execute();

    $sql = "UPDATE users SET hasGame = true WHERE id = ?";
    $statement = $mysqli->prepare($sql);
    $statement->bind_param('i', $_SESSION['userID']);
    $statement->execute();

    $_SESSION['errMsg'] = "Erfolgreich aktiviert.";
    header('Location: ../pages/useKey.php');

  } else {
    $_SESSION['errMsg'] = "Der Key ist nicht gültig.";
    header('Location: ../pages/useKey.php');
  }
 ?>
