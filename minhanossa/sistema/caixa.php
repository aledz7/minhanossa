<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

$currentPage = 'usuario.php';

if($_GET['buscaLogin'] <> ''){
	$sql = "and login LIKE '%".$_GET['buscaLogin']."%'";
}

if($_GET['buscaNome'] <> ''){
	$sql .= "and nome LIKE '%".$_GET['buscaNome']."%'";
}

if($_GET['buscaEmail'] <> ''){
	$sql .= "and email LIKE '%".$_GET['buscaEmail']."%'";
}

if($_GET['buscaStatus'] <> ''){
	$sql .= "and status = '%".$_GET['buscaStatus']."%'";
}

mysql_select_db($database_conexao, $conexao);
$query_rs_usuario = "SELECT * FROM tbl_admin WHERE id is not null $sql ORDER BY nome ASC";
$rs_usuario = mysql_query($query_rs_usuario, $conexao) or die(mysql_error());
$row_rs_usuario = mysql_fetch_assoc($rs_usuario);
$totalRows_rs_usuario = mysql_num_rows($rs_usuario);

mysql_select_db($database_conexao, $conexao);
$query_rs_total_vendidos = "SELECT SUM(valor_total_produto) as somaVendidos FROM tbl_item  WHERE id is not null ";
$rs_total_vendidos = mysql_query($query_rs_total_vendidos, $conexao) or die(mysql_error());
$row_rs_total_vendidos = mysql_fetch_assoc($rs_total_vendidos);
$totalRows_rs_total_vendidos = mysql_num_rows($rs_total_vendidos);

mysql_select_db($database_conexao, $conexao);
$query_rs_total_recebidos = "SELECT SUM(valor_pagamento) as somaRecebidos FROM tbl_pagamento  WHERE id is not null ";
$rs_total_recebidos = mysql_query($query_rs_total_recebidos, $conexao) or die(mysql_error());
$row_rs_total_recebidos = mysql_fetch_assoc($rs_total_recebidos);
$totalRows_rs_total_recebidos = mysql_num_rows($rs_total_recebidos);

mysql_select_db($database_conexao, $conexao);
$query_rs_total_despesas = "SELECT SUM(valor_total) as somaDespesas FROM tbl_contas  WHERE id is not null ";
$rs_total_despesas = mysql_query($query_rs_total_despesas, $conexao) or die(mysql_error());
$row_rs_total_despesas = mysql_fetch_assoc($rs_total_despesas);
$totalRows_rs_total_despesas = mysql_num_rows($rs_total_despesas);

mysql_select_db($database_conexao, $conexao);
$query_rs_contratos_recebidos = "SELECT * FROM tbl_pagamento  WHERE id is not null ORDER BY data_pagamento ASC ";
$rs_contratos_recebidos = mysql_query($query_rs_contratos_recebidos, $conexao) or die(mysql_error());
$row_rs_contratos_recebidos = mysql_fetch_assoc($rs_contratos_recebidos);
$totalRows_rs_contratos_recebidos = mysql_num_rows($rs_contratos_recebidos);
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Caixa</title>

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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" /></head>

<body>
<?php //include_once('head.php');?>

<style>
       th{font-size:10px !important;}
	   .validadeAssinatura{
		  background:#496949 !important;
		  width:100px;
		  height:50px;
		  color:#FFFFFF;
		  margin:10px 10px;
		  padding:7px 10px;
		  border-radius:7px;
		  }
       </style>

