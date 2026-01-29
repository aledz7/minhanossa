<?php
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

include('class/html.php');
$HTML = new HTML;

$currentPage = 'produto.php';

$start = 0;
$limit = 30;

if ($_GET['numeroPag'] > 0) {
  $numeroPag = $_GET['numeroPag'];
} else {
  $numeroPag = 1;
}
//echo ($numeroPag-1);
$start = ($numeroPag - 1) * $limit;
/*if($_GET['busca'] <> ''){
	$sql = " ";
}*/

if ($_GET['id_fornecedor'] <> '') {
  $sql .= " and tbl_produto.id_fornecedor = '" . $_GET['id_fornecedor'] . "'";
}

if ($_GET['tamanho'] <> '') {
  $sql .= " and tbl_produto.numeracao = '" . $_GET['tamanho'] . "'";
}

if ($_GET['categoria'] <> '') {
  $sql .= " and tbl_produto.categoria = '" . $_GET['categoria'] . "'";
}

$sql .= " limit $start, $limit";

if ($_GET['status'] <> '') {
  $sql_status .= " and tbl_produto.status = '" . $_GET['status'] . "'";
} else {
$sql_status .= "and (tbl_produto.status = 'A')";
}

mysql_select_db($database_conexao, $conexao);
$query_rs_produto = "SELECT tbl_produto.*, tbl_categoria.categoria FROM tbl_produto left join tbl_categoria on tbl_produto.categoria = tbl_categoria.id WHERE tbl_produto.id is not null and (tbl_produto.nome LIKE '%" . ($_GET['busca']) . "%' OR tbl_produto.id LIKE '$_GET[busca]') $sql_status $sql";
$rs_produto = mysql_query($query_rs_produto, $conexao) or die(mysql_error());
$row_rs_produto = mysql_fetch_assoc($rs_produto);
$totalRows_rs_produto = mysql_num_rows($rs_produto);

//exit;

mysql_select_db($database_conexao, $conexao);
$query_rs_fornecedor = "SELECT * FROM tbl_fornecedores ORDER BY nome ASC";
$rs_fornecedor = mysql_query($query_rs_fornecedor, $conexao) or die(mysql_error());
$row_rs_fornecedor = mysql_fetch_assoc($rs_fornecedor);
$totalRows_rs_fornecedor = mysql_num_rows($rs_fornecedor);




/*}elseif($_GET['busca'] == '' and $_GET['tamanho'] <> ''){
mysql_select_db($database_conexao, $conexao);
$query_rs_produto = "SELECT tbl_produto.*, tbl_categoria.categoria FROM tbl_produto left join tbl_categoria on tbl_produto.categoria = tbl_categoria.id WHERE tbl_produto.id is not null $sql";
$rs_produto = mysql_query($query_rs_produto, $conexao) or die(mysql_error());
$row_rs_produto = mysql_fetch_assoc($rs_produto);
$totalRows_rs_produto = mysql_num_rows($rs_produto);	
	
}else{
	//LIMIT $start, $limit
mysql_select_db($database_conexao, $conexao);
$query_rs_produto = "SELECT tbl_produto.*, tbl_categoria.categoria FROM tbl_produto left join tbl_categoria on tbl_produto.categoria = tbl_categoria.id WHERE tbl_produto.id is not null $sql ";
$rs_produto = mysql_query($query_rs_produto, $conexao) or die(mysql_error());
$row_rs_produto = mysql_fetch_assoc($rs_produto);
$totalRows_rs_produto = mysql_num_rows($rs_produto);	
}*/
mysql_select_db($database_conexao, $conexao);
$query_rs_totalRegistros = "SELECT count(1) as total FROM tbl_produto left join tbl_categoria on tbl_produto.categoria = tbl_categoria.id WHERE tbl_produto.status = 'A' OR tbl_produto.status IS NULL OR tbl_produto.status = '' ";
$rs_totalRegistros = mysql_query($query_rs_totalRegistros, $conexao) or die(mysql_error());
$row_rs_totalRegistros = mysql_fetch_assoc($rs_totalRegistros);

