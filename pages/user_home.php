<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Projekt M151 | Home</title>
  <link rel="icon" href="../resources/icon_t.png">
  <link href='https://fonts.googleapis.com/css?family=Roboto:900,900italic,500,400italic,100,700italic,300,700,500italic,100italic,300italic,400' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="../css/style_home.css">
</head>
<body>
  <?php
  session_start();
  if ($_SESSION['loggedin'] != true) {
    header('Location: ../pages/index.php');
  } ?>
  <div id="sidebar_left">
    <img id="img_left" src="../resources/image_new.jpg" alt="">
  </div>
  <div id="content_container">
    <div class="navbar">
        <a id="homeBtn" href="user_home.php">Home</a>
        <a href="contact.php">Contact</a>
        <a href="requestKey.php">Request</a>
        <a href="useKey.php">Redeem</a>
        <a href="changePassword.php">Change Password</a>
        <?php
        if($_SESSION['permissionLevel'] >= 50){
          echo '<a href="manageKeys.php">Manage Keys</a>';
          echo '<a href="manageRequests.php">Manage Requests</a>';
        }
        ?>
    </div>
    <div class="content">
      <form align="right" name="form1" method="post" action="../php/logout.php">
        <input name="submit" type="submit" id="submit" value="Log out">
        </label>
      </form>
      <h2>Hi <i><?php echo $_SESSION['username']; ?></i>
        <?php
          if($_SESSION['permissionLevel'] >= 50){
            echo '<img id="adminIcon" src="../resources/crown.png"></img>';
          }
        ?>
      </h2>
      <p>
        Welcome to the beta hub of the <i>Grosser Autodiebstal Simulator</i>, we are glad that you found us.
        If you haven't already, you can request your beta key now. Enjoy and thanks for your feedback.
      </p>
    </div>
  </div>
  <div id="sidebar_right">
    <img id="img_right" src="../resources/rainbow.png" alt="">
  </div>

  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <!-- <script type="text/javascript" src="../js/js_home.js"></script> -->
</body>
</html>
