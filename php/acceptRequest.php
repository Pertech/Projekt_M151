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
  // daten auslesen
  $result = $stmt->get_result();
  // benutzer vorhanden?
  if($result->num_rows){
    // userdaten lesen
    $user = $result->fetch_assoc();
    // passwort prüfen
    
    $sql = "UPDATE requests SET accepted = true, date = ? where id = ?";
    $statement = $mysqli->prepare($sql);
    $statement->bind_param('si', date("Y-m-d"), $requestID);
    $statement->execute();
    
    $sql = "INSERT INTO betakeys (betakey, stateID) VALUES (?, 1)";
    $statement = $mysqli->prepare($sql);
    $key = generateRandomString();
    $statement->bind_param('s', $key);
    $statement->execute();
    
  } else {
    echo "Benutzername oder Passwort sind falsch.<br />";
  }
  
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