mysql_select_db($database_conexao, $conexao);
$query_rs_categoria = "SELECT * FROM tbl_categoria ORDER BY categoria ASC";
$rs_categoria = mysql_query($query_rs_categoria, $conexao) or die(mysql_error());
$row_rs_categoria = mysql_fetch_assoc($rs_categoria);
$totalRows_rs_categoria = mysql_num_rows($rs_categoria);

mysql_select_db($database_conexao, $conexao);
$query_rs_status = "
SELECT DISTINCT status FROM tbl_produto WHERE status IS NOT NULL AND status != ''ORDER BY status";
$rs_status = mysql_query($query_rs_status, $conexao) or die(mysql_error());
$row_rs_status = mysql_fetch_assoc($rs_status);
$totalRows_rs_status = mysql_num_rows($rs_status);

?>
<!DOCTYPE html>
<html>

<head>

  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro > Produtos</title>

  <link rel="stylesheet" href="css/style.default.css" type="text/css" />
  <link rel="stylesheet" href="css/bootstrap-fileupload.min.css" type="text/css" />
  <link rel="stylesheet" href="css/bootstrap-timepicker.min.css" type="text/css" />

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
  <style type="text/css">
    body,
    td,
    th {
      font-family: RobotoRegular, "Helvetica Neue", Helvetica, sans-serif;
    }
  </style>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
  <?php //include_once('head.php');
  ?>

  <div class="mainwrapper">
    <?php include_once('header.php'); ?>
    <?php include_once('inc_coluna.php'); ?>
    <div class="rightpanel">
      <ul class="breadcrumbs">
        <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
        <li><a href="produto.php">Produtos</a></li>

      </ul>
      <div class="pageheader">

        <a href="add_produto.php" class="btn btn-primary btn-mini searchbar"> <i class="icon-plus"></i> &nbsp; Novo</a>

        <div class="pageicon"><span class="iconfa-edit"></span></div>
        <div class="pagetitle">
          <h5>Cadastro</h5>
          <h1>Produtos</h1>
        </div>



      </div>
      <!--pageheader-->
      <div class="maincontent">
        <div class="maincontentinner">
          <div class="widget">
            <h4 class="widgettitle"><span class="iconfa-edit"></span>Produtos</h4>
            <div class="widgetcontent">

              <div class="divider30"></div>
              <div class="mediamgr_head">
                <form method="get" enctype="application/x-www-form-urlencoded" id="formProvas">
                  <ul class="mediamgr_menu">
                    <li class="filesearch">
                      <div class="input-prepend">
                        <span class="add-on">Buscar</span>
                        <input id="busca" value="<?= $_GET['busca']; ?>" style="padding:5px;" type="text" name="busca" class="input-large" />
                      </div>
                    </li>

                    <li class="filesearch" style="margin-left: 10px;">
                      <div class="input-prepend">
                        <span class="add-on">Tamanho</span>
                        <select name="tamanho" id="tamanho" class="input-large" style="height: 32px;">
                          <option value="">SELECIONE</option>
                          <?php for ($i = 36; $i <= 54; $i += 2) { ?>
                            <option value="<?php echo $i; ?>" <?php if ($i == $_GET['tamanho']) {
                                                                echo 'selected';
                                                              } ?>><?php echo $i; ?></option>
                          <?php } ?>



                          <option value="PP">PP</option>
                          <option value="P">P</option>
                          <option value="M">M</option>
                          <option value="G">G</option>
                          <option value="GG">GG</option>
                        </select>
                      </div>
                    </li>

                    <li class="filesearch" style="margin-left: 10px;">
                      <div class="input-prepend">
                        <span class="add-on">Categoria</span>
                        <select name="categoria" id="categoria" class="input-large" style="height: 32px;">
                          <option value="">SELECIONE</option>
                          <?php do { ?>
                            <option value="<?php echo $row_rs_categoria['id']; ?>" <?php if ($row_rs_categoria['id'] == $_GET['categoria']) {
                                                                                      echo 'selected';
                                                                                    } ?>><?php echo $row_rs_categoria['categoria']; ?></option>
                          <?php } while ($row_rs_categoria = mysql_fetch_assoc($rs_categoria)); ?>

                        </select>


                      </div>
                    </li>
                    
                    <li class="filesearch" style="margin-left: 10px;">
                      <div class="input-prepend">
                        <span class="add-on">Status</span>
                        <select name="status" id="status" class="input-large" style="height: 32px;">
                          <option value="">SELECIONE</option>
                          <option value="A" <?php if (isset($_GET['status']) && $_GET['status'] === 'A' && $_GET['status'] === '') echo 'selected'; ?>>Ativo</option>
                          <option value="I" <?php if (isset($_GET['status']) && $_GET['status'] === 'I') echo 'selected'; ?>>Inativo</option>
                        </select>
                      </div>
                    </li>



                    <li class="filesearch">
                      <div class="input-prepend">
                        <span class="add-on">Marcas</span>

                        <select name="id_fornecedor" id="id_fornecedor" class="input-large">
                          <option value=""></option>
                          <?php do { ?>
                            <option value="<?= $row_rs_fornecedor['id']; ?>" <?php if ($row_rs_fornecedor['id'] == $_GET['id_fornecedor']) {
                                                                                echo 'selected';
                                                                              } ?>><?= utf8_decode($row_rs_fornecedor['nome']); ?></option>
                          <? } while ($row_rs_fornecedor = mysql_fetch_assoc($rs_fornecedor)); ?>
                        </select>

                      </div>
                    </li>


                    <li class="left newfilebtn"><a href="javascript:;" onClick="document.getElementById('formProvas').submit()" class="btn btn-primary" style="padding:4px; margin-left:10px;">Pesquisar</a></li>
                    <li class="left newfilebtn"><a href="produto.php" class="btn btn-success" style="padding:4px; margin-left:10px;">MOSTRAR TODOS</a></li>
                  </ul>
                </form>
                <span class="clearall"></span>
              </div>
              <?php if ($totalRows_rs_produto > 0) {

              ?>
                <table width="98%" class="table table-bordered">
                  <tr>
                    <td colspan="8">
                      Foram encontrados <?php echo $row_rs_totalRegistros['total']; ?> pe&ccedil;as.
                    </td>
                  </tr>
                  <tbody>

                    <tr>
                      <td width="6%" style="text-align:center"><strong>C&oacute;digo</strong></td>
                      <td width="17%"><strong>Nome</strong></td>
                      <td width="14%" style="text-align:center"><strong>Valor de aluguel</strong></td>
                      <td width="9%" style="text-align:center"><strong>Tamanho</strong></td>
                      <td width="9%" style="text-align:center"><strong>Estoque</strong></td>
                      <td width="11%" style="text-align:center"><strong>Cor</strong></td>
                      <td width="7%">Valor de venda</td>
                      <!--<td>Locaï¿½ï¿½es</td>-->
                      <td width="27%">&nbsp;</td>
                    </tr>

                    <?php
                    if ($_GET['busca'] == '' or $_GET['categoria'] == '') {
                      if ($totalRows_rs_produto > 0) {
                        do {
                          $idProduto = $row_rs_produto['id'];
                          $nome = $row_rs_produto['nome'];
                          $valor_aluguel = $row_rs_produto['valor_aluguel'];
                          $tamanho = $row_rs_produto['numeracao'];
                          $qnt_estoque = $row_rs_produto['qnt_estoque'];
                          $valor_venda = $row_rs_produto['valor_venda'];

                          $query_rs_cores = "SELECT * FROM tbl_cores WHERE id = '" . $row_rs_produto['id_cor'] . "'";
                          $rs_cores = mysql_query($query_rs_cores, $conexao) or die(mysql_error());
                          $row_rs_cores = mysql_fetch_assoc($rs_cores);
                          $totalRows_rs_cores = mysql_num_rows($rs_cores);

                    ?>
                          <tr>
                            <td style="text-align:center"><?php echo $idProduto; ?></td>
                            <td><?php echo $nome; ?></td>
                            <td style="text-align:center">R$<?php echo number_format($valor_aluguel, 2, ',', '.'); ?></td>
                            <td style="text-align:center"><?php echo $tamanho; ?></td>
                            <td style="text-align:center"><?php echo $qnt_estoque; ?></td>
                            <td style="text-align:center"><?php echo ($row_rs_cores['nome']); ?></td>
                            <td style="text-align:center">R$<?php echo number_format($valor_venda, 2, ',', '.'); ?></td>
                            <?php /*?> <td class="centeralign">
                    <a href="editar_cliente.php?id=<?php echo $row_rs_produto['id'];?>"class="btn btn-primary btn-mini" style="font-size:10px;"> <i class="icon-search"></i> &nbsp; Locaï¿½ï¿½es
                    
                    </a>
                </td><?php */ ?>
                            <td class="centeralign">
                              <a href="editar_produto.php?id=<?php echo $row_rs_produto['id']; ?>" class="btn btn-primary btn-mini" style="font-size:10px;"> <i class="icon-pencil"></i> &nbsp; Editar

                              </a>

                              <a href="disponibilidade.php?id=<?php echo $row_rs_produto['id']; ?>" class="btn btn-primary btn-mini" style="font-size:10px; margin-left:7px;"> <i class="icon-pencil"></i> &nbsp; Disponibilidade

                              </a>
                              <?php
                              if ($row_rs_produto['status'] == 'A' || $row_rs_produto['status'] == '') {
                              ?>
                                <a href="desativar-produto.php?id=<?php echo $row_rs_produto['id']; ?>" class="btn btn-danger btn-mini" style="font-size:10px; margin-left:7px;"> <i class="iconfa-remove"></i> &nbsp; Desativar</a>

                              <?php } elseif ($row_rs_produto['status'] == 'I') { ?>

                                <a href="reativar-produto.php?id=<?php echo $row_rs_produto['id']; ?>" class="btn btn-success btn-mini" style="font-size:10px; margin-left:7px;"> <i class="iconfa-check"></i> &nbsp; Ativar</a>
                              <?php } ?>


                              <a href="sql_excluir.php?id=<?php echo $row_rs_produto['id']; ?>&acao=excluirProduto" class="btn btn-danger btn-mini" style="font-size:10px; margin-left:7px;"> <i class="iconfa-remove"></i> Excluir
                              </a>
                            </td>
                          </tr>
                    <?php } while ($row_rs_produto = mysql_fetch_assoc($rs_produto));
                      }
                    }
                    ?>

                  </tbody>
                </table>
              <?
              } else {
                $HTML->nenhumRegistro();
              } ?>


              <?php if ($_GET['busca'] == '' and $_GET['tamanho'] == '') { ?>
                <nav>
                  <?
                  $total = ceil($row_rs_totalRegistros['total'] / $limit);
                  ?>
                  <style>
                    .pagination li a {
                      color: #000000;
                    }

                    .pagination li {
                      float: left;
                      margin-left: 15px;
                      list-style: none;
                    }
                  </style>
                  <ul class="pagination category-pagination pull-right" style="margin-top:25px;">
                    <?php

                    for ($i = 1; $i <= $total; $i++) { ?>
                      <? if ($i == $numeroPag) { ?>
                        <li class="active">
                          <a href="?numeroPag=<? echo $i ?>"><? echo $i ?></a>
                        </li>
                      <? } else { ?>
                        <li>
                          <a href="?numeroPag=<? echo $i ?>"><? echo $i ?></a>
                        </li>
                      <? } ?>
                    <? } ?>
                    <? if ($numeroPag != $total) { ?>
                      <li class="last">
                        <a href="?numeroPag=<? echo $_GET['numeroPag'] + 1; ?>"><i class="fa fa-long-arrow-right"></i></a>
                      </li>
                    <? } ?>
                  </ul>
                </nav>

              <?php } ?>
            </div>
            <!--widgetcontent-<?php
                              mysql_free_result($rs_produto);
                              ?>->
            </div>widget-->
            <?php include_once('footer.php'); ?>