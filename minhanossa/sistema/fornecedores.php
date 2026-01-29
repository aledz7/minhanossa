<?php
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');
include('class/html.php');
$HTML = new HTML;

$currentPage = basename(__FILE__);


if ($_GET['buscaLogin'] <> '') {
  $sql = "and login LIKE '%" . $_GET['buscaLogin'] . "%'";
}
if ($_GET['buscaNome'] <> '') {
  $sql .= "and nome LIKE '%" . $_GET['buscaNome'] . "%'";
}
if ($_GET['buscaEmail'] <> '') {
  $sql .= "and email LIKE '%" . $_GET['buscaEmail'] . "%'";
}
if ($_GET['buscaStatus'] <> '') {
  $sql .= "and status = '%" . $_GET['buscaStatus'] . "%'";
}

if ($_GET['status'] <> '') {
  $sql_status .= " and tbl_fornecedores.status = '" . $_GET['status'] . "'";
} else {
  $sql_status .= "and (tbl_fornecedores.status = 'A' OR tbl_fornecedores.status = 'I') ";
}

mysql_select_db($database_conexao, $conexao);
$query_rs_fornecedores = "SELECT * FROM tbl_fornecedores WHERE id IS NOT NULL  $sql $sql_status ORDER BY nome ASC";
$rs_fornecedores = mysql_query($query_rs_fornecedores, $conexao) or die(mysql_error());
$row_rs_fornecedores = mysql_fetch_assoc($rs_fornecedores);
$totalRows_rs_fornecedores = mysql_num_rows($rs_fornecedores);
?>
<!DOCTYPE html>
<html>

<head>

  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro > Fornecedores</title>

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
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
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
        <li><a href="fornecedores.php">Cadastro</a></li>

      </ul>
      <div class="pageheader">

        <a href="add-fornecedores.php" class="btn btn-primary btn-mini searchbar"> <i class="icon-plus"></i> &nbsp; Novo</a>

        <!--<form action="results.html" method="post" class="searchbar" />
                <input type="text" name="keyword" placeholder="To search type and hit enter..." />
            </form>-->
        <div class="pageicon"><span class="iconfa-edit"></span></div>
        <div class="pagetitle">
          <h5>Cadastro</h5>
          <h1>Fornecedores</h1>
        </div>



      </div>
      <!--pageheader-->
      <div class="maincontent">
        <div class="maincontentinner">
          <div class="widget">
            <h4 class="widgettitle"><span class="iconfa-edit"></span>Fornecedores</h4>
            <div class="widgetcontent">

              <div class="divider30"></div>
              <?php if ($totalRows_rs_fornecedores > 0) { ?>
                <table class="table table-bordered">

                  <tbody>

                    <tr>
                      <td><strong>C&oacute;digo</strong></td>
                      <td><strong>Nome</strong></td>
                      <td><strong>CPF</strong></td>
                      <td><strong>RG</strong></td>
                      <td><strong>Telefone 1</strong></td>
                      <td>Telefone 2</td>
                      <td>Status</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>

                    <?php
                    if ($totalRows_rs_fornecedores > 0) {
                      do { ?>
                        <tr>
                          <td><?php echo $row_rs_fornecedores['id']; ?></td>
                          <td><?php echo utf8_decode($row_rs_fornecedores['nome']); ?></td>
                          <td><?php echo $row_rs_fornecedores['cpf']; ?></td>
                          <td><?php echo utf8_decode($row_rs_fornecedores['rg']); ?></td>
                          <td><?php echo utf8_decode($row_rs_fornecedores['telefone1']); ?></td>
                          <td><?php echo utf8_decode($row_rs_fornecedores['telefone2']); ?></td>
                          <td> <?php
                                if ($row_rs_fornecedores['status'] == 'A' || $row_rs_fornecedores['status'] == '') {
                                ?>
                              <a href="desativar-marca.php?id=<?php echo $row_rs_fornecedores['id']; ?>" class="btn btn-danger btn-mini" style="font-size:10px; margin-left:7px;"> <i class="iconfa-remove"></i> Desativar
                              </a>

                            <? } elseif ($row_rs_fornecedores['status'] == 'I') { ?>
                              <a href="reativar-marca.php?id=<?php echo $row_rs_fornecedores['id']; ?>" class="btn btn-success btn-mini" style="font-size:10px; margin-left:7px;"> <i class="iconfa-check"></i> Ativar
                              </a>
                            <? } ?>
                          </td>
                          <td class="centeralign">
                            <a href="editar-fornecedores.php?id=<?php echo $row_rs_fornecedores['id']; ?>" class="btn btn-primary btn-mini"> <i class="icon-pencil"></i> &nbsp; Editar

                            </a>
                          </td>
                          <td>
                            <a href="sql_excluir.php?id=<?php echo $row_rs_fornecedores['id']; ?>&acao=excluirFornecedor" class="btn btn-danger btn-mini"> <i class="iconfa-remove"></i> Excluir
                            </a>
                          </td>
                        </tr>
                    <?php } while ($row_rs_fornecedores = mysql_fetch_assoc($rs_fornecedores));
                    }
                    ?>

                  </tbody>
                </table>
              <?
              } else {
                $HTML->nenhumRegistro();
              } ?>
            </div>
            <!--widgetcontent-<?php
                              mysql_free_result($rs_fornecedores);
                              ?>->
            </div><!--widget-->
            <?php include_once('footer.php'); ?>