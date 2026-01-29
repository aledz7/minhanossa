<? include('../admin/funcoes.php');?>
<html>
<head>
<title>::Pagamento PayPal::</title>
</head>

<body onLoad="document.paypal.submit();">
<form method="post" action="php_paypal/process.php" name="paypal" id="paypal">
<input type="hidden" name="amount" value="<?=valorCalculavel($_POST[produto_valor]);?>">
<input type="hidden" name="item_name" value="<?=$_POST[produto_descricao];?>">
<input type="hidden" name="item_number" value="<?=$_POST[idCompra];?>">
<input type="hidden" name="emailEmp" value="<?=$_POST[email_loja];?>">
<input type="hidden" name="idioma" value="BR">
<input type="submit" value=" Pay ">
</form>

</head>
</html>