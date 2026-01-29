<?php require_once('../Connections/conexao.php'); 
// pega data e hora do sistema
$dtHora = date('Y-m-d H:i:s');
$apenasData = date('Y-m-d');

include('funcoes.php');

mysql_select_db($database_conexao, $conexao);

// Verifica se o usuario já possui id na tabela ponto, do dia corrente
$sql = '
select 
	id, 
	id_funcionario, 
	substring(chegada, 1, 10) as "chegada", substring(chegada, 12, 8) as "horaChegada", 
	substring(saida_almoco, 1, 10) as "saida almoco", substring(saida_almoco, 12, 8) as "horasdAlmoco",
	substring(chegada_almoco, 1, 10) as "chegada almoco", substring(chegada_almoco, 12, 8) as "horaChAlmoco",
	substring(saida, 1, 10) as "saida", substring(saida, 12, 8) as "horaSaida"
from 
	tbl_ponto 
where 
	id_funcionario = '.$_GET['idLogado'].' 
	and substring(chegada, 1, 10) ="'.$apenasData.'"';
$qr = mysql_query($sql, $conexao) or die(mysql_error());
$resultado = mysql_num_rows($qr);

if($resultado == 0){
	
	if($_GET['id'] == 'chegada'){
		 
	 $insere = 'insert into tbl_ponto (id_funcionario, chegada, saida_almoco, chegada_almoco, saida) values 
	 ('.$_GET['idLogado'].', "'.$dtHora.'", "0000-00-00 00:00:00","0000-00-00 00:00:00", "0000-00-00 00:00:00")';
	 $qrIns = mysql_query($insere) or die(mysql_error());
	 if($qrIns){
		 	echo "	<script>
					alert('Marcação de chegada realizada.');
					</script>";
					if($_POST['login'] == '') {
						exit;
					}
			}	
	
	} else {
		     echo texto('É necessário registrar à chegada. Verifique!');
		    }
	
	} else if($_GET['id'] == 'sdAlmoco'){
		if(mysql_result($qr, 0, 'saida almoco') == '0000-00-00'){
		$update = 'update tbl_ponto set saida_almoco = "'.$dtHora.'" where id_funcionario = '.$_GET['idLogado'];
		$qrUp = mysql_query($update, $conexao) or die (mysql_error());
		if($qrUp){
				
				echo "	<script>
							alert('Marcação de saída para almoço realizada.');
							</script>";
							exit;
			}
		} else {
			
			echo "	<script>
							alert('Saída para almoço já está registrado!');
							</script>";
							exit;
		}
		
		} else if($_GET['id'] == 'chAlmoco'){           
			if(mysql_result($qr, 0, 'saida almoco') == '0000-00-00'){
				
				echo "	<script>
							alert('É necessário registrar a saída para o almoço.');
							</script>";
							exit;
				} else if(mysql_result($qr, 0, 'chegada almoco') != '0000-00-00'){
						
						 echo "	<script>
							alert('Chegada do almoço já está registrado!');
							</script>";
							exit;
					}else {
						 $insChAlm = 'update 
						 				tbl_ponto set chegada_almoco = "'.$dtHora.'" 
									  where 
									  	id_funcionario = '.$_GET['idLogado'].' and substring(chegada, 1, 10) ="'.$apenasData.'"';
						 $qrInsChAlm = mysql_query($insChAlm) or die (mysql_error());
						 if($qrInsChAlm){
							
							 echo "	<script>
							alert('Marcação de chegado do almoço realizada.');
							</script>";
							exit;
						  }
						}
			} else if($_GET['id'] == 'saida'){
				if(mysql_result($qr, 0, 'saida almoco') == '0000-00-00'){
				   
				   echo "	<script>
							alert('É necessário registrar a saída para o almoço.');
							</script>";
							exit;
				} else if(mysql_result($qr, 0, 'chegada almoco') == '0000-00-00'){
					
					echo "	<script>
							alert('Saída já 'É necessário registrar a chegada do almoço.');
							</script>";
							exit;
				} else if(mysql_result($qr, 0, 'saida') != '0000-00-00'){
						
						echo "	<script>
							alert('Saída já está registrada!');
							</script>";
							exit;
					}else{
						 $insChAlm = 'update 
						 				tbl_ponto set saida = "'.$dtHora.'" 
									  where 
									  	id_funcionario = '.$_GET['idLogado'].' and substring(chegada, 1, 10) ="'.$apenasData.'"';
						 $qrInsChAlm = mysql_query($insChAlm) or die (mysql_error());
						 if($qrInsChAlm){
							 	
								echo "	<script>
							alert('Marcação de saída realizada.');
							</script>";
							exit;
							}
						}
			} else {
					if($_POST['login'] == '') {
						echo "	<script>
								alert('Chegada já esta registrada!');
								</script>";
								exit;
					}
			}
	
	

?>