<?php
include('Connections/conexao.php');
session_start();

include('funcoes.php');
include('verifica-retorno-produto.php');

$colname_rs_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rs_usuario = $_SESSION['MM_Username'];
}
mysql_select_db($database_conexao, $conexao);
$query_rs_usuario = sprintf("SELECT * FROM tbl_admin WHERE login = %s", GetSQLValueString($colname_rs_usuario, "text"));
$rs_usuario = mysql_query($query_rs_usuario, $conexao) or die(mysql_error());
$row_rs_usuario = mysql_fetch_assoc($rs_usuario);
$totalRows_rs_usuario = mysql_num_rows($rs_usuario);

if ($row_rs_usuario['login'] == '') {
  echo "	<script>
			window.location='login.php';
			</script>";
  exit;
}


mysql_select_db($database_conexao, $conexao);
$query_rs_contaReceber = "SELECT sum(valor_total) as total FROM tbl_contas WHERE tipo = 'R' and data_vencimento = '" . date('Y-m-d') . "'";
$rs_contaReceber = mysql_query($query_rs_contaReceber, $conexao) or die(mysql_error());
$row_rs_contaReceber = mysql_fetch_assoc($rs_contaReceber);
$totalRows_rs_contaReceber = mysql_num_rows($rs_contaReceber);

mysql_select_db($database_conexao, $conexao);
$query_rs_contaPagar = "SELECT sum(valor_total) as total FROM tbl_contas WHERE tipo = 'D' and  data_vencimento = '" . date('Y-m-d') . "'";
$rs_contaPagar = mysql_query($query_rs_contaPagar, $conexao) or die(mysql_error());
$row_rs_contaPagar = mysql_fetch_assoc($rs_contaPagar);
$totalRows_rs_contaPagar = mysql_num_rows($rs_contaPagar);


mysql_select_db($database_conexao, $conexao);
$query_rs_metaLoja = "SELECT meta FROM tbl_loja";
$rs_metaLoja = mysql_query($query_rs_metaLoja, $conexao) or die(mysql_error());
$row_rs_metaLoja = mysql_fetch_assoc($rs_metaLoja);
$totalRows_rs_metaLoja = mysql_num_rows($rs_metaLoja);


mysql_select_db($database_conexao, $conexao);
$query_rs_metaAlcLoja = "SELECT sum((select sum(tbl_pagamento.valor_pagamento) from tbl_pagamento where tbl_contrato.id = tbl_pagamento.id_contrato)) as total FROM tbl_contrato where month(data_contrato) = '" . date('m') . "' and year(data_contrato)";
$rs_metaAlcLoja = mysql_query($query_rs_metaAlcLoja, $conexao) or die(mysql_error());
$row_rs_metaAlcLoja = mysql_fetch_assoc($rs_metaAlcLoja);
$totalRows_rs_metaAlcLoja = mysql_num_rows($rs_metaAlcLoja);


mysql_select_db($database_conexao, $conexao);
$query_rs_metaAlcVendedor = "SELECT sum((select sum(tbl_pagamento.valor_pagamento) from tbl_pagamento where tbl_contrato.id = tbl_pagamento.id_contrato)) as total FROM tbl_contrato where month(data_contrato) = '" . date('m') . "' and year(data_contrato) and tbl_contrato.vendedor = '{$_SESSION['dadosUser']['id']}'";
$rs_metaAlcVendedor = mysql_query($query_rs_metaAlcVendedor, $conexao) or die(mysql_error());
$row_rs_metaAlcVendedor = mysql_fetch_assoc($rs_metaAlcVendedor);
$totalRows_rs_metaAlcVendedor = mysql_num_rows($rs_metaAlcVendedor);

$dataHoje = date('Y-m-d');

mysql_select_db($database_conexao, $conexao);
$query_rs_aniversariantes = "SELECT * FROM tbl_cliente WHERE DAY(aniversario) = DAY(CURDATE()) and MONTH(aniversario) = MONTH(CURDATE())";
$rs_aniversariantes = mysql_query($query_rs_aniversariantes, $conexao) or die(mysql_error());
$row_rs_aniversariantes = mysql_fetch_assoc($rs_aniversariantes);
$totalRows_rs_aniversariantes = mysql_num_rows($rs_aniversariantes);
$dataHoje2 = date('Y-m-d');
$data7dias = date('Y-m-d', time() + (86400 * 5));


