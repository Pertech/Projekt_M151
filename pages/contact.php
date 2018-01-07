<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Projekt M151 | Contact</title>
  <link rel="icon" href="../resources/icon_t.png">
  <link href='https://fonts.googleapis.com/css?family=Roboto:900,900italic,500,400italic,100,700italic,300,700,500italic,100italic,300italic,400' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="../css/contact.css">
</head>
<body>
  <?php if ($_SESSION['loggedin'] == false) {
    header('Location: ../pages/index.php');
  } ?>
  <div id="sidebar_left">
    <img id="img_left" src="../resources/image_new.jpg" alt="">
  </div>
  <div id="content_container">
    <div class="navbar">
      <a href="user_home.php">Home</a>
      <a id="contactBtn" href="contact.php">Contact</a>
      <a href="acceptRequestTest.php">Request</a>
      <a href="useKeyTest.php">Redeem</a>
    </div>
    <div class="content">
      <form align="right" name="form1" method="post" action="../php/logout.php">
        <input name="submit" type="submit" id="submit" value="Log out">
        </label>
      </form>
    </div>
  </div>
  <div id="sidebar_right">
    <img id="img_right" src="../resources/rainbow.png" alt="">
  </div>

  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script type="text/javascript" src="../js/contact.js"></script>
</body>
</html>
