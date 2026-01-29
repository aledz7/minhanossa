<?php 
include('Connections/conexao.php'); 
include('funcoes.php');


////VERIFICA OS CONTRATOS COM DOIS DIAS ANTES DE VENCER
$data = date('Y-m-d'); 
$data2 = date('Y-m-d', strtotime("+2 days",strtotime($data)));
//echo "aqui: ".$data2;

mysql_select_db($database_conexao, $conexao);
$query_rs_verifica_contrato = "SELECT * FROM tbl_contrato WHERE data_devolucao = $data2 and envio_email <> 'S'";
$rs_verifica_contrato = mysql_query($query_rs_verifica_contrato, $conexao) or die(mysql_error());
$row_rs_verifica_contrato = mysql_fetch_assoc($rs_verifica_contrato);
$totalRows_rs_verifica_contrato = mysql_num_rows($rs_verifica_contrato);

if($totalRows_rs_verifica_contrato > 0){
	///LOOP PARA ENVIAR E-MAIL AOS CLIENTES
	do{
mysql_select_db($database_conexao, $conexao);
$query_rs_verifica_cliente = "SELECT * FROM tbl_cliente WHERE id = '".$row_rs_verifica_contrato['codigo_cliente']."'";
$rs_verifica_cliente = mysql_query($query_rs_verifica_cliente, $conexao) or die(mysql_error());
$row_rs_verifica_cliente = mysql_fetch_assoc($rs_verifica_cliente);
$totalRows_rs_verifica_cliente = mysql_num_rows($rs_verifica_cliente);
		
		 require("phpmailer/class.phpmailer.php");
	// Define os dados do servidor e tipo de conexão
          $mail = new PHPMailer();
		  
			$email = $row_rs_verifica_cliente['email'];
			$nomeCliente = $row_rs_verifica_cliente['nome'];
			$dataFimPlano = formataData($row_rs_verifica_cliente['data_fim_plano']);
			$idCliente = $row_rs_verifica_cliente['id'];
	
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
                              <div>Como o tempo passou rápido!</div>
                              <p>A gente sabe que é dificil dizer tchau, mas daqui a <span style='color: #d76e79'>dois dias </span> as suas peças precisam voltar pra casa.</p>
							  
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
			 $mail->AddAddress($email);
			 //$mail->AddAddress('adriano@dfinformatica.com.br');
			 $mail->SetFrom('minhanossa@minhanossa.net.br', 'Minha Nossa');
			 $mail->Subject = 'LEMBRETE - MINHA NOSSA';
			 $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; 
			 $mail->MsgHTML($mensagem);
			 $mail->Send();
			 
		} catch (phpmailerException $e) {
			  echo $e->errorMessage(); //Pretty error messages from PHPMailer
		  } catch (Exception $e) {
			  echo $e->getMessage(); //Boring error messages from anything else!
		  }
		
		
		///INSERE NO BANCO A INFORMACAO DE QUE ENVIOU O E-MAIL DE 48HORAS
		$updateSQL = sprintf("UPDATE tbl_contrato SET envio_email=%s WHERE id=%s",
                       GetSQLValueString('S', "text"),
                       GetSQLValueString($idCliente, "int"));

	  mysql_select_db($database_conexao, $conexao);
	  $Result1 = mysql_query($updateSQL, $conexao) or die(mysql_error());
		
		
	}while($row_rs_verifica_contrato = mysql_fetch_assoc($rs_verifica_contrato));
	
}
?>