mysql_select_db($database_conexao, $conexao);
$query_rs_fim_contrato = "SELECT * FROM tbl_cliente WHERE data_vencimento >= '{$dataHoje2}' and data_vencimento <= '{$data7dias}'";
$rs_fim_contrato = mysql_query($query_rs_fim_contrato, $conexao) or die(mysql_error());
$row_rs_fim_contrato = mysql_fetch_assoc($rs_fim_contrato);
$totalRows_rs_fim_contrato = mysql_num_rows($rs_fim_contrato);

//and tbl_contrato.codigo_cliente = '{$row_rs_fim_contrato['id']}'
mysql_select_db($database_conexao, $conexao);
$query_rs_devolver_pecas = "SELECT * FROM tbl_contrato 
WHERE 
	DAY(data_devolucao) = DAY(CURDATE()) 
	and MONTH(data_devolucao) = MONTH(CURDATE()) 
	and YEAR(data_devolucao) = YEAR(CURDATE())
	and (SELECT count(1) FROM tbl_item WHERE tbl_item.id_contrato = tbl_contrato.id and tbl_item.devolvido_em is null) > 0
";
$rs_devolver_pecas = mysql_query($query_rs_devolver_pecas, $conexao) or die(mysql_error());
$row_rs_devolver_pecas = mysql_fetch_assoc($rs_devolver_pecas);
$totalRows_rs_devolver_pecas = mysql_num_rows($rs_devolver_pecas);

mysql_select_db($database_conexao, $conexao);
$query_rs_reservas = "
SELECT
tbl_lista_espera.*, 
tbl_produto.nome, 
tbl_cliente.nome as cliente, 
tbl_produto.id as codigo, 
tbl_cores.nome as cor, 
tbl_produto.numeracao 
FROM
	tbl_lista_espera
	left join tbl_produto on tbl_lista_espera.id_produto = tbl_produto.id
	left join tbl_cores on tbl_cores.id = tbl_produto.id_cor
	left join tbl_cliente on tbl_lista_espera.id_cliente = tbl_cliente.id
where
	1=1
ORDER BY 
	tbl_lista_espera.data DESC
";
$rs_reservas = mysql_query($query_rs_reservas, $conexao) or die(mysql_error());
$row_rs_reservas = mysql_fetch_assoc($rs_reservas);
$totalRows_rs_reservas = mysql_num_rows($rs_reservas);

mysql_select_db($database_conexao, $conexao);
$query_rs_lavanderia = "SELECT * FROM tbl_lavanderia WHERE DAY(data_devolucao) = DAY(CURDATE()) and MONTH(data_devolucao) = MONTH(CURDATE()) ORDER BY data_devolucao DESC";
$rs_lavanderia = mysql_query($query_rs_lavanderia, $conexao) or die(mysql_error());
$row_rs_lavanderia = mysql_fetch_assoc($rs_lavanderia);
$totalRows_rs_lavanderia = mysql_num_rows($rs_lavanderia);

mysql_select_db($database_conexao, $conexao);
$query_rs_cliente = "SELECT * FROM tbl_cliente WHERE id is not null $sql ORDER BY id DESC limit 0,20";
$rs_cliente = mysql_query($query_rs_cliente, $conexao) or die(mysql_error());
$row_rs_cliente = mysql_fetch_assoc($rs_cliente);
$totalRows_rs_cliente = mysql_num_rows($rs_cliente);

mysql_select_db($database_conexao, $conexao);
$query_rs_pendencias = "SELECT * FROM tbl_item WHERE id is not null and pendencias <> '' $sql ORDER BY id DESC limit 0,20";
$rs_pendencias = mysql_query($query_rs_pendencias, $conexao) or die(mysql_error());
$row_rs_pendencias = mysql_fetch_assoc($rs_pendencias);
$totalRows_rs_pendencias = mysql_num_rows($rs_pendencias);

