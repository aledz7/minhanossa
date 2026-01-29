<?php 
include('restrito.php');
include('Connections/conexao.php');
include('funcoes.php');

if (!isset($_SESSION)) { session_start(); }

mysql_select_db($database_conexao, $conexao);
$query_rs_estado = "SELECT * FROM dados_estados ORDER BY nome ASC";
$rs_estado = mysql_query($query_rs_estado, $conexao) or die(mysql_error());
$row_rs_estado = mysql_fetch_assoc($rs_estado);
$totalRows_rs_estado = mysql_num_rows($rs_estado);

mysql_select_db($database_conexao, $conexao);
$query_rs_prazos = "SELECT * FROM tbl_emprestimos ORDER BY nome ASC";
$rs_prazos = mysql_query($query_rs_prazos, $conexao) or die(mysql_error());
$row_rs_prazos = mysql_fetch_assoc($rs_prazos);
$totalRows_rs_prazos = mysql_num_rows($rs_prazos);

mysql_select_db($database_conexao, $conexao);
$query_rs_planos = "SELECT * FROM tbl_plano ORDER BY nome ASC";
$rs_planos = mysql_query($query_rs_planos, $conexao) or die(mysql_error());
$row_rs_planos = mysql_fetch_assoc($rs_planos);
$totalRows_rs_planos = mysql_num_rows($rs_planos);

