<?php
@ session_start();

if($ClientesInstanciada == '') {
	if(file_exists('Connections/conexao.php')) {
		include('Connections/con-pdo.php');
		include('funcoes.php');
	} else {
		require_once('../Connections/con-pdo.php');
		include('../funcoes.php');
	}
	
	class Clientes {
		
		protected $exibeCampos = array();
		protected $addWhere;
		
		protected $camposPersonalizados = array();
		protected $nomeCamposPersonalizados = array();
		
		protected $add_campo_busca = array();
		protected $get_add_campo_busca = array();
		
		private $pdo = null;  

		private static $Clientes = null; 

		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		public static function getInstance($conexao){   
			if (!isset(self::$Clientes)):    
				self::$Clientes = new Clientes($conexao);   
			endif;
			return self::$Clientes;    
		}
		
		/*public function add_exibeCampos($campo) {
			$this->exibeCampos[] = $campo;
		}*/
		
		
		public function ReiniciaAddCamposPersonalizados() {
			unset($this->camposPersonalizados);
			unset($this->nomeCamposPersonalizados);
		}
		
		public function add_campoPersonalizado($campo, $asCampoNome) {
			$this->camposPersonalizados[] = $campo;
			$this->nomeCamposPersonalizados[] = $asCampoNome;
		}
		
		public function add_campo_busca($campo, $get_campo) {
			$this->add_campo_busca[] = $campo;
			$this->get_add_campo_busca[] = $get_campo;
		}
		
		function login($login, $senha, $redireciona='painel-cliente.php') {
			
			if($login <> '' and $senha <> '') {
				try{   
					$sql = "SELECT * FROM tbl_cliente where email = :login and senha = :senha";
					$stm = $this->pdo->prepare($sql);
					$stm->bindValue(':login', $login, PDO::PARAM_STR);
					$stm->bindValue(':senha', $senha, PDO::PARAM_STR);
					$stm->execute();   
					$rsDados = $stm->fetchAll(PDO::FETCH_OBJ);
					
					if($rsDados[0]->id <> '') {
						$_SESSION['clienteLogado'] = 'S';
						$_SESSION['dadosLogadoCLiente'] = $rsDados[0];
						$_SESSION['MM_Username'] = $login;
						
						if($redireciona <> '') {
							echo "	<script>
									window.location='{$redireciona}';
									</script>";
									exit;
						}
					} else {
						echo "	<script>
								alert('Dados inválidos. Por favor, verifique os dados digitados.');
								window.location='login.php';
								</script>";
								exit;
					}
					
				} catch(PDOException $erro){   
					echo $erro->getMessage(); 
				}
			}
		}
		
		function restrito() {
			if($_SESSION['clienteLogado'] == '') {
				echo "	<script>
						alert('Por favor. Realize seu login.');
						window.location='login.php';
						</script>";
						exit;
			}
		}
		
		function logout() {
			if($_GET['acao'] == 'sair') {
				unset($_SESSION['clienteLogado']);
				unset($_SESSION['dadosLogadoCLiente']);
				unset($_SESSION['MM_Username']);
				
				echo "	<script>
						window.location='.';
						</script>";
						exit;
			}
		}
		
		function rsDados($id='', $orderBy='', $limite='', $ativo='', $temFoto='', $id_cidade='', $id_estado='', $email='') {
			
			/// FILTROS
			$nCampos = 0;
			
			if($id <> '') {
				$sql .= " and tbl_cliente.id = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id;
			}
			
			if($email <> '') {
				$sql .= " and tbl_cliente.email = ?"; 
				$nCampos++;
				$campo[$nCampos] = $email;
			}
			
			if($id_cidade <> '') {
				$sql .= " and tbl_cliente.cidade = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id_cidade;
			}
			
			if($id_estado <> '') {
				$sql .= " and tbl_cliente.estado = ?"; 
				$nCampos++;
				$campo[$nCampos] = $estado;
			}
			
			if($ativo == 'S') {
				$sql .= " and tbl_cliente.ativo = 'S'"; 
			}
			
			if($ativo == 'N') {
				$sql .= " and (tbl_cliente.ativo = 'N' or tbl_cliente.ativo is null)"; 
			}
			
			if($temFoto == 'S') {
				$sql .= " and tbl_cliente.foto <> '' and tbl_cliente.foto is not null"; 
			}
			
			/// ORDEM		
			if($orderBy <> '') {
				$sqlOrdem = " order by {$orderBy}";
			}
			
			if($limite <> '') {
				$sqlLimite = " limit 0,{$limite}";
			}
			
			if($this->add_campo_busca <> '') {
				$i_busca=0;
				foreach($this->add_campo_busca as $campo) {
					$item_campo = $campo;
					
					if($this->get_add_campo_busca[$i_busca] <> '') {
						if($item_campo == 'palavra_chave') {
							$sql .= " and (tbl_cliente.nome like '%{$this->get_add_campo_busca[$i_busca]}%' or tbl_cliente.email like '%{$this->get_add_campo_busca[$i_busca]}%')"; 
							$sql .= " and (tbl_cliente.nome like '%{$this->get_add_campo_busca[$i_busca]}%' or tbl_cliente.email like '%{$this->get_add_campo_busca[$i_busca]}%')"; 
						} elseif($item_campo == 'idade') {
							$sql .= " and TIMESTAMPDIFF(YEAR, tbl_cliente.data_de_nascimento, CURDATE()) = {$this->get_add_campo_busca[$i_busca]} "; 
						} elseif($item_campo == 'facebook') {
							$sql .= "  and fld_facebook_id = '{$this->get_add_campo_busca[$i_busca]}' "; 
						} elseif($item_campo == 'email') {
							$sql .= "  and email = '{$this->get_add_campo_busca[$i_busca]}' "; 
						} else {
							$sql .= " and tbl_cliente.{$item_campo} = ?"; 
							$nCampos++;
							$campo[$nCampos] = $this->get_add_campo_busca[$i_busca];
						}
					}
					$i_busca++;
				}
			}
			
			// EXIBE CAMPOS PERSONALIZADOS
			if($this->camposPersonalizados <> '') {
				foreach($this->camposPersonalizados as $idCampoPersonalizado) {
					$iCampo++;
					$nomeCampo = $this->nomeCamposPersonalizados[($iCampo-1)];
					
					$joins .= " left join tbl_relaciona_campos as tbl_campo_{$nomeCampo} on tbl_cliente.id = tbl_campo_{$nomeCampo}.id_cliente and tbl_campo_{$nomeCampo}.id_campo = {$idCampoPersonalizado}";
					$labelCamposAdds .= ", tbl_campo_{$nomeCampo}.valor as {$nomeCampo}";
				}
			}
			
			try{   
				$sql = "SELECT tbl_cliente.*, dados_estados.nome as nome_estado, dados_estados.uf as nome_uf, dados_cidades.nome as nome_cidade {$labelCamposAdds} FROM tbl_cliente left join dados_estados on tbl_cliente.estado = dados_estados.id left join dados_cidades on tbl_cliente.cidade = dados_cidades.id {$joins} where 1=1 $sql $sqlOrdem $sqlLimite";
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
			if($_POST['acao'] == 'addClientes') {
				/*echo $_POST['id_plano'];
				exit;*/
				
				if($_POST['id_plano'] <> ''){
					$timeStamp = strtotime("+1 month");
					$dataFinal .= date ('Y-m-d' , $timeStamp); 
				}
				// Verificar se já existe:
				$sql = "SELECT tbl_cliente.* FROM tbl_cliente where email = ? or cpf = ? ";
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
						
						$sql = "INSERT INTO tbl_cliente (nome, aniversario, email, bairro, cep, cidade, estado, telefone1, telefone2, senha, cpf, rg, endereco, complemento, ativo, pontos, plano_tipo, data_vencimento, id_plano, data_contratacao) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";   
						$stm = $this->pdo->prepare($sql);   
						$stm->bindValue(1, $_POST['nome']);   
						$stm->bindValue(2, $_POST['aniversario']);   
						$stm->bindValue(3, $_POST['email']);   
						$stm->bindValue(4, $_POST['bairro']);   
						$stm->bindValue(5, $_POST['cep']);   
						$stm->bindValue(6, $_POST['cidade']);   
						$stm->bindValue(7, $_POST['estado']);   
						$stm->bindValue(8, $_POST['telefone1']);   
						$stm->bindValue(9, $_POST['telefone2']);   
						$stm->bindValue(10, $_POST['senha']);   
						$stm->bindValue(11, $_POST['cpf']);   
						$stm->bindValue(12, $_POST['rg']);   
						$stm->bindValue(13, $_POST['endereco']);   
						$stm->bindValue(14, $_POST['complemento']);   
						$stm->bindValue(15, $_POST['ativo']);   
						$stm->bindValue(16, $_POST['pontos']);   
						$stm->bindValue(17, $_POST['plano_tipo']);   
						$stm->bindValue(18, $dataFinal);   
						$stm->bindValue(19, $_POST['id_plano']);   
						$stm->bindValue(20, date('Y-m-d'));   
						$stm->execute(); 
						$idConteudo = $this->pdo->lastInsertId();
						
						
						
						
						
						if($_POST['condicao'] == 'presente') {
						require("phpmailer/class.phpmailer.php");
						// Define os dados do servidor e tipo de conexão
					  $mail = new PHPMailer();	
							
							  $mensagem = "
		   <style type='text/css'>
  body {
   padding-top: 0 !important;
   padding-bottom: 0 !important;
   padding-top: 0 !important;
   padding-bottom: 0 !important;
   margin:0 !important;
   width: 100% !important;
   -webkit-text-size-adjust: 100% !important;
   -ms-text-size-adjust: 100% !important;
   -webkit-font-smoothing: antialiased !important;
 }
 .tableContent img {
   border: 0 !important;
   display: block !important;
   outline: none !important;
 }

p, h2{
  margin:0;
}

div,p,ul,h2,h2{
  margin:0;
}

h2.bigger,h2.bigger{
  font-size: 32px;
  font-weight: normal;
}

h2.big,h2.big{
  font-size: 21px;
  font-weight: normal;
}

a.link1{
  color:#D464AA;font-size:13px;font-weight:bold;text-decoration:none;
}

a.link2{
  padding:8px;background:#D464AA;font-size:13px;color:#ffffff;text-decoration:none;font-weight:bold;
}

a.link3{
  background:#D464AA; color:#ffffff; padding:8px 10px;text-decoration:none;font-size:13px;
}
.bgBody{
background: #FFFFFF;
}
.bgItem{
background: #ffffff;
}

@media only screen and (max-width:480px)
		
{
		
table[class='MainContainer'], td[class='cell'] 
	{
		width: 100% !important;
		height:auto !important; 
	}
td[class='specbundle'] 
	{
		width: 100% !important;
		float:left !important;
		font-size:13px !important;
		line-height:17px !important;
		display:block !important;
		
	}
	td[class='specbundle1'] 
	{
		width: 100% !important;
		float:left !important;
		font-size:13px !important;
		line-height:17px !important;
		display:block !important;
		padding-bottom:20px !important;
		
	}	
td[class='specbundle2'] 
	{
		width:90% !important;
		float:left !important;
		font-size:14px !important;
		line-height:18px !important;
		display:block !important;
		padding-left:5% !important;
		padding-right:5% !important;
	}
	td[class='specbundle3'] 
	{
		width:90% !important;
		float:left !important;
		font-size:14px !important;
		line-height:18px !important;
		display:block !important;
		padding-left:5% !important;
		padding-right:5% !important;
		padding-bottom:20px !important;
		text-align:center !important;
	}
	td[class='specbundle4'] 
	{
		width: 100% !important;
		float:left !important;
		font-size:13px !important;
		line-height:17px !important;
		display:block !important;
		padding-bottom:20px !important;
		text-align:center !important;
		
	}
		
td[class='spechide'] 
	{
		display:none !important;
	}
	    img[class='banner'] 
	{
	          width: 100% !important;
	          height: auto !important;
	}
		td[class='left_pad'] 
	{
			padding-left:15px !important;
			padding-right:15px !important;
	}
		 
}
	
@media only screen and (max-width:540px) 

{
		
table[class='MainContainer'], td[class='cell'] 
	{
		width: 100% !important;
		height:auto !important; 
	}
td[class='specbundle'] 
	{
		width: 100% !important;
		float:left !important;
		font-size:13px !important;
		line-height:17px !important;
		display:block !important;
		
	}
	td[class='specbundle1'] 
	{
		width: 100% !important;
		float:left !important;
		font-size:13px !important;
		line-height:17px !important;
		display:block !important;
		padding-bottom:20px !important;
		
	}		
td[class='specbundle2'] 
	{
		width:90% !important;
		float:left !important;
		font-size:14px !important;
		line-height:18px !important;
		display:block !important;
		padding-left:5% !important;
		padding-right:5% !important;
	}
	td[class='specbundle3'] 
	{
		width:90% !important;
		float:left !important;
		font-size:14px !important;
		line-height:18px !important;
		display:block !important;
		padding-left:5% !important;
		padding-right:5% !important;
		padding-bottom:20px !important;
		text-align:center !important;
	}
	td[class='specbundle4'] 
	{
		width: 100% !important;
		float:left !important;
		font-size:13px !important;
		line-height:17px !important;
		display:block !important;
		padding-bottom:20px !important;
		text-align:center !important;
		
	}
		
td[class='spechide'] 
	{
		display:none !important;
	}
	    img[class='banner'] 
	{
	          width: 100% !important;
	          height: auto !important;
	}
		td[class='left_pad'] 
	{
			padding-left:15px !important;
			padding-right:15px !important;
	}
		
	.font{
		font-size:15px !important;
		line-height:19px !important;
		
		}
}

</style>
<script type='colorScheme' class='swatch active'>
  {
    'name':'Default',
    'bgBody':'F6F6F6',
    'link':'D464AA',
    'color':'999999',
    'bgItem':'ffffff',
    'title':'555555'
  }
</script>		  
		  
		  ";
		  $mensagem.= "
		  <body paddingwidth='0' paddingheight='0'   style='padding-top: 0; padding-bottom: 0; padding-top: 0; padding-bottom: 0; background-repeat: repeat; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased;' offset='0' toppadding='0' leftpadding='0'>
  <table width='100%' border='0' cellspacing='0' cellpadding='0' class='tableContent bgBody' align='center'  style='font-family:helvetica, sans-serif;'>
  
   
    
  <tbody>
  <tr>
      <td height='25' background='http://minhanossa.net.br/email/banner1.png' colspan='3'></td>
    </tr>
    <tr>
      <td>
      <table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tbody>
    <tr>
      <td valign='top' class='spechide'>
      
      <table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tbody>
    <tr>
      <td height='130' background='http://minhanossa.net.br/email/banner1.png'>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
</td>
      <td valign='top' width='600'>
      
      <table width='600' border='0' cellspacing='0' cellpadding='0' align='center' class='MainContainer' bgcolor='#ffffff'>
  <tbody>
   
    <tr>
      <td class='movableContentContainer'>
      		<div class='movableContent' style='border: 0px; padding-top: 0px; position: relative;'>
            	<table width='100%' border='0' cellspacing='0' cellpadding='0' align='center' valign='top'>
                  <tr>
                    <td  valign='top'>
                      <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center' valign='top'>
                        <tr>
                          <td align='left' valign='middle' >

                          </td>

                          <td align='right' valign='top' >
                            <div class='contentEditableContainer contentTextEditable' style='display:inline-block;'>

                            </div>
                          </td>
                          <td width='18' align='right' valign='top'>

                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
            </div>
            <div class='movableContent' style='border: 0px; padding-top: 0px; position: relative;'>
            	<table width='100%' border='0' cellspacing='0' cellpadding='0' align='center' valign='top'>

                <tr>
                  <td>
                    <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center' valign='top' class='bgItem'>
                      <tr>
                        <td  width='70'></td>
                        <td  align='left' width='530'>
                          <div class='contentEditableContainer contentTextEditable'>
                            <div class='contentEditable' style='font-size:32px;color:#d76e79;font-weight:normal;'>
                              <h2 style='font-size:32px;'>Minha nossa!</h2>
                            </div>
                          </div>
                        </td>
                        <td  width='70'><img src='http://minhanossa.net.br/email/logo.png' alt='' width='118'></td>
                      </tr>

                      <tr><td colspan='3' height='22' ></td></tr>

                      <tr>
                        <td width='70'></td>
                        <td  align='left' width='530'>
                          <div class='contentEditableContainer contentTextEditable'>
                            <div class='contentEditable' style='font-size:13px;color:#99A1A6;line-height:19px;'>
                              <div>Oi <strong>".$_POST['nome']."</strong>!</div>
                              <p>O(a) <strong>".$_POST['nome_comprador']."</strong> viu nossa marca, achou a sua cara e te deu uma assinatura de presente! Não é maravilhoso?</p>
                              <p>A partir de hoje você pode pegar nossas peças emprestadas por 7 dias, montar looks novos toda semana e deixar o guarda roupa (e a vida, vai) mais divertidos!!</p>
							  <p>
							  Entre com seu login e senha, descubra qual é o seu plano de assinatura  e como o seu guarda roupa vai se transformar em um universo de possibilidades!
							  </p>
							  <p>
							  Seu login é o <strong>seu email</strong> e a senha provisória é <strong>minhanossa123</strong><br>
Te esperamos na loja física, na 104 sul, para concluirmos o seu cadastro e te entregar a sua ecobag!
							  </p>
                              <div>&nbsp;</div>
                              <div>&nbsp;</div>
                              <div>&nbsp;</div>
                              <div align='right' style='color: #d76e79'>Um abraço, equipe Minha Nossa!</div>
                            </div>
                          </div>
                        </td>
                        <td  width='70'></td>
                      </tr>

                      <tr><td colspan='3' height='45' ></td></tr>

                    </table>
                  </td>
                </tr>
                </table>
            </div>
            <div class='movableContent' style='border: 0px; padding-top: 0px; position: relative; font-size: 12px'>
            	<table width='100%' border='0' cellspacing='0' cellpadding='0' align='center' valign='top'>
                  <tr><td height='10' bgcolor='#d76e79'></td></tr>
                    <tr>
                      <td>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center' valign='top' bgcolor='#d76e79'>
                          <tr>
                            <td width='21' rowspan='2'></td>
                            <td colspan='2' valign='middle'><p>Acompanhe nossas redes:
                              </p>
                              <p>&nbsp;</p></td>
                            <td width='33' rowspan='2' valign='middle'><img src='http://minhanossa.net.br/email/chat.png' alt='' width='30' /></td>
                            <td valign='top'>mande um alô para o Minha Nossa!</td>
                            <td width='3' rowspan='2' valign='middle'><img src='http://minhanossa.net.br/email/marker.png' alt='' width='30' /></td>
                            <td valign='middle'>&nbsp;</td>
                            <td width='3' rowspan='2' valign='top'>&nbsp;</td>
                            </tr>
                          <tr>
                            <td width='45' valign='top'><a href='https://www.facebook.com/querominhanossa/' target='_blank'><img src='http://minhanossa.net.br/email/facebook.png' alt='' width='30' style='margin-top: -24px;'></a></td>
                            <td width='111' valign='top'><a href='https://www.instagram.com/querominhanossa/' target='_blank'></a><img src='http://minhanossa.net.br/email/instagram.png' alt='' width='30' style='margin-top: -24px;'></a></td>
                            <td width='202' valign='top'><div><strong>oi@minhanossa.net.br</strong></div>
                              <div><strong>(61) 3522-5985</strong></div>
                              </td>
                            <td width='182' valign='top'><div><strong>SCLS 104 bloco B loja 37Asa Sul Brasília/DF</strong></div>
                              <div><strong>Seg - Sáb 13h às 19h CEP: 70343520</strong></div></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr><td height='10' bgcolor='#d76e79'></td></tr>
                </table>
            </div>

      </td>
    </tr>
  </tbody>
</table>
</td>
      <td valign='top' class='spechide'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tbody>
    <tr>
      <td height='130' background='http://minhanossa.net.br/email/banner1.png' bgcolor='#43474A'>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
</td>
    </tr>
  </tbody>
</table>
</td>
    </tr>
  </tbody>
</table>

  </body> ";
		  
		  
		  $mail->IsSMTP(); // telling the class to use SMTP


		  try {
			 $mail->Host       = "smtp-vip.uni5.net";// sets GMAIL as the SMTP server
			 $mail->SMTPDebug  = 1;// enables SMTP debug information (for testing)
			 $mail->SMTPAuth   = true;// enable SMTP authentication
			// $mail->SMTPSecure = "ssl";// sets the prefix to the servier
			 $mail->Host       = "smtp-vip.uni5.net";// sets GMAIL as the SMTP server
			 $mail->Port       = 587;// set the SMTP port for the GMAIL server
			 $mail->Username   = "minhanossa@minhanossa.net.br";// GMAIL username
			 $mail->Password   = "df123456";// GMAIL password
			 //$mail->AddReplyTo($_POST['email'], $_POST['nome']);
			 $mail->AddAddress($_POST['email']);
			 $mail->SetFrom('minhanossa@minhanossa.net.br', 'Minha Nossa');
			 $mail->Subject = 'PRESENTE!!! - Minha Nossa';
			 $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; 
			 $mail->MsgHTML($mensagem);
			 $mail->Send();
		 
		  } catch (phpmailerException $e) {
			  echo $e->errorMessage(); //Pretty error messages from PHPMailer
		  } catch (Exception $e) {
			  echo $e->getMessage(); //Boring error messages from anything else!
		  }
							
							
							
							echo "	<script>
								window.location='checkout/pagseguro.php?id=$idConteudo&id_plano={$_POST['id_plano']}&condicao=presente';
								</script>";
								exit;
						}
						if($_POST['id_plano'] <> '') {
							
								require("phpmailer/class.phpmailer.php");
						// Define os dados do servidor e tipo de conexão
					  $mail = new PHPMailer();	
							
							  $mensagem = "
		   <style type='text/css'>
  body {
   padding-top: 0 !important;
   padding-bottom: 0 !important;
   padding-top: 0 !important;
   padding-bottom: 0 !important;
   margin:0 !important;
   width: 100% !important;
   -webkit-text-size-adjust: 100% !important;
   -ms-text-size-adjust: 100% !important;
   -webkit-font-smoothing: antialiased !important;
 }
 .tableContent img {
   border: 0 !important;
   display: block !important;
   outline: none !important;
 }

p, h2{
  margin:0;
}

div,p,ul,h2,h2{
  margin:0;
}

h2.bigger,h2.bigger{
  font-size: 32px;
  font-weight: normal;
}

h2.big,h2.big{
  font-size: 21px;
  font-weight: normal;
}

a.link1{
  color:#D464AA;font-size:13px;font-weight:bold;text-decoration:none;
}

a.link2{
  padding:8px;background:#D464AA;font-size:13px;color:#ffffff;text-decoration:none;font-weight:bold;
}

a.link3{
  background:#D464AA; color:#ffffff; padding:8px 10px;text-decoration:none;font-size:13px;
}
.bgBody{
background: #FFFFFF;
}
.bgItem{
background: #ffffff;
}

@media only screen and (max-width:480px)
		
{
		
table[class='MainContainer'], td[class='cell'] 
	{
		width: 100% !important;
		height:auto !important; 
	}
td[class='specbundle'] 
	{
		width: 100% !important;
		float:left !important;
		font-size:13px !important;
		line-height:17px !important;
		display:block !important;
		
	}
	td[class='specbundle1'] 
	{
		width: 100% !important;
		float:left !important;
		font-size:13px !important;
		line-height:17px !important;
		display:block !important;
		padding-bottom:20px !important;
		
	}	
td[class='specbundle2'] 
	{
		width:90% !important;
		float:left !important;
		font-size:14px !important;
		line-height:18px !important;
		display:block !important;
		padding-left:5% !important;
		padding-right:5% !important;
	}
	td[class='specbundle3'] 
	{
		width:90% !important;
		float:left !important;
		font-size:14px !important;
		line-height:18px !important;
		display:block !important;
		padding-left:5% !important;
		padding-right:5% !important;
		padding-bottom:20px !important;
		text-align:center !important;
	}
	td[class='specbundle4'] 
	{
		width: 100% !important;
		float:left !important;
		font-size:13px !important;
		line-height:17px !important;
		display:block !important;
		padding-bottom:20px !important;
		text-align:center !important;
		
	}
		
td[class='spechide'] 
	{
		display:none !important;
	}
	    img[class='banner'] 
	{
	          width: 100% !important;
	          height: auto !important;
	}
		td[class='left_pad'] 
	{
			padding-left:15px !important;
			padding-right:15px !important;
	}
		 
}
	
@media only screen and (max-width:540px) 

{
		
table[class='MainContainer'], td[class='cell'] 
	{
		width: 100% !important;
		height:auto !important; 
	}
td[class='specbundle'] 
	{
		width: 100% !important;
		float:left !important;
		font-size:13px !important;
		line-height:17px !important;
		display:block !important;
		
	}
	td[class='specbundle1'] 
	{
		width: 100% !important;
		float:left !important;
		font-size:13px !important;
		line-height:17px !important;
		display:block !important;
		padding-bottom:20px !important;
		
	}		
td[class='specbundle2'] 
	{
		width:90% !important;
		float:left !important;
		font-size:14px !important;
		line-height:18px !important;
		display:block !important;
		padding-left:5% !important;
		padding-right:5% !important;
	}
	td[class='specbundle3'] 
	{
		width:90% !important;
		float:left !important;
		font-size:14px !important;
		line-height:18px !important;
		display:block !important;
		padding-left:5% !important;
		padding-right:5% !important;
		padding-bottom:20px !important;
		text-align:center !important;
	}
	td[class='specbundle4'] 
	{
		width: 100% !important;
		float:left !important;
		font-size:13px !important;
		line-height:17px !important;
		display:block !important;
		padding-bottom:20px !important;
		text-align:center !important;
		
	}
		
td[class='spechide'] 
	{
		display:none !important;
	}
	    img[class='banner'] 
	{
	          width: 100% !important;
	          height: auto !important;
	}
		td[class='left_pad'] 
	{
			padding-left:15px !important;
			padding-right:15px !important;
	}
		
	.font{
		font-size:15px !important;
		line-height:19px !important;
		
		}
}

</style>
<script type='colorScheme' class='swatch active'>
  {
    'name':'Default',
    'bgBody':'F6F6F6',
    'link':'D464AA',
    'color':'999999',
    'bgItem':'ffffff',
    'title':'555555'
  }
</script>		  
		  
		  ";
		  $mensagem.= "
		  <body paddingwidth='0' paddingheight='0'   style='padding-top: 0; padding-bottom: 0; padding-top: 0; padding-bottom: 0; background-repeat: repeat; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased;' offset='0' toppadding='0' leftpadding='0'>
  <table width='100%' border='0' cellspacing='0' cellpadding='0' class='tableContent bgBody' align='center'  style='font-family:helvetica, sans-serif;'>
  
   
    
  <tbody>
  <tr>
      <td height='25' background='http://minhanossa.net.br/email/banner1.png' colspan='3'></td>
    </tr>
    <tr>
      <td>
      <table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tbody>
    <tr>
      <td valign='top' class='spechide'>
      
      <table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tbody>
    <tr>
      <td height='130' background='http://minhanossa.net.br/email/banner1.png'>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
</td>
      <td valign='top' width='600'>
      
      <table width='600' border='0' cellspacing='0' cellpadding='0' align='center' class='MainContainer' bgcolor='#ffffff'>
  <tbody>
   
    <tr>
      <td class='movableContentContainer'>
      		<div class='movableContent' style='border: 0px; padding-top: 0px; position: relative;'>
            	<table width='100%' border='0' cellspacing='0' cellpadding='0' align='center' valign='top'>
                  <tr>
                    <td  valign='top'>
                      <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center' valign='top'>
                        <tr>
                          <td align='left' valign='middle' >

                          </td>

                          <td align='right' valign='top' >
                            <div class='contentEditableContainer contentTextEditable' style='display:inline-block;'>

                            </div>
                          </td>
                          <td width='18' align='right' valign='top'>

                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
            </div>
            <div class='movableContent' style='border: 0px; padding-top: 0px; position: relative;'>
            	<table width='100%' border='0' cellspacing='0' cellpadding='0' align='center' valign='top'>

                <tr>
                  <td>
                    <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center' valign='top' class='bgItem'>
                      <tr>
                        <td  width='70'></td>
                        <td  align='left' width='530'>
                          <div class='contentEditableContainer contentTextEditable'>
                            <div class='contentEditable' style='font-size:32px;color:#d76e79;font-weight:normal;'>
                              <h2 style='font-size:32px;'>Minha nossa!</h2>
                            </div>
                          </div>
                        </td>
                        <td  width='70'><img src='http://minhanossa.net.br/email/logo.png' alt='' width='118'></td>
                      </tr>

                      <tr><td colspan='3' height='22' ></td></tr>

                      <tr>
                        <td width='70'></td>
                        <td  align='left' width='530'>
                          <div class='contentEditableContainer contentTextEditable'>
                            <div class='contentEditable' style='font-size:13px;color:#99A1A6;line-height:19px;'>
                              <div>Oi <strong>".$_POST['nome']."</strong>!</div>
                              <p>Ficamos muito feliz em ter você na nossa família e visitando a nossa casa!</p>
                              <p>A partir de hoje você pode pegar nossas peças emprestadas por 7 dias, montar looks novos toda semana e deixar o guarda roupa (e a vida, vai) mais divertidos!!</p>
							  <p>Te esperamos na loja física, na 104 sul, para concluirmos o seu cadastro e te entregar a sua ecobag!</p>
                              <div>&nbsp;</div>
                              <div>&nbsp;</div>
                              <div>&nbsp;</div>
                              <div align='right' style='color: #d76e79'>Um abraço, equipe Minha Nossa!</div>
                            </div>
                          </div>
                        </td>
                        <td  width='70'></td>
                      </tr>

                      <tr><td colspan='3' height='45' ></td></tr>

                    </table>
                  </td>
                </tr>
                </table>
            </div>
            <div class='movableContent' style='border: 0px; padding-top: 0px; position: relative; font-size: 12px'>
            	<table width='100%' border='0' cellspacing='0' cellpadding='0' align='center' valign='top'>
                  <tr><td height='10' bgcolor='#d76e79'></td></tr>
                    <tr>
                      <td>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center' valign='top' bgcolor='#d76e79'>
                          <tr>
                            <td width='21' rowspan='2'></td>
                            <td colspan='2' valign='middle'><p>Acompanhe nossas redes:
                              </p>
                              <p>&nbsp;</p></td>
                            <td width='33' rowspan='2' valign='middle'><img src='http://minhanossa.net.br/email/chat.png' alt='' width='30' /></td>
                            <td valign='top'>mande um alô para o Minha Nossa!</td>
                            <td width='3' rowspan='2' valign='middle'><img src='http://minhanossa.net.br/email/marker.png' alt='' width='30' /></td>
                            <td valign='middle'>&nbsp;</td>
                            <td width='3' rowspan='2' valign='top'>&nbsp;</td>
                            </tr>
                          <tr>
                            <td width='45' valign='top'><a href='https://www.facebook.com/querominhanossa/' target='_blank'><img src='http://minhanossa.net.br/email/facebook.png' alt='' width='30' style='margin-top: -24px;'></a></td>
                            <td width='111' valign='top'><a href='https://www.instagram.com/querominhanossa/' target='_blank'></a><img src='http://minhanossa.net.br/email/instagram.png' alt='' width='30' style='margin-top: -24px;'></a></td>
                            <td width='202' valign='top'><div><strong>oi@minhanossa.net.br</strong></div>
                              <div><strong>(61) 3522-5985</strong></div>
                              </td>
                            <td width='182' valign='top'><div><strong>SCLS 104 bloco B loja 37Asa Sul Brasília/DF</strong></div>
                              <div><strong>Seg - Sáb 13h às 19h CEP: 70343520</strong></div></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr><td height='10' bgcolor='#d76e79'></td></tr>
                </table>
            </div>

      </td>
    </tr>
  </tbody>
</table>
</td>
      <td valign='top' class='spechide'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tbody>
    <tr>
      <td height='130' background='http://minhanossa.net.br/email/banner1.png' bgcolor='#43474A'>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
</td>
    </tr>
  </tbody>
</table>
</td>
    </tr>
  </tbody>
</table>

  </body> ";
		  
		  
		  $mail->IsSMTP(); // telling the class to use SMTP


		  try {
			 $mail->Host       = "smtp-vip.uni5.net";// sets GMAIL as the SMTP server
			 $mail->SMTPDebug  = 1;// enables SMTP debug information (for testing)
			 $mail->SMTPAuth   = true;// enable SMTP authentication
			// $mail->SMTPSecure = "ssl";// sets the prefix to the servier
			 $mail->Host       = "smtp-vip.uni5.net";// sets GMAIL as the SMTP server
			 $mail->Port       = 587;// set the SMTP port for the GMAIL server
			 $mail->Username   = "minhanossa@minhanossa.net.br";// GMAIL username
			 $mail->Password   = "df123456";// GMAIL password
			 //$mail->AddReplyTo($_POST['email'], $_POST['nome']);
			 $mail->AddAddress($_POST['email']);
			 $mail->SetFrom('minhanossa@minhanossa.net.br', 'Minha Nossa');
			 $mail->Subject = 'PRESENTE!!! - Minha Nossa';
			 $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; 
			 $mail->MsgHTML($mensagem);
			 $mail->Send();
		 
		  } catch (phpmailerException $e) {
			  echo $e->errorMessage(); //Pretty error messages from PHPMailer
		  } catch (Exception $e) {
			  echo $e->getMessage(); //Boring error messages from anything else!
		  }
					
					
					if($_POST['site'] == 'S') {
						echo "	<script>
								alert('Obrigado seu cadastro foi realizado com sucesso.');
								window.location='/';
								</script>";
								exit;
					}
							
							
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
			}
		}
		
		/*function editar($redireciona='clientes.php') {
			if($_POST['acao'] == 'editarClientes') {
				try { 
				
					if(file_exists('Connections/conexao.php')) {
						$pastaArquivos = 'img_noticias';
					} else {
						$pastaArquivos = '../img_noticias';
					}
						 
					$sql = "UPDATE tbl_cliente SET nome=?, data_de_nascimento=?, email=?, bairro=?, cep=?, cidade=?, estado=?, telefone=?, newsletter=?, senha=?, cpf=?, rg=?, endereco=?, complemento=?, celular=?, skype=?, ativo=?, foto=?, cod_banco=?, agencia=?, conta=?, tipo_conta=?, operacao=?, variacao=?, plano_tipo=?, plano_pago_ate=?, id_plano=?, pontos=? WHERE id=?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_POST['nome']);   
					$stm->bindValue(2, $_POST['data_de_nascimento']);  //echo $_POST['data']; exit; 
					$stm->bindValue(3, $_POST['email']);   
					$stm->bindValue(4, $_POST['bairro']);   
					$stm->bindValue(5, $_POST['cep']);   
					$stm->bindValue(6, $_POST['cidade'][0]);  
					$stm->bindValue(7, $_POST['estado']);   
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
		}*/
		function editar($mensagemAlert='', $redireciona='') {
			if($_POST['acao'] == 'editarClientes') {
				try { 
				
					if(file_exists('Connections/conexao.php')) {
						$pastaArquivos = 'img_noticias';
					} else {
						$pastaArquivos = '../img_noticias';
					}
						 
					$sql = "UPDATE tbl_cliente SET nome=?, aniversario=?, email=?, bairro=?, cep=?, cidade=?, estado=?, telefone1=?, telefone2=?, senha=?, cpf=?, rg=?, endereco=?, complemento=?, pontos=?, data_vencimento=?, ativo=?, data_contratacao=?, plano_tipo=?, id_plano=? WHERE id=?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_POST['nome']);   
					$stm->bindValue(2, $_POST['aniversario']);  //echo $_POST['data']; exit; 
					$stm->bindValue(3, $_POST['email']);   
					$stm->bindValue(4, $_POST['bairro']);   
					$stm->bindValue(5, $_POST['cep']);   
					$stm->bindValue(6, $_POST['id_cidade'][0]);  
					$stm->bindValue(7, $_POST['id_estado']);   
					$stm->bindValue(8, $_POST['telefone1']);   
					$stm->bindValue(9, $_POST['telefone2']);   
					$stm->bindValue(10, $_POST['senha']);   
					$stm->bindValue(11, $_POST['cpf']);   
					$stm->bindValue(12, $_POST['rg']);   
					$stm->bindValue(13, $_POST['endereco']);   
					$stm->bindValue(14, $_POST['complemento']);   
					$stm->bindValue(15, $_POST['pontos']);   
					$stm->bindValue(16, $_POST['data_vencimento']);   
					$stm->bindValue(17, $_POST['ativo']); 
					$stm->bindValue(18, $_POST['data_contratacao']);  
					$stm->bindValue(19, $_POST['plano_tipo']); 
					$stm->bindValue(20, $_POST['id_plano']); 
					$stm->bindValue(21, $_POST['id']);   
					$stm->execute(); 
					$id = $_POST['id'];

					if($mensagemAlert <> '') {
					echo "	<script>
							alert('{$mensagemAlert}');
							</script>";
				}
					
				if($redireciona == ""){
					echo "	<script>
							window.location='clientes.php';
							</script>";
				} else {
					echo "	<script>
							window.location='{$redireciona}';
							</script>";
				}
				exit;
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
			}
		}
		
		function excluir() {
			if($_GET['acao'] == 'excluirClientes') {
				
				try{   
					$sql = "DELETE FROM tbl_cliente WHERE id=? ";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				
			}
		}
	}
	
	$ClientesInstanciada = 'S';
}