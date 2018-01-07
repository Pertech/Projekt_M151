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

    $requestID = htmlspecialchars($_POST['requestID']);


    // select statement erstellen
    $query = "SELECT * from requests where id = ?";
    // query vorbereiten
    $stmt = $mysqli->prepare($query);
    if($stmt===false){
      echo 'prepare() failed '. $mysqli->error;
    }
    // parameter an query binden
    if(!$stmt->bind_param("i", $requestID)){
      echo 'bind_param() failed '. $mysqli->error;
    }
    // query ausführen
    if(!$stmt->execute()){
      echo 'execute() failed '. $mysqli->error;
    }

    $result = $stmt->get_result();
    
    if($result->num_rows){
      /*
        Updated den Request
      */
      $sql = "UPDATE requests SET accepted = false, date = ? where id = ?";
      $statement = $mysqli->prepare($sql);
      $statement->bind_param('si', date("Y-m-d"), $requestID);
      $statement->execute();

    } else {
    }
  } else {
    echo "Keine Berechtigung!";
  }
 ?>
