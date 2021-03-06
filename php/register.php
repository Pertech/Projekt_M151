<?php
  session_start();



// Initialisierung
$_SESSION['errMsg'] = '';
$firstname = $lastname = $email = $username = '';

  // Wurden Daten mit "POST" gesendet?
  if($_SERVER['REQUEST_METHOD'] == "POST"){

    // vorname vorhanden, mindestens 1 Zeichen und maximal 30 Zeichen lang
    if(isset($_POST['signup_firstname']) && !empty(trim($_POST['signup_firstname'])) && strlen(trim($_POST['signup_firstname']) <= 30)){
      // Spezielle Zeichen Escapen > Script Injection verhindern
      $signup_firstname = htmlspecialchars(trim($_POST['signup_firstname']));
    } else {
      // Ausgabe Fehlermeldung
      $_SESSION['errMsg'] .= "Geben Sie bitte einen korrekten Vornamen ein.<br />";
    }

    // nachname vorhanden, mindestens 1 Zeichen und maximal 30 zeichen lang
    if(isset($_POST['signup_lastname']) && !empty(trim($_POST['signup_lastname'])) && strlen(trim($_POST['signup_lastname']) <= 30)){
      // Spezielle Zeichen Escapen > Script Injection verhindern
      $signup_lastname = htmlspecialchars(trim($_POST['signup_lastname']));
    } else {
      // Ausgabe Fehlermeldung
      $_SESSION['errMsg'] .= "Geben Sie bitte einen korrekten Nachnamen ein.<br />";
    }

    // emailadresse vorhanden, mindestens 1 Zeichen und maximal 100 zeichen lang
    if(isset($_POST['signup_email']) && !empty(trim($_POST['signup_email'])) && strlen(trim($_POST['signup_email']) <= 100)){
      $signup_email = htmlspecialchars(trim($_POST['signup_email']));
      // korrekte emailadresse?
      if (filter_var($signup_email, FILTER_VALIDATE_EMAIL) === false){
        $_SESSION['errMsg'] .= "Geben Sie bitte eine korrekte Email-Adresse ein<br />";
      }
    } else {
      // Ausgabe Fehlermeldung
      $_SESSION['errMsg'] .= "Geben Sie bitte eine korrekte Email-Adresse ein.<br />";
    }

    // benutzername vorhanden, mindestens 6 Zeichen und maximal 30 zeichen lang
    if(isset($_POST['signup_username']) && !empty(trim($_POST['signup_username'])) && strlen(trim($_POST['signup_username']) <= 30)){
      $signup_username = trim($_POST['signup_username']);
      // entspricht der benutzername unseren vogaben (minimal 6 Zeichen, Gross- und Kleinbuchstaben)
  		if(!preg_match("/(?=.*[a-z])(?=.*[A-Z])[a-zA-Z]{6,}/", $_POST['signup_username'])){
  			$_SESSION['errMsg'] .= "Der Benutzername muss minmal 6 Zeichen und Gross -und Kleinschreibung beinhalten.<br />";
  		}
    } else {
      // Ausgabe Fehlermeldung
      $_SESSION['errMsg'] .= "Geben Sie bitte einen korrekten Benutzernamen ein.<br />";
    }

    // passwort vorhanden, mindestens 8 Zeichen
    if(isset($_POST['signup_password']) && !empty(trim($_POST['signup_password']))){
      $signup_password = trim($_POST['signup_password']);
      //entspricht das passwort unseren vorgaben? (minimal 8 Zeichen, Zahlen, Buchstaben, keine Zeilenumbrüche, mindestens ein Gross- und ein Kleinbuchstabe)
      if(!preg_match("/(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $_POST['signup_password'])){
        $_SESSION['errMsg'] .= "Passwort muss minimal 8 Zeichen, eine Zahl, ein Sonderzeichen und Gross -und Kleinschreibung beinhalten.<br />";
      }
    } else {
      // Ausgabe Fehlermeldung
      $_SESSION['errMsg'] .= "Geben Sie bitte ein korrektes Passwort ein.<br />";
    }
  }




  if ($_SESSION['errMsg'] == '') {
    $host = 'localhost'; // Host
    $username = 'root'; // Username
    $password = ''; // Passwort
    $database = 'beta'; // Datenbank

    $mysqli = new mysqli($host, $username, $password, $database);
    if ($mysqli->connect_errno) {
        die("Verbindung fehlgeschlagen: " . $mysqli->connect_error);
    }

    if($_POST['signup_password'] == $_POST['signup_password2']){
      $signup_password = password_hash($signup_password, PASSWORD_DEFAULT);

      $sql = "SELECT * FROM users WHERE username = ? or email = ?";
      $statement = $mysqli->prepare($sql);
      $statement->bind_param('ss', $signup_username, $signup_email);
      $statement->execute();

      $result = $statement->get_result();


      if($result->num_rows == 0){
        $sql = "INSERT INTO users (firstname,lastname,username,password,email) VALUES (?, ?, ?, ?, ?)";
        $statement = $mysqli->prepare($sql);
        $statement->bind_param('sssss', $signup_firstname, $signup_lastname, $signup_username ,$signup_password, $signup_email);
        $statement->execute();
        $_SESSION['regSuccessfull'] = true;
        header('Location: ../pages/index.php');
      } else {
        $_SESSION['type'] = 'signup';
        $_SESSION['errMsg'] = 'Der Benutzer ist bereits vorhanden!';
        header('Location: ../pages/index.php');
      }
    }else{
      $_SESSION['type'] = 'signup';
      $_SESSION['errMsg'] = 'Eingegebene Passwörter stimmen nicht überein!';
      header('Location: ../pages/index.php');
    }
  }
  else {
    $_SESSION['type'] = 'signup';
    header('Location: ../pages/index.php');
  }
 ?>
