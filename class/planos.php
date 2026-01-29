<?php
@ session_start();

if($PlanosInstanciada == '') {
	if(file_exists('Connections/conexao.php')) {
		include('Connections/con-pdo.php');
		include('funcoes.php');
	} else {
		require_once('../Connections/con-pdo.php');
		include('../funcoes.php');
	}
	
	class Planos {
		
		protected $exibeCampos = array();
		protected $addWhere;
		
		protected $camposPersonalizados = array();
		protected $nomeCamposPersonalizados = array();
		
		protected $add_campo_busca = array();
		protected $get_add_campo_busca = array();
		
		private $pdo = null;  

		private static $Planos = null; 

		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		public static function getInstance($conexao){   
			if (!isset(self::$Planos)):    
				self::$Planos = new Planos($conexao);   
			endif;
			return self::$Planos;    
		}
		
		function rsDados($id='', $mostraSite='', $orderBy='', $limite='') {
			
			/// FILTROS
			$nCampos = 0;
			
			if($id <> '') {
				$sql .= " and id = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id;
			}
			
			if($mostraSite <> '') {
				$sql .= " and mostra_site = ?"; 
				$nCampos++;
				$campo[$nCampos] = $mostraSite;
			}
			
			/// ORDEM		
			if($orderBy <> '') {
				$sqlOrdem = " order by {$orderBy}";
			}
			
			if($limite <> '') {
				$sqlLimite = " limit 0,{$limite}";
			}
			
			try{   
				$sql = "SELECT * FROM tbl_plano where 1=1 $sql $sqlOrdem $sqlLimite";
				$stm = $this->pdo->prepare($sql);
				
				for($i=1; $i<=$nCampos; $i++) {
					$stm->bindValue($i, $campo[$i]);
				}
				
				$stm->execute();
				$rsDados = $stm->fetchAll(PDO::FETCH_OBJ);
				//print_r($rsDados);
				if($id <> '' or $limite == 1) {
					return($rsDados[0]);
				} else {
					return($rsDados);
				}
			} catch(PDOException $erro){   
				echo $erro->getMessage(); 
			}
		}
		
		function add($redireciona='') {
			if($_POST['acao'] == 'addPlanos') {
				/*echo $_POST['id_plano'];
				exit;*/
				
				if($_POST['id_plano'] <> ''){
					$timeStamp = strtotime("+1 month");
					$dataFinal .= date ('Y-m-d' , $timeStamp); 
				}
				// Verificar se já existe:
				$sql = "SELECT tbl_users.* FROM tbl_users where email = ? or cpf = ? ";
				$stm = $this->pdo->prepare($sql);
				$stm->bindValue(1, $_POST['email']);			
				$stm->bindValue(2, $_POST['cpf']);			
				$stm->execute();  
				
				if(count($stm->fetchAll(PDO::FETCH_OBJ)) > 0) {
					echo "	<script>
							alert('E-mail ou CPF já cadastrado. Por favor. Tente realizar login com seu e-mail de acesso.');
							window.location='.';
							</script>";
							exit;
				} else {
					try{
						
						if(file_exists('Connections/conexao.php')) {
							$pastaArquivos = 'img_noticias';
						} else {
							$pastaArquivos = '../img_noticias';
						}
						
						$sql = "INSERT INTO tbl_users (nome, data_de_nascimento, email, bairro, cep, id_cidade, id_estado, pais, telefone, newsletter, senha, cpf, rg, endereco, complemento, celular, skype, ativo, foto, cod_banco, agencia, conta, tipo_conta, operacao, variacao, pontos, plano_tipo, plano_pago_ate, id_plano, plano_pago_de) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";   
						$stm = $this->pdo->prepare($sql);   
						$stm->bindValue(1, $_POST['nome']);   
						$stm->bindValue(2, formataDataSQL($_POST['data_de_nascimento']));   
						$stm->bindValue(3, $_POST['email']);   
						$stm->bindValue(4, $_POST['bairro']);   
						$stm->bindValue(5, $_POST['cep']);   
						$stm->bindValue(6, $_POST['id_cidade'][0]);   
						$stm->bindValue(7, $_POST['id_estado']);   
						$stm->bindValue(8, $_POST['pais']);   
						$stm->bindValue(9, $_POST['telefone']);   
						$stm->bindValue(10, $_POST['newsletter']);   
						$stm->bindValue(11, $_POST['senha']);   
						$stm->bindValue(12, $_POST['cpf']);   
						$stm->bindValue(13, $_POST['rg']);   
						$stm->bindValue(14, $_POST['endereco']);   
						$stm->bindValue(15, $_POST['complemento']);   
						$stm->bindValue(16, $_POST['celular']);   
						$stm->bindValue(17, $_POST['skype']);   
						$stm->bindValue(18, $_POST['ativo']);   
						$stm->bindValue(19, upload('foto', $pastaArquivos, 'N'));   
						$stm->bindValue(20, $_POST['cod_banco']);   
						$stm->bindValue(21, $_POST['agencia']);   
						$stm->bindValue(22, $_POST['conta']);   
						$stm->bindValue(23, $_POST['tipo_conta']);   
						$stm->bindValue(24, $_POST['operacao']);   
						$stm->bindValue(25, $_POST['variacao']);   
						$stm->bindValue(26, $_POST['pontos']);   
						$stm->bindValue(27, $_POST['plano_tipo']);   
						$stm->bindValue(28, $dataFinal);   
						$stm->bindValue(29, $_POST['id_plano']);   
						$stm->bindValue(30, date('Y-m-d'));   
						$stm->execute(); 
						$idConteudo = $this->pdo->lastInsertId();
						
						
						/// CAMPOS PERSONALIZADOS
						if($_POST['idsCamposPersonalizados'] <> '') {
							$camposPersonalizados = explode(', ', $_POST['idsCamposPersonalizados']);
							for($i=0; $i<count($camposPersonalizados); $i++) {
								try{   
									$sql = "INSERT INTO tbl_relaciona_campos (id_cliente, id_campo, valor, id_idioma) VALUES (?, ?, ?, ?)";   
									$stm = $this->pdo->prepare($sql);   
									$stm->bindValue(1, $idConteudo);   
									$stm->bindValue(2, $camposPersonalizados[$i]);   
									$stm->bindValue(3, $_POST['campoPersonalizado'][$i]);   
									$stm->bindValue(4, 1);   
									$stm->execute();
								} catch(PDOException $erro){
									echo $erro->getMessage(); 
								}
							}
						}
						/// FIM CAMPO PERSONALIZADO
						
						if($_POST['condicao'] == 'presente') {
							echo "	<script>
								window.location='checkout/pagseguro.php?id=$idConteudo&id_plano={$_POST['id_plano']}&condicao=presente';
								</script>";
								exit;
						}
						if($_POST['id_plano'] <> '') {
							echo "	<script>
								window.location='checkout/pagseguro.php?id=$idConteudo&id_plano={$_POST['id_plano']}';
								</script>";
								exit;
						}
						
						if($redireciona == '') {
							$redireciona = 'clientes.php';
						}
						
						echo "	<script>
								window.location='{$redireciona}';
								</script>";
								exit;
					} catch(PDOException $erro){
						echo $erro->getMessage(); 
					}
				}
			}
		}
		
		function editar($redireciona='planos.php') {
			if($_POST['acao'] == 'editarPlanos') {
				try { 
				
					if(file_exists('Connections/conexao.php')) {
						$pastaArquivos = 'img_noticias';
					} else {
						$pastaArquivos = '../img_noticias';
					}
						 
					$sql = "UPDATE tbl_users SET nome=?, data_de_nascimento=?, email=?, bairro=?, cep=?, id_cidade=?, id_estado=?, telefone=?, newsletter=?, senha=?, cpf=?, rg=?, endereco=?, complemento=?, celular=?, skype=?, ativo=?, foto=?, cod_banco=?, agencia=?, conta=?, tipo_conta=?, operacao=?, variacao=?, plano_tipo=?, plano_pago_ate=?, id_plano=?, pontos=? WHERE id=?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_POST['nome']);   
					$stm->bindValue(2, $_POST['data_de_nascimento']);  //echo $_POST['data']; exit; 
					$stm->bindValue(3, $_POST['email']);   
					$stm->bindValue(4, $_POST['bairro']);   
					$stm->bindValue(5, $_POST['cep']);   
					$stm->bindValue(6, $_POST['id_cidade'][0]);  
					$stm->bindValue(7, $_POST['id_estado']);   
					$stm->bindValue(8, $_POST['telefone']);   
					$stm->bindValue(9, $_POST['newsletter'][0]);   
					$stm->bindValue(10, $_POST['senha']);   
					$stm->bindValue(11, $_POST['cpf']);   
					$stm->bindValue(12, $_POST['rg']);   
					$stm->bindValue(13, $_POST['endereco']);   
					$stm->bindValue(14, $_POST['complemento']);   
					$stm->bindValue(15, $_POST['celular']);   
					$stm->bindValue(16, $_POST['skype']);   
					$stm->bindValue(17, $_POST['ativo']); 
					$stm->bindValue(18, upload('foto', $pastaArquivos, 'N'));  
					$stm->bindValue(19, $_POST['cod_banco']); 
					$stm->bindValue(20, $_POST['agencia']); 
					$stm->bindValue(21, $_POST['conta']); 
					$stm->bindValue(22, $_POST['tipo_conta']); 
					$stm->bindValue(23, $_POST['operacao']); 
					$stm->bindValue(24, $_POST['variacao']); 
					$stm->bindValue(25, $_POST['plano_tipo']); 
					$stm->bindValue(26, $_POST['plano_pago_ate']); 
					$stm->bindValue(27, $_POST['id_plano']); 
					$stm->bindValue(28, $_POST['pontos']); 
					$stm->bindValue(29, $_POST['id']);   
					$stm->execute(); 
					$id = $_POST['id'];
					
					/// CAMPOS PERSONALIZADOS
					try{   
						$sql = "DELETE FROM tbl_relaciona_campos WHERE id_cliente=?";   
						$stm = $this->pdo->prepare($sql);   
						$stm->bindValue(1, $id);   
						$stm->execute();
					} catch(PDOException $erro){
						echo $erro->getMessage(); 
					}
				
					if($_POST['idsCamposPersonalizados'] <> '') {
						$camposPersonalizados = explode(', ', $_POST['idsCamposPersonalizados']);
						for($i=0; $i<count($camposPersonalizados); $i++) {
							try{   
								$sql = "INSERT INTO tbl_relaciona_campos (id_cliente, id_campo, valor, id_idioma) VALUES (?, ?, ?, ?)";   
								$stm = $this->pdo->prepare($sql);   
								$stm->bindValue(1, $id);   
								$stm->bindValue(2, $camposPersonalizados[$i]);   
								$stm->bindValue(3, $_POST['campoPersonalizado'][$i]);   
								$stm->bindValue(4, 1);   
								$stm->execute();
							} catch(PDOException $erro){
								echo $erro->getMessage(); 
							}
						}
					}
					
					echo "	<script>
							window.location='{$redireciona}';
							</script>";
							exit;
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
			}
		}
		
		function excluir() {
			if($_GET['acao'] == 'excluirPlanos') {
				
				try{   
					$sql = "DELETE FROM tbl_users WHERE id=? ";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				
			}
		}
	}
	
	$PlanosInstanciada = 'S';
}