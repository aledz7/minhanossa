<?php
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

include('class/html.php');
$HTML = new HTML;

$currentPage = 'retiradas.php';

mysql_select_db($database_conexao, $conexao);
$query_rs_cliente = "SELECT * FROM tbl_cliente where id = '{$_GET['codigo_cliente']}'";
$rs_cliente = mysql_query($query_rs_cliente, $conexao) or die(mysql_error());
$row_rs_cliente = mysql_fetch_assoc($rs_cliente);
$totalRows_rs_cliente = mysql_num_rows($rs_cliente);

mysql_select_db($database_conexao, $conexao);
$query_rs_produtos = "SELECT tbl_produto.*, tbl_cores.nome as nome_cor FROM tbl_produto left join tbl_cores on tbl_produto.id_cor = tbl_cores.id order by tbl_produto.nome asc";
$rs_produtos = mysql_query($query_rs_produtos, $conexao) or die(mysql_error());
$row_rs_produtos = mysql_fetch_assoc($rs_produtos);
$totalRows_rs_produtos = mysql_num_rows($rs_produtos);

if ($_GET['dataInicio'] <> '') {
  $sql .= "and data_retirada >= '" . formataDataSQL($_GET['dataInicio']) . "'";
}

if ($_GET['dataFim'] <> '') {
  $sql .= "and data_retirada <= '" . formataDataSQL($_GET['dataFim']) . "'";
}

if ($_GET['id_cliente'] <> '') {
  $sql .= "and tbl_contrato.codigo_cliente = '" . $_GET['id_cliente'] . "'";
}

if ($_GET['id_produto'] <> '') {
  $sql .= "and tbl_item.nome_produto = '" . $_GET['id_produto'] . "'";
}

$maxRows_rs_provas = 100;
$pageNum_rs_provas = 0;
if (isset($_GET['pageNum_rs_provas'])) {
  $pageNum_rs_provas = $_GET['pageNum_rs_provas'];
}
$startRow_rs_provas = $pageNum_rs_provas * $maxRows_rs_provas;

$colname_rs_provas = "-1";
if (isset($_GET['cat'])) {
  $colname_rs_provas = $_GET['cat'];
}

mysql_select_db($database_conexao, $conexao);

$query_rs_provas = "
SELECT
	tbl_item.*,
	tbl_produto.nome as nomeProduto
FROM
	tbl_item
	inner join tbl_contrato on tbl_item.id_contrato = tbl_contrato.id
	left join tbl_produto on tbl_item.nome_produto = tbl_produto.id
where 
	1=1 $sql
ORDER BY 
	data_retirada ASC";

$query_limit_rs_provas = sprintf("%s LIMIT %d, %d", $query_rs_provas, $startRow_rs_provas, $maxRows_rs_provas);
$rs_provas = mysql_query($query_limit_rs_provas, $conexao) or die(mysql_error());
$row_rs_provas = mysql_fetch_assoc($rs_provas);

if (isset($_GET['totalRows_rs_provas'])) {
  $totalRows_rs_provas = $_GET['totalRows_rs_provas'];
} else {
  $all_rs_provas = mysql_query($query_rs_provas);
  $totalRows_rs_provas = mysql_num_rows($all_rs_provas);
}
$totalPages_rs_provas = ceil($totalRows_rs_provas / $maxRows_rs_provas) - 1;

$queryString_rs_provas = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (
      stristr($param, "pageNum_rs_provas") == false &&
      stristr($param, "totalRows_rs_provas") == false
    ) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rs_provas = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rs_provas = sprintf("&totalRows_rs_provas=%d%s", $totalRows_rs_provas, $queryString_rs_provas);


?>
<!DOCTYPE html>
<html>

<head>

  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Agenda > <?php echo  $_GET['tipo']; ?></title>

  <link rel="stylesheet" href="css/style.default.css" type="text/css" />
  <link rel="stylesheet" href="css/bootstrap-fileupload.min.css" type="text/css" />
  <link rel="stylesheet" href="css/bootstrap-timepicker.min.css" type="text/css" />

  <script type="text/javascript" src="jquery.js"></script>
  <script type="text/javascript" src="load.js"></script>
  <?php include('dialog-jquery/inc-abre-janela.php'); ?>

  <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
  <script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/bootstrap-fileupload.min.js"></script>
  <script type="text/javascript" src="js/bootstrap-timepicker.min.js"></script>
  <script type="text/javascript" src="js/jquery.uniform.min.js"></script>
  <script type="text/javascript" src="js/jquery.validate.min.js"></script>
  <script type="text/javascript" src="js/jquery.tagsinput.min.js"></script>
  <script type="text/javascript" src="js/jquery.autogrow-textarea.js"></script>
  <script type="text/javascript" src="js/charCount.js"></script>
  <script type="text/javascript" src="js/ui.spinner.min.js"></script>
  <script type="text/javascript" src="js/chosen.jquery.min.js"></script>
  <script type="text/javascript" src="js/jquery.cookie.js"></script>
  <script type="text/javascript" src="js/modernizr.min.js"></script>
  <script type="text/javascript" src="js/responsive-tables.js"></script>
  <script type="text/javascript" src="js/custom.js"></script>
  <script type="text/javascript" src="js/forms.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
