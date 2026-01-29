<link href="dialog-jquery/css/jquery.window.css" rel="stylesheet" type="text/css" />
<link href="autocomplete-jquery/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="autocomplete-jquery/jquery-ui.min.js"></script>
<script src="dialog-jquery/jquery.window.js"></script>
<script>

function abreJanelaJquery(url, titulo, comentario, largura, altura, janela) { // create a iframe window

/// ajustes pra funcionar no ie
if(url.substr(-3,3) == 'php') {
pagina = url + '?janela=' + janela; } else {
pagina = url + '&janela=' + janela; }

   window["temp_" + janela] = $.window({
      title: titulo,
      url: pagina,
	  bookmarkable: false,
	  footerContent: comentario,
	  width: largura,
	  height: altura, /// inteiro (Sem px)
	  y: 90
   });
	
}

// exemplo
// onclick="abreJanelaJquery('clientes.php', 'transações', 'nenhum comentário', '700px', '500')"
</script>