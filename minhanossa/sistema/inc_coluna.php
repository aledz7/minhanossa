<?php
mysql_select_db($database_conexao, $conexao);
$query_rs_temAcesso = "SELECT tbl_acessos.*, (select count(1) from tbl_admin_acessos where tbl_admin_acessos.id_usuario = '{$_SESSION['dadosUser']['id']}' and tbl_admin_acessos.id_acesso = tbl_acessos.id) as temAcesso FROM tbl_acessos";
$rs_temAcesso = mysql_query($query_rs_temAcesso, $conexao) or die(mysql_error());
$row_rs_temAcesso = mysql_fetch_assoc($rs_temAcesso);
$totalRows_rs_temAcesso = mysql_num_rows($rs_temAcesso);

mysql_select_db($database_conexao, $conexao);
$query_rs_temTextos = "SELECT * FROM tbl_textos WHERE ativo = 'S' ORDER BY nome ASC";
$rs_temTextos = mysql_query($query_rs_temTextos, $conexao) or die(mysql_error());
$row_rs_temTextos = mysql_fetch_assoc($rs_temTextos);
$totalRows_rs_temTextos = mysql_num_rows($rs_temTextos);

do {
	if($row_rs_temAcesso['temAcesso'] > 0) {
		$temAcessos[$row_rs_temAcesso['id']] = 'S';
	}
} while($row_rs_temAcesso = mysql_fetch_assoc($rs_temAcesso));

