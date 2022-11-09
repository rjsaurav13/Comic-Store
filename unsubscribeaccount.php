
<?php
session_start();
require __DIR__ . '/Connections.php';

if (isset($_GET['token'])) {
    $del_token = $_GET['token'];

    $uselect = $con->prepare('SELECT * from details WHERE Token=?');
    $uselect->bind_param('s', $del_token);
    $uselect->execute();
    $result = $uselect->get_result();
    $no_of_rows = $result->num_rows;
    $uselect->close();


    if ($no_of_rows > 0) {
        $dquery = $con->prepare("DELETE from details WHERE Token=?");
        $dquery->bind_param('s', $dquery);
        $dquery->execute();
        $dquery->close();
        $_SESSION['heading'] = 'Unsubscribe Account';
        $_SESSION['subject'] = 'You have successfully unsubscribed.';
        $_SESSION['data'] = 'To subscribe again';
        header('Location: output.php');
        exit(0);
    }

    else {
        $_SESSION['heading'] = 'Unsubscribe Account';
        $_SESSION['subject'] = 'Account Already unsubscribed.';
        $_SESSION['data'] = 'To subscribe again';
        header('Location: output.php');
        exit(0);
    }
}
