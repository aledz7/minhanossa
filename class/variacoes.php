<?php
if($variacoesInstanciada == '') {
	if(file_exists('Connections/conexao.php')) {
		include('Connections/con-pdo.php');
		include('funcoes.php');
	} else {
		require_once('../Connections/con-pdo.php');
		include('../funcoes.php');
	}
	
	class Variacoes {
		/*  
		* Atributo para conexão com o banco de dados   
		*/  
		private $pdo = null;  
	
		/*  
		* Atributo estático para instância da própria classe    
		*/  
		private static $Variacoes = null; 
	
		/*  
		* Construtor da classe como private  
		* @param $conexao - Conexão com o banco de dados  
		*/  
		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		/*
		* Método estático para retornar um objeto crudBlog    
		* Verifica se já existe uma instância desse objeto, caso não, instância um novo    
		* @param $conexao - Conexão com o banco de dados   
		* @return $AtualizaProcessos - Instancia do objeto AtualizaProcessos    
		*/   
		
		public static function getInstance($conexao){   
			if (!isset(self::$Variacoes)):    
				self::$Variacoes = new Variacoes($conexao);   
			endif;
			return self::$Variacoes;    
		}
		
		function rsDados($idProduto='', $id='', $orderBy='') {
			
			$nCampos = 0;
			
			if($idProduto <> '') {
				$sql .= " and id_produto = ?"; 
				$nCampos++;
				$campo[$nCampos] = $idProduto;
			}
			
			if($id <> '') {
				$sql .= " and id = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id;
			}
						
			if($orderBy <> '') {
				$sqlOrdem = " order by {$orderBy}";
			}
			
			try{   
				$sql = "SELECT * FROM tbl_variacoes where 1=1 $sql $sqlOrdem";
				$stm = $this->pdo->prepare($sql);
				
				for($i=1; $i<=$nCampos; $i++) {
					$stm->bindValue($i, $campo[$i]);
				}
				
				$stm->execute();   
				$rsDados = $stm->fetchAll(PDO::FETCH_OBJ);
				return($rsDados);
			} catch(PDOException $erro){   
				echo $erro->getLine(); 
			}
		}
	}
	
	$variacoesInstanciada = 'S';
}