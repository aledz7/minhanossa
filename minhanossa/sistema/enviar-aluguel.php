<?php
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');
session_start();


mysql_select_db($database_conexao, $conexao);
$query_rs_loja = "SELECT * FROM tbl_loja ORDER BY nome ASC";
$rs_loja = mysql_query($query_rs_loja, $conexao) or die(mysql_error());
$row_rs_loja = mysql_fetch_assoc($rs_loja);
$totalRows_rs_loja = mysql_num_rows($rs_loja);

mysql_select_db($database_conexao, $conexao);
$query_rs_vendedor = "SELECT * FROM tbl_admin ORDER BY nome ASC";
$rs_vendedor = mysql_query($query_rs_vendedor, $conexao) or die(mysql_error());
$row_rs_vendedor = mysql_fetch_assoc($rs_vendedor);
$totalRows_rs_vendedor = mysql_num_rows($rs_vendedor);

mysql_select_db($database_conexao, $conexao);
$query_rs_contrato = "SELECT tbl_contrato.*, tbl_cliente.nome as nomeCliente, tbl_cliente.email as emailCliente FROM tbl_contrato left join tbl_cliente on tbl_contrato.codigo_cliente = tbl_cliente.id WHERE tbl_contrato.id = '" . $_GET['id'] . "'";
$rs_contrato = mysql_query($query_rs_contrato, $conexao) or die(mysql_error());
$row_rs_contrato = mysql_fetch_assoc($rs_contrato);
$totalRows_rs_contrato = mysql_num_rows($rs_contrato);

//print_r($row_rs_contrato); exit;

mysql_select_db($database_conexao, $conexao);
$query_rs_editar_item = "SELECT * FROM tbl_item WHERE id_contrato = '" . $_GET['id'] . "'";
$rs_editar_item = mysql_query($query_rs_editar_item, $conexao) or die(mysql_error());
$row_rs_editar_item = mysql_fetch_assoc($rs_editar_item);
$totalRows_rs_editar_item = mysql_num_rows($rs_editar_item);



if ($_GET['tipo'] == 'R') {
  $tipo = " (Retirada)";
  $tipo2 = " <strong>Data Retirada:</strong>";
}
if ($_GET['tipo'] == 'D') {
  $tipo = " (Devolu&ccedil;&atilde;o)";
  $tipo2 = " <strong>Data Devolu&ccedil;&atilde;o:</strong>";
}


require("phpmailer/class.phpmailer.php");
// Define os dados do servidor e tipo de conex�o
$mail = new PHPMailer();

$mensagem = "
<!doctype html>
<html>
<head>
<meta charset='utf-8'>
<title>Aluguel</title>
<link rel='stylesheet' type='text/css' href='css.css'>
</head>

<body>
<table width='100%' style='border:solid 1px #CCCCCC' border='0' cellpadding='0' cellspacing='0'>
  <tr>
    <td width='50%' height='50' style='padding-left:8px;' ><strong>" . utf8_decode($row_rs_loja['nome']) . "</strong></td>
    <td width='50%' align='right' valign='top'  style='padding-top:5px; padding-bottom:5px; padding-right:5px;'>" . utf8_decode($row_rs_loja['logradouro']) . " <br />
     Fone: " . utf8_decode($row_rs_loja['telefone1']) . "<br />
      " . utf8_decode($row_rs_loja['cnpj']) . "</td>
  </tr>
</table>
<div align='center' style='font-family:Arial, Helvetica, sans-serif; margin:5px; font-weight:bold; letter-spacing:1px;'> ALUGUEL N&deg;
  " . $_GET['id'] . "
</div>
<table width='100%'  border='0' cellpadding='0' cellspacing='0'>
  <tr>
    <td style='padding-bottom:6px;' class='preto_arial_12' >Cliente: <strong>" . $row_rs_contrato['nomeCliente'] . "</strong></td>
  </tr>
  <tr>
    <td  style='border:solid 1px #CCCCCC; padding:5px' align='center'><h4>Rela&ccedil;&atilde;o de Itens " . $tipo . "</h4></td>
  </tr>
   <tr>
    <td  style='border:solid 1px #CCCCCC; padding:5px' ><strong>Foram listados " . $totalRows_rs_editar_item . " itens.</strong></td>
  </tr>
