<?php
session_start();
require _DIR_ . '/Connections.php';
/*
  * This Function sends verification email
*/

function authenticate($email, $verifytoken, $from, $fromName, $headers, $hostname)
{
    $to_email = $email;
    $_SESSION['token'] = $verifytoken;
    $subject = 'Email Verification';
    $headers .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-Type: text/html; charset=iso-8859-1' . "\r\n";

    $body = "
            <!DOCTYPE html>
            <html>
            <head>
            <style>
                h1 {
                    color: #03e9f4;
                    margin:3%;
                    text-align: center;
                }
                h2 {

                    text-align: center;
                }

                .validate {
                    margin:0 auto;
                    display:block;
                    background-color: #03e9f4;
                    border: none;
                    color: white;
                    padding: 15px 32px;
                    text-align: center;
                    text-decoration: none;
                    width:25%;
                    font-size: 16px;
                }
                p {
                    text-align:center;
                }
            </style>
            </head>
            <body>
                <h1>Comic Store</h1>
                <h2>Email Verification</h2>
                <p>Please verify your email to get funny comics on your registered mail.</p>
                <br>
                <a href='$hostname/saurav/verification.php?token=$verifytoken' Class='validate'>Verification</a>
            </body>
            </html>
    ";
    $returnpath = "-f" . $from;

    // sending verfication mail to the user.
    if (mail($to_email, $subject,  $body, $headers, $returnpath)) {
        $_SESSION['heading'] = 'Registration';
        $_SESSION['subject'] = 'Verify Your Email address.';
        $_SESSION['data'] = 'Verification link has been sent to your registered mail.
                            <br> <br> Please verify your mail.
                            <br> <br> To register another account';
        header('Location: output.php');
        exit(0);
    }
}

// E-mail validation
if (isset($_POST['sumbit'])) {
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $e_mail = mysqli_real_escape_string($con, $_POST['email']);
        $e_mail = trim($e_mail);
        $e_mail = stripslashes($e_mail);
        $e_mail = htmlspecialchars($e_mail, ENT_QUOTES, 'UTF-8');
    }


    if (filter_var($e_mail, FILTER_VALIDATE_EMAIL)) {
        $validation = md5(rand());
        $counter = $con->prepare("SELECT Email from details where Email=? LIMIT 1");
        $counter->bind_param('s', $e_mail);
        $counter->execute();
        $output = $counter->get_result();
        $row_no = $output->num_rows;
        $counter->close();
        if ($row_no > 0) {
            $_SESSION['heading'] = 'Registration';
            $_SESSION['subject'] = 'Email Already Exist.';
            $_SESSION['data'] = 'To register another account';
            header('Location: output.php');
            exit(0);
        }
        //Check for E-mail Count
        else {
            $insert_data = $con->prepare("INSERT INTO details(Email,Token) VALUES (?,?)");
            $insert_data->bind_param('ss', $e_mail, $validation);
            $result = $insert_data->execute();
            $insert_data->close();

            if ($result) {
                authenticate($e_mail, $validation, $from, $fromName, $headers, $hostname);
            } else {
                $_SESSION['heading'] = 'Registration';
                $_SESSION['subject'] = 'Registration Not Done.';
                $_SESSION['data'] = 'To register another account';
                header('Location: output.php');
                exit(0);
            }
        }
    } else {
        $_SESSION['heading'] = 'Registration';
        $_SESSION['subject'] = 'Email Not Valid';
        $_SESSION['data'] = 'To register another account';
        header('Location: output.php');
        exit(0);
    }
}
