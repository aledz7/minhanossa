<?php
include('class/conteudos.php');
$conteudos = Conteudos::getInstance(Conexao::getInstance());

$servicos = $conteudos->rsDados('26');
foreach($servicos as $servico) { ?>
	<li><a href="servicos.php?nome=<?=texto($servico->titulo);?>&id=<?=$servico->id;?>"><?=texto($servico->titulo);?></a></li>
<?php } ?>

<?php
include('class/produtos.php');
$produtos = Produtos::getInstance(Conexao::getInstance());

include('class/textos.php');
$textos = Textos::getInstance(Conexao::getInstance());

include('class/html.php');
$html = new HTML;

include('class/traducoes.php');  // Sempre colocar antes de tudo.
$traducoes = Traducoes::getInstance(Conexao::getInstance());
$traducoes->trocaIdioma();


include('class/fotos.php');
$fotos = Fotos::getInstance(Conexao::getInstance());


include('class/clientes.php');
$clientes = Clientes::getInstance(Conexao::getInstance());
$clientes->login($_POST['email'], $_POST['senha'], 'minha-area.php');


include('class/newsletter.php');
$newsletter = Newsletter::getInstance(Conexao::getInstance());
$newsletter->add('.', 'Obrigado. Seu cadastro foi realizado com sucesso.');
?>

/// INFO SITE
<?php
include('class/info-site.php');
$infoSite = InfoSite::getInstance(Conexao::getInstance())->rsDados();

echo $infoSite->telefone;
?>
