<?php
if($CidadesInstanciada == '') {
	if(file_exists('Connections/con-pdo.php')) {
		include('Connections/con-pdo.php');
		include('funcoes.php');
	} else {
		require_once('../Connections/con-pdo.php');
		include('../funcoes.php');
	}
	
	class Cidades {
		/*  
		* Atributo para conex�o com o banco de dados   
		*/  
		private $pdo = null;  
	
		/*  
		* Atributo est�tico para inst�ncia da pr�pria classe    
		*/  
		private static $Cidades = null; 
	
		/*  
		* Construtor da classe como private  
		* @param $conexao - Conex�o com o banco de dados  
		*/  
		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		/*
		* M�todo est�tico para retornar um objeto crudBlog    
		* Verifica se j� existe uma inst�ncia desse objeto, caso n�o, inst�ncia um novo    
		* @param $conexao - Conex�o com o banco de dados   
		* @return $AtualizaProcessos - Instancia do objeto AtualizaProcessos    
		*/   
		
		public static function getInstance($conexao){   
			if (!isset(self::$Cidades)):    
				self::$Cidades = new Cidades($conexao);   
			endif;
			return self::$Cidades;    
		}
		
		function rsDados($uf, $id_estado='') {
			
			$nCampos = 0;
			
			if($uf <> '') {
				$sql .= " and uf = ?"; 
				$nCampos++;
				$campo[$nCampos] = $uf;
			}
			
			if($id_estado <> '') {
				$sql .= " and id_estado = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id_estado;
			}
			//echo $sql; exit;
			
			try{   
				$sql = "SELECT * FROM dados_cidades where 1=1 $sql";
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
		
		function selectCidades($uf="", $id_estado="", $nomeCampo='id_cidade', $selecionado='', $campoLabel='nome', $style="", $class='form-control', $desc_primeira_opcao='') {
			$cidades = $this->rsDados($uf, $id_estado);
			?>
			<select name="<?=$nomeCampo;?>" id="<?=$nomeCampo;?>" class="<?php echo $class;?>" style=" <?=$style;?>">
				<option value=""><?=$desc_primeira_opcao;?></option>
					<?php 
					foreach($cidades as $cidade) {
					?>
						<option value="<?php echo $cidade->id?>" <?php if($cidade->id == $selecionado) { echo 'selected="selected"'; } ?>><?php echo $cidade->$campoLabel;?></option>
					<?php 
					}
					?>
			</select>
        <?
		}
	}
	
	$CidadesInstanciada = 'S';
}