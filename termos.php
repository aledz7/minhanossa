<?php
include('class/termo-de-uso.php');
$Termos = Termos::getInstance(Conexao::getInstance());

?>

<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <title>Minha Nossa! - Multimarcas de Empréstimos de Roupas em Brasília DF</title>
    <meta charset="UTF-8">
    <meta name="author" content="DFinformatica">
    <meta name="keywords" content="roupas">
    <meta name="description" content="Transformando o guarda-roupa feminino em um universo de possibilidades">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <!-- Ultima versão compactada BOOTSTRAP.CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link href="css/style.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/fav.png" type="image/x-icon" />
</head>

<body>

    <?php include('header.php');?>

    <style>
    .preto {
        padding: 48px 0 0;
        background-image: url(../images/fundo.png);
    }

    .amarelo {
        padding-right: 0px !important;
        padding-left: 0px !important;
        background: #fff;
        height: 1300px;
    }

    .verm {
        background: #fff;
    }

    .fonte-1 {
        font-size: 30px;
    }

    .azul {
        color: #fff;
    }

    /* Style the tab */
.tab {
  float: left;
  border: none;
  background-color: #f1f1f1;
  width: 30%;
  height: 100%;
}

/* Style the buttons inside the tab */
.tab button {
  display: block;
  background-color: inherit;
  color: #337ab7;
  padding: 5px 16px;
  width: 100%;
  border: none;
  outline: none;
  text-align: left;
  cursor: pointer;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current "tab button" class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  float: left;
  padding: 0px 12px;
  border: none;
  width: 70%;
  border-left: none;
  height: 300px;
}
.botao_voltar {
    margin-top: 105px;
}

@media only screen and (max-width: 600px) {
    .amarelo {
        height: 2180px;
    }

    .botao_voltar {
        position: absolute;
        margin-top: 579px;
    }
    
}
    </style>


    <section class="row preto">
        <div class="container amarelo">
            <h1 class="text-center">Termo de Adesão & Condições de Uso</h1> <br>

            <div class="col-md-12 verm">
                <div class="tab">
                    <?php $perguntas = $Termos->rsDados('', 'ordem ASC');
                    foreach($perguntas as $pergunta) { ?>
                    <button class="tablinks" onclick="openCity(event, '<?php echo $pergunta->id;?>')" id="defaultOpen"><?php echo utf8_decode($pergunta->titulo);?></button>
                    <?php }?>
                </div>
            
                <?php $termo = $Termos->rsDados('', 'ordem ASC');
                    foreach($termo as $termos) { 
                ?>
                <div id="<?php echo $termos->id;?>" class="tabcontent">
                    <h3><?php echo utf8_decode($termos->titulo);?></h3>
                    <p><?php echo utf8_decode($termos->descricao);?></p>
                </div>
                <?php }?>
            </div>
            <div class="col-md-12 botao_voltar">
                <div class="col-sm-6 text-left">
                    <h3 class="text-left">
                        <a href="javascript:;" onClick="history.back()">
                            <i class="fa fa-chevron-left" aria-hidden="true"></i>
                            voltar
                        </a>
                    </h3>

                </div>
                <!-- <div class="col-sm-6 text-right">
                      <div class="clearfix">&nbsp;</div>
                      <a href="index.php">
                        <button class="add-to-cart btn btn-default " type="button">eu aceito os termos e condições</button>
                      </a>
                    </div>   -->
            </div>

            <br>
        </div>
    </section>

    <div class="clearfix">
        &nbsp;
    </div>

    <div class="clearfix">
        &nbsp;
    </div>

    <div class="clearfix">
        &nbsp;
    </div>

    <?php include('footer1.php');?>


</body>
<!-- Latest compiled and minified JS -->
<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
<!-- Latest compiled and minified JS -->
<script src="//code.jquery.com/jquery.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<!-- <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script> -->
<script src="js/script.js"></script>

</html>