$editFormAction = $_SERVER['PHP_SELF'];
if(isset($_SERVER['QUERY_STRING'])) {
	$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formAddCLiente")) {	
	
	$insertSQL = sprintf("INSERT INTO tbl_cliente (nome, cpf, rg, telefone1, telefone2, email, estado, cidade, cep, endereco, numero, complemento, bairro, aniversario, tamanho_uso, termo_de_uso, id_plano, data_contratacao, data_vencimento, pontuacao, atendente, nome_cartao, numero_cartao, mes_cartao, ano_cartao, cod_cartao, ativo, plano_tipo, senha, pontos, nome_2, cpf_2, telefone1_2, telefone2_2, nome_3, cpf_3, telefone1_3, telefone2_3, nome_4, cpf_4, telefone1_4, telefone2_4, tipo_cliente, renovacoes, id_prazo, quantidade_pecas) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
		       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['cpf'], "text"),
                       GetSQLValueString($_POST['rg'], "text"),
                       GetSQLValueString($_POST['telefone1'], "text"),
                       GetSQLValueString($_POST['telefone2'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
		       GetSQLValueString($_POST['cidade'], "text"),
                       GetSQLValueString($_POST['cep'], "text"),
                       GetSQLValueString($_POST['endereco'], "text"),
                       GetSQLValueString($_POST['numero'], "text"),
                       GetSQLValueString($_POST['complemento'], "text"),
                       GetSQLValueString($_POST['bairro'], "text"),
		       GetSQLValueString($_POST["aniversario"], "text"),
		       GetSQLValueString($_POST["tamanho_uso"], "text"),
		       GetSQLValueString($_POST["termo_de_uso"], "text"),
		       GetSQLValueString($_POST["id_plano"], "text"),
		       GetSQLValueString($_POST["data_contratacao"], "text"),
		       GetSQLValueString($_POST["data_vencimento"], "text"),
		       GetSQLValueString($_POST["pontuacao"], "text"),
		       GetSQLValueString($_POST["atendente"], "text"),
		       GetSQLValueString($_POST["nome_cartao"], "text"),
		       GetSQLValueString($_POST["numero_cartao"], "text"),
		       GetSQLValueString($_POST["mes_cartao"], "text"),
		       GetSQLValueString($_POST["ano_cartao"], "text"),
		       GetSQLValueString($_POST["cod_cartao"], "text"),
		       GetSQLValueString($_POST["ativo"], "text"),
		       GetSQLValueString($_POST["plano_tipo"], "text"),
		       GetSQLValueString($_POST["senha"], "text"),
		       GetSQLValueString($_POST["pontos"], "text"),
		       GetSQLValueString($_POST["nome_2"], "text"),
		       GetSQLValueString($_POST["cpf_2"], "text"),
		       GetSQLValueString($_POST["telefone1_2"], "text"),
		       GetSQLValueString($_POST["telefone2_2"], "text"),
			   GetSQLValueString($_POST["nome_3"], "text"),
		       GetSQLValueString($_POST["cpf_3"], "text"),
		       GetSQLValueString($_POST["telefone1_3"], "text"),
		       GetSQLValueString($_POST["telefone2_3"], "text"),
			   GetSQLValueString($_POST["nome_4"], "text"),
		       GetSQLValueString($_POST["cpf_4"], "text"),
		       GetSQLValueString($_POST["telefone1_4"], "text"),
		       GetSQLValueString($_POST["telefone2_4"], "text"),
		       GetSQLValueString($_POST["tipo_cliente"], "text"),
		       GetSQLValueString($_POST["renovacoes"], "text"),
		       GetSQLValueString($_POST["id_prazo"], "text"),
		       GetSQLValueString($_POST["quantidade_pecas"], "text"));
	mysql_select_db($database_conexao, $conexao);
	$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());
	$idConteudo = mysql_insert_id();

	marcaHistoricoAlteracao("Incluiu o cliente: {$_POST['nome']}.");
	
	if($_POST['acao'] == 'novoContrato') {
		echo "	<script>
				window.location='add_contrato.php?id_cliente={$idConteudo}';
				</script>";
				exit;
	}
		
	echo "	<script>
			window.location='cliente.php';
			</script>";
			exit;		
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Adicionar CLiente</title>

<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-fileupload.min.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-timepicker.min.css" type="text/css" />
<style type="text/css">
body,td,th {
	font-family: RobotoRegular, "Helvetica Neue", Helvetica, sans-serif;
}
</style>
<?php /*?><script type="text/javascript" >
    
    function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('rua').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('uf').value=("");
            document.getElementById('ibge').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('rua').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('uf').value=(conteudo.uf);
            document.getElementById('ibge').value=(conteudo.ibge);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }
        
    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('rua').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('uf').value="...";
                document.getElementById('ibge').value="...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = '//viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };

    </script><?php */?>
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
            <li><a href="cliente.php">Cliente</a> <span class="separator"></span></li>
            <li>Adicionar Cliente</li>
        </ul>
        <div class="maincontent">
            <div class="maincontentinner">
            
            <div class="widget">
            <h4 class="widgettitle"><span class="iconfa-edit"></span>Novo Cliente</h4>
            <div class="widgetcontent">
           
           
               <form class="stdform" action="" method="post" name="formAddCLiente" id="formAddCLiente" />
                    	
                        <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-2">
                                    C&oacute;digo<br>
                                    <div class="input-prepend">
                                        <input type="text" name="id" class="input-small" placeholder="Código" disabled />
                                		<span class="add-on"><i class="icon-qrcode"></i></span>
                                    </div>
                                </div>
                            	<div class="col-md-2">
                                    Termo de Uso<br>
                                    <div class="input-prepend">
                                        
                                        <input type="checkbox" name="termo_uso" id="termo_uso" class="input-small" value="S"/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    Ativo<br>
                                    <div class="input-prepend">
                                        
                                        <input type="checkbox" name="ativo" id="ativo" class="input-small" value="S" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-4">
                                    Tipo Cliente<br>
                                    <div class="input-prepend">
                                        <select name="tipo_cliente" class="input-middle">
                                            <option value="L">Loja Física</option>
                                            <option value="S"> E-commerce</option>
                                        </select>
                                      
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">    

                                
                                <div class="col-md-4 container_nome">
                                    Nome<br>
                                    <div class="input-prepend ">
                                        <input name="nome" type="text" required="required" class="input-xlarge" placeholder="Nome" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    Aniversário<br>
                                    <div class="input-prepend">
                                    	<input name="aniversario" type="date" required="required" class="input-medium"  />
                                		<span class="add-on"><i class="iconfa-calendar"></i></span>
                                    </div>
                                </div>
                               <!-- <div class="col-md-3">
                                    Pontuação<br>
                                    <div class="input-prepend">
                                    	<input name="pontuacao" type="text" class="input-medium"  />
                                		<span class="add-on"><i class="iconfa-date"></i></span>
                                    </div>
                                </div>-->
                                
                              
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">    

                               
                                <div class="col-md-3">
                                    CPF<br>
                                    <div class="input-prepend">
                                    	<input name="cpf" type="text" required="required" class="input-medium" placeholder="Informe um CPF válido" value="<?php echo $_GET['cpf'];?>" />
                                		<span class="add-on"><i class="iconfa-credit-card"></i></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    RG<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="rg" class="input-small" placeholder="Informe um RG válido" />
                                		<span class="add-on"><i class="iconfa-credit-card"></i></span>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
				<div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-3">
                                    Telefone 1<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="telefone1" class="input-medium" placeholder="Telefone 1" />
                                		<span class="add-on"><i class="iconfa-phone"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    Telefone 2<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="telefone2" class="input-medium" placeholder="Telefone 2" />
                                		<span class="add-on"><i class="iconfa-phone"></i></span>
                                    </div>
                                </div>
                             
                            
                            </div>
                        </div>
				
                        <br>
                        <div class="row">
                            <div class="col-md-12">
								<div class="col-md-4 container_nome" style="width: 21.333333%;">
                                    Nome 2<br>
                                    <div class="input-prepend ">
                                        <input name="nome_2" type="text" class="input-xlarge" placeholder="Nome" />
                                    </div>
                                </div>
								<div class="col-md-3">
                                    CPF<br>
                                    <div class="input-prepend">
                                    	<input name="cpf_2" type="text" class="input-medium" placeholder="Informe um CPF válido"/>
                                		<span class="add-on"><i class="iconfa-credit-card"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    Aniversário<br>
                                    <div class="input-prepend">
                                    	<input name="aniversario_4" type="date" required="required" class="input-medium"  />
                                		<span class="add-on"><i class="iconfa-calendar"></i></span>
                                    </div>
                                </div>
                            	<div class="col-md-2">
                                    Telefone 1<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="telefone1_2" class="input-medium" placeholder="Telefone 1" />
                                		<!--<span class="add-on"><i class="iconfa-phone"></i></span>-->
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    Telefone 2<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="telefone2_2" class="input-medium" placeholder="Telefone 2" />
                                		<!--<span class="add-on"><i class="iconfa-phone"></i></span>-->
                                    </div>
                                </div>
                             
                            
                            </div>
                        </div>
						<br>
                        <div class="row">
                            <div class="col-md-12">
								<div class="col-md-4 container_nome" style="width: 21.333333%;">
                                    Nome 3<br>
                                    <div class="input-prepend ">
                                        <input name="nome_3" type="text" class="input-xlarge" placeholder="Nome" />
                                    </div>
                                </div>
								<div class="col-md-3">
                                    CPF<br>
                                    <div class="input-prepend">
                                    	<input name="cpf_3" type="text" class="input-medium" placeholder="Informe um CPF válido"/>
                                		<span class="add-on"><i class="iconfa-credit-card"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    Aniversário<br>
                                    <div class="input-prepend">
                                    	<input name="aniversario_3" type="date" required="required" class="input-medium"  />
                                		<span class="add-on"><i class="iconfa-calendar"></i></span>
                                    </div>
                                </div>
                            	<div class="col-md-2">
                                    Telefone 1<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="telefone1_3" class="input-medium" placeholder="Telefone 1" />
                                		<!--<span class="add-on"><i class="iconfa-phone"></i></span>-->
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    Telefone 2<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="telefone2_3" class="input-medium" placeholder="Telefone 2" />
                                		<!--<span class="add-on"><i class="iconfa-phone"></i></span>-->
                                    </div>
                                </div>
                             
                            
                            </div>
                        </div>
						<br>
                        <div class="row">
                            <div class="col-md-12">
								<div class="col-md-4 container_nome" style="width: 21.333333%;">
                                    Nome 4<br>
                                    <div class="input-prepend ">
                                        <input name="nome_4" type="text" class="input-xlarge" placeholder="Nome" />
                                    </div>
                                </div>
								<div class="col-md-3">
                                    CPF<br>
                                    <div class="input-prepend">
                                    	<input name="cpf_4" type="text" class="input-medium" placeholder="Informe um CPF válido"/>
                                		<span class="add-on"><i class="iconfa-credit-card"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    Aniversário<br>
                                    <div class="input-prepend">
                                    	<input name="aniversario_4" type="date" required="required" class="input-medium"  />
                                		<span class="add-on"><i class="iconfa-calendar"></i></span>
                                    </div>
                                </div>
                            	<div class="col-md-2">
                                    Telefone 1<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="telefone1_4" class="input-medium" placeholder="Telefone 1" />
                                		<!--<span class="add-on"><i class="iconfa-phone"></i></span>-->
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    Telefone 2<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="telefone2_4" class="input-medium" placeholder="Telefone 2" />
                                		<!--<span class="add-on"><i class="iconfa-phone"></i></span>-->
                                    </div>
                                </div>
                            
                            </div>
                        </div>
						<br>
                        <div class="row">
                            <div class="col-md-12">
                            	
                             
                                <div class="col-md-5">
                                    E-mail<br>
                                    <div class="input-prepend">
                                    	<input type="email" name="email" class="input-xlarge" placeholder="Informe um email válido" />
                                		<span class="add-on"><i class="iconfa-envelope-alt"></i></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-5">
                                    Senha<br>
                                    <div class="input-prepend">
                                    	<input type="password" name="senha" class="input-xlarge" placeholder="Senha" />
                                		
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-3">
                                    Estado<br>
                                    <div class="input-prepend">
                                         
                                    	<select name="estado" class="uniformselect" onChange="document.getElementById('janela_cidades').innerHTML='&nbsp;Carregando Cidades!'; AtualizaJanela('cidades.php?id_estado=' + this.value, 'cidades');">
                       					<?php do{?>
                            				<option value="<?php echo $row_rs_estado['id'];?>" /><?php echo utf8_encode($row_rs_estado['nome']);?>
                       					<?php }while($row_rs_estado = mysql_fetch_assoc($rs_estado));?>         
                       					</select>
                                        
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <span id="janela_cidades"></span>
                                </div>
                               
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                            	
                                <div class="col-md-2">
                                    CEP<br>
                                    <div class="input-prepend">
                                        <input type="text" name="cep" class="input-small" placeholder="CEP" id="cep" value="" sonKeyPress="return txtBoxFormat(this.name, '99999-999', event);" maxlength="9"/>
                                		<span class="add-on"><i class="icon-edit"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    Endere&ccedil;o<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="endereco" class="input-xxlarge" placeholder="Informe o endereço" id="endereco" />
                                		<span class="add-on"><i class="icon-home"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    N&uacute;mero<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="numero" class="input-small" placeholder="Informe o número"/>
                                		<span class="add-on"><i class="icon-resize-vertical"></i></span>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-4">
                                    Complemento<br>
                                    <div class="input-prepend">
                                        <input type="text" name="complemento" class="input-xlarge" placeholder="Informe o complemento"/>
                                		<span class="add-on"><i class="icon-pencil"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    Bairro<br>
                                    <div class="input-prepend">
                                    	<input name="bairro" type="text" class="input-xlarge" id="bairro" placeholder=" Informe o bairro" />
                                		<span class="add-on"><i class="icon-asterisk"></i></span>
                                    </div>
                                </div>
                               
                            
                            </div>
                        </div>
               
               <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-12">
                                    Tamanho que usa em cada Marca<br>
                                    <div class="input-prepend">
                                        <textarea name="tamanho_uso" id="tamanho_uso" rows="2" class="span5" style="width:1000px;"></textarea>
                                		
                                    </div>
                                </div>
                            </div>
                        </div>
               <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-12">
                                    Observações<br>
                                    <div class="input-prepend">
                                        <textarea name="atendente" id="atendente" rows="2" class="span5" style="width:1000px;"></textarea>
                                		
                                    </div>
                                </div>
                            </div>
                        </div>
                              <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-12">
                                    Renovações<br>
                                    <div class="input-prepend">
                                        <textarea name="atendente" id="atendente" rows="2" class="span5" style="width:1000px;"></textarea>
                                		
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                 <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-4">
                                    Nome Cartão<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="nome_cartao" class="input-medium" placeholder="Nome Cartão" />
                                		<span class="add-on"><i class="iconfa-pencil"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    Número Cartão<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="numero_cartao" class="input-medium" placeholder="Número Cartão" maxlength="16" />
                                		<span class="add-on"><i class="iconfa-pencil"></i></span>
                                    </div>
                                </div>
                                                           
                            </div>
                        </div>
                 <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-2">
                                    Mês Cartão<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="mes_cartao" class="input-small" maxlength="2" />
                                		<span class="add-on"><i class="iconfa-pencil"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    Ano Cartão<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="ano_cartao" class="input-small" maxlength="4"/>
                                		<span class="add-on"><i class="iconfa-pencil"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    Cód. Cartão<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="cod_cartao" class="input-small" maxlength="4"/>
                                		<span class="add-on"><i class="iconfa-pencil"></i></span>
                                    </div>
                                </div>
                               <div class="col-md-4">
                                    Prazo do Empréstimo<br>
                                    <div class="input-prepend">
                                        <select name="id_prazo" class="input-xlarge">
                                            <option value="">-SELECIONE-</option>
                                            <?php do{?>
                                            <option value="<?php echo $row_rs_prazos['id'];?>"><?php echo $row_rs_prazos['nome'];?></option>
                                            <?php }while($row_rs_prazos = mysql_fetch_assoc($rs_prazos));?>
                                        </select>
                                    	
                                		<span class="add-on"><i class="iconfa-pencil"></i></span>
                                    </div>
                                </div>                            
                            </div>
                        </div>
                 <div class="row">
                            <div class="col-md-12">
                            	<div class="col-md-4">
                                    Plano Contrato<br>
                                    <div class="input-prepend">
                                        <select name="id_plano" class="input-xlarge">
                                            <option value="">-SELECIONE-</option>
                                            <?php do{?>
                                            <option value="<?php echo $row_rs_planos['id'];?>"><?php echo $row_rs_planos['nome'];?></option>
                                            <?php }while($row_rs_planos = mysql_fetch_assoc($rs_planos));?>
                                        </select>
                                    	
                                		<span class="add-on"><i class="iconfa-pencil"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                   Tipo Plano<br>
                                    <div class="input-prepend">
                                        <select name="plano_tipo" class="input-xlarge">
                                            <option value="">-SELECIONE-</option>
                                            <option value="M">MENSAL</option>
                                            <option value="T">TRIMESTRAL</option>
                                            <option value="S">SEMESTRAL</option>
                                            <option value="A">ANUAL</option>
                                            
                                        </select>
                                    	
                                		<span class="add-on"><i class="iconfa-pencil"></i></span>
                                    </div>
                                </div>
                               <div class="col-md-3">
                                    Pontos<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="pontos" class="input-small"/>
                                		
                                    </div>
                                </div>  
                                                           
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-md-12">
                            	
                                <div class="col-md-4">
                                    Data Contratação<br>
                                    <div class="input-prepend">
                                    	<input type="date" name="data_contratacao" class="input-xlarge" value="<?php echo date('Y-m-d');?>"/>
                                		<span class="add-on"><i class="iconfa-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    Vencimento Plano<br>
                                    <div class="input-prepend">
                                    	<input type="date" name="data_vencimento" class="input-xlarge"/>
                                		<span class="add-on"><i class="iconfa-pencil"></i></span>
                                    </div>
                                </div>
                                                        
                                <div class="col-md-3">
                                    Quantidade de peças<br>
                                    <div class="input-prepend">
                                    	<input type="text" name="quantidade_pecas" class="input-small"/>
                                		
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
                   <input type="hidden" name="acao" value="<?php echo $_GET['acao'];?>">
                </form>
           
            </div><!--widgetcontent-->
            </div><!--widget-->
               <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
 <script>
 // Registra o evento blur do campo "cep", ou seja, quando o usuário sair do campo "cep" faremos a consulta dos dados
 $("#cep").blur(function(){
 // Para fazer a consulta, removemos tudo o que não é número do valor informado pelo usuário
 var cep = this.value.replace(/[^0-9]/, "");
 
 // Validação do CEP; caso o CEP não possua 8 números, então cancela a consulta
 if(cep.length!=8){
 return false;
 }
 
 // Utilizamos o webservice "viacep.com.br" para buscar as informações do CEP fornecido pelo usuário.
 // A url consiste no endereço do webservice ("http://viacep.com.br/ws/"), mais o cep que o usuário
 // informou e também o tipo de retorno que desejamos, podendo ser "xml", "piped", "querty" ou o que
 // iremos utilizar, que é "json"
 var url = "https://viacep.com.br/ws/"+cep+"/json/";
 
 // Aqui fazemos uma requisição ajax ao webservice, tratando o retorno com try/catch para que caso ocorra algum
 // erro (o cep pode não existir, por exemplo) o usuário não seja afetado, assim ele pode continuar preenchendo os campos
 $.getJSON(url, function(dadosRetorno){
 try{
 // Insere os dados em cada campo
 $("#endereco").val(dadosRetorno.logradouro);
 $("#bairro").val(dadosRetorno.bairro);
 $("#cidade").val(dadosRetorno.localidade);
 $("#estado").val(dadosRetorno.estado);
 $("#uf").val(dadosRetorno.uf);
 }catch(ex){}
 });
 });
 </script>
       
            <?php include_once('footer.php');?>