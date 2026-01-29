<?php
if($TraducoesInstanciada == '') {
	@ session_start();
	
	if(file_exists('Connections/conexao.php')) {
		include('Connections/con-pdo.php');
		include('funcoes.php');
	} else {
		require_once('../Connections/con-pdo.php');
		include('../funcoes.php');
	}
	
	class Traducoes {
		
		private $pdo = null;  

		private static $Traducoes = null; 

		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		public static function getInstance($conexao){   
			if (!isset(self::$Traducoes)):    
				self::$Traducoes = new Traducoes($conexao);   
			endif;
			return self::$Traducoes;    
		}
		
		function trocaIdioma() {
			if($_SESSION['id_idioma'] == '' or $_SESSION['sigla_idioma'] == '') {
				$_SESSION['id_idioma'] = 1;
				$_SESSION['sigla_idioma'] = 'pt-br';
			}
			
			if($_GET['id_idioma'] <> '' and $_SESSION['id_idioma'] <> $_GET['id_idioma']) {
				$_SESSION['id_idioma'] = $_GET['id_idioma'];
				
				try{   
					$sql = "SELECT sigla FROM tbl_idiomas where id = ?";
					$stm = $this->pdo->prepare($sql);
					$stm->bindValue(1, $_GET['id_idioma']);
					$stm->execute();   
					$rsDados = $stm->fetchAll(PDO::FETCH_OBJ);
				} catch(PDOException $erro){   
					echo $erro->getLine(); 
				}
				
				$_SESSION['sigla_idioma'] = $rsDados[0]->sigla;
			}
		}
		
		function linkTrocaIdioma($idIdioma) {
			return('?&'.$_SERVER['QUERY_STRING'].'&id_idioma='.$idIdioma);
		}
		
		function traduzManual($texto) {
			$t["CADA"]['por'] = 'CADA';
			$t["CADA"]['ing'] = 'EACH';
		}
		
		function traduzGoogle($texto) {
			if($_SESSION['id_idioma'] == '1') {
				return($texto);
			} else {
				$ch = curl_init();
				$timeout = 5; // set to zero for no timeout
				$url = "http://servidor-de-traducao.web2415.uni5.net/resultado/?palavra=".urlencode($texto)."&de_idioma=pt-br&para_idioma={$_SESSION['sigla_idioma']}";
				curl_setopt ($ch, CURLOPT_URL, $url);
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
				$traducao = curl_exec($ch);
				curl_close($ch);
				return($traducao);
			}
		}
	}
	
	$TraducoesInstanciada = 'S';
}