</table>";
do {
  mysql_select_db($database_conexao, $conexao);
  $query_rs_itens_produtos = "SELECT * FROM tbl_produto WHERE id = '" . $row_rs_editar_item['nome_produto'] . "'";
  $rs_itens_produtos = mysql_query($query_rs_itens_produtos, $conexao) or die(mysql_error());
  $row_rs_itens_produtos = mysql_fetch_assoc($rs_itens_produtos);
  $totalRows_rs_itens_produtos = mysql_num_rows($rs_itens_produtos);

  mysql_select_db($database_conexao, $conexao);
  $query_rs_mostrar_cor = "SELECT * FROM 	tbl_cores WHERE id = '" . $row_rs_itens_produtos['id_cor'] . "'";
  $rs_mostrar_cor = mysql_query($query_rs_mostrar_cor, $conexao) or die(mysql_error());
  $row_rs_mostrar_cor = mysql_fetch_assoc($rs_mostrar_cor);
  $totalRows_rs_mostrar_cor = mysql_num_rows($rs_mostrar_cor);

  $valor = number_format($row_rs_itens_produtos['valor_venda'], 2, ',', '.');
  $mensagem .= "	
<table width='100%' border='0' cellpadding='0' cellspacing='0' style='border:solid 1px #CCCCCC; padding:5px'>
  <tr>
    <td colspan='4'>Id Produto: <strong>" . $row_rs_itens_produtos['id'] . "</strong></td>
  </tr>
   <tr>
    <td colspan='4'>Produto: <strong>" . utf8_decode($row_rs_itens_produtos['nome']) . "</strong></td>
  </tr>
  <tr>
    <td colspan='2'>Data do Retirada: <strong>" . formataData($row_rs_editar_item['data_retirada']) . "</strong></td>
    <td colspan='2'>Data da Devolu&ccedil;&atilde;o: <strong>" . formataData($row_rs_editar_item['data_devolucao']) . "</strong></td>
  </tr>
  <tr>   
    <td colspan='2'>Quantidade: <strong>" . $row_rs_editar_item['quantidade_produto'] . "</strong></td>
    <td colspan='2'>Pontua&ccedil;&atilde;o: <strong>" . $row_rs_itens_produtos['pontuacao'] . "</strong></td>
    
  </tr>  
  <tr>   
    <td colspan='2'>Coment&aacute;rio: <strong>" . $row_rs_contrato['comentario'] . "</strong></td>
    
  </tr> 
  <tr>   
    <td colspan='2'>Valor: <strong>" . "R$ " . $valor . "</strong></td>
    <td colspan='2'>Cor: <strong>" . $row_rs_mostrar_cor['nome'] . "</strong></td>
    
  </tr>
  <tr>
    
  </tr>";

  $somaPontuacao += $row_rs_itens_produtos['pontuacao'];
  $somaValor += $row_rs_itens_produtos['valor_venda'];

  $mensagem .= "</table>";
} while ($row_rs_editar_item = mysql_fetch_assoc($rs_editar_item));
$mensagem .= "
<table width='100%'  border='0' cellpadding='0' cellspacing='0'>
   <tr>
    <td  style='border:solid 1px #CCCCCC; padding:5px' ><strong>Total de " . $somaPontuacao . " pontos.</strong></td>
    <td  style='border:solid 1px #CCCCCC; padding:5px' ><strong>Valor total " . "R$ " . number_format($somaValor, 2, ',', '.') . " .</strong></td>
  </tr>
</table>

<table width='100%'  border='0' cellpadding='0' cellspacing='0'>
   <tr>
    <td  colspan='2'>" . $tipo2 . " " . date('d/m/Y') . "</td>
  </tr>
  <tr>
    <td  colspan='2'>&nbsp;</td>
  </tr>
  <tr>
    <td  colspan='2'>&nbsp;</td>
  </tr>
  <tr>
    <td align='center'>_________________________________________</td>
    <td align='center'>_________________________________________</td>
  </tr>
  <tr>
    <td align='center'><strong>Assinatura Cliente</strong></td>
    <td align='center'><strong>Assinatura Loja</strong></td>
  </tr>
</table>

</body>
</html>";

$mail->IsSMTP(); // telling the class to use SMTP


try {
  $mail->Host       = "smtp-vip.uni5.net"; // sets GMAIL as the SMTP server
  $mail->SMTPDebug  = 1; // enables SMTP debug information (for testing)
  $mail->SMTPAuth   = true; // enable SMTP authentication
  // $mail->SMTPSecure = "ssl";// sets the prefix to the servier
  $mail->Host       = "smtp-vip.uni5.net"; // sets GMAIL as the SMTP server
  $mail->Port       = 587; // set the SMTP port for the GMAIL server
  $mail->Username   = "minhanossa@minhanossa.net.br"; // GMAIL username
  $mail->Password   = "df123456"; // GMAIL password
  //$mail->AddReplyTo($_POST['email'], $_POST['nome']);
  $mail->AddAddress($row_rs_contrato['emailCliente']);
  //$mail->AddAddress('adriano@dfinformatica.com.br');
  $mail->SetFrom('contato@minhanossa.net.br', 'MINHA NOSSA');
  $mail->Subject = 'Comprovante de Aluguel - MINHA NOSSA';
  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
  $mail->MsgHTML($mensagem);
  $mail->Send();
} catch (phpmailerException $e) {
  echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
  echo $e->getMessage(); //Boring error messages from anything else!
}

echo "<script type='text/javascript'>alert('Mensagem enviada com sucesso!');window.location='contrato_cadastro.php?id={$_GET['id']}';</script>\n";
