<?php

session_start();

$_SESSION['errMsg'] = '';
if(isset($_POST['newPassword1']) && !empty(trim($_POST['newPassword1']))){
  $newPassword1 = trim($_POST['newPassword1']);
  //entspricht das passwort unseren vorgaben? (minimal 8 Zeichen, Zahlen, Buchstaben, keine Zeilenumbrüche, mindestens ein Gross- und ein Kleinbuchstabe)
  if(!preg_match("/(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $_POST['newPassword1'])){
    $_SESSION['errMsg'] .= "Das Passwort entspricht nicht dem geforderten Format.<br />";
  }
} else {
  // Ausgabe Fehlermeldung
  $_SESSION['errMsg'] .= "Geben Sie bitte ein korrektes Passwort ein.<br />";
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

  $oldPassword = htmlspecialchars($_POST['oldPassword']);
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
      // passwort prüfen
      $user = $result->fetch_assoc();
      if(password_verify($oldPassword, $user['password'])){

        $password = password_hash($newPassword1, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = ? where id = ?";
        $statement = $mysqli->prepare($sql);
        $statement->bind_param('si', $password, $_SESSION['userID']);
        $statement->execute();
        $_SESSION['errMsg'] = "Erfolgreich geändert.";
        header('Location: ../pages/changePassword.php');
      } else {
        $_SESSION['errMsg'] = "Das alte Passwort ist falsch.";
        header('Location: ../pages/changePassword.php');
      }
    }else {
      $_SESSION['errMsg'] = "Unerwarteter Fehler.";
      header('Location: ../pages/changePassword.php');
    }
  } else {
    $_SESSION['errMsg'] = "Die Passwörter stimmen nicht überein.";
    header('Location: ../pages/changePassword.php');
  }
} else {
  header('Location: ../pages/changePassword.php');
}
?>
