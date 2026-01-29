<?php
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');
if (!isset($_SESSION)) { session_start(); }


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


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formEditcontrato")) {


    $updateSQL = sprintf(
        "UPDATE tbl_contrato SET loja=%s, vendedor=%s, data_evento=%s, data_devolucao=%s, codigo_cliente=%s, nome_cliente=%s, tipo_contrato=%s, comentario=%s, tipo_plano=%s WHERE id=%s",
        GetSQLValueString($_POST['loja'], "text"),
        GetSQLValueString($_POST['vendedor'], "text"),
        GetSQLValueString($_POST['data_evento'], "text"),
        GetSQLValueString($_POST['data_devolucao'], "text"),
        GetSQLValueString($_POST['codigo_cliente'], "text"),
        GetSQLValueString($_POST['nome_cliente'], "text"),
        GetSQLValueString($_POST['tipo_contrato'], "text"),
        GetSQLValueString($_POST['comentario'], "text"),
        GetSQLValueString($_POST['tipo_plano'], "text"),
        GetSQLValueString($_POST['id'], "int")
    );
    mysql_select_db($database_conexao, $conexao);
    $Result1 = mysql_query($updateSQL, $conexao) or die(mysql_error());
    $idConteudo = mysql_insert_id();


    //// ITENS
    $deleteSQL = sprintf("DELETE FROM tbl_item WHERE id_contrato=%s", GetSQLValueString($_POST['id'], "int"));
    mysql_select_db($database_conexao, $conexao);
    $Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());

    $deleteSQL = sprintf("DELETE FROM tbl_historico_produto WHERE id_contrato=%s", GetSQLValueString($_POST['id'], "int"));
    mysql_select_db($database_conexao, $conexao);
    $Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());

    for ($i = 0; $i < count($_POST['nome_produto']); $i++) {


        $insertSQL = sprintf(
            "INSERT INTO tbl_item (nome_produto, quantidade_produto, valor_unitario_produto, desconto_produto, valor_total_produto, id_contrato, data_prova, data_retirada, data_devolucao, retirado_em, devolvido_em, busto, cintura, quadril, corpo, saia, paleto, comprimento, manga, camisa, colete, tamanho, colarinho, calca, barra, cintura_homem, sapato, comentario_item, id_cliente, pendencias) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($_POST['nome_produto'][$i], "text"),
            GetSQLValueString($_POST['quantidade_produto'][$i], "text"),
            GetSQLValueString(valorCalculavel($_POST['valor_unitario_produto'][$i]), "text"),
            GetSQLValueString($_POST['desconto_produto'][$i], "text"),
            GetSQLValueString(valorCalculavel($_POST['valor_total_produto'][$i]), "text"),
            GetSQLValueString($_POST['id'], "int"),
            GetSQLValueString($_POST['data_prova'][$i], "text"),
            GetSQLValueString($_POST['data_evento'], "text"),
            GetSQLValueString($_POST['data_devolucao'], "text"),
            GetSQLValueString($_POST['retirado_em'][$i], "text"),
            GetSQLValueString($_POST['devolvido_em'][$i], "text"),
            GetSQLValueString($_POST['busto'][$i], "text"),
            GetSQLValueString($_POST['cintura'][$i], "text"),
            GetSQLValueString($_POST['quadril'][$i], "text"),
            GetSQLValueString($_POST['corpo'][$i], "text"),
            GetSQLValueString($_POST['saia'][$i], "text"),
            GetSQLValueString($_POST['paleto'][$i], "text"),
            GetSQLValueString($_POST['comprimento'][$i], "text"),
            GetSQLValueString($_POST['manga'][$i], "text"),
            GetSQLValueString($_POST['camisa'][$i], "text"),
            GetSQLValueString($_POST['colete'][$i], "text"),
            GetSQLValueString($_POST['tamanho'][$i], "text"),
            GetSQLValueString($_POST['colarinho'][$i], "text"),
            GetSQLValueString($_POST['calca'][$i], "text"),
            GetSQLValueString($_POST['barra'][$i], "text"),
            GetSQLValueString($_POST['cintura_homem'][$i], "text"),
            GetSQLValueString($_POST['sapato'][$i], "text"),
            GetSQLValueString($_POST['comentario_item'][$i], "text"),
            GetSQLValueString($_POST['codigo_cliente'], "text"),
            GetSQLValueString($_POST['pendencias'][$i], "text")
        );
        mysql_select_db($database_conexao, $conexao);
        $Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());

        ///HISTORIC PRODUCT
        $insertSQL = sprintf(
            "INSERT INTO tbl_historico_produto (id_produto, condicao, data_saida, data_retorno, id_contrato) VALUES (%s, %s, %s, %s, %s)",
            GetSQLValueString($_POST['nome_produto'][$i], "text"),
            GetSQLValueString('C', "text"),
            GetSQLValueString($_POST['data_evento'], "text"),
            GetSQLValueString($_POST['data_devolucao'], "text"),
            GetSQLValueString($idConteudo, "int")
        );
        mysql_select_db($database_conexao, $conexao);
        $Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
    }

    //// PAGAMENTO
    $deleteSQL = sprintf("DELETE FROM tbl_pagamento WHERE id_contrato=%s", GetSQLValueString($_POST['id'], "int"));
    mysql_select_db($database_conexao, $conexao);
    $Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());

    $deleteSQL = sprintf("DELETE FROM tbl_contas WHERE id_contrato=%s", GetSQLValueString($_POST['id'], "int"));
    mysql_select_db($database_conexao, $conexao);
    $Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());

    for ($o = 0; $o < count($_POST['valor_pagamento']); $o++) {
        $insertSQL = sprintf(
            "INSERT INTO tbl_pagamento (data_pagamento, forma_pagamento, parcelas, valor_pagamento, id_contrato, id_cliente) VALUES (%s, %s, %s, %s, %s, %s)",
            GetSQLValueString($_POST['data_pagamento'][$o], "text"),
            GetSQLValueString($_POST['forma_pagamento'][$o], "text"),
            GetSQLValueString($_POST['parcela_pagamento'][$o], "text"),
            GetSQLValueString(valorCalculavel($_POST['valor_pagamento'][$o]), "text"),
            GetSQLValueString($_POST['id'], "int"),
            GetSQLValueString($_POST['codigo_cliente'], "text")
        );
        mysql_select_db($database_conexao, $conexao);
        $Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
        $idPagamento = mysql_insert_id();

        $_POST['id_contrato'] = $_POST['id'];
        $_POST['tipo'] = 'R';
        $_POST['id_pagamento_contrato'] = $idPagamento;
        $totalContrato += $_POST['valor_pagamento'][$o];
        $_POST['valor_total'] = $_POST['valor_pagamento'][$o];
        $_POST['data_emissao'] = date('Y-m-d');
        $_POST['data_vencimento'] = $_POST['data_pagamento'][$o];
        include('add-conta-inc.php');
    }

    /// Comiss�o
    $deleteSQL = sprintf("DELETE FROM tbl_comissoes WHERE id_contrato=%s", GetSQLValueString($_POST['id'], "int"));
    mysql_select_db($database_conexao, $conexao);
    $Result1 = mysql_query($deleteSQL, $conexao) or die(mysql_error());
    $_POST['totalContrato'] = $totalContrato;
    $_POST['id_user_vendedor'] = $_POST['vendedor'];
    $_POST['id_contrato'] = $_POST['id'];
    include('add-comissao-inc.php');
    // Fim comiss�o

    //// Hist�rico de Altera��es
    mysql_select_db($database_conexao, $conexao);
    $query_rs_editar_cliente = "SELECT * FROM tbl_cliente where id = '{$_POST['codigo_cliente']}'";
    $rs_editar_cliente = mysql_query($query_rs_editar_cliente, $conexao) or die(mysql_error());
    $row_rs_editar_cliente = mysql_fetch_assoc($rs_editar_cliente);
    $totalRows_rs_editar_cliente = mysql_num_rows($rs_editar_cliente);

    marcaHistoricoAlteracao("Modificou o contrato {$_POST['id']} do cliente {$row_rs_editar_cliente['nome']}.");
    ////

    echo "	<script>
			window.location='contrato_cadastro.php';
			</script>";
    exit;
}

