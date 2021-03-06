<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Projekt M151 | Login</title>
  <link rel="icon" href="../resources/icon_t.png">
  <link href='https://fonts.googleapis.com/css?family=Roboto:900,900italic,500,400italic,100,700italic,300,700,500italic,100italic,300italic,400' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <script type="text/javascript">
    function goToRegister() {
        var myElement = document.querySelector("#textbox");
        myElement.style.marginLeft = "0";
        var myElement2 = document.querySelector(".top");
        myElement2.style.marginLeft = "100%";
    }
  </script>
  <?php
  session_start();
  ?>
  <div id="fback">
    <div class="pane_2">
      <img id="lead_2_img" src="../resources/rainbow.png" alt="Cover2">
    </div>
    <div class="pane_1">
      <img id="lead_img" src="../resources/image_new.jpg" alt="Cover">
    </div>
  </div>

  <div id="textbox">
    <div class="top">

      <div class="left">
        <div id="ic">
          <?php
            if(isset($_SESSION['errMsg']) && isset($_SESSION['type']) && $_SESSION['type'] == 'signup'){
              echo "<p>" . $_SESSION['errMsg'] . "</p>";
              // ruft die funktion oben auf, damit beim neuladen der seite automatisch wieder der Registrieungs-Screen angezeigt wird
              echo "<script>goToRegister()</script>";
              session_destroy();
            }
           ?>
          <h2 id="sign_h2">Sign Up</h2>
          <p>Sign up today and request a brand new key for your beta experience!</p>

          <form id="sign_up_div" name="signup_form" method="post" enctype="multipart/form-data" action="../php/register.php">

            <div class="form-group">
              <label class="control-label" for="inputNormal">Username</label>
              <input type="text" name="signup_username" id="signup_username" class="bp-suggestions form-control" cols="50" rows="10"
                maxlength="30"
                pattern="(?=.*[a-z])(?=.*[A-Z])[a-zA-Z]{6,}"
                title="Gross- und Keinbuchstaben, min 6 Zeichen." required></input>
            </div>
            <div class="form-group">
              <label class="control-label" for="inputNormal">First Name</label>
              <input type="text" name="signup_firstname" id="signup_firstname" class="bp-suggestions form-control" cols="50" rows="10" maxlength="30" required></input>
            </div>
            <div class="form-group">
              <label class="control-label" for="inputNormal">Last Name</label>
              <input type="text" name="signup_lastname" id="signup_lastname" class="bp-suggestions form-control" cols="50" rows="10" maxlength="30" required></input>
            </div>
            <div class="form-group">
              <label class="control-label" for="inputNormal">Email</label>
              <input type="text" name="signup_email" id="signup_email" class="bp-suggestions form-control" cols="50" rows="10" maxlength="100" required></input>
           </div>
           <div class="form-group">
              <label class="control-label" for="inputNormal">Password</label>
              <input type="password" name="signup_password" id="signup_password" class="bp-suggestions form-control" cols="50" rows="10" pattern="(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                  title="mindestens einen Gross-, einen Kleinbuchstaben, eine Zahl und ein Sonderzeichen, mindestens 8 Zeichen lang,keine Umlaute." required></input>
           </div>
           <div class="form-group">
              <label class="control-label" for="inputNormal">Confirm Password</label>
              <input type="password" name="signup_password2" id="signup_password2" class="bp-suggestions form-control" cols="50" rows="10" pattern="(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                  title="mindestens einen Gross-, einen Kleinbuchstaben, eine Zahl und ein Sonderzeichen, mindestens 8 Zeichen lang,keine Umlaute." required></input>
           </div>
           <input type="submit" name="signup_submit" id="signup_submit" value="Sign Up" class="mainbtn su"/>

         </form>

         <button id="moveright">Login</button>
      </div>
    </div>

  <div class="right">
    <div id="ic">
      <?php
        if(isset($_SESSION['errMsg']) && isset($_SESSION['type']) && $_SESSION['type'] == 'login'){
          echo "<p>" . $_SESSION['errMsg'] . "</p>";
          session_destroy();
        }
        if(isset($_SESSION['regSuccessfull']) && $_SESSION['regSuccessfull'] == true){
          echo "<p> Erfolgreich registriert! </p>";
          session_destroy();
        }
       ?>
      <h2>Login</h2>
      <p>Welcome back!</p>
      <form name="login-form" id="login_div" method="post" action="../php/login.php">

        <div class="form-group lg">
          <label class="control-label" for="inputNormal">Username</label>
          <input type="text" name="login_username" class="bp-suggestions form-control" cols="50" rows="10"></input>
        </div>
        <div class="form-group soninpt lg">
          <label class="control-label" for="inputNormal">Password</label>
          <input type="password" name="login_password" class="bp-suggestions form-control" cols="50" rows="10"></input>
        </div>
      <input type="submit" value="Login" class="mainbtn"/>
    </form>

    <button id="moveleft">Sign Up</button>
    </div>
  </div>

  </div>
  </div>

  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script  src="../js/index.js"></script>
  <!--<script src="https://code.createjs.com/soundjs-0.6.2.min.js"></script>-->
</body>
</html>
