<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

session_start();

$editFormAction = $_SERVER['PHP_SELF'];
if(isset($_SERVER['QUERY_STRING'])) {
	$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


mysql_select_db($database_conexao, $conexao);
$query_rs_cats = "SELECT * FROM tbl_cats ORDER BY categoria ASC";
$rs_cats = mysql_query($query_rs_cats, $conexao) or die(mysql_error());
$row_rs_cats = mysql_fetch_assoc($rs_cats);
$totalRows_rs_cats = mysql_num_rows($rs_cats);

mysql_select_db($database_conexao, $conexao);
$query_rs_subcategorias = "SELECT * FROM tbl_subcategorias WHERE id_categoria = {$row_rs_cats['id']} ORDER BY nome ASC";
$rs_subcategorias = mysql_query($query_rs_subcategorias, $conexao) or die(mysql_error());
$row_rs_subcategorias = mysql_fetch_assoc($rs_subcategorias);
$totalRows_rs_subcategorias = mysql_num_rows($rs_subcategorias);



if((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formAddCLiente")) {	
	
	  $insertSQL = sprintf("INSERT INTO tbl_pecas (id_categoria, tipo1, tamanho1, pontos1, tipo2, tamanho2, pontos2, tipo3, tamanho3, pontos3, tipo4, tamanho4, pontos4, tipo5, tamanho5, pontos5, tipo6, tamanho6, pontos6, categoria, foto, valor_loja, valor_loja2, valor_loja3, valor_loja4, valor_loja5, valor_loja6, id_subcategoria) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
			GetSQLValueString($_POST['id_categoria'], "text"),
            GetSQLValueString($_POST['tipo1'], "text"),
			GetSQLValueString($_POST['tamanho1'], "text"),					  
			GetSQLValueString($_POST['pontos1'], "text"),
			GetSQLValueString($_POST['tipo2'], "text"),
			GetSQLValueString($_POST['tamanho2'], "text"),					  
			GetSQLValueString($_POST['pontos2'], "text"),
			GetSQLValueString($_POST['tipo3'], "text"),
			GetSQLValueString($_POST['tamanho3'], "text"),					  
			GetSQLValueString($_POST['pontos3'], "text"),
	  		GetSQLValueString($_POST['tipo4'], "text"),
			GetSQLValueString($_POST['tamanho4'], "text"),					  
			GetSQLValueString($_POST['pontos4'], "text"),
			GetSQLValueString($_POST['tipo5'], "text"),
			GetSQLValueString($_POST['tamanho5'], "text"),					  
			GetSQLValueString($_POST['pontos5'], "text"),
			GetSQLValueString($_POST['tipo6'], "text"),
			GetSQLValueString($_POST['tamanho6'], "text"),					  
			GetSQLValueString($_POST['pontos6'], "text"),                  
            GetSQLValueString($_POST['categoria'], "text"),
			GetSQLValueString(upload('foto', '../img_noticias', 'N'), "text"),
			GetSQLValueString(valorCalculavel($_POST['valor_loja']), "text"),			 
			GetSQLValueString(valorCalculavel($_POST['valor_loja2']), "text"),			 
			GetSQLValueString(valorCalculavel($_POST['valor_loja3']), "text"),			 
			GetSQLValueString(valorCalculavel($_POST['valor_loja4']), "text"),			 
			GetSQLValueString(valorCalculavel($_POST['valor_loja5']), "text"),			 
            GetSQLValueString(valorCalculavel($_POST['valor_loja6']), "text"),
            GetSQLValueString($_POST['subcategoria'], "text"));			 
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
	$idConteudo = mysql_insert_id();
//echo $_POST['id'];
	marcaHistoricoAlteracao("Incluiu a Pe&ccedil;a: {$_POST['titulo']}.");
	
		 $deleteSQL = sprintf("DELETE FROM tbl_relaciona_categorias WHERE id_produto=%s",
                       GetSQLValueString($_POST['id'], "int"));

	  mysql_select_db($database_conexao, $conexao);
	  $Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());	
	
	
	if($_POST['id_categoria'] <> ''){
		foreach ($_POST['id_categoria'] as $item_categoria){
			$insertSQL = sprintf("INSERT INTO tbl_relaciona_categorias (id_categoria, id_produto) VALUES (%s, %s)",
			GetSQLValueString($item_categoria, "text"),						 
			GetSQLValueString($idConteudo, "text"));
			mysql_select_db($database_conexao, $conexao);
			$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
		}
	}
	
	if($_POST['id_subcategoria'] <> ''){
		foreach ($_POST['id_subcategoria'] as $item){
			$insertSQL = sprintf("INSERT INTO tbl_relaciona_categorias (id_subcategoria, id_produto) VALUES (%s, %s)",
		    GetSQLValueString($item, "text"),
            GetSQLValueString($idConteudo, "text"));
  			mysql_select_db($database_conexao, $conexao);
  			$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
		}	
	}
		
		

	
	echo "	<script>
			if(confirm('Deseja inserir mais fotos?')){
				window.location='controle-de-fotos-pecas.php?id=$idConteudo&tipo=Pecas';	
			}else{
				window.location='minhas_pecas.php';
			}
			</script>";
			exit;		
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Adicionar Pe&ccedil;as</title>

<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-fileupload.min.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-timepicker.min.css" type="text/css" />
<style type="text/css">
body,td,th {
	font-family: RobotoRegular, "Helvetica Neue", Helvetica, sans-serif;
}
</style>
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
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript" src="js/forms.js"></script>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="load.js"></script>

<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="ckeditor/ckfinder/ckfinder.js"></script>

<meta charset="UTF-8" />
</head>

<body>
<?php //include_once('head.php');?>

<div class="mainwrapper">
    
<?php include_once('header.php');?>
    
<?php include_once('inc_coluna.php');?>
    
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="minhas_pecas.php">Roupa</a> <span class="separator"></span></li>
            <li>Adicionar Roupa</li>
        </ul>
        <div class="maincontent">
            <div class="maincontentinner">
            
            <div class="widget">
            <h4 class="widgettitle"><span class="iconfa-edit"></span>Nova Peça</h4>
            <div class="widgetcontent">
           
           
               <form class="stdform" action="" method="post" name="formAddCLiente" id="formAddCLiente" enctype="multipart/form-data" />
                  
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-10 container_nome">
                                    Primeira Descrição<br>
                                    <div class="input-prepend ">
                                        <input name="tipo1" type="text" class="input-xxlarge" placeholder="Primeira descrição" />
                                    </div>
                                </div>
														</div>
                        </div>
							
                        <div class="row">
                            <div class="col-md-12">    

                                <div class="col-md-10 container_nome">
                                    Primeiro Tamanho<br>
                                    <div class="input-prepend ">
                                        <input name="tamanho1" type="text" class="input-xxlarge" placeholder="Primeiro tamanho" />
                                    </div>
                                </div>
														</div>
                        </div>
							
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-10 container_nome">
                                    Primeiro pontos<br>
                                    <div class="input-prepend ">
                                        <input name="pontos1" type="text" class="input-xxlarge" placeholder="Primeiro pontos" />
                                    </div>
                                </div>
														</div>
                        </div>
							
				       <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-10 container_nome">
                                    Valor nas outras lojas<br>
                                    <div class="input-prepend ">
                                        <input name="valor_loja" type="text" class="input-xxlarge" placeholder="Valor nas outras lojas" />
                                    </div>
                                </div>
							</div>
                        </div>
				
				
						<div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-10 container_nome">
                                    Segunda Descrição<br>
                                    <div class="input-prepend ">
                                        <input name="tipo2" type="text" class="input-xxlarge" placeholder="Segunda descrição" />
                                    </div>
                                </div>
														</div>
                        </div>
							
                        <div class="row">
                            <div class="col-md-12">    

                                <div class="col-md-10 container_nome">
                                    Segundo Tamanho<br>
                                    <div class="input-prepend ">
                                        <input name="tamanho2" type="text" class="input-xxlarge" placeholder="Segunda tamanho" />
                                    </div>
                                </div>
														</div>
                        </div>
							
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-10 container_nome">
                                    Segundo pontos<br>
                                    <div class="input-prepend ">
                                        <input name="pontos2" type="text" class="input-xxlarge" placeholder="Segundo pontos" />
                                    </div>
                                </div>
														</div>
                        </div>
							
			      	 
				     <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-10 container_nome">
                                    Valor nas outras lojas<br>
                                    <div class="input-prepend ">
                                        <input name="valor_loja2" type="text" class="input-xxlarge" placeholder="Valor nas outras lojas" />
                                    </div>
                                </div>
							</div>
                        </div> 
							
						<div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-10 container_nome">
                                    Terceiro Descrição<br>
                                    <div class="input-prepend ">
                                        <input name="tipo3" type="text" class="input-xxlarge" placeholder="Terceiro descrição" />
                                    </div>
                                </div>
							</div>
                        </div>
							
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-10 container_nome">
                                    Terceiro Tamanho<br>
                                    <div class="input-prepend ">
                                        <input name="tamanho3" type="text" class="input-xxlarge" placeholder="Terceiro tamanho" />
                                    </div>
                                </div>
							</div>
                        </div>
							
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-10 container_nome">
                                   Terceiro pontos<br>
                                    <div class="input-prepend ">
                                        <input name="pontos3" type="text" class="input-xxlarge" placeholder="Terceiro pontos" />
                                    </div>
                                </div>
							</div>
                        </div>
					     	
				        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-10 container_nome">
                                    Valor nas outras lojas<br>
                                    <div class="input-prepend ">
                                        <input name="valor_loja3" type="text" class="input-xxlarge" placeholder="Valor nas outras lojas" />
                                    </div>
                                </div>
							</div>
                        </div>
				
						<div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-10 container_nome">
                                   	Quarta Descrição<br>
                                    <div class="input-prepend ">
                                        <input name="tipo4" type="text" class="input-xxlarge" placeholder="Quarta descrição" />
                                    </div>
                                </div>
							</div>
                        </div>
							
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-10 container_nome">
                                    Quarto Tamanho<br>
                                    <div class="input-prepend ">
                                        <input name="tamanho4" type="text" class="input-xxlarge" placeholder="Quarto tamanho" />
                                    </div>
                                </div>
							</div>
                        </div>
							
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-10 container_nome">
                                   Quarto pontos<br>
                                    <div class="input-prepend ">
                                        <input name="pontos4" type="text" class="input-xxlarge" placeholder="Quarto pontos" />
                                    </div>
                                </div>
							</div>
                        </div>
				
				       <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-10 container_nome">
                                    Valor nas outras lojas<br>
                                    <div class="input-prepend ">
                                        <input name="valor_loja4" type="text" class="input-xxlarge" placeholder="Valor nas outras lojas" />
                                    </div>
                                </div>
							</div>
                        </div>
					
						<div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-10 container_nome">
                                    Quinta Descrição<br>
                                    <div class="input-prepend ">
                                        <input name="tipo5" type="text" class="input-xxlarge" placeholder="Quinta descrição" />
                                    </div>
                                </div>
							</div>
                        </div>
							
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-10 container_nome">
                                    Quinto Tamanho<br>
                                    <div class="input-prepend ">
                                        <input name="tamanho5" type="text" class="input-xxlarge" placeholder="Quinto tamanho" />
                                    </div>
                                </div>
							</div>
                        </div>
							
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-10 container_nome">
                                   Quinto pontos<br>
                                    <div class="input-prepend ">
                                        <input name="pontos5" type="text" class="input-xxlarge" placeholder="Quinto pontos" />
                                    </div>
                                </div>
							</div>
                        </div>
				
				      <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-10 container_nome">
                                    Valor nas outras lojas<br>
                                    <div class="input-prepend ">
                                        <input name="valor_loja5" type="text" class="input-xxlarge" placeholder="Valor nas outras lojas" />
                                    </div>
                                </div>
							</div>
                        </div>
				   
				
						<div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-10 container_nome">
                                    Sexta Descrição<br>
                                    <div class="input-prepend ">
                                        <input name="tipo6" type="text" class="input-xxlarge" placeholder="Sexta descrição" />
                                    </div>
                                </div>
							</div>
                        </div>
							
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-10 container_nome">
                                    Sexto Tamanho<br>
                                    <div class="input-prepend ">
                                        <input name="tamanho6" type="text" class="input-xxlarge" placeholder="Sexto tamanho" />
                                    </div>
                                </div>
							</div>
                        </div>
							
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-10 container_nome">
                                   Sexto pontos<br>
                                    <div class="input-prepend ">
                                        <input name="pontos6" type="text" class="input-xxlarge" placeholder="Sexto pontos" />
                                    </div>
                                </div>
							</div>
                        </div>
                            
                        <div class="row">
						<div class="col-md-12">
							<div class="col-md-4 container_nome">
								Categorias<br> <!--aqui -->
								<div class="input-prepend ">
									
										<?php do{
									
									?>
											
										  <div class="col-md-12 container_nome" style="font-size: 12px;">	
											  <input name="id_categoria[]" type="checkbox" data-id="<?php echo $row_rs_cats['id'];?>" value="<?php echo $row_rs_cats['id'];?>">
											  &nbsp; <?php echo $row_rs_cats['categoria'];?>											  
										  </div>
									<?php
												 
												 
												 
										
											mysql_select_db($database_conexao, $conexao);
		 $query_rs_subcategoria = sprintf("SELECT * FROM tbl_subcategorias WHERE id_categoria = %s", GetSQLValueString($row_rs_cats['id'], "int"));
		$rs_subcategoria = mysql_query($query_rs_subcategoria, $conexao) or die(mysql_error());
		$row_rs_subcategoria = mysql_fetch_assoc($rs_subcategoria);
		$totalRows_rs_subcategoria = mysql_num_rows($rs_subcategoria); ?>
									
									
									
										<?php 
												 if ($totalRows_rs_subcategoria >0){
													 
												 
												 
												 
												 do{
									
																		mysql_select_db($database_conexao, $conexao);
		$query_rs_existe_subcat = sprintf("SELECT * FROM tbl_relaciona_categorias WHERE id_subcategoria = %s and id_produto = '{$_GET[id]}'", GetSQLValueString($row_rs_subcategoria['id'], "int"));
		$rs_existe_subcat = mysql_query($query_rs_existe_subcat, $conexao) or die(mysql_error());
		$row_rs_existe_subcat = mysql_fetch_assoc($rs_existe_subcat);
		$totalRows_rs_existe_subcat = mysql_num_rows($rs_existe_subcat);
									
									?>     
								
										  <div class="col-md-12 container_nome" style="font-size: 12px;">	
											  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="id_subcategoria[]" data-id="<?php echo $row_rs_subcategoria['id'];?>" value="<?php echo $row_rs_subcategoria['id'];?>" <?php if($totalRows_rs_existe_subcat > 0){ echo "checked";}?>>
											  &nbsp; <?php echo $row_rs_subcategoria['nome'];?>											  
										  </div>									
									
									<?php }
										while($row_rs_subcategoria = mysql_fetch_assoc($rs_subcategoria));
										}
									?> 									
									
										<?php }while($row_rs_cats = mysql_fetch_assoc($rs_cats));?>									  
								</div>					
												
								
								
								
								
								
								
							</div>
						</div>
                    </div>
							
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-10 container_nome">
                                    Foto Principal<br>
                                    <div class="input-prepend ">
                                        <input name="foto" type="file" class="input-xxlarge" />
                                    </div>
                                </div>
							</div>
                        </div>
				
				         <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-10 container_nome">
                                   Valor nas outras lojas<br>
                                    <div class="input-prepend ">
                                        <input name="valor_loja6" type="text" class="input-xxlarge" placeholder="Valor nas outras lojas" />
                                    </div>
                                </div>
							</div>
                        </div>
				
                      <div class="row">
                      	<div class="col-md-12" align="right">
                        	 <a href="javascript:;" onClick="document.getElementById('formAddCLiente').submit();" class="btn btn-mini btn-success"> <i class="iconfa-ok"></i>&nbsp; Salvar</a>
                             <a href="cliente.php" class="btn btn-danger btn-mini"> <i class="iconfa-remove"></i>&nbsp; Cancelar</a>
                        </div>
                      </div>
                   
                   <input type="hidden" name="MM_insert" id="MM_insert" value="formAddCLiente">
                   <input type="hidden" name="acao" value="<?=$_GET['acao'];?>">
                </form>
           
            </div><!--widgetcontent-->
            </div><!--widget-->
            
       
            <?php include_once('footer.php');?>