<?php
@session_start();

if($_SESSION['popUpAbriu'] == '') {
?>
<link rel="stylesheet" type="text/css" href="ferramentas/newsletter-popup/css/subscribe-better.css" />
<script type="text/javascript" src="ferramentas/newsletter-popup/js/jquery.subscribe-better.js"></script>
<style>
/* Default Demo Style */
@import url(http://fonts.googleapis.com/css?family=Roboto:300,400,700);
</style>
<div class="subscribe-me">
  <h2 style="font-size:1.5em; font-weight: 300; font-family: 'Roboto',Arial,sans-serif;">Seja Bem-Vindo</h2>
  <a href="#close" class="sb-close-btn">x</a>
  <p style="color: black; font-size: 16px; font-weight: 100; font-family: 'Roboto',Arial,sans-serif;">Cadastre-se e receba promoções e ofertas por e-mail</p>
  <form method="post" id="formNewsletterPopUp">
    <input name="email" type="email" id="email" placeholder="Seu e-mail" style="color:hsla(0,0%,0%,1.00)">
    <input type="submit" value="Confirmar">
    <input type="hidden" name="acao" value="addNewsletter">
  </form>
</div>
<script type="text/javascript">
// Usar $ caso seja jquery padrão
gfx(document).ready( function() {
	gfx(".subscribe-me").subscribeBetter();
});
</script>
<?php
$_SESSION['popUpAbriu'] = 'S';
}
?>