<div class="mainwrapper">
<?php include_once('header.php');?>
<?php include_once('inc_coluna.php');?>
<div class="rightpanel">
  <ul class="breadcrumbs">
    <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
    <li><a href="caixa.php">Caixa</a></li>
    
  </ul>
  <div class="pageheader">
    
     <a href="add_contas.php?tipo=R"class="btn btn-primary btn-mini searchbar" style="position:relative; float:right; margin-left:8px; margin-top:10px;" > <i class="icon-plus"></i> &nbsp; Nova Conta a Receber</a>
    
     <a href="add_contas.php?tipo=D"class="btn btn-primary btn-mini searchbar" style="position:relative; float:right; margin-left:8px; margin-top:10px;" > <i class="icon-plus"></i> &nbsp; Nova Conta a Pagar</a>

    <a href="add_contrato.php"class="btn btn-primary btn-mini searchbar" style="position:relative; float:right; margin-top:10px;"> <i class="icon-plus"></i> &nbsp; Novo Contrato</a>
    
    <div class="pageicon"><span class="iconfa-edit"></span></div>
    <div class="pagetitle">
      <h5>Cadastro</h5>
      <h1>Fechamento de Caixa</h1>
    </div>
  </div>
  <!--pageheader-->
  <div class="maincontent">
    <div class="maincontentinner">
      <div class="widget">
        <h4 class="widgettitle"><span class="iconfa-shopping-cart"></span>Assinatura</h4>
        <div class="widgetcontent">
          <form class="stdform" action="" method="get" name="formSearchUsuario" />
          
          
          <div class="row">
              <div class="col-md-12">
                  <div class="col-md-4">
                        <div class="totalVendido" style="background:#356e35; color:#FFFFFF; border-radius:3px; padding:7px 5px;">
                        	Total Vendido: R$ <?php echo number_format($row_rs_total_vendidos['somaVendidos'],2,',','.');?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="totalVendido" style="background:#57889c; color:#FFFFFF; border-radius:3px; padding:7px 5px;">
                        	Total Recebidos: R$ <?php echo number_format($row_rs_total_recebidos['somaRecebidos'],2,',','.');?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="totalVendido" style="background:#c02631; color:#FFFFFF; border-radius:3px; padding:7px 5px;">
                        	Total Despesas: R$ <?php echo number_format($row_rs_total_despesas['somaDespesas'],2,',','.');?>
                        </div>
                    </div>
                </div>
          </div>
       
          </form>
          <div class="divider30"></div>
          <h3>Pagamentos Realizados</h3>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th width="11%">Contrato</th>
                <th width="13%">CLiente</th>
                <th width="8%">Vendedor</th>
                <th width="10%">Data Contrato</th>
                <th width="11%">Valor Pago</th>
                <th width="11%">Forma Pgto</th>
                <th width="13%">Valor do Contrato</th>
              </tr>
            </thead>
            <tbody>
            <?php do{
				

mysql_select_db($database_conexao, $conexao);
$query_rs_puxa_contrato = "SELECT * FROM tbl_contrato WHERE id = '".$row_rs_contratos_recebidos['id_contrato']."' ";
$rs_puxa_contrato = mysql_query($query_rs_puxa_contrato, $conexao) or die(mysql_error());
$row_rs_puxa_contrato = mysql_fetch_assoc($rs_puxa_contrato);
$totalRows_rs_puxa_contrato = mysql_num_rows($rs_puxa_contrato);

mysql_select_db($database_conexao, $conexao);
$query_rs_soma_valor_contrato = "SELECT SUM(valor_total_produto) as somaValorContratoI FROM tbl_item  WHERE id_contrato = '".$row_rs_puxa_contrato['id']."' ";
$rs_soma_valor_contrato = mysql_query($query_rs_soma_valor_contrato, $conexao) or die(mysql_error());
$row_rs_soma_valor_contrato = mysql_fetch_assoc($rs_soma_valor_contrato);
$totalRows_rs_soma_valor_contrato = mysql_num_rows($rs_soma_valor_contrato);

mysql_select_db($database_conexao, $conexao);
$query_rs_puxa_cliente_contrato = "SELECT * FROM tbl_cliente WHERE id = '".$row_rs_contratos_recebidos['id_cliente']."' ";
$rs_puxa_cliente_contrato = mysql_query($query_rs_puxa_cliente_contrato, $conexao) or die(mysql_error());
$row_rs_puxa_cliente_contrato = mysql_fetch_assoc($rs_puxa_cliente_contrato);
$totalRows_rs_puxa_cliente_contrato = mysql_num_rows($rs_puxa_cliente_contrato);

mysql_select_db($database_conexao, $conexao);
$query_rs_puxa_vendedor_contrato = "SELECT * FROM tbl_loja WHERE id = '".$row_rs_puxa_contrato['vendedor']."' ";
$rs_puxa_vendedor_contrato = mysql_query($query_rs_puxa_vendedor_contrato, $conexao) or die(mysql_error());
$row_rs_puxa_vendedor_contrato = mysql_fetch_assoc($rs_puxa_vendedor_contrato);
$totalRows_rs_puxa_vendedor_contrato = mysql_num_rows($rs_puxa_vendedor_contrato);
				
				?>	
                <tr>
                <td><?php echo $row_rs_contratos_recebidos['id_contrato']?></td>
                <td><?php echo $row_rs_puxa_cliente_contrato['nome']?></td>
                <td><?php echo $row_rs_puxa_vendedor_contrato['nome']?></td>
                <td><?php echo substr($row_rs_puxa_contrato['data_contrato'],8,2);?>/<?php echo substr($row_rs_puxa_contrato['data_contrato'],5,2);?>/<?php echo substr($row_rs_puxa_contrato['data_contrato'],0,4);?> <?php echo substr($row_rs_puxa_contrato['data_contrato'],11,2);?>:<?php echo substr($row_rs_puxa_contrato['data_contrato'],14,2);?>:<?php echo substr($row_rs_puxa_contrato['data_contrato'],17,2);?></td>
                <td><?php echo formaPagamento($row_rs_contratos_recebidos['forma_pagamento'])?></td>
                <td>R$ <?php echo number_format($row_rs_contratos_recebidos['valor_pagamento'],2,',','.')?></td>
                <td>R$ <?php echo number_format($row_rs_soma_valor_contrato['somaValorContratoI'],2,',','.')?></td>
                
              </tr>
           <?php }while($row_rs_contratos_recebidos = mysql_fetch_assoc($rs_contratos_recebidos));?>
            </tbody>
          </table>
          <h3>Formas de Pagamentos dispon&iacute;veis</h3>
          <div>
          <img src="images/money.jpg" alt="">
          <img src="images/americanexpress.png" alt="">
          <img src="images/mastercard.png" alt="">
          <img src="images/visa.png" alt="">
          </div>
        </div>
       
            </div><!--widget-->
<?php include_once('footer.php');?>