?>
<!DOCTYPE>
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-BR">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home</title>
  <link rel="stylesheet" href="css/style.default.css" type="text/css" />
  <link rel="stylesheet" href="css/responsive-tables.css" />
  <style type="text/css">
    body,
    td,
    th {
      font-family: RobotoRegular, "Helvetica Neue", Helvetica, sans-serif;
    }
  </style>
  <script type="text/javascript" src="jquery.js"></script>
  <script type="text/javascript" src="load.js"></script>
  <? include('dialog-jquery/inc-abre-janela.php'); ?>

  <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
  <script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script>
  <script type="text/javascript" src="js/modernizr.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/jquery.cookie.js"></script>
  <script type="text/javascript" src="js/jquery.uniform.min.js"></script>
  <script type="text/javascript" src="js/flot/jquery.flot.min.js"></script>
  <script type="text/javascript" src="js/flot/jquery.flot.resize.min.js"></script>
  <script type="text/javascript" src="js/responsive-tables.js"></script>
  <script type="text/javascript" src="js/custom.js"></script>
  <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->

  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
</head>

<body>
  <?php //include_once('head.php');
  ?>
  <div class="mainwrapper">
    <?php include_once('header.php'); ?>
    <?php include_once('inc_coluna.php'); ?>
    <!-- leftpanel -->

    <div class="rightpanel">
      <ul class="breadcrumbs">
        <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
        <li>Home <span class="separator"></span></li>
      </ul>
      <div class="pageheader">
        <!--<form action="results.html" method="post" class="searchbar" />
      
      <input type="text" name="keyword" placeholder="To search type and hit enter..." />
      </form>-->
        <div class="pageicon"><span class="iconfa-laptop"></span></div>
        <div class="pagetitle">

          <h1>SISTEMA</h1>
        </div>
      </div>
      <!--pageheader-->

      <div class="maincontent">
        <div class="maincontentinner">
          <?php if ($totalRows_rs_fim_contrato > 0) { ?>
            <div class="row-fluid">
              <div id="dashboard-right" class="span12">
                <div class="divider15"></div>
                <div class="widgetbox">
                  <div class="headtitle">

                    <h4 class="widgettitle">Vencimento de Planos Cliente</h4>
                  </div>
                  <div class="widgetcontent">
                    <?php do {


                      mysql_select_db($database_conexao, $conexao);
                      $query_rs_planos = "SELECT * FROM tbl_plano WHERE id = '" . $row_rs_fim_contrato['id_plano'] . "'";
                      $rs_planos = mysql_query($query_rs_planos, $conexao) or die(mysql_error());
                      $row_rs_planos = mysql_fetch_assoc($rs_planos);
                      $totalRows_rs_planos = mysql_num_rows($rs_planos);
                    ?>
                      <li><a href="editar_cliente.php?id=<?php echo $row_rs_fim_contrato['id']; ?>" style="color:#000000; font-size: 14px;"><?php echo ($row_rs_fim_contrato['nome']); ?> - <?php echo ($row_rs_planos['nome']); ?> Vencimento: <?php echo formataData($row_rs_fim_contrato['data_vencimento']); ?></a></li>
                    <?php } while ($row_rs_fim_contrato = mysql_fetch_assoc($rs_fim_contrato)); ?>
                  </div>
                </div>

              </div>
            </div>
          <?php } ?>
          <div class="row-fluid">
            <div id="dashboard-right" class="span12">
              <div class="divider15"></div>
              <div class="widgetbox">
                <div class="headtitle">

                  <h4 class="widgettitle">Pe&ccedil;as Reservadas</h4>
                </div>
                <div class="widgetcontent">
                  <?php do { ?>
                    <li><a href="editar_produto.php?id=<?php echo $row_rs_reservas['codigo']; ?>" style="color:#000000; font-size: 14px;">
                        Data da reserva: <?php echo formataData($row_rs_reservas['data']); ?>
                        - <?php echo $row_rs_reservas['codigo']; ?> - <?php echo $row_rs_reservas['nome']; ?> - Cor: <?php echo ($row_rs_reservas['cor']); ?> - Tamanho: <?php echo $row_rs_reservas['numeracao']; ?>
                      </a>
                    </li>
                  <?php } while ($row_rs_reservas = mysql_fetch_assoc($rs_reservas)); ?>
                </div>
              </div>

            </div>
          </div>

          <div class="row-fluid">
            <div id="dashboard-right" class="span12">
              <div class="divider15"></div>
              <div class="widgetbox">
                <div class="headtitle">

                  <h4 class="widgettitle">Pe&ccedil;as Com Pend&ecirc;ncias</h4>
                </div>
                <div class="widgetcontent">

                  <?php do { ?>
                    <li><a href="editar_contrato.php?id=<?php echo $row_rs_pendencias['id_contrato']; ?>" style="color:#000000; font-size: 14px;">
                        Data de Devolu&ccedil;&atilde;o: <?php echo formataData($row_rs_pendencias['devolvido_em']); ?>
                        - N&ordm; do Contrato<?php echo $row_rs_pendencias['id_contrato']; ?> - Pend&ecirc;ncias: <?php if ($row_rs_pendencias['pendencias'] == 'pen') {
                                                                                                                    echo 'Nenhuma Pend�ncia';
                                                                                                                  } elseif ($row_rs_pendencias['pendencias'] == 'loja') {
                                                                                                                    echo 'Conserto - Loja';
                                                                                                                  } elseif ($row_rs_pendencias['pendencias'] == 'costureira') {
                                                                                                                    echo 'Conserto - Costureira';
                                                                                                                  } elseif ($row_rs_pendencias['pendencias'] == 'fornecedo') {
                                                                                                                    echo 'Conserto - Fornecedor';
                                                                                                                  } elseif ($row_rs_pendencias['pendencias'] == 'mancha') {
                                                                                                                    echo 'Mancha Lavanderia';
                                                                                                                  } elseif ($row_rs_pendencias['pendencias'] == 'dano') {
                                                                                                                    echo 'Dano Permanente';
                                                                                                                  }

                                                                                                                  ?>
                      </a>
                    </li>
                  <?php } while ($row_rs_pendencias = mysql_fetch_assoc($rs_pendencias)); ?>
                </div>
              </div>

            </div>
          </div>


          <div class="row-fluid">
            <div id="dashboard-right" class="span12">
              <div class="divider15"></div>
              <div class="widgetbox">
                <div class="headtitle">

                  <h4 class="widgettitle">&Uacute;ltimos Clientes Cadastrados</h4>
                </div>
                <div class="widgetcontent">
                  <?php
                  if ($totalRows_rs_cliente > 0) {
                    do {
                      if ($row_rs_cliente['id_plano'] <> '') {
                        mysql_select_db($database_conexao, $conexao);
                        $query_rs_plano = "SELECT * FROM tbl_plano WHERE id = '" . $row_rs_cliente['id_plano'] . "'";
                        $rs_plano = mysql_query($query_rs_plano, $conexao) or die(mysql_error());
                        $row_rs_plano = mysql_fetch_assoc($rs_plano);
                        $totalRows_rs_plano = mysql_num_rows($rs_plano);
                      }
                  ?>
                      <li><a href="editar_cliente.php?id=<?php echo $row_rs_cliente['id']; ?>" style="color:#000000; font-size: 14px;">
                          Nome: <?php echo ($row_rs_cliente['nome']); ?> - <?php echo formataData($row_rs_cliente['data_contratacao']); ?>

                        </a>
                      </li>
                  <?php  } while ($row_rs_cliente = mysql_fetch_assoc($rs_cliente));
                  } ?>
                </div>
              </div>

            </div>
          </div>

          <?php if ($totalRows_rs_aniversariantes > 0) { ?>
            <div class="row-fluid">
              <div id="dashboard-right" class="span12">
                <div class="divider15"></div>
                <div class="widgetbox">
                  <div class="headtitle">

                    <h4 class="widgettitle">Aniversariantes de Hoje</h4>
                  </div>
                  <div class="widgetcontent">
                    <?php do { ?>
                      <li><a href="editar_cliente.php?id=<?php echo $row_rs_aniversariantes['id']; ?>" style="color:#000000; font-size: 14px;"><?php echo $row_rs_aniversariantes['nome']; ?></a></li>
                    <?php } while ($row_rs_aniversariantes = mysql_fetch_assoc($rs_aniversariantes)); ?>
                  </div>
                </div>

              </div>
            </div>
          <?php } ?>
           <?php if($totalRows_rs_devolver_pecas > 0){?>
        <div class="row-fluid">
              <div id="dashboard-right" class="span12" >
            <div class="divider15"></div>
            <div class="widgetbox">
              <div class="headtitle">
               
                <h4 class="widgettitle">Devolu&ccedil;&otilde;es de pe&ccedil;as de Hoje</h4>
              </div>
              <div class="widgetcontent">
                  <?php do{
						mysql_select_db($database_conexao, $conexao);
						$query_rs_devolver_pecas_cliente = "SELECT * FROM tbl_cliente WHERE id = '".$row_rs_devolver_pecas['codigo_cliente']."'";
						$rs_devolver_pecas_cliente = mysql_query($query_rs_devolver_pecas_cliente, $conexao) or die(mysql_error());
						$row_rs_devolver_pecas_cliente = mysql_fetch_assoc($rs_devolver_pecas_cliente);
						$totalRows_rs_devolver_pecas_cliente = mysql_num_rows($rs_devolver_pecas_cliente);

                  ?>
                  <li>
					  <a style="color:#000000; font-size: 14px;">
						  <strong>Cliente: </strong>
						  <?php echo ($row_rs_devolver_pecas_cliente['nome']);
						  
	//print_r($row_rs_devolver_pecas);
						  
						  ?>
					  </a> - 
					  <a style="color:#000000; font-size: 14px;" href="editar_contrato.php?id=<?php echo $row_rs_devolver_pecas['id']?>">
						  <strong>VERIFICAR </strong>
					  </a>
				  </li>
                  <?php }while($row_rs_devolver_pecas = mysql_fetch_assoc($rs_devolver_pecas));?>
              </div>
            </div>
            
          </div>
        </div>
          <?php }?>

          <?/* <?php if ($totalRows_rs_lavanderia > 0) { ?>
            <div class="row-fluid">
              <div id="dashboard-right" class="span12">
                <div class="divider15"></div>
                <div class="widgetbox">
                  <div class="headtitle">
                    <h4 class="widgettitle">Devolu&ccedil;&otilde;es da Lavanderia</h4>
                  </div>
                  <div class="widgetcontent">
                    <?php do {
                      mysql_select_db($database_conexao, $conexao);
                      $query_rs_lavanderia_produto = "SELECT * FROM tbl_produto WHERE id = '" . $row_rs_lavanderia['id_produto'] . "'";
                      $rs_lavanderia_produto = mysql_query($query_rs_lavanderia_produto, $conexao) or die(mysql_error());
                      $row_rs_lavanderia_produto = mysql_fetch_assoc($rs_lavanderia_produto);
                      $totalRows_rs_lavanderia_produto = mysql_num_rows($rs_lavanderia_produto);

                    ?>
                      <li><a style="color:#000000; font-size: 14px;"><strong>Data: </strong><?php echo $row_rs_lavanderia['data_devolucao']; ?> - <strong>Pe&ccedil;a: </strong><?php echo $row_rs_lavanderia_produto['nome']; ?></a></li>
                    <?php } while ($row_rs_lavanderia = mysql_fetch_assoc($rs_lavanderia)); ?>
                  </div>
                </div>

              </div>
            </div>
          <?php } ?> */?>

          <?php if ($temAcessos[15] == 'S' or $temAcessos[14] == 'S') { ?>
            <div class="row-fluid">

              <?php if ($temAcessos[14] == 'S') { ?>
                <!--
          <div id="dashboard-right" class="span4" style="margin-left:0px;">
            <div class="divider15"></div>
            <div class="widgetbox">
              <div class="headtitle">
               
                <h4 class="widgettitle">A Pagar Hoje</h4>
              </div>
              <div class="widgetcontent" >
              <a <?php /*?>href="contas.php?dataInicio=<?=date('d/m/Y');?>&dataFim=<?=date('d/m/Y');?>&busca=&tipo=D"<?php */ ?> style="color:#C00003; font-size:30px; text-decoration:none;;">R$ <?= number_format($row_rs_contaPagar['total'], 2, ',', '.'); ?></a>
              </div>
              
            </div>
            
            
          </div>
-->
              <?php } ?>


              <?php if ($temAcessos[15] == 'S') { ?>
                <!--
          <div id="dashboard-right" class="span4">
            <div class="divider15"></div>
            <div class="widgetbox">
              <div class="headtitle">
               
                <h4 class="widgettitle">A Receber Hoje</h4>
              </div>
              
              <div class="widgetcontent" >
              <a <?php /*?>href="contas.php?dataInicio=<?=date('d/m/Y');?>&dataFim=<?=date('d/m/Y');?>&busca=&tipo=R"<?php */ ?> style="color:#006C09; font-size:30px; text-decoration:none;;">R$ <?= number_format($row_rs_contaReceber['total'], 2, ',', '.'); ?></a>
              </div>

            </div>
            
            
          </div>
-->
              <?php } ?>
            </div>
          <?php } ?>


          <div class="row-fluid">



            <div id="dashboard-right" class="span4">
              <div class="divider15"></div>
              <div class="widgetbox">
                <div class="headtitle">
                  <?php /*?><div class="btn-group">
                                <button data-toggle="dropdown" class="btn dropdown-toggle">Action <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                  <li><a href="#">Action</a></li>
                                  <li><a href="#">Another action</a></li>
                                  <li><a href="#">Something else here</a></li>
                                  <li class="divider"></li>
                                  <li><a href="#">Separated link</a></li>
                                </ul>
                            </div><?php */ ?>
                  <h4 class="widgettitle">Disponibilidade de Trajes</h4>
                </div>
                <div class="widgetcontent">
                  <form action="disponibilidade.php" method="get" id="formBusca">
                    <table width="100%" border="0">
                      <tbody>
                        <tr>
                          <td width="19%" align="right" style="padding-right:10px;  ">Produto:</td>
                          <td width="81%"><?php buscaGenericad('id_produto', 'id', '', 'Disponibilidade', 'nome', $javascript, 'tbl_produto', $concatCampos, $where); ?></td>
                        </tr>
                        <tr>
                          <td colspan="2" align="left" style="padding-top:10px;"><a href="javascript:;" onclick="document.getElementById('formBusca').submit();" class="btn btn-primary btn-mini"> <i class="icon-pencil"></i> &nbsp; Pesquisar Disponibilidade </a></td>
                        </tr>
                      </tbody>
                    </table>
                    <input type="hidden" name="dataEvento" value="<?= date('d/m/Y'); ?>">
                  </form>



                </div>
                <!--widgetcontent-->
              </div>
              <!--widgetbox-->

              <br />
            </div>

            <!--          <div id="dashboard-right" class="span4" >
            <div class="divider15"></div>
            <div class="widgetbox">
              <div class="headtitle">
               
                <h4 class="widgettitle">Sua Folha de Ponto</h4>
              </div>
              <div class="widgetcontent">
              	<li><a href="javascript:;" onClick="marcaPonto('chegada')" style="color:#000000;">Marcar Chegada</a></li>
                <li><a href="javascript:;" onClick="marcaPonto('sdAlmoco')" style="color:#000000;">Sa?da para Almo?o</a></li>
                <li><a href="javascript:;" onClick="marcaPonto('chAlmoco')" style="color:#000000;">Chegada do Almo?o </a></li>
                <li><a href="javascript:;" onClick="marcaPonto('saida')" style="color:#000000;">Marcar Sa?da</a></li>
              </div>
            </div>
            
          </div>-->


            <!--
          <div id="dashboard-right" class="span4" >
            <div class="divider15"></div>
            <div class="widgetbox">
              <div class="headtitle">
               
                <h4 class="widgettitle">Metas de <?= exibe_mes(date('m')); ?> de <?= date('Y'); ?></h4>
              </div>
              <div class="widgetcontent"> 
              	<li>Meta Geral da Loja: <strong><?= number_format($row_rs_metaLoja['meta'], 2, ',', '.'); ?></strong></li>
              	<li>Meta geral alcan�ada: <strong><?= number_format($row_rs_metaAlcLoja['total'], 2, ',', '.'); ?></strong></li>
                ------------
              	<li>Sua meta: <strong><?= number_format($_SESSION['dadosUser']['meta'], 2, ',', '.'); ?></strong></li>
              	<li>Meta alcan�ada: <strong><?= number_format($row_rs_metaAlcVendedor['total'], 2, ',', '.'); ?></strong></li>
              	<li>Faltando para alcan�ar: <strong><?= number_format($_SESSION['dadosUser']['meta'] - $row_rs_metaAlcVendedor['total'], 2, ',', '.'); ?></strong></li>
              </div>
              
            </div>
           
            
          </div>
-->







          </div>
          <!--row-fluid-->

          <?php include_once('footer.php'); ?>
          <?php
          mysql_free_result($rs_usuario);
          ?>