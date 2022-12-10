<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" media="screen" href="./style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Kinder Family Christmas</title>
</head>

<body>
    <?php
    include('connection.php');
    $check = isset($_GET['shuffle_done']);
    $button_register = false;
    $button_shuffle = false;
    $sql = "SELECT * FROM kinders";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if ($check) {
        $class = "d-none";
        $shuffle_class = "d-none";
    } elseif ($result->num_rows >= 12) {
        if ($row['drawn']) {
            header("Location:finish_page.php?shuffle_done=1");
        } else{
            $button_shuffle = true;
        }
        $class = "d-none";
        $shuffle_done = "d-none";
    } else {
        if ($row['drawn']) {
            header("Location:finish_page.php?shuffle_done=1");
        } elseif($result->num_rows < 12) {
            $button_register = true;
        }
        $shuffle_class = "d-none";
        $shuffle_done = "d-none";
    }
    ?>
    <nav class="main all-height">
        <div class="container-fluid pt-3 text-center">
            <span class="font-c display-1 text-white">O Amigo Secreto da Familia Kinder</span>
        </div>
        <div id="finish_text" class="text-box <?php echo $class ?>">
            <div class="heading-primary ">
                <span class="font-c sorteio display-2 text-white">Ja está!!</span>
                <p class="heading-primary-sub h6">Boa!!!<br>Já estas inscrito para mais um sorteio do amigo secreto da
                    familia Kinder.<br>Agora é rezar aos deuses para que te saía aquela pessoa que receberia aquela
                    prenda do ano passado que não gostaste tanto.<br>Boa sorte e não te esqueças de ser feliz,
                    especialemente nesta época!!</p><br>
                <h1 class="font-c display-2 text-white">Feliz Natal!</h1>
            </div>
            <?php
            if ($button_register) {
                echo "<a href='index.php' class='btn btn-white btn-animated'>Outro registo?</a>";
            }
            ?>
        </div>
        <div id="shuffle" class="text-box <?php echo $shuffle_class ?>">
            <div class="heading-primary ">
                <span class="font-c sorteio display-2 text-white">Aí está o momento!</span>
                <p class="heading-primary-sub h6">Já está!<br> Já estão todos inscritos!<br>Que estás à espera para
                    carregares
                    no botão??<br>BORA!!!!!!</p><br>
                <h1 class="font-c display-2 text-white">Feliz Natal!</h1>
            </div>
            <?php
            if ($button_shuffle) {
                echo "<a href='shuffle.php' class='btn btn-white btn-animated'>Sorteiar!!</a>";
            }
            ?>
        </div>
        <div id="shuffle_done" class="text-box <?php echo $shuffle_done ?>">
            <div class="heading-primary ">
                <span class="font-c sorteio display-2 text-white">Feito!!</span>
                <p class="heading-primary-sub h6">YEAHHHH!!! O sorteio já está feito!! <br>Verifica o teu email para veres
                    quem
                    te saiu, acho que vais gostar ;) <br>Boa sorte para encontrares a prenda perfeita :)<br>Mas
                    lembra-te, o
                    Natal é especial pela oportunidade de criar memórias felizes,, não é só prendas
                    ;)<br>Vemo-nos no dia 17 de dezembro na fantastica casa do Jommi e Tixa.<br>Até lá, boas compras :P
                </p>
                <br>
                <h1 class="font-c display-2 text-white">Feliz Natal!</h1>
            </div>
        </div>
    </nav>
</body>

</html>