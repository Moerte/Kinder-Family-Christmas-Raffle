<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$first_name = strip_tags(isset($_POST["first_name"]) ? $_POST['first_name'] : NULL);
$surname = strip_tags(isset($_POST["surname"]) ? $_POST['surname'] : NULL);
$email = strip_tags(isset($_POST["email"]) ? $_POST['email'] : NULL);
$kids = strip_tags(isset($_POST['kids']) ? $_POST['kids'] : NULL);
$exc_email = strip_tags(isset($_POST["exc_email"]) ? $_POST['exc_email'] : NULL);

include('connection.php');

$sql = "INSERT INTO kinders (first_name, surname, email, exclusion)
VALUES ('" . $first_name . "','" . $surname . "', '" . $email . "','" . $exc_email . "')";

if ($conn->query($sql) === TRUE) {
    send_email($first_name, $surname, $email);
    header('Location:finish_page.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

if ($kids != NULL) {
    $sql = "SELECT * FROM `kinder_kids` WHERE kinders_email = '" . $email . "' OR kinders_email = '" . $exc_email . "'";
    $result = $conn->query($sql);
    if ($result->num_rows < 1) {
        $query = 'INSERT INTO kinder_kids (name, age, kinders_email) VALUES ';
        $query_parts = array();
        for ($x = 0; $x < $kids; $x++) {
            $query_parts[] = "('" . strip_tags($_POST['kid_nome_' . $x]) . "', '" . strip_tags($_POST['kid_idade_' . $x]) . "', '" . $email . "')";
        }
    }
}
echo $query .= implode(',', $query_parts);

if ($conn->query($query) === TRUE) {
    echo "New kid created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();
function send_email($first_name, $surname, $email)
{
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
                                <p>Ola ' . $first_name . ' ' . $surname . '.<br>Boa! Já estás inscrito! Agora é esperar que todos se inscrevam para o botão de sorteio ficar disponivel!<br>Quem irá carregar no botão?<br>Não perca o próximo episodio que nós tambemn não! :P <br>
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
    $body = utf8_decode($croqui);
    
    require '/home/naropt12/public_html/PHPMailer/src/Exception.php';
    require '/home/naropt12/public_html/PHPMailer/src/PHPMailer.php';
    require '/home/naropt12/public_html/PHPMailer/src/SMTP.php';
    $mail = new PHPMailer();
    $mail->isSMTP();

    $mail->SMTPDebug = SMTP::DEBUG_OFF;
    $mail->Host = 'Host';
    $mail->Port = 465;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->SMTPAuth = true;
    $mail->Username = 'example@email.com';
    $mail->Password = 'Password';
    $mail->setFrom('example@email.com', 'NARO | No Reply Please');
    $mail->addAddress($email, $first_name . " " . $surname);
    $mail->Subject = 'Ja estas registado no Amigo secreto da familia Kinder!';
    $mail->msgHTML($body, __DIR__);
    $test = $mail->send();
    echo "Here " . $test . " => " . $mail->ErrorInfo;
    if (!$test) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message sent!';
    }
}
?>