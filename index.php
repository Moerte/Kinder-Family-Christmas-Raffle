<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" media="screen" href="./style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./js/validate_data.js"></script>
    <script src="./js/manager.js"></script>
    <title>Kinder Family Christmas</title>
    <script>
        function addQuestion() {

            var container = document.getElementById("how_many");
            var label = document.createElement('label');
            label.htmlFor = "kids";
            var text = document.createTextNode("Quantos? ");
            label.appendChild(text);
            var div_label = document.createElement('div');
            div_label.classList.add('col-md-2');
            div_label.appendChild(label);
            container.appendChild(div_label);

            var input = document.createElement("input");
            input.type = "text";
            input.name = "kids";
            input.id = "kids";
            input.classList.add("form-control");
            var div_group = document.createElement('div');
            div_group.classList.add('form-group');
            var div = document.createElement('div');
            div.classList.add('col-md-2');
            div.appendChild(div_group);
            div.appendChild(input);
            container.appendChild(div);


            var input = document.createElement("a");
            input.href = "#";
            input.name = "kids";
            input.id = "filldetails";
            input.setAttribute('onclick', 'addDetails()');
            input.classList.add("form-control", "text-center", "text-decoration-none", "col-md-3");
            input.innerText = "Go!";
            var div = document.createElement('div');
            div.classList.add('col-md-2');
            div.appendChild(input);
            container.appendChild(div);
            document.getElementById('form_question').onclick = null;
        }
        function addDetails() {
            var number = document.getElementById("kids").value;
            var container = document.getElementById("kids_details");
            while (container.hasChildNodes()) {
                container.removeChild(container.lastChild);
            }
            for (i = 0; i < number; i++) {
                var col = document.createElement('div');
                col.classList.add('col-md-6');
                var group = document.createElement('div');
                group.classList.add('form-group');
                col.appendChild(group);

                var label = document.createElement('label');
                label.htmlFor = "kid_" + (i + 1);
                var text = document.createTextNode("Filho " + (i + 1) + " - Nome");
                label.appendChild(text);

                var input = document.createElement("input");
                input.id = "kid_" + (i + 1);
                input.type = "text";
                input.name = "kid_nome_" + i;
                input.placeholder = "Nome da criança";
                input.classList.add('form-control');
                col.appendChild(label);
                col.appendChild(input);
                container.appendChild(col);

                var label = document.createElement('label');
                label.htmlFor = "_kid_" + (i + 1);
                var text = document.createTextNode("Filho " + (i + 1) + " - Idade");
                label.appendChild(text);

                var col = document.createElement('div');
                col.classList.add('col-md-6');
                var group = document.createElement('div');
                group.classList.add('form-group');
                col.appendChild(group);

                var input = document.createElement("input");
                input.id = "_kid_" + (i + 1);
                input.type = "text";
                input.name = "kid_idade_" + i;
                input.placeholder = "Idade em anos (só o número)";
                input.classList.add('form-control');
                col.appendChild(label);
                col.appendChild(input);
                container.appendChild(col);
                container.appendChild(document.createElement("br"));

            }
        }
    </script>
</head>

<body>
    <?php
    include('connection.php');
    $sql = "SELECT * FROM kinders";
    $result = $conn->query($sql);
    if ($result->num_rows >= 12) {
        $row = $result->fetch_assoc();
        echo "<script>window.location.href='finish_page.php" . (($row['drawn'] == 1) ? "?shuffle_done=1'" : "'") . ";</script>";
    }
    ?>
    <nav class="main all-height">
        <div class="container-fluid pt-3 text-center">
            <span class="font-c display-1 text-white">O Amigo Secreto da Familia Kinder</span>
        </div>
        <div id="initial_text" class="text-box mt-4">
            <div class="heading-primary">
                <span class="font-c sorteio display-2 text-white">O Sorteio!!</span>
                <p class="heading-primary-sub h6">Olá amiguinhos!!!<br>Mais um ano, mais um fantastico Sorteio do
                    Amigo Secreto desta linda familia Kinder.<br>O Natal é aquela época do ano em que a partilha e a
                    felicidade reinam.<br> É a época de saires à rua cheio/a de frio, mas sentires conforto no cheirinho
                    das lareiras acesas. <br>É tambem a época de dares em maluco/a num centro comercial à procura da
                    prenda ideial para aquele familiar que te saiu no sorteio de amigo secreto e não fazes ideia do que
                    comprar.<br> No entanto, se há algo que o Natal tem de especial é a oportunidade de criar memórias
                    felizes em família. Portanto, aproveitem este Natal para serem felizes e partilharem experiências de
                    felicidade com todas a gente.</p><br>
                <h1 class="mt-4 font-c display-2 text-white">Feliz Natal!</h1>
            </div>
            <a href="#" class="startQuest btn btn-white btn-animated">Regista-te aqui!</a>
        </div>
    </nav>
    <div id="form_container" class="d-none container image_bg" style="margin-top: 30vh;">
        <div class=" text-center mt-5 ">
        </div>
        <div class="row ">
            <div class="col-lg-7 mx-auto">
                <div class="card mt-2 mx-auto p-4 bg-light">
                    <div class="card-body bg-light">
                        <div class="container">
                            <form id="register_id" role="form" action="add_guest.php" method="POST">
                                <div class="controls">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="form_name">Primeiro nome</label>
                                                <input id="form_name" type="text" name="first_name" class="form-control"
                                                    placeholder="Insere o teu primeiro nome" required="required"
                                                    data-error="Firstname is required.">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="surname">Apelido</label>
                                                <input id="surname" type="text" name="surname" class="form-control"
                                                    placeholder="Insere o teu apelido" required="required"
                                                    data-error="Lastname is required.">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="form_email">Email</label>
                                                <input id="form_email" type="email" name="email" class="form-control"
                                                    placeholder="Insere o teu email" required="required"
                                                    data-error="Valid email is required.">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="form_email_exc">Email a excluir</label>
                                                <input id="form_email_exc" type="email" name="exc_email"
                                                    class="form-control" placeholder="Insere o email do teu companheiro/a">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2" id="how_many">

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="form_question">Tens filhos?</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <a id="form_question" name="question"
                                                class="form-control text-center text-decoration-none col-md-3" rows="4"
                                                onclick="addQuestion()">Sim</a>
                                        </div>
                                    </div>
                                    <div class="row mt-2" id="kids_details">
                                    </div>
                                </div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <input type="submit" class="btn btn-danger btn-send pt-2 btn-block
                            " value="Inserir">
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>