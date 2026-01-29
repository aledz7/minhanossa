<?php
include('../class/info-site.php');
$infoSite = InfoSite::getInstance(Conexao::getInstance())->rsDados();
?>
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title><?=$infoSite->nome; echo ($_GET['nome'] <> '') ? ' - '.$_GET['nome'] : $_GET['nome']?></title>
<meta name="description" content="<?=$_GET['nome'].' - '.$infoSite->nome.' - '.strip_tags(str_replace('
', '', $infoSite->endereco));?> ">
<meta name="keywords" content="<?=$_GET['nome'].' - '.$infoSite->nome.' - '.strip_tags(str_replace('
', '', $infoSite->endereco));?> ">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- favicon
		============================================ -->
<link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
<!-- Google Fonts
		============================================ -->
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Lato:400,300,700,900' rel='stylesheet' type='text/css'>
<!-- Bootstrap CSS
		============================================ -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<!-- Bootstrap CSS
		============================================ -->
<link rel="stylesheet" href="css/font-awesome.min.css">
<!-- owl.carousel CSS
		============================================ -->
<link rel="stylesheet" href="css/owl.carousel.css">
<link rel="stylesheet" href="css/owl.theme.css">
<link rel="stylesheet" href="css/owl.transitions.css">
<!-- nivo slider CSS
		============================================ -->
<link rel="stylesheet" href="lib/css/nivo-slider.css" type="text/css" />
<link rel="stylesheet" href="lib/css/preview.css" type="text/css" media="screen" />
<!-- animate CSS
		============================================ -->
<link rel="stylesheet" href="css/animate.css">
<!-- meanmenu CSS
		============================================ -->
<link rel="stylesheet" href="css/meanmenu.min.css">
<!-- Image Zoom CSS
		============================================ -->
<link rel="stylesheet" href="css/img-zoom/jquery.simpleLens.css">
<!-- normalize CSS
		============================================ -->
<link rel="stylesheet" href="css/normalize.css">
<!-- main CSS
		============================================ -->
<link rel="stylesheet" href="css/main.css">
<!-- style CSS
		============================================ -->
<link rel="stylesheet" href="style.css">
<!-- responsive CSS
		============================================ -->
<link rel="stylesheet" href="css/responsive.css">
<style type="text/css">
body, td, th {
	font-family: "Open Sans", sans-serif;
}
</style>
<!-- modernizr JS
		============================================ -->
<script src="js/vendor/modernizr-2.8.3.min.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
<script src="js/jquery-1.8.3.js"></script>
<script src="js/jquery-ui.js"></script>
<script type="text/javascript">
        $(document).ready(function() {
         
        // Captura o retorno do resultado-busca.php
        $.getJSON('resultado-busca.php', function(data){
            var produtos = [];
             
            // Armazena na array capturando somente o nome do produto
            $(data).each(function(key, value) {
                produtos.push(value.nome);
            });
             
            // Chamo o Auto complete do JQuery ui setando o id do input, array com os dados e o mínimo de caracteres para disparar o AutoComplete
            $('#busca').autocomplete({ source: produtos, minLength: 2});
        });
    });
  </script>
<script type="text/javascript">

     function submitenter(myfield,e)
     {
      var keycode;
      if (window.event) keycode = window.event.keyCode;
      else if (e) keycode = e.which;
      else return true;

      if (keycode == 13)
      {
       myfield.form.submit();
       return false;
      }
      else
       return true;
     }

  </script>
<script type="text/javascript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<script type="text/javascript">
 function chamaForm(){
	document.getElementById("easy2").style.display = "none";
	document.getElementById("easy").style.display = "block";	
}
function chamaTabela(){
	document.getElementById("easy2").style.display = "block";
	document.getElementById("easy").style.display = "none";
}
</script>
</head>
