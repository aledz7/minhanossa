<?php
if($HTMLInstanciada == '') {
	include('funcoes.php');
	
	class HTML {
		function nenhumRegistro($mensagem="Nenhum registro encontrado.") {
			?>
            <div align="center" style="margin-bottom:27px; font-size:15px;"><?=$mensagem;?></div>
            <?
		}
	}
	
	$HTMLInstanciada = 'S';
}