</head>
<style>
  .input-append .add-on,
  .input-prepend .add-on {
    display: inline-block;
    width: auto;
    height: 20px;
    min-width: 16px;
    padding: 4px 5px;
    font-size: 14px;
    font-weight: normal;
    line-height: 20px;
    text-align: center;
    text-shadow: 0 1px 0 #ffffff;
    background-color: #eeeeee;
    border: 1px solid #ccc;
  }
</style>

<body>
  <?php //include_once('head.php');
  ?>

  <div class="mainwrapper">
    <?php include_once('header.php'); ?>
    <?php include_once('inc_coluna.php'); ?>
    <div class="rightpanel">
      <ul class="breadcrumbs">
        <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
        <li><a href="provas.php"><?php echo  $_GET['tipo']; ?></a></li>

      </ul>
      <div class="pageheader">

        <a href="add_contrato.php" class="btn btn-primary btn-mini searchbar"> <i class="icon-plus"></i> &nbsp; Novo</a>

        <div class="pageicon"><span class="iconfa-edit"></span></div>
        <div class="pagetitle">
          <h5>Agenda</h5>
          <h1><?php echo  $_GET['tipo']; ?></h1>
        </div>



      </div>
      <!--pageheader-->
      <div class="maincontent">
        <div class="maincontentinner">
          <div class="widget">
            <h4 class="widgettitle"><span class="icon-calendar"></span>Agenda de <?php echo  $_GET['tipo']; ?></h4>
            <div class="widgetcontent">


              <div class="mediamgr_head">
                <form method="get" enctype="application/x-www-form-urlencoded" id="formProvas">
                  <ul class="mediamgr_menu">
                    <li class="filesearch">
                      <?php /*?>    		  <div class="input-prepend">
                                      <span class="add-on">Data de In&iacute;cio</span>
                                      <input id="dataInicio" type="text" name="dataInicio" class="input-small datepicker" style="padding:4px;" value="<?php echo $_GET['dataInicio'];?>" />                                    </div>
                                   
                                   
                                      <div class="input-prepend">
                                      <span class="add-on">Data Final</span>
                                      <input id="dataFim" value="<?php echo $_GET['dataFim'];?>" style="padding:4px;" type="text" name="dataFim" class="input-small datepicker" />                                    
								   </div>
								
								
                                      <div class="input-prepend">
										  <span class="add-on">Produtos</span>
                                      <select name="id_produto" id="id_produto">
                                      	<option value=""></option>
										<?php do { ?>
                                        	<option value="<?php echo $row_rs_produtos['id'];?>" <?php if($row_rs_produtos['id'] == $_GET['id_produto']) { echo 'selected'; } ?>><?php echo utf8_decode($row_rs_produtos['nome']);?> (Tam.: <?php echo $row_rs_produtos['numeracao'];?> - Cor: <?php echo utf8_decode($row_rs_produtos['nome_cor']);?>)</option>
                                        <?php } while($row_rs_produtos = mysql_fetch_assoc($rs_produtos)); ?>
                                      </select>
									</div><?php */ ?>



                      <div class="input-prepend">
                        <span class="add-on">C&oacute;digo do Produto</span>
                      </div>

                      <style>
                        #id_produto {
                          height: 22px;
                          margin-top: 2px;
                          margin-left: -2px;
                          border-left: none;
                        }
                      </style>
                      <?php $_GET['label'] = $row_rs_produtos['id'];
                      $_GET['idAtual'] = $_GET['id_produto'];
                      buscaGenericad('id_produto', 'id', '', 'Clientes', 'nome', $javascript, 'tbl_produto', $concatCampos, $where); ?>

                      <div class="input-prepend">
                        <span class="add-on">Cliente</span>
                      </div>

                      <style>
                        #id_cliente {
                          height: 22px;
                          margin-top: 2px;
                          margin-left: -2px;
                          border-left: none;
                        }
                      </style>
                      <?php $_GET['label'] = $row_rs_cliente['nome'];
                      $_GET['idAtual'] = $_GET['id_cliente'];
                      buscaGenericad('id_cliente', 'id', '', 'Clientes', 'nome', $javascript, 'tbl_cliente', $concatCampos, $where); ?>
                    </li>
                    <li class="left newfilebtn">
                      <a href="javascript:;" onClick="document.getElementById('formProvas').submit()" class="btn btn-primary" style="padding: 6px;margin-left: 88px; margin-top: 0px;">Pesquisar</a>
                    </li>
                  </ul>
                  <input type="hidden" name="tipo" value="<?php echo  $_GET['tipo']; ?>">
                </form>
                <span class="clearall"></span>
              </div>
              <?php if ($totalRows_rs_provas > 0) { ?>
                <table width="100%" class="table table-bordered">

                  <tbody>

                    <tr>
                      <td width="31%"><strong>Cliente</strong></td>
                      <td width="27%"><strong>Nome do Produto</strong></td>
                      <td width="5%" style="text-align:center"><strong>QTD</strong></td>
                      <td width="13%"><strong>Retirada</strong></td>
                      <td width="12%"><strong>Devolvido em:</strong></td>
                      <td style="text-align:center"><strong>Op&ccedil;&otilde;es</strong></td>

                    </tr>

                    <?php
                    if ($totalRows_rs_provas > 0) {
                      do {
                        mysql_select_db($database_conexao, $conexao);
                        $query_rs_nome_cliente = "SELECT * FROM tbl_cliente WHERE id = '" . $row_rs_provas['id_cliente'] . "'";
                        $rs_nome_cliente = mysql_query($query_rs_nome_cliente, $conexao) or die(mysql_error());
                        $row_rs_nome_cliente = mysql_fetch_assoc($rs_nome_cliente);
                        $totalRows_rs_nome_cliente = mysql_num_rows($rs_nome_cliente);
                    ?>
                        <tr>
                          <td><?php echo $row_rs_nome_cliente['nome']; ?></td>
                          <td><?php echo utf8_decode($row_rs_provas['nomeProduto']); ?></td>
                          <td style="text-align:center"><?php echo $row_rs_provas['quantidade_produto']; ?></td>

                          <td><?php echo formataData($row_rs_provas['data_retirada']); ?></td>

                          <td><?php echo formataData($row_rs_provas['data_devolucao']); ?></td>

                          <td width="12%" style="text-align:center"><a href="editar_contrato.php?id=<?php echo $row_rs_provas['id_contrato']; ?>" class="btn btn-primary btn-mini"> <i class="icon-pencil"></i> &nbsp; Visualizar

                            </a></td>


                        </tr>
                    <?php } while ($row_rs_provas = mysql_fetch_assoc($rs_provas));
                    }
                    ?>

                  </tbody>
                </table>
              <?php
              } else {
                $HTML->nenhumRegistro();
              }
              ?>

              <table border="0">
                <tr>
                  <td>
                    <div>
                      <?php if ($totalRows_rs_provas > $qtd_produtos) { ?>
                        <table border="0" cellpadding="0" cellspacing="0" class="texto_menus">
                          <tr>
                            <td>
                              <span class="BuscaTexto1">P&aacute;ginas de resultados:</span><span class="texto1 style1">
                                <?php
                                $pag = $_GET['pageNum_rs_provas'];

                                $totalPages_rs_provas++;
                                for ($i = 0; $i < $totalPages_rs_provas; $i = $i + 1) {
                                  $a = $a + 1;
                                  if ($n == $i) {
                                    echo "<A href=?pageNum_rs_provas=" . $_GET['pageNum_rs_provas='] . '0' . "&totalRows_rs_provas=" . $totalRows_rs_provas . "&tipo=" . $_GET['tipo'] . "&dataInicio=" . $_GET['dataInicio'] . "&dataFim=" . $_GET['dataFim'] . "&id_produto=" . $_GET['id_produto'] . "&id_cliente=" . $_GET['id_cliente'] . " style='color:rgba(0,0,0,1.00)'><B>" . $a . "</B></A><strong>&nbsp;&nbsp;| </strong>";
                                  } else {
                                    $p = $a - 1;

                                    if ($pag == $p) {
                                      $estilo = "style='color:#CC0000'";
                                    } else {
                                      $estilo = "style='color:rgba(0,0,0,1.00)'";
                                    }

                                    echo "<A href=?pageNum_rs_provas=" . $_GET['pageNum_rs_provas='] . $p . "&totalRows_rs_provas=" . $totalRows_rs_provas . "&tipo=" . $_GET['tipo'] . "&dataInicio=" . $_GET['dataInicio'] . "&dataFim=" . $_GET['dataFim'] . "&id_produto=" . $_GET['id_produto'] . "&id_cliente=" . $_GET['id_cliente'] . " {$estilo}><b> " . $a . " </b></A>&nbsp;|";
                                  }
                                }
                                $totalPages_rs_provas--;
                                ?>
                              </span>
                              <?php if ($pageNum_rs_provas < $totalPages_rs_provas) { // Show if not last page 
                              ?>
                                <a href="<?php printf("%s?pageNum_rs_provas=%d%s", $currentPage, min($totalPages_rs_provas, $pageNum_rs_provas + 1), $queryString_rs_provas); ?>" style="color:rgba(0,0,0,1.00)">AVAN&Ccedil;AR</a>
                              <?php } // Show if not last page 
                              ?>
                            </td>
                          </tr>
                        </table>
                      <?php } ?>
                    </div>
                  </td>
                </tr>
              </table>

            </div>
            <!--widgetcontent-<?php
                              mysql_free_result($rs_cliente);
                              ?>->
            </div><!--widget-->
            <?php include_once('footer.php'); ?>