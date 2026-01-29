<?php 
//session_start();
include('Connections/conexao.php');
include('funcoes.php');

	if($_GET[acao] == 'excluirUsuario') {
		mysql_select_db($database_conexao, $conexao);
		
		$deleteSQL = sprintf("DELETE FROM tbl_admin WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
	
	echo "
	<script>
		window.location='usuario.php';
	</script>
	";
	}

if($_GET[acao] == 'excluiracervo') {
		mysql_select_db($database_conexao, $conexao);
		
		$deleteSQL = sprintf("DELETE FROM tbl_acervo WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
	
	echo "
	<script>
		window.location='nosso_acervo.php';
	</script>
	";
	}

	if($_GET[acao] == 'excluirProduto') {
		mysql_select_db($database_conexao, $conexao);
		
		$deleteSQL = sprintf("DELETE FROM tbl_produto WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
	
	echo "
	<script>
		window.location='produto.php';
	</script>
	";
	}
	if($_GET[acao] == 'excluirLoja') {
		mysql_select_db($database_conexao, $conexao);
		
		$deleteSQL = sprintf("DELETE FROM tbl_loja WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
	
	echo "
	<script>
		window.location='loja.php';
	</script>
	";
	}


	if($_GET[acao] == 'excluirCats') {
		mysql_select_db($database_conexao, $conexao);
		
		$deleteSQL = sprintf("DELETE FROM tbl_cats WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
	
	echo "
	<script>
		window.location='cats.php';
	</script>
	";
	}






	if($_GET[acao] == 'excluirCliente') {
		mysql_select_db($database_conexao, $conexao);
		
		$deleteSQL = sprintf("DELETE FROM tbl_cliente WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
	
	echo "
	<script>
		window.location='cliente.php';
	</script>
	";
	}
	
	
	if($_GET[acao] == 'excluirFornecedor') {
		mysql_select_db($database_conexao, $conexao);
		$deleteSQL = sprintf("DELETE FROM tbl_fornecedores WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
		mysql_select_db($database_conexao, $conexao);
		$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
	
		echo "	<script>
				window.location='fornecedores.php';
				</script>";
				exit;
	}
	
	if($_GET[acao] == 'excluirContrato') {
		mysql_select_db($database_conexao, $conexao);
		
		$deleteSQL = sprintf("DELETE FROM tbl_contrato WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
	
	echo "	<script>
			window.location='contrato_cadastro.php';
			</script>";
			exit;
	}
	if($_GET[acao] == 'excluirCatProduto') {
		mysql_select_db($database_conexao, $conexao);

		$deleteSQL = sprintf("DELETE FROM tbl_subcategorias WHERE id_categoria=%s",
                       GetSQLValueString($_GET['id'], "int"));
		mysql_select_db($database_conexao, $conexao);
		$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
		
		$deleteSQL = sprintf("DELETE FROM tbl_categoria WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
	
	echo "
	<script>
		window.location='categoria_produto.php';
	</script>
	";
	}
	if($_GET[acao] == 'excluirContas') {
		mysql_select_db($database_conexao, $conexao);
		$deleteSQL = sprintf("DELETE FROM tbl_contas WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
		mysql_select_db($database_conexao, $conexao);
		$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
	
		echo "	<script>
				window.location='contas.php?tipo={$_GET['tipo']}';
				</script>";
				exit;
	}
	if($_GET[acao] == 'excluirContasReceber') {
		mysql_select_db($database_conexao, $conexao);
		
		$deleteSQL = sprintf("DELETE FROM tbl_contas_receber WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
	
	echo "
	<script>
		window.location='contas_receber.php';
	</script>
	";
	}
        
        if($_GET[acao] == 'excluirPlano') {
		mysql_select_db($database_conexao, $conexao);
		
		$deleteSQL = sprintf("DELETE FROM tbl_plano WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
	
	echo "
	<script>
		window.location='planos.php';
	</script>
	";
	}

if($_GET[acao] == 'excluirMarca') {
		mysql_select_db($database_conexao, $conexao);
		
		$deleteSQL = sprintf("DELETE FROM tbl_marcas WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
	
	echo "
	<script>
		window.location='marcas.php';
	</script>
	";
	}




if($_GET[acao] == 'excluirFotos') {
		mysql_select_db($database_conexao, $conexao);
		
		$deleteSQL = sprintf("DELETE FROM tbl_home WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
	
	echo "
	<script>
		window.location='fotos.php';
	</script>
	";
	}





if($_GET[acao] == 'excluirPecas') {
		mysql_select_db($database_conexao, $conexao);
		
		$deleteSQL = sprintf("DELETE FROM tbl_pecas WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
	
	echo "
	<script>
		window.location='minhas_pecas.php';
	</script>
	";
	}
        
        if($_GET[acao] == 'excluirColecaoProduto') {
		mysql_select_db($database_conexao, $conexao);
		
		$deleteSQL = sprintf("DELETE FROM tbl_colecao WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
	
	echo "
	<script>
		window.location='colecao_produto.php';
	</script>
	";
	}
        if($_GET[acao] == 'excluirCores') {
		mysql_select_db($database_conexao, $conexao);
		
		$deleteSQL = sprintf("DELETE FROM tbl_cores WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
	
	echo "
	<script>
		window.location='cores.php';
	</script>
	";
	}
        
        if($_GET[acao] == 'excluirComposicao') {
		mysql_select_db($database_conexao, $conexao);
		
		$deleteSQL = sprintf("DELETE FROM tbl_composicoes WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
	
	echo "
	<script>
		window.location='composicoes.php';
	</script>
	";
	}
        if($_GET[acao] == 'excluirFormaPagamento') {
		mysql_select_db($database_conexao, $conexao);
		
		$deleteSQL = sprintf("DELETE FROM tbl_forma_pagamento WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
	
	echo "
	<script>
		window.location='forma_pagamento.php';
	</script>
	";
	}
        if($_GET[acao] == 'excluirCartaoPresente') {
		mysql_select_db($database_conexao, $conexao);
		
		$deleteSQL = sprintf("DELETE FROM tbl_cartao_presente WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
	
	echo "
	<script>
		window.location='cartao_presente.php';
	</script>
	";
	}

	if($_GET[acao] == 'excluirBlog') {
		mysql_select_db($database_conexao, $conexao);
		
		$deleteSQL = sprintf("DELETE FROM tbl_blog WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
	
	echo "
	<script>
		window.location='blog.php';
	</script>
	";
	}

	if($_GET['acao'] == 'excluirSubcatProduto') {
		mysql_select_db($database_conexao, $conexao);
		$deleteSQL = sprintf("DELETE FROM tbl_subcategorias WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
		mysql_select_db($database_conexao, $conexao);
		$Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
	
		echo "
		<script>
			window.location='sub_cat_produto.php?id_categoria={$_GET['id_categoria']}';
		</script>";
	}
?>