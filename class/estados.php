<?php
if($EstadosInstanciada == '') {
	if(file_exists('Connections/conexao.php')) {
		include('Connections/con-pdo.php');
		include('funcoes.php');
	} else {
		require_once('../Connections/con-pdo.php');
		include('../funcoes.php');
	}
	
	class Estados {
		/*  
		* Atributo para conexão com o banco de dados   
		*/  
		private $pdo = null;  
	
		/*  
		* Atributo estático para instância da própria classe    
		*/  
		private static $Estados = null; 
	
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
			if (!isset(self::$Estados)):    
				self::$Estados = new Estados($conexao);   
			endif;
			return self::$Estados;    
		}
		
		function rsDados($id='') {
			
			/// FILTROS
			$nCampos = 0;
			
			if($id <> '') {
				$sql .= " and dados_estados.id = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id;
			}
			
			try{   
				$sql = "SELECT * FROM dados_estados where 1=1 ";
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
		
		function selectEstados($nomeCampo='id_estado', $style="padding:5px;", $selecionado='', $campoLabel='uf', $chamaCidades='', $class='form-control') {
			$estados = $this->rsDados();
			?>
			<select name="<?=$nomeCampo;?>" id="<?=$nomeCampo;?>" class="<?php echo $class;?>" style=" <?=$style;?>" <?php if($chamaCidades == 'S') { ?>onChange="AtualizaJanela('cidades.php?id_estado='+this.value, 'Cidades');"<?php } ?>>
				<option value=""></option>
					<?php 
					foreach($estados as $estado) {
					?>
						<option value="<?php echo $estado->id?>" <?php if($estado->id == $selecionado) { echo 'selected="selected"'; } ?>><?php echo $estado->$campoLabel;?></option>
					<?php 
					}
					?>
			</select>
        <?php
		}
	}
	
	$EstadosInstanciada = 'S';
}