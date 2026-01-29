<?php
if($InfoSiteInstanciada == '') {
	if(file_exists('Connections/conexao.php')) {
		include('Connections/con-pdo.php');
		include('funcoes.php');
	} else {
		require_once('../Connections/con-pdo.php');
		include('../funcoes.php');
	}
	
	class InfoSite {

		private $pdo = null;  

		private static $InfoSite = null; 
	
		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
		
		public static function getInstance($conexao){   
			if (!isset(self::$InfoSite)):    
				self::$InfoSite = new InfoSite($conexao);   
			endif;
			return self::$InfoSite;    
		}
		
		var $email;
		var	$telefone;
		var	$celular;
		var	$nome;
		var	$facebook;
		var	$twitter;
		var	$gplus;
		var	$instagram;
		var	$endereco;
		var	$cep;
		var	$logo;
		var	$marca_dagua;
		var	$temAtacado;
		var $temLojaVirtual;
		var $temOutrasEspecificacoes;
		var $email_pagseguro;
		var $token_pagseguro;
		var $host_smtp;
		var $porta_smtp;
		var $usuario_smtp;
		var $senha_smtp;
		var $temPagSeguro;
		var $tem_dados_bancarios;
		var $temNewsletter;
		var $tem_estoque_peso;
				
		function rsDados() {
			
			try{   
				$sql = "SELECT * FROM tbl_config ";
				$stm = $this->pdo->prepare($sql);
				$stm->execute();   
				$rsDados = $stm->fetchAll(PDO::FETCH_OBJ);
											
				$this->email = $rsDados[0]->e_mail;
				$this->telefone = $rsDados[0]->telefone;
				$this->celular = $rsDados[0]->celular;
				$this->nome = $rsDados[0]->nome_loja;
				$this->facebook = $rsDados[0]->linkFacebook;
				$this->twitter = $rsDados[0]->linkTwitter;
				$this->gplus = $rsDados[0]->linkGooglePlus;
				$this->instagram = $rsDados[0]->linkInstagram;
				$this->cep = $rsDados[0]->cep_loja;
				$this->logo = $rsDados[0]->logo;
				$this->marca_dagua = $rsDados[0]->marca_dagua;
				$this->endereco = nl2br($rsDados[0]->endereco);
				$this->temAtacado = $rsDados[0]->temAtacado;
				$this->temLojaVirtual = $rsDados[0]->temLojaVirtual;
				$this->temOutrasEspecificacoes = $rsDados[0]->temOutrasEspecificacoes;
				$this->email_pagseguro = $rsDados[0]->email_pagseguro;
				$this->token_pagseguro = $rsDados[0]->token_pagseguro;
				$this->host_smtp = $rsDados[0]->host_smtp;
				$this->porta_smtp = $rsDados[0]->porta_smtp;
				$this->usuario_smtp = $rsDados[0]->usuario_smtp;
				$this->senha_smtp = $rsDados[0]->senha_smtp;
				$this->temPagSeguro = $rsDados[0]->temPagSeguro;
				$this->temNewsletter = $rsDados[0]->temNewsletter;
				$this->tem_dados_bancarios = $rsDados[0]->cad_clientes_tem_conta_banco;
				$this->tem_estoque_peso = $rsDados[0]->tem_estoque_peso;
				
			} catch(PDOException $erro){   
				echo $erro->getMessage(); 
			}
			
			return($this);
		}
		
		
		function editar() {
			if($_POST['acao'] == 'editarConfig') {
				//echo upload('logo', '../img_noticias/', 'N'); exit;
				try{   
					$sql = "UPDATE tbl_config SET e_mail=?, telefone=?, nome_loja=?, linkFacebook=?, linkTwitter=?, linkGooglePlus=?, cep_loja=?, endereco=?, logo=?, marca_dagua=?, linkInstagram=?, email_pagseguro=?, token_pagseguro=?, host_smtp=?, porta_smtp=?, usuario_smtp=?, senha_smtp=?, celular=? ";   
					$stm = $this->pdo->prepare($sql);  
					$stm->bindValue(1, $_POST['e_mail']);
					$stm->bindValue(2, $_POST['telefone']);
					$stm->bindValue(3, $_POST['nome_loja']);   
					$stm->bindValue(4, $_POST['linkFacebook']);   
					$stm->bindValue(5, $_POST['linkTwitter']);   
					$stm->bindValue(6, $_POST['linkGooglePlus']);   
					$stm->bindValue(7, $_POST['cep_loja']);   
					$stm->bindValue(8, $_POST['endereco']);   
					$stm->bindValue(9, upload('logo', '../img_noticias/', 'N'));   
					$stm->bindValue(10, upload('marcaDagua', '../img_noticias/', 'N'));   
					$stm->bindValue(11, $_POST['linkInstagram']);   
					$stm->bindValue(12, $_POST['email_pagseguro']);
					$stm->bindValue(13, $_POST['token_pagseguro']);   
					$stm->bindValue(14, $_POST['host_smtp']);   
					$stm->bindValue(15, $_POST['porta_smtp']);   
					$stm->bindValue(16, $_POST['usuario_smtp']);   
					$stm->bindValue(17, $_POST['senha_smtp']);   
					$stm->bindValue(18, $_POST['celular']);   
					$stm->execute();  
					
					echo "	<script>
							window.location='.';
							</script>";
							exit;
				} catch(PDOException $erro){   
					echo $erro->getMessage();
				}
			}
		}
		
		
		function editar_config_loja() {
			if($_POST['acao'] == 'editar_config_loja') {
				
				try {
					$sql = "TRUNCATE tbl_estados_frete_gratis";   
					$stm = $this->pdo->prepare($sql);   
					$stm->execute(); 
				} catch(PDOException $erro){
					echo $erro->getMessage();
				}
				
				foreach($_POST['id_estado'] as $item) {
					try {
						$sql = "INSERT INTO tbl_estados_frete_gratis (id_estado) VALUES (?)";   
						$stm = $this->pdo->prepare($sql);   
						$stm->bindValue(1, $item);   
						$stm->execute(); 
					} catch(PDOException $erro){
						echo $erro->getMessage();
					}
				}
				
				echo "	<script>
						alert('Alterações realizadas com sucesso.');
						window.location='configs-loja.php';
						</script>";
						exit;
			}
		}
		
		function rs_estados_frete_gratis($id='', $uf='') {
			
			if($id <> '') {
				$sql .= " and tbl_estados_frete_gratis.id_estado = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id;
			}
			
			if($uf <> '') {
				$sql .= " and dados_estados.uf = ?"; 
				$nCampos++;
				$campo[$nCampos] = $uf;
			}
			
			try{   
				$sql = "SELECT dados_estados.* FROM tbl_estados_frete_gratis left join dados_estados on tbl_estados_frete_gratis.id_estado = dados_estados.id where 1=1 $sql ";
				$stm = $this->pdo->prepare($sql);
				
				for($i=1; $i<=$nCampos; $i++) {
					$stm->bindValue($i, $campo[$i]);
				}
				
				$stm->execute();   
				$rsDados = $stm->fetchAll(PDO::FETCH_OBJ);
				return($rsDados[0]);
			} catch(PDOException $erro){   
				echo $erro->getLine(); 
			}
			
			return($this);
		}
	}
	
	$InfoSiteInstanciada = 'S';
}