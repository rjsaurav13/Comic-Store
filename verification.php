<?php
session_start();
require __DIR__ . '/Connections.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];


    $vquery = $con->prepare('SELECT Token, TStatus from details WHERE Token=? LIMIT 1');
    $vquery->bind_param('s', $token);
    $vquery->execute();
    $results = $vquery->get_result();
    $no_of_row = $results->num_rows;
    $vquery->close();

    if ($no_of_row > 0) {
        $data = mysqli_fetch_array($results);
        if ($data['TStatus'] == "0") {
            $validation_token = $data['Token'];

            $uquery = $con->prepare("UPDATE details SET TStatus='1' WHERE Token=? LIMIT 1");
            $uquery->bind_param('s', $validation_token);
            $uquery->execute();
            $uquery->close();
            $_SESSION['heading'] = 'Email Verification';
            $_SESSION['subject'] = 'Email Verified.';
            $_SESSION['data'] = 'Email has been successfully verified you will receive XKCD Comic every 5 mins.
            <br><br>To register another account';
            header('Location: output.php');
            exit(0);
        }

        // If status is already 1.
        else {
            $_SESSION['heading'] = 'Email Verification';
            $_SESSION['subject'] = 'Email Already Verified.';
            $_SESSION['data'] = 'To register another account';
            header('Location: output.php');
            exit(0);
        }
    }
}
