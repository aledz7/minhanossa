<?php
@ session_start();

if($BlogInstanciada == '') {
	if(file_exists('Connections/conexao.php')) {
		include('Connections/con-pdo.php');
		include('funcoes.php');
	} else {
		require_once('../Connections/con-pdo.php');
		include('../funcoes.php');
	}
	
	class Blogs {
		
		protected $exibeCampos = array();
		protected $addWhere;
		
		protected $camposPersonalizados = array();
		protected $nomeCamposPersonalizados = array();
		
		protected $add_campo_busca = array();
		protected $get_add_campo_busca = array();
		
		private $pdo = null;  

		private static $Blogs = null; 

		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		public static function getInstance($conexao){   
			if (!isset(self::$Blogs)):    
				self::$Blogs = new Blogs($conexao);   
			endif;
			return self::$Blogs;    
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
				$sql = "SELECT * FROM tbl_blog where 1=1 $sql $sqlOrdem $sqlLimite";
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
			if($_POST['acao'] == 'addBlog') {
			
					try{
						
						if(file_exists('Connections/conexao.php')) {
						$pastaArquivos = '../img_noticias';
					} else {
						$pastaArquivos = '../img_noticias';
					}
						
						$sql = "INSERT INTO tbl_blog (titulo, breve, descricao, foto) VALUES (?, ?, ?, ?)";   
						$stm = $this->pdo->prepare($sql);   
						$stm->bindValue(1, $_POST['titulo']);   
						$stm->bindValue(2, $_POST['breve']);   
						$stm->bindValue(4, $_POST['descricao']);   
						$stm->bindValue(4, upload('foto', $pastaArquivos, 'N'));  
						$stm->execute(); 
						$idConteudo = $this->pdo->lastInsertId();
						
						if($redireciona == '') {
							$redireciona = 'blog.php';
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
		
		function editar($redireciona='blog.php') {
			if($_POST['acao'] == 'editarBlog') {
				try { 
				
					if(file_exists('Connections/conexao.php')) {
						$pastaArquivos = 'img_noticias';
					} else {
						$pastaArquivos = '../img_noticias';
					}
						 
					$sql = "UPDATE tbl_blog SET titulo=?, breve=?, descricao=?, foto=? WHERE id=?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_POST['titulo']);   
					$stm->bindValue(2, $_POST['breve']);   
					$stm->bindValue(3, $_POST['descricao']); 
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
			if($_GET['acao'] == 'excluirBlog') {
				
				try{   
					$sql = "DELETE FROM tbl_blog WHERE id=? ";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				
			}
		}
	}
	
	$BlogInstanciada = 'S';
}