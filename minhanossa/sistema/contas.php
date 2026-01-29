<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

include('class/html.php');
$HTML = new HTML;

$currentPage = 'contrato_cadastro.php';

if($_GET['tipo'] <> ''){
	$sql .= "and tbl_contas.tipo = '{$_GET['tipo']}'";
}

if($_GET['busca'] <> ''){
	$sql .= "and tbl_contas.descricao LIKE '%{$_GET['busca']}%'";
}

if($_GET['dataInicio'] <> ''){
	$sql .= "and tbl_contas.data_vencimento >= '".formataDataSQL($_GET['dataInicio'])."'";
}

if($_GET['dataFim'] <> ''){
	$sql .= "and tbl_contas.data_vencimento <= '".formataDataSQL($_GET['dataFim'])."'";
}

mysql_select_db($database_conexao, $conexao);
$query_rs_contas = "SELECT * FROM tbl_contas where 1=1 $sql ORDER BY data_vencimento ASC";
$rs_contas = mysql_query($query_rs_contas, $conexao) or die(mysql_error());
$row_rs_contas = mysql_fetch_assoc($rs_contas);
$totalRows_rs_contas = mysql_num_rows($rs_contas);
?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Financeiro > Contas > <?php echo ($_GET['tipo'] == 'D') ? 'Pagar' : 'Receber';?></title>

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
body,td,th {
	font-family: RobotoRegular, "Helvetica Neue", Helvetica, sans-serif;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" /></head>

<body>
<?php //include_once('head.php');?>

<div class="mainwrapper">
<?php include_once('header.php');?>
<?php include_once('inc_coluna.php');?>
<div class="rightpanel">
  <ul class="breadcrumbs">
    <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
    <li><a href="contas_receber.php">Contas a <?php echo ($_GET['tipo'] == 'D') ? 'Pagar' : 'Receber';?></a></li>
    
  </ul>
  <div class="pageheader">
  
    	<a href="add_contas.php?tipo=<?php echo $_GET['tipo'];?>" class="btn btn-primary btn-mini searchbar"> <i class="icon-plus"></i> &nbsp; Novo</a>
    
    <!--<form action="results.html" method="post" class="searchbar" />
                <input type="text" name="keyword" placeholder="To search type and hit enter..." />
            </form>-->
    <div class="pageicon"><span class="iconfa-edit"></span></div>
    <div class="pagetitle" >
      <h5>Financeiro</h5>
      <h1>Contas a <?php echo ($_GET['tipo'] == 'D') ? 'Pagar' : 'Receber';?></h1>
    </div>
    
    
    
  </div>
  <!--pageheader-->
  <div class="maincontent">
    <div class="maincontentinner">
      <div class="widget">
        <h4 class="widgettitle"><span class="iconfa-shopping-cart"></span>Contas a <?php echo ($_GET['tipo'] == 'D') ? 'Pagar' : 'Receber';?></h4>
        <div class="widgetcontent">
        
          <div class="mediamgr_head">
					<form method="get" enctype="application/x-www-form-urlencoded" id="formProvas">
                    	<ul class="mediamgr_menu">
                            <li class="filesearch">
                            		<div class="input-prepend">
                                      <span class="add-on">Data de In&iacute;cio</span>
                                      <input id="dataInicio" type="text" name="dataInicio" class="input-small datepicker" style="padding:5px;" value="<?php echo $_GET['dataInicio'];?>" />                                    </div>
                                   
                                   
                                   <div class="input-prepend">
                                      <span class="add-on">Data Final</span>
                                      <input id="dataFim" value="<?php echo $_GET['dataFim'];?>" style="padding:5px;" type="text" name="dataFim" class="input-small datepicker" />                                    </div>
                                   
                                   
                                   <div class="input-prepend">
                                      <span class="add-on">Palavra-Chave</span>
                                   
                            
                                      <input type="text" name="busca" style="padding:5px;">
                                   </div>
                                      
                                      
                                
                            </li>
                            <li class="left newfilebtn"><a href="javascript:;" onClick="document.getElementById('formProvas').submit()" class="btn btn-primary"  style="padding:4px; margin-left:10px;">Pesquisar</a></li>
                        </ul>
                        <input type="hidden" name="tipo" value="<?php echo $_GET['tipo'];?>">
            </form>
                        <span class="clearall"></span>
                    </div>
                    
              <?php if($totalRows_rs_contas > 0) { ?>      
          <table class="table table-bordered">
           
            <tbody>
            
            
              
              <tr>
                <td width="15%" class="centeralign"><strong>Data Emiss&atilde;o</strong></td>
                <td width="16%" class="centeralign"><strong>Data Vencimento</strong></td>
                <td width="32%"><strong>Descri&ccedil;&atilde;o</strong></td>
                <td width="15%" class="centeralign"><strong>Valor total</strong></td>
                <td width="22%" style="text-align:center">Op&ccedil;&otilde;es</td>
              </tr>
            
            <?php
			if($totalRows_rs_contas > 0){
			 do{?>
              <tr>
                <td  class="centeralign"><?php echo substr($row_rs_contas['data_emissao'],8,2);?> / <?php echo substr($row_rs_contas['data_emissao'],5,2);?> / <?php echo substr($row_rs_contas['data_emissao'],0,4);?></td>
                <td  class="centeralign"><?php echo substr($row_rs_contas['data_vencimento'],8,2);?> / <?php echo substr($row_rs_contas['data_vencimento'],5,2);?> / <?php echo substr($row_rs_contas['data_vencimento'],0,4);?></td>
                <td ><?php echo $row_rs_contas['descricao'];?></td>
                <td  class="centeralign"><?php echo number_format($row_rs_contas['valor_total'],2,',','.');?></td>
                <td class="centeralign">
                    <a href="editar_contas.php?id=<?php echo $row_rs_contas['id'];?>"class="btn btn-primary btn-mini"> <i class="icon-pencil"></i> &nbsp; Editar
                    
                    </a>
                	<a href="sql_excluir.php?id=<?php echo $row_rs_contas['id']; ?>&acao=excluirContas&tipo=<?php echo $_GET['tipo'];?>" class="btn btn-danger btn-mini" style="margin-left:7px;"> <i class="iconfa-remove"></i> Excluir
                    </a>
				</td>
                </tr>
            <?php 
			$total += $row_rs_contas['valor_total'];
			}while($row_rs_contas = mysql_fetch_assoc($rs_contas));
			
			
			
			?>
			
            <tr>
                <td>&nbsp;</td>
                <td colspan="2">&nbsp;</td>
              	<td  class="centeralign"><strong>Total: <?php echo number_format($total,2,',','.'); ?></strong></td>
              	<td>&nbsp;</td>
              </tr>
			
			<?php
			}
			?>
            
              
            </tbody>
          </table>
          <?php } else { 
		  		$HTML->nenhumRegistro();
		   } ?>
        </div>
        <!--widgetcontent-<?php
mysql_free_result($rs_contas);
?>->
            </div><!--widget-->
        <?php include_once('footer.php');?>