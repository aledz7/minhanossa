<?php
if($NewsletterInstanciada == '') {
	if(file_exists('Connections/conexao.php')) {
		include('Connections/con-pdo.php');
		include('funcoes.php');
	} else {
		require_once('../Connections/con-pdo.php');
		include('../funcoes.php');
	}
	
	class Newsletter {

		private $pdo = null;  

		private static $Newsletter = null; 

		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		public static function getInstance($conexao){   
			if (!isset(self::$Newsletter)):    
				self::$Newsletter = new Newsletter($conexao);   
			endif;
			return self::$Newsletter;    
		}
		
		function rsDados($id='') {
			
			/// FILTROS
			$nCampos = 0;
			
			if($idMenu <> '') {
				$sql .= " and idMenu = ?"; 
				$nCampos++;
				$campo[$nCampos] = $idMenu;
			}
			
			if($id <> '') {
				$sql .= " and id = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id;
			}
			
			try{   
				$sql = "SELECT tbl_contatos.* FROM tbl_contatos where 1=1 $sql ";
				$stm = $this->pdo->prepare($sql);
				
				for($i=1; $i<=$nCampos; $i++) {
					$stm->bindValue($i, $campo[$i]);
				}
				
				$stm->execute();   
				$rsDados = $stm->fetchAll(PDO::FETCH_OBJ);
				if($id <> '') {
					return($rsDados[0]);
				} else {
					return($rsDados);
				}
			} catch(PDOException $erro){   
				echo $erro->getLine(); 
			}
		}
		
				
		function add($redirecionaSucesso="cadastros-newsletter.php", $alert='') {
			if($_POST['acao'] == 'addNewsletter') {
				
				if($_POST['email'] == '') {
					echo "	<script>
							alert('ERRO: POST >> [\'email\'] não encontrado.');
							window.location='.';
							</script>";
							exit;
				}
				
				// Verificar se já existe:
				$sql = "SELECT tbl_newsletter.* FROM tbl_newsletter where email = ? ";
				$stm = $this->pdo->prepare($sql);
				$stm->bindValue(1, $_POST['email']);			
				$stm->execute();  
				
				if(count($stm->fetchAll(PDO::FETCH_OBJ)) > 0) {
					echo "	<script>
							alert('E-mail já cadastrado. Obrigado.');
							window.location='.';
							</script>";
							exit;
				} else {
					try{   
						$sql = "INSERT INTO tbl_newsletter (nome, email) VALUES (?, ?)";   
						$stm = $this->pdo->prepare($sql);   
						$stm->bindValue(1, $_POST['nome']);   
						$stm->bindValue(2, $_POST['email']);   
						$stm->execute(); 
						$idConteudo = $this->pdo->lastInsertId();
						
						if($alert <> '') {
							$scriptAlert = "alert('$alert')";
						}
						
						echo "	<script>
								window.location='$redirecionaSucesso';
								{$scriptAlert}
								</script>";
								exit;
					} catch(PDOException $erro){
						echo $erro->getMessage(); 
					}
				}
			}
		}
		
		function hidden_add() {
			?>
            <input type="hidden" name="acao" value="addNewsletter">
            <?
		}
		
		function editar() {
			if($_POST['acao'] == 'editarNewsletter') {
				try{   
					$sql = "UPDATE tbl_contatos SET nome=?, email=? WHERE id=?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_POST['nome']);   
					$stm->bindValue(2, $_POST['email']);  //echo $_POST['data']; exit; 
					$stm->bindValue(3, $_POST['id']);   
					$stm->execute(); 
					$idConteudo = $this->pdo->lastInsertId();
					
					echo "	<script>
							window.location='cadastros-newsletter.php';
							</script>";
							exit;
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
			}
		}
		
		function excluir() {
			if($_GET['acao'] == 'excluirContato') {
			
				try{   
					$sql = "DELETE FROM tbl_contatos WHERE id=?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				
			}
		}
	}
	
	$NewsletterInstanciada = 'S';
}