$colname_rs_contrato = "-1";
if (isset($_GET['id'])) {
    $colname_rs_contrato = $_GET['id'];
}
mysql_select_db($database_conexao, $conexao);
$query_rs_contrato = sprintf("SELECT tbl_contrato.*, tbl_cliente.nome as nomeCliente FROM tbl_contrato left join tbl_cliente on tbl_contrato.codigo_cliente = tbl_cliente.id WHERE tbl_contrato.id = %s", GetSQLValueString($colname_rs_contrato, "int"));
$rs_contrato = mysql_query($query_rs_contrato, $conexao) or die(mysql_error());
$row_rs_contrato = mysql_fetch_assoc($rs_contrato);
$totalRows_rs_contrato = mysql_num_rows($rs_contrato);

mysql_select_db($database_conexao, $conexao);
$query_rs_planos = "SELECT * FROM tbl_plano ORDER BY nome ASC";
$rs_planos = mysql_query($query_rs_planos, $conexao) or die(mysql_error());
$row_rs_planos = mysql_fetch_assoc($rs_planos);
$totalRows_rs_planos = mysql_num_rows($rs_planos);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Editar Aluguel</title>

    <link rel="stylesheet" href="css/style.default.css" type="text/css" />
    <link rel="stylesheet" href="css/bootstrap-fileupload.min.css" type="text/css" />
    <link rel="stylesheet" href="css/bootstrap-timepicker.min.css" type="text/css" />
    <link rel="stylesheet" href="prettify/prettify.css" type="text/css" />

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
    <?php include('dialog-jquery/inc-abre-janela.php'); ?>

    <script src="js/number_format.js"></script>
    <script src="js/outras-funcoes.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <style type="text/css">
        body,
        td,
        th {
            font-family: RobotoRegular, "Helvetica Neue", Helvetica, sans-serif;
        }
    </style>
    <script type="text/javascript" src="js/elements.js"></script>

    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
    <script type="text/javascript">
        function MM_openBrWindow(theURL, winName, features) { //v2.0
            window.open(theURL, winName, features);
        }
    </script>
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
                <li><a href="contrato_cadastro.php">Aluguel</a> <span class="separator"></span></li>
                <li>Editar Aluguel</li>
            </ul>
            <div class="maincontent">
                <div class="maincontentinner">

                    <div class="widget">
                        <h4 class="widgettitle"><span class="iconfa-edit"></span>Aluguel</h4>
                        <div class="widgetcontent">


                            <form class="stdform" action="" method="post" name="formEditcontrato" id="formEditcontrato" />

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-2">
                                        C&oacute;digo<br>
                                        <div class="input-prepend">
                                            <input type="text" name="id" class="input-small" placeholder="C�digo" disabled value="<?php echo $row_rs_contrato['id'] ?>" />
                                            <span class="add-on"><i class="icon-qrcode"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        Data Cadastro<br>
                                        <div class="input-prepend">
                                            <input type="datetime" name="data_contrato" class="input-medium" readonly value="<?php echo formataData($row_rs_contrato['data_contrato']) . ' &agrave;s ' . substr($row_rs_contrato['data_contrato'], 11) ?>" />
                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        Loja<br>
                                        <div class="input-prepend">
                                            <select name="loja" class="uniformselect">
                                                <option />
                                                Selecione
                                                <?php do { ?>
                                                    <option value="<?php echo $row_rs_loja['id']; ?>" <?php if ($row_rs_contrato['loja'] == $row_rs_loja['id']) {
                                                                                                            echo "selected";
                                                                                                        } ?> />
                                                    <?php echo utf8_decode($row_rs_loja['nome']); ?>
                                                <?php } while ($row_rs_loja = mysql_fetch_assoc($rs_loja)); ?>
                                            </select>


                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        Vendedor<br>
                                        <div class="input-prepend">

                                            <select name="vendedor" class="uniformselect">
                                                <option />
                                                Selecione
                                                <?php do { ?>
                                                    <option value="<?php echo $row_rs_vendedor['id']; ?>" <?php if ($row_rs_contrato['vendedor'] == $row_rs_vendedor['id']) {
                                                                                                                echo "selected";
                                                                                                            } ?> />
                                                    <?php echo utf8_decode($row_rs_vendedor['nome']); ?>
                                                <?php } while ($row_rs_vendedor = mysql_fetch_assoc($rs_vendedor)); ?>
                                            </select>


                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row" style="margin-top:7px; margin-bottom:7px;">
                                <div class="col-md-12">
                                    <div class="col-md-3">
                                        Data de Retirada<br>
                                        <div class="input-prepend">
                                            <input type="date" name="data_evento" class="input-medium" placeholder="Data de Retirada" value="<?php echo $row_rs_contrato['data_evento'] ?>" />
                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        Data de Devolu&ccedil;&atilde;o<br>
                                        <div class="input-prepend">
                                            <input type="date" name="data_devolucao" class="input-medium" placeholder="Data de Devolucao" value="<?php echo $row_rs_contrato['data_devolucao'] ?>" />
                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        Cliente<br>
                                        <?php
                                        $_GET['label'] = utf8_decode($row_rs_contrato['nomeCliente']);
                                        $_GET['idAtual'] = $row_rs_contrato['codigo_cliente'];
                                        buscaGenericad('codigo_cliente', 'id', '', 'Clientes', 'nome', "parent.document.getElementById('envia').src='busca-plano.php?id=[id]';", 'tbl_cliente', $concatCampos, $where); ?>
                                    </div>

                                </div>
                            </div>

                            <div class="row" style="margin-top:7px; margin-bottom:7px;">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        Plano<br>
                                        <div class="input-prepend">

                                            <select name="tipo_contrato" id="tipo_contrato" class="uniformselect" style="width: 360px !important;">
                                                <option />
                                                Selecione
                                                <?php do { ?>
                                                    <option value="<?php echo $row_rs_planos['id']; ?>" <?php if ($row_rs_contrato['tipo_plano'] == $row_rs_planos['id']) {
                                                                                                            echo "selected";
                                                                                                        } ?> /><?php echo utf8_decode($row_rs_planos['nome']); ?>
                                                <?php } while ($row_rs_planos = mysql_fetch_assoc($rs_planos)); ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <?php /*?><a href="javascript:;" class="btn btn-primary btn-mini" onClick="MM_openBrWindow('imprimir-aluguel.php?id=<?php echo $_GET['id'];?>&tipo=R','imprimirAluguel','status=yes,width=850,height=450')"> <i class="iconfa-ok"></i>&nbsp; Imprimir Retirada</a>
                                	
                                	<a href="javascript:;" class="btn btn-primary btn-mini" onClick="MM_openBrWindow('imprimir-aluguel.php?id=<?php echo $_GET['id'];?>&tipo=D','imprimirAluguel','status=yes,width=850,height=450')"> <i class="iconfa-ok"></i>&nbsp; Imprimir Devolu&ccedil;&atilde;o</a><?php */ ?>
                                        <a href="imprimir-aluguel.php?id=<?php echo $_GET['id']; ?>&tipo=R" class="btn btn-primary btn-mini"> <i class="iconfa-ok"></i>&nbsp; Imprimir Retirada</a>

                                        <a href="imprimir-aluguel.php?id=<?php echo $_GET['id']; ?>&tipo=D" class="btn btn-primary btn-mini" target="_blank"> <i class="iconfa-ok"></i>&nbsp; Imprimir Devolu&ccedil;&atilde;o</a>
                                    </div>

                                </div>
                            </div>

                            <div class="row" style="margin-top:7px; margin-bottom:7px;">
                                <div class="col-md-12">
                                    <div class="col-md-5">

                                    </div>

                                    <div class="col-md-5">

                                        <a href="enviar-aluguel.php?id=<?php echo $_GET['id']; ?>&tipo=R" class="btn btn-primary btn-mini"> <i class="iconfa-ok"></i>&nbsp; Enviar Cliente Retirada</a>

                                        <a href="enviar-aluguel.php?id=<?php echo $_GET['id']; ?>&tipo=D" class="btn btn-primary btn-mini"> <i class="iconfa-ok"></i>&nbsp; Enviar Cliente Devolu&ccedil;&atilde;o</a>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">


                                    Coment&aacute;rio<br>
                                    <div class="input-prepend">
                                        <textarea name="comentario" rows="5" class="span5" placeholder="Informações importantes sobre o contatro" style="width:1018px;"><?php echo $row_rs_contrato['comentario'] ?></textarea>
                                    </div>



                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Itens Adicionados</h3>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-2">
                                        Adicionar qtd. de Itens:<br>
                                        <div class="input-prepend">
                                            <input name="qtdItens" type="text" class="input-small" id="qtdItens" />
                                        </div>
                                    </div>
                                    <div class="col-md-2" style="margin-left:10px;">
                                        <br>
                                        <div class="input-prepend">
                                            <a href="javascript:;" onClick="AtualizaJanela('itens.php?qtdItens=' + document.getElementById('qtdItens').value, 'Itens');" class="btn btn-mini btn-success">Mostrar Op&ccedil;&otilde;es</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <?php //$_GET['id'] = $row_rs_contrato['id_item'] 
                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="janela_Itens">
                                        <?php include_once 'itens.php'; ?>
                                    </div>

                                </div>
                            </div>

                            <br>
                            <?php /*?>     <div class="row">
                            <div class="col-md-12">
                            	<h3>Forma de Pagamento</h3>
                            </div>
                        </div>
                                
                                 <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-2">
                                    QTD. de Pagamentos:<br>
                                    <div class="input-prepend">
                                    	<input name="qtdPago" type="text" class="input-small" id="qtdPago" />
                                    </div>
                                </div>
                                <div class="col-md-2" style="margin-left:10px;">
                                   <br>
                                    <div class="input-prepend">
            <a href="javascript:;" onClick="AtualizaJanela('pagamento.php?qtdPago=' + document.getElementById('qtdPago').value, 'Pagamento');" class="btn btn-mini btn-success"  >Mostrar Op&ccedil;&otilde;es</a>
                                    </div>
                                </div>
                                
                                </div>
                                </div>
                                
                       <div class="row">
                            <div class="col-md-12">
                            <div id="janela_Pagamento">
                            	<?php include_once'pagamento.php';?>
                            </div>
                                
                                </div>
                                </div><?php */ ?>




                            <div class="row" style="margin-top:10px;">
                                <div class="col-md-12" align="right">
                                    <a href="javascript:;" onClick="document.getElementById('formEditcontrato').submit();" class="btn btn-mini btn-success"> <i class="iconfa-ok"></i>&nbsp; Salvar</a>

                                    <?php /*?> <a href="javascript:;" class="btn btn-primary btn-mini" onClick="MM_openBrWindow('imprimir-aluguel.php?id=<?php echo $_GET['id'];?>','imprimirAluguel','status=yes,width=850,height=450')"> <i class="iconfa-ok"></i>&nbsp; Imprimir</a><?php */ ?>

                                    <a href="contrato_cadastro.php" class="btn btn-danger btn-mini"><i class="iconfa-remove"></i>&nbsp; Cancelar</a>
                                </div>
                            </div>
                            <input type="hidden" name="MM_update" id="MM_update" value="formEditcontrato">
                            <input type="hidden" name="id" id="id" value="<?php echo $row_rs_contrato['id'] ?>">
                            </form>

                        </div><!--widgetcontent-->
                    </div><!--widget-->
                    <iframe id="envia" name="envia" src="" style="width:0px;height:0px;border:0px;"></iframe>

                    <?php include_once('footer.php'); ?>