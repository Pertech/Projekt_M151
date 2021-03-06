<?php

session_start();
  /*
    Überprüft die Berechtigungen
  */
  if($_SESSION['permissionLevel'] >= 50){

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

    $sql = "SELECT r.id, u.username FROM requests as r LEFT JOIN users as u on u.id = r.userID WHERE accepted IS NULL";
    $statement = $mysqli->prepare($sql);
    $statement->execute();
    $result = $statement->get_result();
    while($row = $result->fetch_assoc()) {
        $myArray[] = $row;
    }
    echo json_encode($myArray);
  } else {
    echo "Keine Berechtigung!";
  }

?>
