<?php if ($_SESSION["pagamento"] == "PayPal") { ?>
<form action="payment.php" method="post" name="pgPayPal" id="pgPayPal" style="text-align:center; margin-bottom:10px;">
<input name="email_loja" type="hidden" value="financeiro@vsracing.com.br">
<input name="produto_descricao" type="hidden" value="<?=$produtos_nomes;?>">
<input name="produto_valor" type="hidden" value="<?=$total_prods+$_SESSION['total_frete'];?>" >
<input name="idCompra" type="hidden" value="<?=$_SESSION['compra'];?>" >
<input name="Comprar" type="submit" class="style_bt_vermelho" style="padding:3px;" id="Comprar" value="Clique aqui para efetuar o pagamento!">
</form> 
<script>
document.getElementById('pgPayPal').submit();
</script>
<?php 
 
} ?>

<!--echo " <script> window.location='$url'</script>"; -->