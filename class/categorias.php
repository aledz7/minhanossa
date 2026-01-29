<?php
@ session_start();

if($CatgoriasInstanciada == '') {
	if(file_exists('Connections/conexao.php')) {
		include('Connections/con-pdo.php');
		include('funcoes.php');
	} else {
		require_once('../Connections/con-pdo.php');
		include('../funcoes.php');
	}
	
	class Categorias {
		
		protected $exibeCampos = array();
		protected $addWhere;
		
		protected $camposPersonalizados = array();
		protected $nomeCamposPersonalizados = array();
		
		protected $add_campo_busca = array();
		protected $get_add_campo_busca = array();
		
		private $pdo = null;  

		private static $Categorias  = null; 

		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		public static function getInstance($conexao){   
			if (!isset(self::$Categorias )):    
				self::$Categorias = new Categorias($conexao);   
			endif;
			return self::$Categorias;    
		}
		
		
		function rsDados($id='', $orderBy='', $limite='') {
			
			/// FILTROS
			$nCampos = 0;
			
			if($id <> '') {
				$sql .= " and id = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id;
			}
			
			/// ORDEM		
			if($orderBy <> '') {
				$sqlOrdem = " order by {$orderBy}";
			}
			
			if($limite <> '') {
				$sqlLimite = " limit 0,{$limite}";
			}
		
			try{   
				$sql = "SELECT * FROM tbl_cats where 1=1 $sql $sqlOrdem $sqlLimite";
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

		function rsDadosSub($id='', $id_categoria='', $orderBy='', $limite='') {
			
			/// FILTROS
			$nCampos = 0;
			
			if($id <> '') {
				$sql .= " and id = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id;
			}

			if($id_categoria <> '') {
				$sql .= " and id_categoria = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id_categoria;
			}
			
			/// ORDEM		
			if($orderBy <> '') {
				$sqlOrdem = " order by {$orderBy}";
			}
			
			if($limite <> '') {
				$sqlLimite = " limit 0,{$limite}";
			}
		
			try{   
				$sql = "SELECT * FROM tbl_subcategorias where 1=1 $sql $sqlOrdem $sqlLimite";
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
		
		/*function add($redireciona='') {
			if($_POST['acao'] == 'addMarcas') {
			
					try{
						
						if(file_exists('Connections/conexao.php')) {
						$pastaArquivos = 'img_noticias';
					} else {
						$pastaArquivos = '../img_noticias';
					}
						
						$sql = "INSERT INTO tbl_marcas (titulo, instagram, link, foto) VALUES (?, ?, ?, ?)";   
						$stm = $this->pdo->prepare($sql);   
						$stm->bindValue(1, $_POST['titulo']);   
						$stm->bindValue(2, $_POST['instagram']);   
						$stm->bindValue(4, $_POST['link']);   
						$stm->bindValue(4, upload('foto', $pastaArquivos, 'N'));  
						$stm->execute(); 
						$idConteudo = $this->pdo->lastInsertId();
						
						
						
						if($_POST['condicao'] == 'presente') {
							echo "	<script>
								window.location='checkout/pagseguro.php?id=$idConteudo&id_plano={$_POST['id_plano']}&condicao=presente';
								</script>";
								exit;
						}
						if($_POST['id_plano'] <> '') {
							if($_POST['token_plano'] == 'SEM TOKEN') {
								echo "	<script>
									window.location='checkout/pagseguro.php?id=$idConteudo&id_plano={$_POST['id_plano']}';
									</script>";
									exit;
							}else{
								echo "
								
								<form action='https://pagseguro.uol.com.br/pre-approvals/request.html' name='formPag' id='formPag' method='post'>
                                <input type='hidden' name='code' value='{$_POST['token_plano']}' />
                                <input type='hidden' name='iot' value='button' />
                                </form>
								<script>
								document.formPag.submit();
								</script>
								";
								exit;
								
							}
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
		} */
		
		/*function editar($redireciona='marcas.php') {
			if($_POST['acao'] == 'editarMarcas') {
				try { 
				
					if(file_exists('Connections/conexao.php')) {
						$pastaArquivos = 'img_noticias';
					} else {
						$pastaArquivos = '../img_noticias';
					}
						 
					$sql = "UPDATE tbl_marcas SET titulo=?, instagram=?, link=?, foto=? WHERE id=?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_POST['titulo']);   
					$stm->bindValue(2, $_POST['instagram']);   
					$stm->bindValue(3, $_POST['link']); 
					$stm->bindValue(4, upload('foto', $pastaArquivos, 'N'));  
					$stm->bindValue(5, $_POST['id']);   
					$stm->execute(); 
					$id = $_POST['id'];
				
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
			if($_GET['acao'] == 'excluirMarcas') {
				
				try{   
					$sql = "DELETE FROM tbl_marcas WHERE id=? ";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				
			}
		}*/
	}
	
	$CategoriasInstanciada = 'S';
}