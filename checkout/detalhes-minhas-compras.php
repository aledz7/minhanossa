<?php require_once('Connections/conexao.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_rs_compra = "-1";
if (isset($_GET['id'])) {
  $colname_rs_compra = $_GET['id'];
}
mysql_select_db($database_conexao, $conexao);
$query_rs_compra = sprintf("SELECT * FROM tbl_compras WHERE id = %s", GetSQLValueString($colname_rs_compra, "int"));
$rs_compra = mysql_query($query_rs_compra, $conexao) or die(mysql_error());
$row_rs_compra = mysql_fetch_assoc($rs_compra);
$totalRows_rs_compra = mysql_num_rows($rs_compra);

include('funcoes.php');

mysql_select_db($database_conexao, $conexao);
$query_rs_cliente = "SELECT * FROM tbl_users WHERE id = '$row_rs_compra[id_cliente]'";
$rs_cliente = mysql_query($query_rs_cliente, $conexao) or die(mysql_error());
$row_rs_cliente = mysql_fetch_assoc($rs_cliente);
$totalRows_rs_cliente = mysql_num_rows($rs_cliente);

mysql_select_db($database_conexao, $conexao);
$query_rs_pedidos = "SELECT * FROM tbl_pedidos_por_id_compra WHERE id_compra = '$row_rs_compra[id]'";
$rs_pedidos = mysql_query($query_rs_pedidos, $conexao) or die(mysql_error());
$row_rs_pedidos = mysql_fetch_assoc($rs_pedidos);
$totalRows_rs_pedidos = mysql_num_rows($rs_pedidos);

?>
<link href="css.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style7 {color: #FF0000}
.arial_12_vermelho {font-family: Arial; font-size: 12px; color: #FF0000; font-weight: bold; }
.style11 {FONT-SIZE: 12px; COLOR: #3e6497; FONT-FAMILY: Arial; font-weight: bold; }
.style16 {color: #000000}
.style25 {color: #CC0000;
	font-size: 11px;
}
.texto_pagina {font-family: Arial;
font-size: 12px;
color: dimgray;
}
.style26 {font-weight: bold}
-->
</style>
<link href="css/fonts.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td><span class="titulo_verde"><strong>Detalhes do pedido c&oacute;digo: <?php echo $row_rs_compra['id']; ?>&nbsp;
    </strong></span><br />
    <br>
    <table width="99%" border="0" align="center" cellspacing="0" bgcolor="white"  style="border: 5px solid #DFDFDF">
      <tr>
        <td height="59" style="padding:10px;" valign="top"><p><span class="arial_12_vermelho">Identifica&ccedil;&atilde;o do   Pedido:</span><strong><BR>
                  <BR>
          </strong><span class="texto_pagina">Pedido N&ordm; <STRONG><?php echo $row_rs_compra['id']; ?></STRONG> realizado em <STRONG><?php echo substr($row_rs_compra['data'],8,2).'/'.substr($row_rs_compra['data'],5,2).'/'.substr($row_rs_compra['data'],0,4); ?></STRONG></span></p>
            <p class="style7"><strong class="titulo_campos">Status: </strong><?php echo descStatus($row_rs_compra['status']); ?></p></td>
      </tr>
    </table>
    <br>
    <table width="99%" border="0" align="center" cellspacing="0" bgcolor="white"  style="border: 5px solid #DFDFDF">
      <tr>
        <td height="59" style="padding:10px;" valign="top"><strong><span class="arial_12_vermelho">Seus Dados:</span><br />
          <BR>
          </strong>
            <TABLE width="100%" align="center" border="0">
              <TBODY>
                <TR vAlign="top">
                  <TD width="50%" class="texto_pagina"><strong><?php echo $row_rs_cliente['nome']; ?> <?php echo $row_rs_cliente['sobrenome']; ?></strong><BR>
                      <span class="style16">Data/Nascimento:</span> <?php echo $row_rs_cliente['data_de_nascimento']; ?><BR>
                      <span class="style16">CPF:</span> <?php echo $row_rs_cliente['cpf']; ?><BR>
                    <span class="style16">RG:</span> <?php echo $row_rs_cliente['rg']; ?><BR>
                      <span class="style16">Sexo: </span><?php echo $row_rs_cliente['sexo']; ?><BR>
                      <span class="style16"><BR>
                        Telefone: </span><?php echo $row_rs_cliente['ddd_telefone']; ?> <?php echo $row_rs_cliente['telefone']; ?><br>
                    <span class="style16">Celular:</span> <?php echo $row_rs_cliente['ddd_celular']; ?> <?php echo $row_rs_cliente['celular']; ?><BR>
                    <span class="style16">E-mail:</span> <A href="mailto:<?php echo $row_rs_cliente['email']; ?>"><?php echo $row_rs_cliente['email']; ?></A> </TD>
                  <TD width="50%" class="texto_pagina"><?php echo ucfirst($row_rs_cliente['endereco']); ?>, <?php echo ucfirst($row_rs_cliente['complemento']); ?><BR>
                  <?php echo ucfirst($row_rs_cliente['bairro']); ?>, <?php echo ucfirst($row_rs_cliente['cidade']); ?>-<?php echo $row_rs_cliente['estado']; ?><BR>
                      <span class="style16">CEP:</span> <?php echo $row_rs_cliente['cep']; ?><BR>
                      <span class="style16">Pa&iacute;s:</span> <?php echo $row_rs_cliente['pais']; ?></TD>
                </TR>
              </TBODY>
          </TABLE></td>
      </tr>
    </table>
    <br>
    <table width="99%" border="0" align="center" cellspacing="0" bgcolor="white"  style="border: 5px solid #DFDFDF">
      <tr>
        <td height="59" style="padding:10px;" valign="top"><div class="arial_12_vermelho"><strong>Dados da Compra:</strong><br />
         
        </div> <br />
            <TABLE 
      width="100%" border=1 cellPadding=2 cellSpacing=0 borderColor=#eeeeee class="texto_preto">
              <TBODY>
                <TR style="FONT-WEIGHT: bold; BACKGROUND-COLOR: whitesmoke" 
        vAlign=center>
                  <TD width="8%" ><div align="center">
                      <p>Cod</p>
                  </div></TD>
                  <TD width="60%" >Nome</TD>
                  <TD width="7%" align="center" >QTD</TD>
                  <TD width="13%" align="center" >Valor</TD>
                  <TD width="12%" align="center">Total</TD>
                </TR>
              </TBODY>
            </TABLE>
<?php do { 

$id_prod = $row_rs_pedidos['produto'];

mysql_select_db($database_conexao, $conexao);
$query_rs_produto = "SELECT * FROM tbl_produtos WHERE id = '$id_prod'";
$rs_produto = mysql_query($query_rs_produto, $conexao) or die(mysql_error());
$row_rs_produto = mysql_fetch_assoc($rs_produto);
$totalRows_rs_produto = mysql_num_rows($rs_produto);

mysql_select_db($database_conexao, $conexao);
$query_rs_transf_bancaria = "SELECT * FROM tbl_pagamento_deposito_transferencia";
$rs_transf_bancaria = mysql_query($query_rs_transf_bancaria, $conexao) or die(mysql_error());
$row_rs_transf_bancaria = mysql_fetch_assoc($rs_transf_bancaria);
$totalRows_rs_transf_bancaria = mysql_num_rows($rs_transf_bancaria);
?>            
            <TABLE class='texto_preto' borderColor=#eeeeee cellSpacing=0 cellPadding=2 
      width="100%" border=1>
              <TBODY>
              <form name="form1" id="form1">
                <TR class=exibe_registros 
        onmouseover="this.style.backgroundColor='whitesmoke';" 
        onmouseout="this.style.backgroundColor='';">
                  <TD width="8%" class="style11"><div align="center"><?php echo $row_rs_pedidos['produto']; ?></div></TD>
                  <TD width="60%" class="style11"><div align="left"><a href="?pg=detalhes&id_produto=<?php echo $row_rs_produto['id']; ?>" class="style11"><?php echo $row_rs_produto['nome']; ?></a></div></TD>
                  <TD width="7%" class="style11"><div align="center"><?php echo $row_rs_pedidos['qtd']; ?></div></TD>
                  <TD width="13%" class="style11"><div align="center">R$:
                    <?php
					  echo number_format($row_rs_pedidos['valor_c_acrecimo'],2,',','.'); ?>
                  </div></TD>
                  <TD width="12%"><div align="center" class="style11">R$:
                    <?php 
					  $total = $row_rs_pedidos['valor_c_acrecimo']*$row_rs_pedidos['qtd'];
					  echo number_format($total,2,',','.');
					  $subtotal = $subtotal+$total;
					  $qtds = $qtds+$row_rs_pedidos['qtd'];?>
                  </div></TD>
                </TR>
              </form>
            </TABLE>
          <?php } while ($row_rs_pedidos = mysql_fetch_assoc($rs_pedidos)); ?>          
          <br>
            <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#EEEEEE">
              <tr>
                <td bgcolor="#F5F5F5">
                
                
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="texto_preto">
                    <tr>
                      <td><div  class="arial14cinza"><strong>&nbsp;Total de produtos solicitados: <span class="style25"><?php echo $qtds ?></span></strong> </div></td>
                      <td><div align="right" class="arial14cinza"><strong>SubTotal R$:
                        <?=number_format($subtotal,2,',','.');?>
                        &nbsp; </strong></div></td>
                    </tr>
             <?php if($row_rs_compra['desconto'] > 0) { ?>       
                    <tr>
                      <td>&nbsp;</td>
                      <td><div align="right" class="arial14cinza"><strong>Desconto R$:
                        <?=$row_rs_compra['desconto'];?>
  &nbsp; </strong></div></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td><div align="right" class="arial14cinza"><strong>Total com desconto R$:
                        <?=number_format($subtotal-valorCalculavel($row_rs_compra['desconto']),2,',','.');?>
  &nbsp; </strong></div></td>
                    </tr>
                    <?php } ?>
                </table>
                
                </td>
              </tr>
          </table></td>
      </tr>
    </table>
    <br>
    <table width="99%" border="0" align="center"  cellspacing="0" bgcolor="white"  style="border: 5px solid #DFDFDF">
      <tr>
        <td height="59" valign="top" style="padding:10px;"><div class="arial_12_vermelho"><strong>Dados da Entrega: </strong></div><br />

            <TABLE width="100%" align="center" border="0">
              <TBODY>
                <TR vAlign="top">
                  <TD width="50%"><STRONG class="titulo_campos">Forma de entrega escolhida</STRONG></TD>
                  <TD width="50%"><STRONG class="titulo_campos">Endere&ccedil;o de entrega</STRONG></TD>
                </TR>
                <TR vAlign="top">
                  <TD width="50%" class="texto_pagina"><p><?php echo $row_rs_compra['forma_de_envio']; ?><BR>
                  Valor do frete: <?php echo $row_rs_compra['total_frete']; ?><br />
                  Protocolo - Correios: <?php echo $row_rs_compra['protocolo_entrega']; ?></p>                  </TD>
                  <TD width="50%" class="texto_pagina"><?php echo ucfirst($row_rs_cliente['endereco']); ?>, <?php echo ucfirst($row_rs_cliente['complemento']); ?><BR>
                      <?php echo ucfirst($row_rs_cliente['bairro']); ?>, <?php echo ucfirst($row_rs_cliente['cidade']); ?> - <?php echo $row_rs_cliente['estado']; ?><BR>
                    CEP: <?php echo $row_rs_cliente['cep']; ?> </TD>
                </TR>
              </TBODY>
          </TABLE></td>
      </tr>
    </table>
    <br>
    <table width="99%" border="0" align="center"  cellspacing="0" bgcolor="white"  style="border: 5px solid #DFDFDF">
      <tr>
        <td height="59" style="padding:10px;" valign="top"><div class="arial_12_vermelho"><strong>Dados para Pagamento:</strong><br />
        </div><br />

          <table width='100%' border='0' class="preto_arial_12">
            <tr>
              <td colspan='2' class="arial12preto"><?php echo $row_rs_transf_bancaria['banco']; ?> - <?php echo strtoupper($row_rs_transf_bancaria['site_banco']); ?></td>
            </tr>
            <tr>
              <td width='6%' nowrap class="arial12preto"><div align='right' class='arial12preto'><strong>Ag&ecirc;ncia:</strong></div></td>
              <td width='94%' class='arial12preto'><?php echo $row_rs_transf_bancaria['agencia']; ?></td>
            </tr>
            <tr>
              <td nowrap class='arial12preto'><div align='right'><strong>Conta corrente:</strong></div></td>
              <td class='arial12preto'><?php echo $row_rs_transf_bancaria['conta']; ?></td>
            </tr>
            <tr>
              <td nowrap class='arial12preto'><div align='right'><strong>Cedente:</strong></div></td>
              <td class='arial12preto'><?php echo $row_rs_transf_bancaria['cedente']; ?></td>
            </tr>
          </table></td>
      </tr>
    </table>    </td>
  </tr>
</table>
<?php
mysql_free_result($rs_compra);

mysql_free_result($rs_cliente);

mysql_free_result($rs_pedidos);

mysql_free_result($rs_transf_bancaria);
?>
