<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

session_start();

$currentPage = 'contrato_cadastro.php';

if($_GET['dataSaidaDe'] <> ''){
	$sql2 .= "and data_evento between '".formataDataSQL($_GET['dataSaidaDe'])."' and '".formataDataSQL($_GET['dataSaidaAte'])."'";
}

if($_GET['dataRetorno'] <> ''){
	$sql2 .= "and data_devolucao = '".formataDataSQL($_GET['dataRetorno'])."'";
}

if($_GET['buscaCodigo'] <> ''){
	$sql_item .= " and tbl_item.nome_produto = '".$_GET['buscaCodigo']."'";
}

if($_GET['cliente'] <> ''){
	$sql2 .= " and codigo_cliente = '".$_GET['cliente']."'";
}

if($_GET['mes'] == '' and $_GET['buscaDe'] == '') {
	$mes = date('m');
	$ano = date('Y');
}

if($_GET['mes'] <> '') {
	$sql2 .= " and month(tbl_contrato.data_evento) = {$_GET['mes']}";
}

if($_GET['ano'] <> '') {
	$sql2 .= " and year(tbl_contrato.data_evento) = {$_GET['ano']}";
}

$maxRows_rs_contratos = 100;
$pageNum_rs_contratos = 0;
if (isset($_GET['pageNum_rs_contratos'])) {
  $pageNum_rs_contratos = $_GET['pageNum_rs_contratos'];
}
$startRow_rs_contratos = $pageNum_rs_contratos * $maxRows_rs_contratos;

$colname_rs_contratos = "-1";
if (isset($_GET['cat'])) {
  $colname_rs_contratos = $_GET['cat'];
}
mysql_select_db($database_conexao, $conexao);
$query_rs_cliente = "SELECT * FROM tbl_admin WHERE id is not null ORDER BY nome ASC";
$rs_cliente = mysql_query($query_rs_cliente, $conexao) or die(mysql_error());
$row_rs_cliente = mysql_fetch_assoc($rs_cliente);
$totalRows_rs_cliente = mysql_num_rows($rs_cliente);

mysql_select_db($database_conexao, $conexao);
$query_rs_contrato = "SELECT * FROM tbl_contrato WHERE 1=1 $sql2 ORDER BY data_contrato DESC limit 0,100";
$rs_contrato = mysql_query($query_rs_contrato, $conexao) or die(mysql_error());
$row_rs_contrato = mysql_fetch_assoc($rs_contrato);
$totalRows_rs_contrato = mysql_num_rows($rs_contrato);

if(basename($_SERVER['SCRIPT_NAME']) == 'editar_contrato.php') {
			$row_rs_editar_item = mysql_fetch_assoc($rs_editar_item);
		}
		if(basename($_SERVER['SCRIPT_NAME']) == 'editar-lavanderia.php') {
			$row_rs_editar_item = mysql_fetch_assoc($rs_editar_item);
		}
		if(basename($_SERVER['SCRIPT_NAME']) == 'editar_reserva.php') {
			$row_rs_editar_item = mysql_fetch_assoc($rs_editar_item);
		}

//print_r($row_rs_contrato);

mysql_select_db($database_conexao, $conexao);
$query_rs_cliente = "SELECT * FROM tbl_cliente ORDER BY nome ASC";
$rs_cliente = mysql_query($query_rs_cliente, $conexao) or die(mysql_error());
$row_rs_cliente = mysql_fetch_assoc($rs_cliente);
$totalRows_rs_cliente = mysql_num_rows($rs_cliente);
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Aluguel</title>

<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-fileupload.min.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-timepicker.min.css" type="text/css" />