?>
<div class="leftpanel">
    <div class="leftmenu">
      <ul class="nav nav-tabs nav-stacked">
        <li class="nav-header">Navega&ccedil;&atilde;o</li>
        <li <?php if(basename($_SERVER['SCRIPT_NAME']) == 'index.php'){ echo "class='active'";}?>><a href="."><span class="iconfa-home"></span> Home</a></li>
         <li class="dropdown <?php if(basename($_SERVER['SCRIPT_NAME']) == 'usuario.php' or basename($_SERVER['SCRIPT_NAME']) == 'loja.php' or basename($_SERVER['SCRIPT_NAME']) == 'contrato.php' or basename($_SERVER['SCRIPT_NAME']) == 'add_usuario.php' or basename($_SERVER['SCRIPT_NAME']) == 'editar_usuario.php' or basename($_SERVER['SCRIPT_NAME']) == 'add_loja.php' or basename($_SERVER['SCRIPT_NAME']) == 'editar_loja.php' or basename($_SERVER['SCRIPT_NAME']) == 'assinatura.php'){ echo "active";}?>">
            <a href=""><span class="iconfa-briefcase"></span> Site</a>
          <ul>
          <?php if($totalRows_rs_temTextos > 0){?>
		  <?php if($temAcessos[36] == 'S') { ?>
           <?php do{?>
            <li><a href="editarTextos.php?id=<?php echo $row_rs_temTextos['id'];?>"><?php echo $row_rs_temTextos['titulo'];?> (texto)</a></li>
           <?php }while($row_rs_temTextos = mysql_fetch_assoc($rs_temTextos));?>
		  <?php }?>
          <?php }?>
		  <?php if($temAcessos[34] == 'S') { ?>
          <li><a href="blog.php">Blog</a></li>
		  <?php }?>
		  <?php if($temAcessos[35] == 'S') { ?>
          <li><a href="planos.php">Planos</a></li>
		  <?php } ?>
		  <?php if($temAcessos[37] == 'S') { ?>
          <li><a href="marcas.php">Marcas</a></li>
		  <?php }?>

      <?php if($temAcessos[40] == 'S') { ?>
          <li><a href="fotos.php">Home Page</a></li>
      <?php }?>
			  
			  <?php if($temAcessos[40] == 'S') { ?>
          <li><a href="fotos_feed.php">Fotos Loja</a></li>
      <?php }?>

					
			<?php if($temAcessos[39] == 'S') { ?>
				<li><a href="minhas_pecas.php">Minhas Pe&ccedil;as</a></li>
			<?php }?>
			  
			<?php if($temAcessos[39] == 'S') { ?>
				<li><a href="nosso_acervo.php">Nosso Acervo</a></li>
			<?php }?>

          
      <?php if($temAcessos[39] == 'S') { ?>
        <li><a href="cats.php">Categorias (Pe&ccedil;as)</a></li>
      <?php }?>
						
		  <?php if($temAcessos[38] == 'S') { ?>
          <li><a href="termo-de-uso.php">Termo de Uso</a></li>
		  <?php } ?>
          </ul>
        </li>
        <li class="dropdown <?php if(basename($_SERVER['SCRIPT_NAME']) == 'usuario.php' or basename($_SERVER['SCRIPT_NAME']) == 'loja.php' or basename($_SERVER['SCRIPT_NAME']) == 'contrato.php' or basename($_SERVER['SCRIPT_NAME']) == 'add_usuario.php' or basename($_SERVER['SCRIPT_NAME']) == 'editar_usuario.php' or basename($_SERVER['SCRIPT_NAME']) == 'add_loja.php' or basename($_SERVER['SCRIPT_NAME']) == 'editar_loja.php' or basename($_SERVER['SCRIPT_NAME']) == 'assinatura.php'){ echo "active";}?>">
            <a href=""><span class="iconfa-briefcase"></span> Administra&ccedil;&atilde;o</a>
          <ul>
          <?php if($temAcessos[1] == 'S') { ?>
            <li><a href="usuario.php">Usu&aacute;rio / Funcion&aacute;rios</a></li>
          <?php } ?>
         <?php if($temAcessos[2] == 'S') { ?>
            <li><a href="editar_loja.php?id=2">Configura&ccedil;&otilde;es</a></li>
            <?php } ?>
          <?php if($temAcessos[3] == 'S') { ?>
            <li><a href="contrato.php">Cl&aacute;usulas do Contrato</a></li>
            <?php } ?>
          </ul>
        </li>
        <li class="dropdown <?php if(basename($_SERVER['SCRIPT_NAME']) == 'cliente.php' or basename($_SERVER['SCRIPT_NAME']) == 'contrato_cadastro.php' or basename($_SERVER['SCRIPT_NAME']) == 'produto.php'){ echo "active";}?>"><a href=""><span class="iconfa-edit"></span> Cadastro</a>
          <ul>
          <?php if($temAcessos[4] == 'S') { ?>
            <li><a href="cliente.php">Cliente</a></li>
            <?php } ?>
            
            <?php if($temAcessos[21] == 'S') { ?>
            <li><a href="planos.php">Planos</a></li>
            <?php } ?>
            
			 
            <li><a href="emprestimo.php">Prazo do Empr&eacute;stimo</a></li>
            
			  
             <?php if($temAcessos[5] == 'S') { ?>
            <li><a href="fornecedores.php">Fornecedores</a></li>
            <?php } ?>
            
            
            
			<?php if($temAcessos[7] == 'S') { ?>
            <li><a href="produto.php">Produtos</a></li>
             <?php } ?>
            
			<?php if($temAcessos[8] == 'S') { ?>
            <li><a href="categoria_produto.php">Categoria de Produto</a></li>
             <?php } ?>
             
             <?php if($temAcessos[22] == 'S') { ?>
             <li><a href="colecao_produto.php">Cole&ccedil;&atilde;o</a></li>
             <?php } ?>
             <?php if($temAcessos[23] == 'S') { ?>
             <li><a href="cores.php">Cores</a></li>
             <?php } ?>
             <?php if($temAcessos[24] == 'S') { ?>
             <li><a href="composicoes.php">Tipo Lavagem</a></li>
             <?php } ?>
             <?php if($temAcessos[25] == 'S') { ?>
             <li><a href="forma_pagamento.php">Formas de Pagamento</a></li>
             <?php } ?>
             <?php if($temAcessos[26] == 'S') { ?>
             <li><a href="cartao_presente.php">Prazos e Empr&eacute;stimos</a></li>
             <?php } ?>
          </ul>
        </li>
        <?php if($temAcessos[33] == 'S') { ?>
            <li><a href="contrato_cadastro.php?mes=<?php echo date('m');?>&ano=<?php echo date('Y');?>"><span class="iconfa-edit"></span>Aluguel</a></li>
             <?php } ?>
        <?php if($temAcessos[28] == 'S') { ?>
        <li ><a href="ajustes.php"><span class="iconfa-edit"></span> Consertos</a></li>
        <?php } ?>
        <?php if($temAcessos[32] == 'S') { ?>
        <li ><a href="lista-espera.php"><span class="iconfa-edit"></span> Reserva de Pe&ccedil;as</a></li>
        <?php } ?>
        
        <?php if($temAcessos[29] == 'S') { ?>
        <li ><a href="lavanderia.php"><span class="iconfa-edit"></span> Lavanderia</a></li>
        <?php } ?>

        <?php if($temAcessos[30] == 'S') { ?>
        <li ><a href="localiza-peca.php"><span class="iconfa-edit"></span> Localizar Pe&ccedil;a</a></li>
        <?php } ?>

     <?php /*?>   <?php if($temAcessos[31] == 'S') { ?>
        <li ><a href="descarta-peca.php"><span class="iconfa-edit"></span> Descartar Pe&ccedil;a</a></li>
        <?php } ?><?php */?>
        
        <?php if($temAcessos[20] == 'S') { ?>
        <li ><a href="ordem-de-servico.php"><span class="iconfa-briefcase"></span> Ordem de Servi&ccedil;o</a></li>
        <?php } ?>
        
        <?php if($temAcessos[10] == 'S') { ?>
        <li ><a href="retiradas.php?tipo=Retiradas"><span class="iconfa-edit"></span> Retiradas</a>
         <?php } ?>
          <?php /*?><ul>
          <?php if($temAcessos[9] == 'S') { ?>
            <li><a href="provas.php?tipo=Provas">Provas</a></li>
            <?php } ?>
             
            <?php if($temAcessos[11] == 'S') { ?>
            <li><a href="devolucoes_pendentes.php">Devolu&ccedil;&otilde;es Pendentes</a></li>
            <?php } ?>
            
            <?php if($temAcessos[12] == 'S') { ?>
            <li><a href="agenda.php">Minha Agenda</a></li>
            <?php } ?>
            
          </ul><?php */?>
        </li>
         <?php if($temAcessos[11] == 'S') { ?>
        <li ><a href="devolucoes_pendentes.php"><span class="iconfa-edit"></span> Devolu&ccedil;&otilde;es Pendentes</a>
         <?php } ?>
       
        
        <?php /*?><li class="dropdown "><a href=""><span class="iconfa-briefcase"></span> Financeiro</a>
          <ul>
          <?php if($temAcessos[13] == 'S') { ?>
            <li><a href="caixa.php">Caixa</a></li>
            <?php } ?>
            
            <?php if($temAcessos[14] == 'S') { ?>
            <li><a href="contas.php?tipo=D">Contas a Pagar</a></li>
            <?php } ?>
            
            <?php if($temAcessos[15] == 'S') { ?>
            <li><a href="contas.php?tipo=R">Contas a Receber</a></li>
            <?php } ?>
          </ul>
        </li><?php */?>
        
        <?php /*if($temAcessos[16] == 'S') { 
				
				//print_r($_SESSION);
				?>
        <li class="dropdown "><a href=""><span class="iconfa-briefcase"></span> Folha de Ponto</a>
          <ul>
          	
            <li><a href="javascript:;" onClick="marcaPonto('chegada')">Marcar Chegada</a></li>
            <li><a href="javascript:;" onClick="marcaPonto('sdAlmoco')">Sa�da para Almo�o</a></li>
            <li><a href="javascript:;" onClick="marcaPonto('chAlmoco')">Chegada do Almo�o </a></li>
            <li><a href="javascript:;" onClick="marcaPonto('saida')">Marcar Sa�da</a></li>
          </ul>
        </li>
        <?php }*/?>
        
        <li class="dropdown "><a href=""><span class="iconfa-briefcase"></span> Relat&oacute;rios</a>
          <ul>
        <?php /*?>  <?php if($temAcessos[17] == 'S') { ?>
            <li><a href="comissoes.php">Comiss&otilde;es</a></li>
            <?php } ?>
            <?php */?>
         <?php /*?>   <?php if($temAcessos[18] == 'S') { ?>
            <li><a href="folha-de-ponto.php">Folha de Ponto</a></li>
            <?php } ?><?php */?>
            
            <?php if($temAcessos[19] == 'S') { ?>
            <li><a href="historico-alteracoes.php">Hist&oacute;rico de Altera&ccedil;&otilde;es</a></li>
            <?php } ?>
            
            <?php if($temAcessos[27] == 'S') { ?>
            <li><a href="relatorio-cliente.php">Cliente</a></li>
            <?php } ?>
			 <?php if($temAcessos[27] == 'S') { ?>
            <li><a href="relatorio-produto.php">Relatorio de Pe&ccedil;as</a></li>
            <?php } ?> 
          </ul>
        </li>
   		<li><a href="news.php"><span class="iconfa-email"></span>Newsletter</a></li>
        
        
      </ul>
    </div>
  </div>
<iframe src="" name="enviaColuna" id="enviaColuna" style="display:none" frameborder="0"></iframe>

<?php // print_r($temAcessos);?>