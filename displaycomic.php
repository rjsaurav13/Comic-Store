<?php
require __DIR__ . '/Comicintegration.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title> Comic Store </title>
    <link rel='stylesheet' href='assest/style.css'>
</head>

<body>
          <div class="login-box">
  <form>
  <div class="user-box">
            <h2 style="color:white; text-align:center; font-size:30px;"><?php echo $heading; ?></h2>
            <img style="margin-left: auto; margin-right: auto; height:180%; width:100%; display:block;" src="<?php echo $image; ?>" alt='$title' />
            <p style="color:white; text-align:center; font-size:20px;">To Register </p>
            <a href='/'  style="margin-left:24%" class='validate'>
                <span></span>
                Click Here
            </a>
          </div>
        </form>
      </div>

</body>

</html>
