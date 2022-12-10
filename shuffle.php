<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

include('connection.php');
$sql = "SELECT * FROM kinders";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
if ($row['drawn'] == 1) {
    header("Location:finish_page.php?shuffle_done=1");
    return;
}elseif ($result->num_rows < 12) {
    header("Location:index.php");
}

// Adults raffle
for ($i = 0; $i < 5; $i++) {
    $user_winners = big_random_selection($conn);
    if (in_array("ERROR", $user_winners)) {
        continue;
    }
    break;
}
// kids raffle
for ($j = 0; $j < 5; $j++) {
    $kids_winners = kids_random_selection($conn);
    if (in_array("ERROR", $kids_winners)) {
        continue;
    }
    break;
}


$mail = new PHPMailer();
$mail->isSMTP();

$mail->SMTPDebug = SMTP::DEBUG_OFF;
$mail->Host = 'host';
$mail->Port = 465;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->SMTPAuth = true;
$mail->Username = 'example@email.com';
$mail->Password = 'Password';

foreach ($user_winners as $key => $value) {
    
    $flag = false;
    $name = get_name($key, $conn);
    $winner_name = get_name($value, $conn);
    $extra_msg = "";

    $sql = "SELECT * FROM `kinder_kids` WHERE kinders_email = '" . $key . "'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $extra_msg .= "<br>Como tens filhos, aqui tens tambem o amigo secreto para as pequenas:<br>";
        while ($row = $result->fetch_assoc()) {
            $kid_name = $row['name'];
            $sql_2 = "SELECT * FROM `kinder_kids` WHERE name = '" . $kids_winners[$kid_name] . "'";
            $result_2 = $conn->query($sql_2);
            $row_2 = $result_2->fetch_assoc();
            $extra_msg .= "- A " . $kid_name . " tem como amigo secreto a " . $kids_winners[$kid_name] . ". Não te esqueças que ela tem " . $row_2['age'] . " anos.<br>";
            $flag = true;
        }
    }
    $croqui = '<!DOCTYPE html>
    <html lang="pt-pt">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <title>Kinder Family Christmas</title>
        <style>
            body {
                background-image: url("./img/forest_1.jpg");
                height: 80vh;
                background-repeat: no-repeat;
                background-size: 100% 100%;
                font-family: "Christmas_font_2", sans-serif;
                font-weight: 400;
                font-size: 16px;
                line-height: 1.7;
            }
    
            .font-c {
                font-family: "Christmas_font", sans-serif;
            }
    
            label {
                font-size: 1em;
            }
    
            .main {
                background-image: linear-gradient(to right bottom,
                        rgba(195, 42, 42, 0.8),
                        rgba(242, 7, 7, 0.8)), url(data:image/jpg;base64,{{"./img/christmas_2.jpg"}});
                background-size: cover;
                background-position: top;
                clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
            }
    
            .half-height {
                height: 20vh;
                transition: height 2s;
            }
    
            .text-box {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                text-align: center;
                width: 90%;
            }
        </style>
    </head>
    
    <body>
        <nav class="main fixed-top half-height">
            <div class="container-fluid pt-3 text-center">
                <span class="font-c display-2 text-white">O Amigo Secreto da Familia Kinder</span>
            </div>
        </nav>
        <div id="form_container" class="container image_bg" style="margin-top: 30vh;">
            <div class=" text-center mt-5 ">
            </div>
            <div class="row ">
                <div class="col-lg-7 mx-auto">
                    <div class="card mt-2 mx-auto p-4 bg-light">
                        <div class="card-body bg-light">
                            <div class="container">
                            <p>Ola '.$name.'.<br>O sorteio está feito!!<br>E o teu amigo secreto é: '.$winner_name.' ;) '.$extra_msg.'<br>Boa sorte para encontrares a prenda perfeita :)<br>Mas não te esqueças, o Natal é especial pela oportunidade de criar memórias felizes, não apenas pelas prendas ;)<br>Vemo-nos no dia 17 de dezembro na fantastica casa do Jommi e Tixa.<br>Até lá, boas compras :P
                            </p>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="main fixed-bottom half-height">
                <div class="container-fluid pt-3 text-center">
                    <span class="font-c display-1 text-white">Feliz Natal!</span>
                </div>
            </nav>
        </body> 
        </html>';
    $body= utf8_decode($croqui);
    $mail->clearAddresses();
    $mail->setFrom('example@email.com', 'Amigo Secreto | No Reply Please');
    $mail->addAddress($key, $name);
    $mail->Subject = 'Ja sabemos quem e o teu amigo secreto!';
    $mail->msgHTML($body, __DIR__);
    $test = $mail->send();
    echo "Here " . $test . " => " . $mail->ErrorInfo;
    if (!$test) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message sent!' . $key;
    }
}

$update = "UPDATE kinders SET drawn='1'";
$result = $conn->query($update);

header("Location:finish_page.php?shuffle_done=1");

function big_random_selection($conn)
{
    $sql = "SELECT * FROM kinders";
    $result = $conn->query($sql);
    $already_out = array();
    $associations = array();
    while ($row = $result->fetch_assoc()) {
        $exclusions = array();
        $email = $row['email'];
        array_push($exclusions, $row['exclusion'], $email);
        $sql_2 = "SELECT email FROM kinders";
        $result_2 = $conn->query($sql_2);
        $arr = array();
        while ($row_2 = $result_2->fetch_assoc()) {
            if (in_array($row_2['email'], $exclusions) || in_array($row_2['email'], $exclusions) || in_array($row_2['email'], $already_out)) {
                continue;
            }
            array_push($arr, $row_2['email']);
        }

        $winner = $arr[rand(0, count($arr) - 1)] == '' ? "ERROR" : $arr[rand(0, count($arr) - 1)];
        array_push($already_out, $winner);
        $associations[$email] = $winner;
    }
    return $associations;
}

function kids_random_selection($conn)
{
    $sql = "SELECT * FROM kinder_kids";
    $result = $conn->query($sql);
    $already_out = array();
    $associations = array();
    while ($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $sql_2 = "SELECT * FROM kinder_kids";
        $result_2 = $conn->query($sql_2);
        $arr = array();
        while ($row_2 = $result_2->fetch_assoc()) {
            if (in_array($row_2['name'], $already_out) || $row['kinders_email'] == $row_2['kinders_email']) {
                continue;
            }
            array_push($arr, $row_2['name']);
        }
        $winner = $arr[rand(0, count($arr) - 1)] == '' ? "ERROR" : $arr[rand(0, count($arr) - 1)];
        array_push($already_out, $winner);
        $associations[$name] = $winner;
    }
    return $associations;
}

function get_name($email, $conn)
{
    $sql = "SELECT first_name, surname FROM kinders WHERE email='" . $email . "'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['first_name'] . " " . $row['surname'];
}

?>