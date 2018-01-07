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

$sql = "INSERT INTO requests (userID) VALUES (?)";
$statement = $mysqli->prepare($sql);
$statement->bind_param('i', $_SESSION['userID']);
$statement->execute();

header('Location: ../pages/requestKey.php');

?>