<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="load.js"></script>
<? include('dialog-jquery/inc-abre-janela.php');?>

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
body,td,th {
	font-family: RobotoRegular, "Helvetica Neue", Helvetica, sans-serif;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

<body>
<?php //include_once('head.php');?>

<div class="mainwrapper">
<?php include_once('header.php');?>
<?php include_once('inc_coluna.php');?>
<div class="rightpanel">
  <ul class="breadcrumbs">
    <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
    <li><a href="contrato_cadastro.php">Aluguel</a></li>
    
  </ul>
  <div class="pageheader">
  
    	<?php /*?><a href="javascript:;" class="btn btn-primary btn-mini searchbar" onClick="abreJanelaJquery('novo-contrato-codigo-cliente.php', 'Codigo Cliente', '', '250px', '120', rand(1,9999));"> <i class="icon-plus"></i> &nbsp; Novo Aluguel</a><?php */?>
    	<a href="add_contrato.php" class="btn btn-primary btn-mini searchbar" > <i class="icon-plus"></i> &nbsp; Novo Aluguel</a>
    
    <div class="pageicon"><span class="iconfa-edit"></span></div>
    <div class="pagetitle" >
      <h5>Cadastro</h5>
      <h1>Aluguel</h1>
    </div>
    
    
    
  </div>
  <!--pageheader-->
  <div class="maincontent">
    <div class="maincontentinner">
      <div class="widget">
        <h4 class="widgettitle"><span class="iconfa-shopping-cart"></span>Cadastro Aluguel</h4>
        <div class="widgetcontent">
        
          <div class="divider30"></div>
			
			 <div class="mediamgr_head">
					<form method="get" enctype="application/x-www-form-urlencoded" id="formProvas">
                    	<ul class="mediamgr_menu">
                            
                            
                           
							<li class="filesearch" style="margin-left: 10px;">

                <div class="input-prepend">
                  <span class="add-on">Data Retirada (De)</span>
                  <input id="dataSaidaDe" type="text" name="dataSaidaDe" class="input-small datepicker" style="padding:5px;" value="<?=$_GET['dataSaidaDe'];?>" />                                    
                </div>
                <div class="input-prepend">
                  <span class="add-on">Data Retirada (AtÃ©)</span>
                  <input id="dataSaidaAte" type="text" name="dataSaidaAte" class="input-small datepicker" style="padding:5px;" value="<?=$_GET['dataSaidaAte'];?>" />                                    
                </div>
                <div class="input-prepend">
                  <span class="add-on">Data Devolu&ccedil;&atilde;o</span>
                  <input id="dataRetorno" type="text" name="dataRetorno" class="input-small datepicker" style="padding:5px;" value="<?=$_GET['dataRetorno'];?>" />                                    
                </div>
								
								    <div class="input-prepend">
                                      <span class="add-on">C&oacute;digo</span>
                                      <input id="buscaCodigo" type="text" name="buscaCodigo" class="input-small" style="padding:5px;" value="<?=$_GET['buscaCodigo'];?>" />                                    
                                      </div>
								
                            		<div class="input-prepend">
                                      <span class="add-on">Cliente</span>
                                      <select name="cliente" id="cliente" class="input-large" style="height: 32px; width: 122px;">
                                      	<option value="">SELECIONE</option>
                                      	<?php do{?>
                                      	<option value="<?php echo $row_rs_cliente['id'];?>" <?php if($_GET['cliente'] == $row_rs_cliente['id']){ echo "selected";}?>><?php echo $row_rs_cliente['nome'];?></option>
                                      	<?php }while($row_rs_cliente = mysql_fetch_assoc($rs_cliente));?>
                                      	
                                      </select>
                                     </div>
                            </li>
                            <li class="left newfilebtn"><a href="javascript:;" onClick="document.getElementById('formProvas').submit()" class="btn btn-primary"  style="padding:4px; margin-left:10px;">Pesquisar</a></li>
                            <li class="left newfilebtn"><a href="contrato_cadastro.php" class="btn btn-success"  style="padding:4px; margin-left:10px;">MOSTRAR TODOS</a></li>
                        </ul>
            </form>
                        <span class="clearall"></span>
                    </div>
			<?php 
			include('menus-financeiro.php')?>
			<br>
          <table class="table table-bordered" width="100%">
           
            <tbody>
            
            
              
              <tr>
                <td width="6%" style="text-align:center"><strong>C&oacute;digo</strong></td>
                <td width="9%" style="text-align:center"><strong>C&oacute;d. Client</strong></td>
                <td width="19%"><strong>Cliente</strong></td>
                <td width="12%"><strong>Data Retirada</strong></td>
                <td width="12%"><strong>Data Devolu&ccedil;&atilde;o</strong></td>
                <td width="9%" style="text-align:center"><strong>Total Pe&ccedil;as</strong></td>
                <td width="11%"><strong>Produto</strong></td>
				<td width="11%"><strong>Valor Total</strong></td>
                <td width="22%" style="text-align:center; font-weight:bold;">Op&ccedil;&otilde;es</td>
              </tr>
            
            <?php
			if($totalRows_rs_contrato > 0){
			 do{
mysql_select_db($database_conexao, $conexao);
$query_rs_nome_cliente = "SELECT * FROM tbl_cliente WHERE id = '".$row_rs_contrato['codigo_cliente']."'";
$rs_nome_cliente = mysql_query($query_rs_nome_cliente, $conexao) or die(mysql_error());
$row_rs_nome_cliente = mysql_fetch_assoc($rs_nome_cliente);
$totalRows_rs_nome_cliente = mysql_num_rows($rs_nome_cliente);

mysql_select_db($database_conexao, $conexao);
$query_rs_valor_contrato = "
SELECT 
	tbl_item.*,
	tbl_produto.valor_venda
FROM 
	tbl_item 
	left join tbl_produto on tbl_item.nome_produto = tbl_produto.id
WHERE 
	id_contrato = '".$row_rs_contrato['id']."'";
$rs_valor_contrato = mysql_query($query_rs_valor_contrato, $conexao) or die(mysql_error());
$row_rs_valor_contrato = mysql_fetch_assoc($rs_valor_contrato);
$totalRows_rs_valor_contrato = mysql_num_rows($rs_valor_contrato);	

/*mysql_select_db($database_conexao, $conexao);
$query_rs_produto = "SELECT * FROM tbl_item WHERE id_contrato = '".$row_rs_contrato['id']."'";
$rs_produto = mysql_query($query_rs_produto, $conexao) or die(mysql_error());
$row_rs_produto = mysql_fetch_assoc($rs_produto);
$totalRows_rs_produto = mysql_num_rows($rs_produto);*/
				 
/*mysql_select_db($database_conexao, $conexao);
$query_rs_produto1 = "SELECT * FROM tbl_item WHERE id_contrato = '".$row_rs_contrato['id']."' $sql_item ORDER BY nome_produto ASC";
$rs_produto1 = mysql_query($query_rs_produto1, $conexao) or die(mysql_error());
$row_rs_produto1 = mysql_fetch_assoc($rs_produto1);
$totalRows_rs_produto1 = mysql_num_rows($rs_produto1);*/

//print_r($row_rs_contrato);
				 
		
				 
 $devolucao = substr($row_rs_contrato['data_devolucao'],8,2)." / ".substr($row_rs_contrato['data_devolucao'],5,2)." / ".substr($row_rs_contrato['data_devolucao'],0,4);
 
 $retirada = substr($row_rs_contrato['data_evento'],8,2)." / ".substr($row_rs_contrato['data_evento'],5,2)." / ".substr($row_rs_contrato['data_evento'],0,4);	
 
 //$valor = number_format($row_rs_valor_contrato['valor_total_produto'],2,',','.');
 
$somavalor += $row_rs_editar_item['valorVenda'];
				 
 $traje = 	$row_rs_valor_contrato['nome'];	 
 
 $cliente = $row_rs_nome_cliente['nome'];
 $idcliente = $row_rs_nome_cliente['id'];
 
 $idContrato = $row_rs_contrato['id'];
				 $quantidadeProduto=0;
	$produtos_nomes = '';
	$valor = 0;
	
	do {
				 $quantidadeProduto += $row_rs_valor_contrato['quantidade_produto'];
				 $produtos_nomes .= $row_rs_valor_contrato['nome_produto']." / ";
		$valor += $row_rs_valor_contrato['valor_venda'];
	}while($row_rs_valor_contrato = mysql_fetch_assoc($rs_valor_contrato));
				 
				 
   /*?>   echo number_format($somavalor,2,',','.');?></strong></td>
      <input type="hidden" name="somaValor" value="<?php echo $somavalor;?>"><?php */?>
   
              <tr>
                <td style="text-align:center"><?php echo $idContrato;?></td>
                <td ><?php echo $idcliente;?></td>
                <td><?php echo ($cliente);?></td>
                <td><?php echo $retirada;?></td>
                <td><?php echo $devolucao;?></td>
                <td style="text-align:center"><?php echo $quantidadeProduto;?></td>
				
                <td>
                <?php 
				
				echo $produtos_nomes;
	
	?>
                </td>
				  
				  <td style="text-align:center"><?=number_format($valor,2,',','.')?></td>
				  
                <td colspan="2" class="centeralign">
                    <a href="editar_contrato.php?id=<?php echo $row_rs_contrato['id'];?>"class="btn btn-primary btn-mini"> <i class="icon-pencil"></i> &nbsp; Gerenciar
                    
                    </a>
                	 
                                	
                                	<a href="enviar-aluguel.php?id=<?php echo $row_rs_contrato['id'];?>&tipo=R" class="btn btn-primary btn-mini"> <i class="iconfa-ok"></i>&nbsp; Enviar Cliente Retirada</a>
                                	
                                	<a href="enviar-aluguel.php?id=<?php echo $row_rs_contrato['id'];?>&tipo=D" class="btn btn-primary btn-mini"> <i class="iconfa-ok"></i>&nbsp; Enviar Cliente Devolu&ccedil;&atilde;o</a>
                               
				</td>
              </tr>
            <?php }while($row_rs_contrato = mysql_fetch_assoc($rs_contrato));
			}
			?>
              
				    <table border="0">
    <tr>
      <td><div>
               
                <table border="0" cellpadding="0" cellspacing="0" class="texto_menus">
                  <tr>
                    <td> 
<span class="BuscaTexto1">P&aacute;ginas de resultados:</span><span class="texto1 style1">
<?
$pag = $_GET[pageNum_rs_contratos];

$totalPages_rs_contratos++;
for ($i=0; $i< $totalPages_rs_contratos; $i=$i+1)
{
$a=$a+1; 
if ($n==$i) 
{
echo "<A href=?pageNum_rs_contratos=".$_GET['pageNum_rs_contratos='].'0'."&totalRows_rs_contratos=".$totalRows_rs_contratos."&tipo=".$_GET[tipo]."&dataInicio=".$_GET[dataInicio]."&dataFim=".$_GET[dataFim]."&id_produto=".$_GET[id_produto]."&id_cliente=".$_GET[id_cliente]." style='color:rgba(0,0,0,1.00)'><B>".$a."</B></A><strong>&nbsp;&nbsp;| </strong>";
}
else
{
$p = $a-1;

if($pag == $p) {
	$estilo = "style='color:#CC0000'"; 
} else {
	$estilo = "style='color:rgba(0,0,0,1.00)'"; 
}

echo "<A href=?pageNum_rs_contratos=".$_GET['pageNum_rs_contratos='].$p."&totalRows_rs_contratos=".$totalRows_rs_contratos."&tipo=".$_GET[tipo]."&dataInicio=".$_GET[dataInicio]."&dataFim=".$_GET[dataFim]."&id_produto=".$_GET[id_produto]."&id_cliente=".$_GET[id_cliente]." {$estilo}><b> ".$a." </b></A>&nbsp;|";
}
}
$totalPages_rs_contratos--;
?>
                      </span>
                      <?php if ($pageNum_rs_contratos < $totalPages_rs_contratos) { // Show if not last page ?>
                      <a href="<?php printf("%s?pageNum_rs_contratos=%d%s", $currentPage, min($totalPages_rs_contratos, $pageNum_rs_contratos + 1), $queryString_rs_contratos); ?>" style="color:rgba(0,0,0,1.00)">AVAN&Ccedil;AR</a>
                    <?php } // Show if not last page ?>                    </td>
                  </tr>
          </table>
      
		  
            </div></td>
    </tr>
  </table>
				
            </tbody>
          </table>
			
			
			
        </div>
        <!--widgetcontent-<?php
mysql_free_result($rs_contrato);
?>->
            </div><!--widget-->
		  
		
<?php include_once('footer.php');?>