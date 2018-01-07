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
    $statement = $mysqli->prepare($query);
    if($statement===false){
      echo 'prepare() failed '. $mysqli->error;
    }
    // parameter an query binden
    if(!$statement->bind_param("i", $requestID)){
      echo 'bind_param() failed '. $mysqli->error;
    }
    // query ausführen
    if(!$statement->execute()){
      echo 'execute() failed '. $mysqli->error;
    }

    if($result->num_rows){
      /*
        Updated den Request
      */
      $sql = "UPDATE requests SET accepted = true, date = ? where id = ?";
      $statement = $mysqli->prepare($sql);
      $statement->bind_param('si', date("Y-m-d"), $requestID);
      $statement->execute();

      /*
        Fügt den Key ein
      */
      $sql = "INSERT INTO betakeys (betakey, stateID) VALUES (?, 1)";
      $statement = $mysqli->prepare($sql);
      $key = generateRandomString();
      $statement->bind_param('s', $key);
      $statement->execute();

    } else {

    }
  } else {
    echo "Keine Berechtigung!";
  }

  /*
    Erstellt einen Key
  */
  function generateRandomString($length = 15) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }
 ?>
