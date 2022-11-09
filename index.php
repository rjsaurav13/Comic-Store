<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">

<head>
    <link rel='stylesheet' href='assest/style.css'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Comic Store
    </title>
</head>

<body>
    <div class="login-box">
        <div id="logo"><img src="./images/logo.png" width="190px">
        </div>
        <h2><br></h2>
        <form action="datainsert.php" method="post">
            <div class="user-box">
                <input type="text" name="email" required="">
                <label>E-mail</label>
            </div>
            <a>
              <span></span>
              <input class="submit" type="submit" name="sumbit">
            </a>

            &nbsp
            <a href='/displaycomic.php'>
                <span></span>
                Comics
            </a>
        </form>
    </div>
</body>

</html>
