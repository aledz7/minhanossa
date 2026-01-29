<?php
include('Connections/conexao.php');
include('restrito.php');
include('funcoes.php');

mysql_select_db($database_conexao, $conexao);
$query_rs_categoria = "SELECT * FROM tbl_categoria ORDER BY categoria ASC";
$rs_categoria = mysql_query($query_rs_categoria, $conexao) or die(mysql_error());
$row_rs_categoria = mysql_fetch_assoc($rs_categoria);
$totalRows_rs_categoria = mysql_num_rows($rs_categoria);

mysql_select_db($database_conexao, $conexao);
$query_rs_fornecedor = "SELECT * FROM tbl_fornecedores ORDER BY nome ASC";
$rs_fornecedor = mysql_query($query_rs_fornecedor, $conexao) or die(mysql_error());
$row_rs_fornecedor = mysql_fetch_assoc($rs_fornecedor);
$totalRows_rs_fornecedor = mysql_num_rows($rs_fornecedor);

mysql_select_db($database_conexao, $conexao);
$query_rs_colecao = "SELECT * FROM tbl_colecao ORDER BY nome ASC";
$rs_colecao = mysql_query($query_rs_colecao, $conexao) or die(mysql_error());
$row_rs_colecao = mysql_fetch_assoc($rs_colecao);
$totalRows_rs_colecao = mysql_num_rows($rs_colecao);

mysql_select_db($database_conexao, $conexao);
$query_rs_cores = "SELECT * FROM tbl_cores ORDER BY nome ASC";
$rs_cores = mysql_query($query_rs_cores, $conexao) or die(mysql_error());
$row_rs_cores = mysql_fetch_assoc($rs_cores);
$totalRows_rs_cores = mysql_num_rows($rs_cores);

mysql_select_db($database_conexao, $conexao);
$query_rs_composicao = "SELECT * FROM tbl_composicoes ORDER BY nome ASC";
$rs_composicao = mysql_query($query_rs_composicao, $conexao) or die(mysql_error());
$row_rs_composicao = mysql_fetch_assoc($rs_composicao);
$totalRows_rs_composicao = mysql_num_rows($rs_composicao);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formProduto")) {
    $code_number = $_POST['codigoBarra'];
    /*mysql_select_db($database_conexao, $conexao);
	$query_rs_confere_codigo = "SELECT * FROM tbl_produto WHERE codigoBarra = '".str_pad($_POST['codigoBarra'], 12, "0", STR_PAD_LEFT)."'";
	$rs_confere_codigo = mysql_query($query_rs_confere_codigo, $conexao) or die(mysql_error());
	$row_rs_confere_codigo = mysql_fetch_assoc($rs_confere_codigo);
	$totalRows_rs_confere_codigo = mysql_num_rows($rs_confere_codigo);
	
	if($totalRows_rs_confere_codigo > 0){
		
		echo "	<script>
			alert('Código de barra já cadastrado em nosso sistema.');
			history.back();
			</script>";
			exit;
	}else{*/


    $insertSQL = sprintf(
        "INSERT INTO tbl_produto (categoria, qnt_estoque, nome, preco_custo, valor_aluguel, valor_venda, foto, tipo, id_fornecedor, id_colecao, id_composicao, descricao, id_cor, numeracao, pontuacao, modo_lavagem, codigoBarra, origem, status) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($_POST['categoria'], "int"),
        GetSQLValueString($_POST['qnt_estoque'], "int"),
        GetSQLValueString($_POST['nome'], "text"),
        GetSQLValueString(valorCalculavel($_POST['preco_custo']), "int"),
        GetSQLValueString(valorCalculavel($_POST['valor_aluguel']), "int"),
        GetSQLValueString(valorCalculavel($_POST['valor_venda']), "int"),
        GetSQLValueString(upload('foto', 'imgs-sis', 'N'), "text"),
        GetSQLValueString($_POST['tipo'], "int"),
        GetSQLValueString($_POST['id_fornecedor'], "text"),
        GetSQLValueString($_POST['id_colecao'], "text"),
        GetSQLValueString($_POST['id_composicao'], "text"),
        GetSQLValueString($_POST['descricao'], "text"),
        GetSQLValueString($_POST['id_cor'], "text"),
        GetSQLValueString($_POST['numeracao'], "text"),
        GetSQLValueString($_POST['pontuacao'], "text"),
        GetSQLValueString($_POST['modo_lavagem'], "text"),
        GetSQLValueString(str_pad($code_number, 12, "0", STR_PAD_LEFT), "text"),
        GetSQLValueString($_POST['origem'], "text"),
        GetSQLValueString($_POST['status'], "text")
    );
    mysql_select_db($database_conexao, $conexao);
    $Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());

    echo "	<script>
			window.location='produto.php';
			</script>";
    exit;
    //}
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cadastro > Produtos > Novo</title>

    <link rel="stylesheet" href="css/style.default.css" type="text/css" />
    <link rel="stylesheet" href="css/bootstrap-fileupload.min.css" type="text/css" />
    <link rel="stylesheet" href="css/bootstrap-timepicker.min.css" type="text/css" />

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
    <script type="text/javascript" src="js/responsive-tables.js"></script>
    <script type="text/javascript" src="js/custom.js"></script>
    <script type="text/javascript" src="js/forms.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <style type="text/css">
        body,
        td,
        th {
            font-family: RobotoRegular, "Helvetica Neue", Helvetica, sans-serif;
        }
    </style>
    <meta charset="UTF-8" />
