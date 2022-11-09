<?php

require __DIR__ . '/Connections.php';
require __DIR__ . '/datainsert.php';
require __DIR__ . '/Comicintegration.php';

// Download Image
$sdir = 'XKCD_COMIC/';
$fileN = basename($image);
$cdir = $sdir . $fileN;
file_put_contents($cdir, file_get_contents($image));
$file = "XKCD_COMIC/$fileN";


$squery = $con->prepare("select Email,Token from details where TStatus='1'");
$squery->bind_param('i', $TSatus);
$squery->execute();
$query = $squery->get_result();
$squery->close();
while ($result = mysqli_fetch_array($query)) {
    $to_email = $result['Email'];
    $token = $result['Token'];
    $subject = 'Comic Store';

    $htmlContent = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>

            h2 {
                color: #4CAF50;
                text-align: center;
            }

            .verify {
            margin:0 auto;
            display:block;
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            width:25%;
            font-size: 16px;
            }
            img {
                display: block;
                margin-left: auto;
                margin-right: auto;
                width: 50%;
            }
            p {
                text-align:center;
                font-size:16px;
                font-weight: bold;
            }

        </style>
    </head>
    <body>
        <h2>$heading</h2>
        <img src='$image' alt='$heading'  />
        <br>
        <p> If you want to Unsubcribe click on the button below</p>
        <br>
        <a href='$hostname/assingment/unsubscribeaccount.php?token=$token' Class='verify'>Unsubcribe</a>
    </body>
    </html>
    ";


    $semi_rand = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

    $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
        "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n";

    // Preparing attachment
    if (!empty($file) > 0) {

        if (is_file($file)) {
            $message .= "--{$mime_boundary}\n";
            $fp =    fopen($file, "rb");
            $data =  fread($fp, filesize($file));

            fclose($fp);
            $data = chunk_split(base64_encode($data));
            $message .= "Content-Type: application/octet-stream; name=\"" . basename($file) . "\"\n" .
                "Content-Description: " . basename($file) . "\n" .
                "Content-Disposition: attachment;\n" . " filename=\"" . basename($file) . "\"; size=" . filesize($file) . ";\n" .
                "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
        }
    }
    $message .= "--{$mime_boundary}--";
    $returnpath = "-f" . $from;

    // Email sending status
    if (mail($to_email, $subject, $message, $headers, $returnpath)) {
        echo "Email successfully sent to $to_email";
    } else {
        echo 'Email sending failed';
    }
}
