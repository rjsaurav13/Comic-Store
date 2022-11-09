<!-- Gateway page -->
<?php
session_start();
$heading = isset($_SESSION['heading']) ? $_SESSION['heading'] : '';
$subject = isset($_SESSION['subject']) ? $_SESSION['subject'] : '';
$data = isset($_SESSION['data']) ? $_SESSION['data'] : '';
?>

<!DOCTYPE html>
<html>

<head>
    <link rel='stylesheet' href='assest/style.css'>
    <title><?php echo $heading; ?></title>
</head>

<body>
  <div class="login-box">
      <div id="logo"><img src="./images/logo.png" width="190px">
      </div>
      <h2><br></h2>
      <form>
          <div class="user-box">
            <h1><?php echo $subject; ?></h1>
            <p><?php echo $data; ?></p>
            <a href='/' class='validate'>
              <span></span>
              Click Here
            </a>
        </div>
      </form>
  </div>
</body>

</html>