</head>

<body>
    <?php //include_once('head.php');
    ?>

    <div class="mainwrapper">

        <?php include_once('header.php'); ?>

        <?php include_once('inc_coluna.php'); ?>

        <div class="rightpanel">

            <ul class="breadcrumbs">
                <li><a href="."><i class="iconfa-home"></i></a> <span class="separator"></span></li>
                <li><a href="produto.php">Produto</a> <span class="separator"></span></li>
                <li>Adicionar Produto</li>
            </ul>
            <div class="maincontent">
                <div class="maincontentinner">

                    <div class="widget">
                        <h4 class="widgettitle"><span class="iconfa-th"></span>Novo Produto</h4>
                        <div class="widgetcontent">

                            <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="formProduto" class="stdform" id="formProduto">



                                <p>


                                <div class="row">
                                    <div class="col-md-2">
                                        C&oacute;digo<br>
                                        <div class="input-prepend">

                                            <input type="text" name="id" class="input-small" placeholder="Código" disabled />
                                            <span class="add-on"><i class="iconfa-qrcode"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        Origem<br>
                                        <div class="input-prepend">
                                            <select name="origem" class="uniformselect">
                                                <option value="L">Loja</option>
                                                <option value="E">E-commerce</option>
                                            </select>
                                        </div>
                                    </div>


                                </div>

                                <!-- <div class="row">
        <div class="col-md-5">
            C&oacute;digo de Barra<br>
            <div class="input-prepend">
                
                <input type="text" name="codigoBarra" class="input-xlarge" placeholder="Código de Barra"/>
                
            </div>
        </div>
     
    </div> -->

                                <div class="row">

                                    <div class="col-md-3">
                                        Categoria<br>
                                        <div class="input-prepend">
                                            <select name="categoria" id="categoria" class="uniformselect">
                                                <?php do { ?>
                                                    <option value="<?php echo $row_rs_categoria['id']; ?>"><?php echo $row_rs_categoria['categoria']; ?></option>
                                                <?php } while ($row_rs_categoria = mysql_fetch_assoc($rs_categoria)); ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        Fornecedor<br>
                                        <div class="input-prepend">
                                            <select name="id_fornecedor" class="uniformselect">
                                                <?php do { ?>
                                                    <option value="<?php echo $row_rs_fornecedor['id']; ?>"><?php echo $row_rs_fornecedor['nome']; ?></option>
                                                <?php } while ($row_rs_fornecedor = mysql_fetch_assoc($rs_fornecedor)); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        Nome<br>
                                        <div class="input-prepend">
                                            <input type="text" name="nome" class="input-xlarge" placeholder="Nome" />
                                            <span class="add-on"><i class="iconfa-edit"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        Quantidade de estoque<br>
                                        <div class="input-prepend">

                                            <input type="number" name="qnt_estoque" class="input-small" />
                                            <span class="add-on"><i class="iconfa-shopping-cart"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        Numeração<br>
                                        <div class="input-prepend">

                                            <input type="text" name="numeracao" class="input-small" />
                                            <span class="add-on"><i class="iconfa-shopping-cart"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-prepend">
                                            <input type="hidden" name="status" class="input-small" value="A"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-3">
                                        Coleção<br>
                                        <div class="input-prepend">
                                            <select name="id_colecao" class="uniformselect">
                                                <?php do { ?>
                                                    <option value="<?php echo $row_rs_colecao['id']; ?>"><?php echo $row_rs_colecao['nome']; ?></option>
                                                <?php } while ($row_rs_colecao = mysql_fetch_assoc($rs_colecao)); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        Cor<br>
                                        <div class="input-prepend">
                                            <select name="id_cor" class="uniformselect">
                                                <?php do { ?>
                                                    <option value="<?php echo $row_rs_cores['id']; ?>"><?php echo $row_rs_cores['nome']; ?></option>
                                                <?php } while ($row_rs_cores = mysql_fetch_assoc($rs_cores)); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!--<div class="col-md-3">
        	Tipo Lavagem<br>
            <div class="input-prepend">
                <select name="id_composicao" class="uniformselect">
					<?php do { ?>
                    	<option value="<?php echo $row_rs_composicao['id']; ?>" ><?php echo $row_rs_composicao['nome']; ?></option>
                    <?php } while ($row_rs_composicao = mysql_fetch_assoc($rs_composicao)); ?>         
                </select>
            </div>    
        </div>-->
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        Pre&ccedil;o de custo<br>
                                        <div class="input-prepend">

                                            <input type="text" name="preco_custo" class="input-medium" />
                                            <span class="add-on"><i class="fa fa-usd"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        Valor do aluguel<br>
                                        <div class="input-prepend">

                                            <input type="text" name="valor_aluguel" class="input-medium" />
                                            <span class="add-on"><i class="fa fa-usd"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        Valor de venda<br>
                                        <div class="input-prepend">

                                            <input type="text" name="valor_venda" class="input-medium" />
                                            <span class="add-on"><i class="fa fa-usd"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- <div class="col-md-6">
            Imagem<br>
            <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="input-append">
                    <div class="uneditable-input span3">
                        <i class="iconfa-file fileupload-exists"></i>
                        <span class="fileupload-preview"></span>
                    </div>
                <span class="btn btn-file"><span class="fileupload-new">Selecione arquivo</span>
                <span class="fileupload-exists">Mudar</span>
                <input type="file" name="foto" /></span>
                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remover</a>
                </div>
            </div>
        </div> -->
                                    <div class="col-md-4">
                                        Tipo<br>
                                        <div class="input-prepend">
                                            <select name="tipo" class="uniformselect">
                                                <option>Selecione...</option>
                                                <option value="1">MASCULINO</option>
                                                <option value="2">FEMININO</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- <div class="col-md-3">
        	Pontuação<br>
            <div class="input-prepend">
            	
                <input type="text" name="pontuacao" class="input-medium"/>
                <span class="add-on"><i class="fa fa-pencil"></i></span>
            </div>    
        </div> -->

                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            Descrição<br>
                                            <div class="input-prepend">
                                                <textarea name="descricao" id="descricao" rows="5" class="span5" style="width:1000px;"></textarea>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- <div class="col-md-12">
                            	<div class="col-md-12">
                                    Modo de Lavagem<br>
                                    <div class="input-prepend">
                                        <textarea name="modo_lavagem" id="modo_lavagem" rows="5" class="span5" style="width:1000px;"></textarea>
                                		
                                    </div>
                                </div>
                            </div>
                        </div> -->

                                    <div class="row">
                                        <div class="col-md-11" align="right">

                                            <a href="produto.php" class="btn btn-danger btn-mini">
                                                <i class="iconfa-remove"></i> &nbsp; Cancelar
                                            </a>

                                            <a href="javascript:;" onClick="document.getElementById('formProduto').submit();" class="btn btn-mini btn-success">
                                                <i class="iconfa-ok"></i> &nbsp; Salvar
                                            </a>
                                        </div>
                                    </div>
                                    <input type="hidden" name="MM_insert" value="formProduto">
                                    </p>







                            </form>

                        </div><!--widgetcontent-->
                    </div><!--widget-->


                    <?php include_once('footer.php'); ?>
                    <?php
                    mysql_free_result($rs_categoria);
                    ?>